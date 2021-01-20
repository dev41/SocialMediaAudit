import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";

const selectors = {
    alertContainer: '.js-container-alert',
    processSpinner: '.js-stripe-process-spinner',

    containerBody: '.js-stripe-billing-history-body',
    tableBody: '.js-table-body',

    payNowBtn: '.js-pay-now-btn',
};

const money = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

class BillingHistory extends VisualComponent {
    constructor(container) {
        super(container);

        if (!container.length) {
            return;
        }

        this.init();
    }

    init() {
        this.initElements();
        this.initEvents();
    }

    initElements() {
        this.elements.alertContainer = $(selectors.alertContainer);
        this.elements.processSpinner = this.container.find(selectors.processSpinner);

        this.elements.containerBody = this.container.find(selectors.containerBody);
        this.elements.tableBody = this.container.find(selectors.tableBody);
    }

    initEvents() {
        let self = this;
        self.elements.processSpinner.show();

        $.ajax({
            url: 'user-billing-history',
            method: 'POST'
        }).done(function (r) {
            if (!r.success) {
                return;
            }

            self.elements.containerBody.show();
            self.table(r.invoice);
            self.payNow();

        }).fail(function (xhr) {
            var message = xhr.responseJSON.message;
            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.alertContainer,);
        }).always(function () {
            self.elements.processSpinner.hide();
        });
    }

    /**
     * @param {Object} invoice
     */
    table(invoice) {
        let self = this,
            invoices = invoice.data,
            table = self.elements.tableBody,
            showPayNowColumn = false,
            t = table.DataTable({
                order: [[0, 'desc']],
                responsive: !0,
                filter: false,
                lengthChange: false,
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [-1]
                    },
                    {
                        class: 'status',
                        aTargets: [3]
                    }
                ]
            });

        invoices.forEach(function (invoice) {

            if (['draft', 'open', 'paid'].indexOf(invoice.status) === -1) {
                return;
            }

            let pdf = '<a class="btn btn--success" href="' + invoice.invoice_pdf + '" target="_blank"><span>View</span></a>',
                amount = (invoice.amount_paid ? invoice.amount_paid : invoice.total) / 100,
                date = new Date(invoice.created * 1000),
                buttonPayNow = '<a href="' + invoice.hosted_invoice_url + '" class="ladda-button ladda-button-n1 btn btn--sm btn--primary" target="_blank"> Pay Now </a>';

            if (['open', 'draft'].indexOf(invoice.status) !== -1) {
                buttonPayNow = '<a data-invoice="' + invoice.id + '" class="ladda-button ladda-button-n1 btn btn--sm btn--primary js-pay-now-btn">' +
                    '<span> Pay Now </span></a>';
                showPayNowColumn = true;
            } else if (['paid'].indexOf(invoice.status) !== -1) {
                buttonPayNow = '';
            }

            t.row.add([
                invoice.number,
                date.toLocaleString(),
                money.format(amount),
                invoice.status,
                pdf,
                buttonPayNow,
            ]);
        });

        if (!showPayNowColumn) {
            table.addClass('--hide-pay-now');
        }

        t.draw(false);
    }

    payNow() {
        let self = this;

        self.container.find(selectors.payNowBtn).on('click', function () {
            let btn = $(this);

            self.lock();
            self.elements.processSpinner.show();

            $.ajax({
                url: 'user-pay-now',
                method: 'POST',
                data: {invoice: btn.data('invoice')}
            }).done(function (r) {
                if (!r.message || !r.success) {
                    return;
                }
                window.scroll(0, 0);
                VisualComponent.showMessage(r.message, AlertTypes.SUCCESS, self.elements.alertContainer, {
                    visibleTime: 2000,
                    onHide: function () {
                        document.location.reload();
                    }
                });

            }).fail(function (xhr) {
                let message = xhr.responseJSON.message;
                VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.alertContainer);
            }).always(function () {
                self.unlock();
                self.elements.processSpinner.hide();
            });
        });
    }
}

export {BillingHistory}