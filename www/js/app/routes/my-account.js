import {Subscription} from "../components/Stripe/Subscription";
import {Billing, events as BillingEvents} from "../components/Stripe/Billing";
import {BillingHistory} from "../components/Stripe/BillingHistory";
import {ChangeCard} from "../components/Stripe/ChangeCard";
import {ProfileUpdate} from "../components/Stripe/ProfileUpdate";
import {Register} from "../components/Stripe/Register";

$(function () {
    new Register($('.js-subscription-form'));

    if (window.location.pathname === '/my-account') {

        new Subscription($('.js-subscription-container'));
        new Billing($('.js-billing-container'));
        new BillingHistory($('.js-stripe-billing-history'));

        $('.js-update-profile-btn').on('click', function (e) {
            showUpdateModal.call(this, function() {
                setTimeout(function () {
                    $('#user-first_name').focus();
                }, 500);
                new ProfileUpdate($('.js-update-profile-form'));
            });
        });

        $('.js-change-password-btn').on('click', function (e) {
            showUpdateModal.call(this, function() {
                setTimeout(function () {
                    $('#user-new_password').focus();
                }, 500);
                new ProfileUpdate($('.js-change-password-form'));
            });
        });

        $('.js-change-card-btn').on('click', function (e) {
            showUpdateModal.call(this, function() {
                new ChangeCard($('.js-stripe-change-card-form'));
            });
        });

        $('#modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-content').html(
                '<div class="js-stripe-process-spinner">\n' +
                '    <svg class="loader" style="position: absolute">\n' +
                '        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-loader"></use>\n' +
                '    </svg>\n' +
                '</div>'
            );
        });
    }
});

function showUpdateModal(onLoad)
{
    $('#modal')
        .modal({
            focus: false,
            show: true,
        })
        .find('.modal-dialog')
        .load($(this).attr('data-action'), function(e) {
            if (onLoad instanceof Function) {
                onLoad(e, this);
            }
        });
}