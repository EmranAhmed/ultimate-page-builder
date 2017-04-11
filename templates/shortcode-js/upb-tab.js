;(function ($) {
    $.fn.upbTab = function (settings) {

        let options = $.extend({}, $.fn.upbTab.defaults, settings);

        return this.each(function () {

            // console.log('EXECUTED tab');

            $(this).on('click', function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                var index = $(this).index();

                $(this).parent().find('.upb-tab-item').removeClass('active');

                $(this).parent().next().find('.upb-tab-content').removeClass('active');

                $(this).addClass('active');

                $(this).parent().next().find('.upb-tab-content').eq(index).addClass('active');
            });
        });
    };
})(jQuery);

