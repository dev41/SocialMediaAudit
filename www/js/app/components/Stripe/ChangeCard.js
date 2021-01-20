import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";
import {Billing} from "./Billing";

const selectors = {
    billingContainer: '.js-billing-container',
    alertContainer: '.js-container-alert-change-card',
    processSpinner: '.js-stripe-process-spinner',

    cardNumber: '.js-stripe-card-number',
    cardExpiry: '.js-stripe-card-expiry',
    cardCVC: '.js-stripe-card-cvc',
    brandIcon: '.js-stripe-card-brand-icon',

    cardZIP: '.js-stripe-card-zip',
    cardCountry: '.js-user-country',
    cardState: '.js-user-state',
    cardCity: '.js-stripe-card-city',
    cardAddress: '.js-stripe-card-address',

    inputFieldState: '.js-field-state',

    idModal: '#modal',
    modalSubmit: '.js-change-card-submit',
    modalForm: '.js-stripe-change-card-form',
    stateInputTemplate: '.js-state-input-template',
};

const inputStyle = {
    base: {
        fontSize: '15px',
        color: 'rgb(102, 102, 102)',
        lineHeight: '26px',
        height: '26px',
        '::placeholder': {
            color: '#b3b3b3',
        }
    },
};

const cardBrandToPfClass = {
    visa: 'pf-visa',
    mastercard: 'pf-mastercard',
    amex: 'pf-american-express',
    discover: 'pf-discover',
    diners: 'pf-diners',
    jcb: 'pf-jcb',
    unknown: 'pf-credit-card'
};

class ChangeCard extends VisualComponent {

    constructor(container) {
        super(container);
        this.form = this.container;

        if (!this.form.length) {
            return;
        }

        this.brandIconClass = cardBrandToPfClass.unknown;
        this.init();
    }

    init() {
        this.publicKey = this.form.data('stripe-public-key');
        this.stripe = window.Stripe(this.publicKey);

        this.initElements();
        this.initEvents();
    }

    initElements() {

        this.elements.processSpinner = this.form.find(selectors.processSpinner);
        this.lock();

        this.elements.alertContainer = this.form.find(selectors.alertContainer);

        this.elementsStripe = this.stripe.elements();

        this.elements.cardNumberElement = this.elementsStripe.create('cardNumber', {
            style: inputStyle
        });
        this.elements.cardNumberElement.mount(selectors.cardNumber);

        this.elements.cardExpiryElement = this.elementsStripe.create('cardExpiry', {
            style: inputStyle
        });
        this.elements.cardExpiryElement.mount(selectors.cardExpiry);

        this.elements.cardCvcElement = this.elementsStripe.create('cardCvc', {
            style: inputStyle
        });
        this.elements.cardCvcElement.mount(selectors.cardCVC);

        this.elements.inputZIP = this.form.find(selectors.cardZIP);
        this.elements.inputCountry = this.form.find(selectors.cardCountry);
        this.elements.inputState = this.form.find(selectors.cardState);
        this.elements.inputCity = this.form.find(selectors.cardCity);
        this.elements.inputAddress = this.form.find(selectors.cardAddress);
        this.elements.inputFieldState = this.form.find(selectors.inputFieldState);

        this.elements.userFullName = this.form.data('user-full-name');
        this.elements.brandIcon = this.form.find(selectors.brandIcon);

        this.elements.modalSubmit = this.form.find(selectors.modalSubmit);
        this.elements.modalForm = this.form.find(selectors.modalForm);
        this.elements.modal = $(selectors.modal);

        this.stateInputTemplate = $(selectors.stateInputTemplate).html();
    }

    afterLock()
    {
        this.elements.processSpinner.show();
    }

    afterUnlock()
    {
        this.elements.processSpinner.hide();
    }

    initEvents() {
        let self = this;

        self.elements.cardNumberElement.on('ready', () => {
            self.unlock();
            self.elements.cardNumberElement.focus();
        });

        self.elements.cardNumberElement.on('change', function (event) {
            if (event.brand) {
                self.setBrandIcon(event.brand);
            }
        });

        self.form[0].addEventListener('submit', function (e) {

            if (self.checkLock() === true) {
                self.lock();

                let options = {
                    address_zip: self.elements.inputZIP.val().trim(),
                    address_country: self.elements.inputCountry.val().trim(),
                    address_state: self.form.find(selectors.cardState).val().trim(),
                    address_city: self.elements.inputCity.val().trim(),
                    address_line1: self.elements.inputAddress.val().trim(),
                    name: self.elements.userFullName,
                };

                self.stripe.createToken(self.elements.cardNumberElement, options).then(self.processResult.bind(self));
            }
            e.preventDefault();
        });

        self.elements.inputCountry.on('change', function (e) {

            let select = self.elements.inputCountry.select().val(),
                states = window.sma.states,
                lists = null;


            self.elements.inputCountry.find('option').each(function (i, e) {
                if ($(e).val() === self.elements.inputCountry.val()) {
                    $(e).attr("selected", "selected");

                } else {
                    $(e).removeAttr("selected");
                }
            });

            if (states) {
                $.each(states, function (index, value) {
                    if (index === select) {
                        $.each(value, function (index, value) {
                            lists += "<option value='" + index + "'>" + value + "</option>";
                        });
                    }
                });

                if (lists === null) {
                    self.elements.inputFieldState.removeClass('input-select');
                    self.elements.inputFieldState.html(self.stateInputTemplate);
                } else {
                    self.elements.inputFieldState.addClass('input-select');
                    self.elements.inputFieldState.html('<select id="state" name="User[state]" class="js-user-state"></select>');
                    self.form.find(selectors.cardState).html(lists);
                }
            } else {
                self.inputFieldState.removeClass('input-select');
                self.inputFieldState.html(self.stateInputTemplate);
            }
        });

    }

    processResult(result) {
        let self = this;

        if (result.token) {
            $.ajax({
                url: this.form.attr('action'),
                method: 'POST',
                data: {
                    token: result.token,
                    postal_code: self.elements.inputZIP.val(),
                    User: {
                        country: self.elements.inputCountry.val(),
                        state: self.form.find(selectors.cardState).val(),
                        address: self.elements.inputAddress.val(),
                        city: self.elements.inputCity.val(),
                        zip_code: self.elements.inputZIP.val(),
                    }
                }
            }).done(function (r) {
                if (!r.message || !r.success) {
                    return;
                }

                $(selectors.idModal).modal('hide');

                let billingComponent = new Billing($(selectors.billingContainer));

                VisualComponent.showMessage(r.message, AlertTypes.SUCCESS);

            }).fail(function (xhr) {
                let message = xhr.responseJSON.message;
                VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.alertContainer,);
            }).always(function () {
                self.unlock();
            });
        } else if (result.error) {
            VisualComponent.showMessage(result.error.message, AlertTypes.ERROR, self.elements.alertContainer,);
            self.unlock();
        }
    };

    setBrandIcon(brand) {
        var pfClass = cardBrandToPfClass.hasOwnProperty(brand) ?
            cardBrandToPfClass[brand] :
            cardBrandToPfClass.unknown;

        this.elements.brandIcon.removeClass(this.brandIconClass);
        this.elements.brandIcon.addClass(pfClass);
        this.brandIconClass = pfClass;
    };
}

export {ChangeCard}