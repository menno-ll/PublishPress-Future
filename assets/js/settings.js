(function ($) {
    $(document).ready(function () {
        init();
    });

    function toggleCustomDateBox()
    {
        $(this).siblings('.pe-custom-date-container').hide();

        if ($(this).val() === 'custom') {
            $(this).siblings('.pe-custom-date-container').show();
        }
    }

    function init() {
        $('.pe-custom-date-toggle').on('change', toggleCustomDateBox);
    }
})(jQuery, config);
