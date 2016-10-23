(function (api, wp, $) {

    class UltimatePageBuilder {
        constructor(data) {
            this.data = {};
            $.extend(this.data, data);
        }

        getData() {
            console.log(this.data);
        }

    }

    api.bind('ready', () => {
        api.previewer.bind('_upb_page_data', (data) => {
            api.UltimatePageBuilder = new UltimatePageBuilder(data);

            api.UltimatePageBuilder.getData();
        });
    });

    ///api.Menus.NewMenuControl = api.Control.extend({});

})(wp.customize, wp, jQuery);