import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";

const selectors = {
    formTitle: '.js-subscription-form-title',
    cardNumber: '.js-stripe-card-number',
    cardExpiry: '.js-stripe-card-expiry',
    cardCVC: '.js-stripe-card-cvc',
    cardZIP: '.js-stripe-card-zip',
    TCAccept: '.js-user-tc-accept',
    cardCountry: '.js-user-country',
    cardState: '.js-user-state',
    cardCity: '.js-stripe-card-city',
    cardAddress: '.js-stripe-card-address',
    couponInput: '.js-stripe-coupon',
    inputFieldState: '.js-field-state',
    brandIcon: '.js-stripe-card-brand-icon',
    errorContainer: '.js-stripe-container-error',
    successContainer: '.js-stripe-container-success',
    couponContainer: '.js-coupon-container',
    successMessage: '.js-stripe-msg-success',
    completeMessage: '.js-stripe-msg-complete',
    processSpinner: '.js-stripe-process-spinner',
    processSpinnerAmount: '.js-amount-process-spinner',
    amountContainer: '.js-amount-container',
    alertAmount: '.js-amount-container-alert',
    messageSpinner: '.js-msg-spinner',
    btnTestCoupon: '.js-btn-test-coupon',
    btnProcess: '.js-btn-process',
    subscriptionPrice: '.js-subscription-price',
    appliedCouponInfo: '.js-applied-coupon-info',
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
    }
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

class Register extends VisualComponent {

    constructor(container)
    {
        super(container);
        this.form = this.container;

        if (!this.form.length) {
            return;
        }

        this.brandIconClass = cardBrandToPfClass.unknown;
        this.init();
    }

    init()
    {
        this.publicKey = this.form.data('stripe-public-key');
        this.planId = this.form.data('plan-id');

        this.stripe = window.Stripe(this.publicKey);

        this.initElements();
        this.initEvents();

    }

    initElements()
    {
        this.formTile = $(selectors.formTitle);

        this.elements = this.stripe.elements();

        this.cardNumberElement = this.elements.create('cardNumber', {
            style: inputStyle
        });
        this.cardNumberElement.mount(selectors.cardNumber);

        this.cardExpiryElement = this.elements.create('cardExpiry', {
            style: inputStyle
        });
        this.cardExpiryElement.mount(selectors.cardExpiry);

        this.cardCvcElement = this.elements.create('cardCvc', {
            style: inputStyle
        });
        this.cardCvcElement.mount(selectors.cardCVC);

        this.inputZIP = this.form.find(selectors.cardZIP);
        this.inputTCAccept = this.form.find(selectors.TCAccept);
        this.inputCountry = this.form.find(selectors.cardCountry);
        this.inputFieldState = this.form.find(selectors.inputFieldState);
        this.inputCity = this.form.find(selectors.cardCity);
        this.inputAddress = this.form.find(selectors.cardAddress);

        this.userFullName = this.form.data('user-full-name');
        this.brandIcon = this.form.find(selectors.brandIcon);
        this.btnProcess = this.form.find(selectors.btnProcess);

        this.processSpinner = $(selectors.processSpinner);

        this.couponContainer = $(selectors.couponContainer);
        this.couponInput = this.couponContainer.find(selectors.couponInput);
        this.btnTestCoupon = this.couponContainer.find(selectors.btnTestCoupon);
        this.subscriptionPrice = $(selectors.subscriptionPrice);
        this.processSpinnerAmount = $(selectors.processSpinnerAmount);
        this.amountContainer = $(selectors.amountContainer);
        this.alertAmount = $(selectors.alertAmount);
        this.appliedCouponInfo = $(selectors.appliedCouponInfo);

        this.stateInputTemplate = $(selectors.stateInputTemplate).html();
    }

