;(function ($) {
    $.fn.upbAccordion = function (settings) {

        let options = $.extend({}, $.fn.upbAccordion.defaults, settings);

        return this.each(function () {

            $(this).on('click', function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                //Expand or collapse this panel
                $(this).next().slideToggle('fast').toggleClass('active');

                //Hide the other panels
                $(this).parent().parent().find(".upb-accordion-content").not($(this).next()).slideUp('fast').removeClass('active');
            });
        });
    };
})(jQuery);

