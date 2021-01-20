import {VisualComponent} from "../VisualComponent";
import {messageTypes as AlertTypes} from "../Alert";

const selectors = {
    containerBody: '.js-subscription-body',
    subscriptionIsset: '.js-isset-subscription',
    subscriptionAdd: '.js-add-subscription',
    subscriptionPlan: '.js-subscription-plan',
    subscriptionTrialMsg: '.js-trial-msg',

    chancelSubscriptionAlert: '.js-cancel-subscription-alert',
    cancelSubscriptionMsg: '.js-cancel-subscription-msg',
    cancelBtn: '.js-cancel-subscription-btn',

    reactivateSubContainer: '.js-reactivate-subscription',
    reactivateBtn: '.js-reactivate-subscription-btn',

    cancelSubBtn: '.js-cancel-sub-submit',
    cancelForm: '.js-cancel-sub-form',
    idModalCancel: '#cancelSub',

    processSpinner: '.js-stripe-process-spinner',
};

class Subscription extends VisualComponent {
    constructor(container) {
        super(container);
        this.init();
    }

    init() {
        this.initElements();
        this.initEvents();
    }

    initElements() {
        this.elements.containerBody = this.container.find(selectors.containerBody);
        this.elements.subscriptionIsset = this.container.find(selectors.subscriptionIsset);
        this.elements.subscriptionAdd = this.container.find(selectors.subscriptionAdd);
        this.elements.subscriptionPlan = this.container.find(selectors.subscriptionPlan);
        this.elements.subscriptionTrialMsg = this.container.find(selectors.subscriptionTrialMsg);

        this.elements.chancelSubscriptionAlert = this.container.find(selectors.chancelSubscriptionAlert);
        this.elements.cancelSubscriptionMsg = this.container.find(selectors.cancelSubscriptionMsg);

        this.elements.cancelBtn = this.container.find(selectors.cancelBtn);
        this.elements.cancelSubBtn = $(selectors.cancelSubBtn);
        this.elements.cancelForm = $(selectors.cancelForm);
        this.elements.processSpinnerModal = this.elements.cancelForm.find(selectors.processSpinner);

        this.elements.reactivateSubContainer = this.container.find(selectors.reactivateSubContainer);
        this.elements.reactivateBtn = this.container.find(selectors.reactivateBtn);

        this.elements.processSpinner = this.container.find(selectors.processSpinner);
    }

    initEvents() {
        let self = this;

        self.loadSubscription();

        self.elements.cancelBtn.on('click', function () {
            self.chancelSubscription();
        });


        self.elements.reactivateBtn.on('click', function () {
            self.reactivateSubscription();
        });
    }

    loadSubscription() {
        let self = this;

        self.lock();
        self.elements.processSpinner.show();

        $.ajax({
            url: 'user-subscription',
            method: 'POST',
        }).done(function (r) {
            if (!r.success) {
                return;
            }

            if (r.subscription) {
                let subscription = r.subscription,
                    options = {year: 'numeric', month: 'long', day: 'numeric'}; // September 17, 2016

                Object.keys(subscription).forEach(function (key) {
                    if (key === 'current_period_start' || key === 'current_period_end') {
                        subscription[key] = new Date(subscription[key] * 1000).toLocaleString("en-US", options);
                    }
                    self.elements.containerBody.find('[data-name="sub-' + key + '"]').html(subscription[key]);
                });

                self.subscriptionShowResult(r);

            } else {
                self.elements.subscriptionAdd.show();
            }

        }).fail(function (xhr) {
            let message = xhr.responseJSON.message;
            VisualComponent.showMessage(message, AlertTypes.ERROR);
        }).always(function () {
            self.unlock();
            self.elements.processSpinner.hide();
        });
    }

    subscriptionShowResult(r)
    {
        let self = this,
            subscription = r.subscription,
            message = r.message,
            optionsAlert = {
                'visibleTime': 'notTimeout',
                'close': false,
            };

        if (subscription.status === 'trialing' && !subscription.cancel_at_period_end) {

            self.elements.subscriptionPlan.show();
            self.elements.subscriptionTrialMsg.show();
            self.elements.subscriptionAdd.hide();
            self.elements.subscriptionIsset.show();
            self.elements.reactivateSubContainer.hide();
            self.elements.chancelSubscriptionAlert.html("");

        } else if (subscription.status !== 'canceled' && subscription.cancel_at_period_end) {

            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.chancelSubscriptionAlert, optionsAlert);
            self.elements.subscriptionPlan.show();
            self.elements.subscriptionIsset.hide();
            self.elements.subscriptionAdd.show();
            self.elements.reactivateSubContainer.show();

        } else if (subscription.status === 'canceled') {

            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.chancelSubscriptionAlert, optionsAlert);
            self.elements.subscriptionAdd.show();
            self.elements.subscriptionPlan.hide();
            self.elements.reactivateSubContainer.hide();

        } else if (subscription.status === 'past_due') {

            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.chancelSubscriptionAlert, optionsAlert);
            self.elements.subscriptionPlan.show();

        } else {

            self.elements.chancelSubscriptionAlert.find('.alert.bg--error').remove();

            if (message) {
                // VisualComponent.showMessage(r.message, AlertTypes.ERROR, self.elements.chancelSubscriptionAlert, optionsAlert);
            }
            self.elements.subscriptionPlan.show();
            self.elements.subscriptionAdd.hide();
            self.elements.subscriptionIsset.show();
            self.elements.reactivateSubContainer.hide();

        }
    }

    chancelSubscription() {
        let self = this;

        self.elements.cancelSubBtn.on('click', function () {

            self.elements.processSpinner.show();
            self.lock();

            $.ajax({
                url: 'user-cancel-subscription/' + self.elements.cancelForm.data('user-id'),
                method: 'POST',
            }).done(function (r) {
                if (!r.message || !r.success) {
                    return;
                }

                $(selectors.idModalCancel).modal('hide');

                VisualComponent.showMessage(r.message, AlertTypes.SUCCESS);
                self.loadSubscription();

            }).fail(function (xhr) {
                let message = xhr.responseJSON.message;
                VisualComponent.showMessage(message, AlertTypes.ERROR);
            }).always(function () {
                self.elements.processSpinnerModal.hide();
                self.unlock();
            });

        });
    }

    reactivateSubscription() {
        let self = this;

        self.elements.processSpinner.show();
        self.lock();

        $.ajax({
            url: 'user-reactivate-subscription',
            method: 'POST',
        }).done(function (r) {
            if (!r.message || !r.success) {
                return;
            }

            VisualComponent.showMessage(r.message, AlertTypes.SUCCESS);
            self.loadSubscription();

        }).fail(function (xhr) {
            let message = xhr.responseJSON.message;
            VisualComponent.showMessage(message, AlertTypes.ERROR);
        }).always(function () {
            self.unlock();
        });
    }
}

export {Subscription}