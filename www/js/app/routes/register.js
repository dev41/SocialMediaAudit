$(function () {
    $('.js-auto-generate-btn').on('click', function () {
        let randomstring = Math.random().toString(36).slice(-8);
        $('.js-field-password').val(randomstring).trigger('blur');
        return false;
    });

});