    initEvents()
    {
        let self = this;

        self.cardNumberElement.on('ready', function() {
           self.cardNumberElement.focus();
        });

        self.cardNumberElement.on('change', function (event) {
            if (event.empty === true) {
                return;
            }

            if (event.brand) {
                self.setBrandIcon(event.brand);
            }

            if (event.error) {
                VisualComponent.showMessage(event.error.message, AlertTypes.ERROR);
            }
        });

        let submitForm = function() {
            self.processSpinner.show();
            self.form.addClass('disabled');

            let options = {
                address_zip: self.inputZIP.val(),
                address_country: self.inputCountry.val(),
                address_state: self.form.find(selectors.cardState).val(),
                address_city: self.inputCity.val(),
                address_line1: self.inputAddress.val(),
                name: self.userFullName
            };

            self.stripe.createToken(self.cardNumberElement, options).then(self.processResult.bind(self));
        };

        self.form.on('keypress', function (e) {
            let keycode = (e.keyCode ? e.keyCode : e.which) * 1;

            if (keycode === 13) {
                submitForm();
            }
        });
        self.form[0].addEventListener('submit', function (e) {
            submitForm();
        });
        self.btnProcess.on('click', function (e) {
            submitForm();
        });

        self.btnTestCoupon.on('click', function () {
            self.checkCoupon();
        });

        self.couponInput.on('keypress', function (e) {
            let keycode = (e.keyCode ? e.keyCode : e.which) * 1;

            if (keycode === 13) {
                self.checkCoupon();
            }
        });

        self.inputCountry.on('change', function (e) {

            let select = self.inputCountry.select().val(),
                states = window.sma.states,
                lists = null;


            self.inputCountry.find('option').each(function (i, e) {
                if ($(e).val() === self.inputCountry.val()) {
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
                    self.inputFieldState.removeClass('input-select');
                    self.inputFieldState.html(self.stateInputTemplate);
                } else {
                    self.inputFieldState.addClass('input-select');
                    self.inputFieldState.html('<select id="state" name="User[state]" class="js-user-state"></select>');
                    self.form.find(selectors.cardState).html(lists);
                }
            } else {
                self.inputFieldState.removeClass('input-select');
                self.inputFieldState.html(self.stateInputTemplate);
            }
        });

        self.container.find('.js-user-tc-accept-label').on('click', function (e) {
            if (e.target !== this) {
                return;
            }
            self.inputTCAccept.prop('checked', !self.inputTCAccept.prop('checked'));
        });
    }

    /**
     * @param {string} brand
     */
    setBrandIcon(brand)
    {
        let pfClass = cardBrandToPfClass.hasOwnProperty(brand) ?
            cardBrandToPfClass[brand] :
            cardBrandToPfClass.unknown;

        this.brandIcon.removeClass(this.brandIconClass);
        this.brandIcon.addClass(pfClass);
        this.brandIconClass = pfClass;
    };

    checkCoupon()
    {
        let self = this;
        let coupon = self.couponInput.val().trim();

        if (!coupon) {
            return;
        }

        self.processSpinnerAmount.show();
        self.amountContainer.addClass('disabled');

        $.ajax({
            url: self.couponContainer.data('url'),
            method: 'POST',
            data: {
                coupon_code: coupon,
                plan: self.planId
            }
        }).done(function (r) {
            self.showCouponResponse(r);
            self.couponContainer.hide();
        }).fail(function (xhr) {
            self.showCouponResponse(xhr.responseJSON);
        }).always(function () {
            self.processSpinnerAmount.hide();
            self.amountContainer.removeClass('disabled');
        });
    };


    /**
     * @param result
     */
    processResult(result)
    {
        let self = this;

        if (result.token) {

            $.ajax({
                url: self.form.attr('action'),
                method: 'POST',
                data: {
                    token: result.token,
                    postal_code: self.inputZIP.val(),
                    coupon_code: self.couponInput.val().trim(),
                    User: {
                        tc_accept: self.inputTCAccept.is(":checked") ? 1 : 0,
                        country: self.inputCountry.val(),
                        state: self.form.find(selectors.cardState).val(),
                        address: self.inputAddress.val(),
                        city: self.inputCity.val(),
                        zip_code: self.inputZIP.val(),
                    }
                }
            }).done(function (r) {
                if (!r.message || !r.success) {
                    return;
                }
                self.form.addClass('disabled');
                window.location.href = r.url;

            }).fail(function (xhr) {
                let message = xhr.responseJSON.message;
                VisualComponent.showMessage(message, AlertTypes.ERROR);
                self.processSpinner.hide();
                self.form.removeClass('disabled');
            });

        } else if (result.error) {
            VisualComponent.showMessage(result.error.message, AlertTypes.ERROR);
            self.processSpinner.hide();
            self.form.removeClass('disabled');
        }
    };


    showCouponResponse(response)
    {
        let self = this;
        if (!(response instanceof Object)) {
            return;
        }

        let message = response.message || '',
            price = response.price || 0,
            messageType = response.success ? AlertTypes.SUCCESS : AlertTypes.ERROR;

        self.alertAmount.html('');
        VisualComponent.showMessage(message, messageType, self.alertAmount);

        self.subscriptionPrice.html('$' + price);

        if (response['appliedCouponInfo']) {
            self.appliedCouponInfo.html(response['appliedCouponInfo']);
        }
    };
}

export {Register}