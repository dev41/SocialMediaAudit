import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";
import {Profile} from "./Profile";

const selectors = {
    profileContainer: '.js-profile-container',

    alertContainer: '.js-container-alert-profile',
    processSpinner: '.js-stripe-process-spinner',

    modalProfileForm: '.js-update-profile-form',
    modalPasswordForm: '.js-change-password-form',
    idModal: '#modal',
};

class ProfileUpdate extends VisualComponent
{
    constructor(container) {
        super(container);

        this.form = this.container;

        if (!this.form.length) {
            return;
        }
        this.init();
    }

    init() {
        this.initElements();
        this.initEvents();

    }

    initElements() {

        this.elements.alertContainer = this.form.find(selectors.alertContainer);
        this.elements.processSpinner = this.form.find(selectors.processSpinner);

        this.elements.modalProfileForm = $(selectors.modalProfileForm);
        this.elements.modalPasswordForm = $(selectors.modalPasswordForm);
    }

    initEvents() {
        let self = this;

        self.elements.modalProfileForm.on('beforeSubmit', function () {
            self.updateProfile();
            return false;
        });

        self.elements.modalPasswordForm.on('beforeSubmit', function () {
            self.changePassword();
            return false;
        });
    }


    updateProfile() {
        let self = this,
            formData = self.form.serialize();

        self.elements.processSpinner.show();
        self.lock();
        $("input").prop('disabled', true);

        self.form.addClass('disabled');

        $.ajax({
            url: self.form.attr("action"),
            method: 'POST',
            data: formData,
            processData: false
        }).done(function (r) {
            if (!r.message || !r.success) {
                return;
            }

            $(selectors.idModal).modal('hide');
            let profileComponent = new Profile(selectors.profileContainer);

            VisualComponent.showMessage(r.message, AlertTypes.SUCCESS);
        }).fail(function (xhr) {

            let message = xhr.responseJSON.message;

            if (typeof message === 'object') {
                let messages = '';
                Object.keys(message).forEach(function (key) {

                    messages += message[key];
                });
                message = messages;
            }

            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.alertContainer);
        }).always(function () {
            self.elements.processSpinner.hide();
            self.form.removeClass('disabled');
            $("input").prop('disabled', false);
            self.unlock();
        });
    }

    changePassword() {
        let self = this,
            formData = self.form.serialize();

        self.elements.processSpinner.show();
        self.lock();
        self.form.addClass('disabled');

        $.ajax({
            url: self.form.attr("action"),
            method: 'POST',
            data: formData
        }).done(function (r) {
            if (!r.message || !r.success) {
                return;
            }

            $(selectors.idModal).modal('hide');

            VisualComponent.showMessage(r.message, AlertTypes.SUCCESS);

        }).fail(function (xhr) {
            let message = xhr.responseJSON.message;
            if (typeof message === 'object') {
                let messages = '';
                Object.keys(message).forEach(function (key) {

                    messages += message[key];
                });
                message = messages;
            }
            VisualComponent.showMessage(message, AlertTypes.ERROR, self.elements.alertContainer);

        }).always(function () {

            self.elements.processSpinner.hide();
            self.form.removeClass('disabled');
            self.unlock();
        });
    }
}

export {ProfileUpdate}