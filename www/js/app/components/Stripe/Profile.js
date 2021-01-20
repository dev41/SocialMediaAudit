import {VisualComponent} from "../VisualComponent";
import {Alert, messageTypes as AlertTypes} from "../Alert";

const selectors = {
    containerBody: '.js-profile-body',
    processSpinner: '.js-stripe-process-spinner',
    fullNameHeader: '.js-full-name',
};

class Profile extends VisualComponent {
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
        this.elements.containerBody = this.container.find(selectors.containerBody);
        this.elements.processSpinner = this.container.find(selectors.processSpinner);
        this.elements.fullNameHeader =  $(selectors.fullNameHeader);
    }

    initEvents() {
        let self = this;

        self.elements.processSpinner.show();
        self.elements.containerBody.addClass('hidden');
        self.lock();

        $.ajax({
            url: 'user-profile',
            method: 'POST',
        }).done(function (r) {
            if (!r.success) {
                return;
            }

            self.unlock();
            self.elements.containerBody.removeClass('hidden');

            let objUser = r.user;

            Object.keys(objUser).forEach(function (key) {
                self.elements.containerBody.find('[data-name="user-' + key + '"]').html(objUser[key]);
            });

            self.elements.fullNameHeader.html('<i class="stack-interface stack-users"></i>' + objUser['first_name'] + ' ' + objUser['last_name']);

            r.user.agency ? self.elements.containerBody.find('[data-name="agency-company_name"]').html(r.user.agency.company_name) : 'N/a';

        }).fail(function (xhr) {
            let message = xhr.responseJSON.message;

            VisualComponent.showMessage(message, AlertTypes.ERROR);
        }).always(function () {
            self.elements.processSpinner.hide();
        });

    }
}

export {Profile}