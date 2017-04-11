;(function ($) {
    $.fn.upbAccordion = function (settings) {

        let options = $.extend({}, $.fn.upbAccordion.defaults, settings);

        return this.each(function () {

            // console.log('EXECUTED accordion');

            $(this).on('click', function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                //Expand or collapse this panel
                $(this).next().slideToggle('fast', function () {
                    $(this).toggleClass('active');
                }.bind(this)).toggleClass('active');

                //Hide the other panels
                $(this).parent().parent().find(".upb-accordion-content").not($(this).next()).slideUp('fast').removeClass('active');
                $(this).parent().parent().find('.upb-accordion-item').not($(this)).removeClass('active');

            });
        });
    };
})(jQuery);

