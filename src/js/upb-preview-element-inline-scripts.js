jQuery(function ($) {

    // See jQuery off api http://api.jquery.com/off/ to modify
    $(document.body).on('upb_tab_preview_inline_js', function (e, upb) {
        $(".upb-tab-item").upbTab();
    });

    $(document.body).on('upb_accordion_preview_inline_js', function (e, upb) {
        $(".upb-accordion-item").upbAccordion();
    });
});