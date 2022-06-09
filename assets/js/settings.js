(function ($) {
    const INVALID_CLASS = 'invalid';

    $(document).ready(function () {
        init();
    });

    function toggleCustomDateBox() {
        $(this).siblings('.pe-custom-date-container').hide();

        if ($(this).val() === 'custom') {
            $(this).siblings('.pe-custom-date-container').show();
        }
    }

    function validateRequiredField() {
        $(this).removeClass(INVALID_CLASS);

        if ($(this).val().trim() === '') {
            $(this).addClass(INVALID_CLASS);
        }
    }

    function cleanUpValidationFromField() {
        $(this).removeClass(INVALID_CLASS);
    }

    function showErrorNotice()
    {
        hideErrorNotice();

        const $notice = $('<div>');
        $notice.addClass('pe-notice');
        $notice.addClass('error');
        $notice.html('AHa');

        $('.postexpirator-nav-tab-wrapper').after($notice);
    }

    function hideErrorNotice()
    {
        $('.pe-notice.error').remove();
    }

    function onSubmit(e) {
        validateRequiredField.bind(document.getElementById('expired-default-date-format'))();
        validateRequiredField.bind(document.getElementById('expired-default-time-format'))();
        validateRequiredField.bind(document.getElementById('expired-custom-expiration-date'))();

        if ($('#expirationdate_save_options').find('.invalid').length > 0) {
            showErrorNotice();

            e.preventDefault();
            return false;
        }

        hideErrorNotice();
    }

    function init() {
        $('.pe-custom-date-toggle').on('change', toggleCustomDateBox);

        $('#expired-default-date-format').on('blur', validateRequiredField);
        $('#expired-default-time-format').on('blur', validateRequiredField);
        $('#expired-custom-expiration-date').on('blur', validateRequiredField);

        $('#expirationdate_save_options').submit(onSubmit);
    }
})(jQuery, config);
