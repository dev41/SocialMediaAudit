import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";

const selectors = {
    processSpinner: '.js-stripe-process-spinner',
    containerBody: '.js-stripe-card-body',
    containerNoCard: '.js-stripe-no-card',
    addressInfo: '.js-address-info',

    loadBtn: '.js-load-btn',
    cardNumber: '.js-card-number',
    cardBrand: '.js-card-brand',
    cardExpire: '.js-card-expire',
    cardChangeBtn: '.js-change-credit-card',
};

const events = {
    UNLOCK_SUBSCRIPTION: 'unlock_subscription',
};

class Billing extends VisualComponent {
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
        this.elements.processSpinner = this.container.find(selectors.processSpinner);

        this.elements.containerBody = this.container.find(selectors.containerBody);
        this.elements.containerNoCard = this.container.find(selectors.containerNoCard);
        this.elements.addressInfo = this.container.find(selectors.addressInfo);

        this.elements.loadBtn = this.container.find(selectors.loadBtn);
        this.elements.cardNumber = this.container.find(selectors.cardNumber);
        this.elements.cardBrand = this.container.find(selectors.cardBrand);
        this.elements.cardExpire = this.container.find(selectors.cardExpire);
        this.elements.cardChangeBtn = this.container.find(selectors.cardChangeBtn);
    }


    initEvents() {
        let self = this;

        self.elements.processSpinner.show();
        self.lock();

        $.ajax({
            url: 'user-billing',
            method: 'POST',
        }).done(function (r) {
            if (!r.success) {
                return;
            }

            self.unlock();
            self.trigger(events.UNLOCK_SUBSCRIPTION);

            let objCard = r.card,
                getAddressInfo = function (cardData) {
                    let lines = [], parts = [];

                    if (cardData.address_line1 || cardData.address_city) {

                        if (cardData.address_line1) {
                            parts.push(cardData.address_line1);
                        }

                        if (cardData.address_city) {
                            parts.push(cardData.address_city);
                        }

                        lines.push(parts.join(', '));
                        parts = [];
                    }

                    if (cardData.address_state_short || cardData.address_zip) {

                        if (cardData.address_state_short) {
                            parts.push(cardData.address_state_short);
                        }

                        if (cardData.address_zip) {
                            parts.push(cardData.address_zip);
                        }

                        lines.push(parts.join(', '));
                        parts = [];
                    }

                    if (cardData.address_country) {
                        lines.push(cardData.address_country);
                    }

                    return lines;
                };

            if (objCard) {
                self.elements.containerBody.show();

                Object.keys(objCard).forEach(function (key) {
                    self.elements.containerBody.find('[data-name="card-' + key + '"]').html(objCard[key]);
                });

                self.elements.addressInfo.html(getAddressInfo(objCard).map(function (val) {
                    return '<span>' + val + '</span>';
                }).join('<br>'));

                self.elements.containerNoCard.hide();
            } else {
                self.elements.containerNoCard.show();
            }

            self.container.find('.js-change-card-btn').show();

        }).fail(function (xhr) {
            let message = xhr.responseJSON.message;
            VisualComponent.showMessage(message, AlertTypes.ERROR);
        }).always(function () {
            self.elements.processSpinner.hide();
        });

        self.elements.cardChangeBtn.change(function (e) {
            e.preventDefault();

            let form = this,
                formData = form.serialize();
            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData
            });
        });
    }
}

export {Billing, events}