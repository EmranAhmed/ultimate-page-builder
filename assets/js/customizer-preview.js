'use strict';

wp.customize.UltimatePageBuilderPreview = function ($, _, wp, api) {

    var self = {};

    /**
     * Initialize preview.
     */
    self.init = function () {
        api.preview.bind('active', function () {
            api.preview.send('page_builder_data', _wp_Customize_Preview_Page_Builder_Page_Data);
        });
    };

    api.bind('preview-ready', function (data) {

        if (api.settings.activePanels['ultimate-page-builder-panel']) {
            // $.extend(self.data, _wpCustomizePageBuilderPreview);
            self.init();
        }
    });

    return self;
}(jQuery, _, wp, wp.customize);