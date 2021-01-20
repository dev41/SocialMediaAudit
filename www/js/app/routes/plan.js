import {Confirmation} from "../components/dialog/Confirmation";

$(function() {

    if (!window.sma.user.plan_id) {
        return;
    }

    let acceptSubmit = false;

    $('#form-plan-base').on('submit', function() {
        let form = this;

        if (acceptSubmit) {
            return true;
        }

        Confirmation.show({
            title: 'Change plan to Basic.',
            content: 'Do you really want to change the plan?',
            onOk: function() {
                acceptSubmit = true;
                form.submit();
            },
        });

        return false;
    });

    $('#form-plan-advanced').on('submit', function() {
        let form = this;

        if (acceptSubmit) {
            return true;
        }

        Confirmation.show({
            title: 'Change plan to Advanced.',
            content: 'Do you really want to change the plan?',
            onOk: function() {
                acceptSubmit = true;
                form.submit();
            },
        });

        return false;
    });
});