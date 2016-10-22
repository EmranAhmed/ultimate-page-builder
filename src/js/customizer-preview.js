wp.customize.UPBPreview = ( function ($, _, wp, api) {

    const self = {};

    /**
     * Initialize preview.
     */
    self.init = () => {
        api.preview.bind('active', () => {
            api.preview.send('page_builder_data', _wp_Customize_Preview_Page_Builder_Page_Data);

        });

    };

    api.bind('preview-ready', (data) => {

        if (api.settings.activePanels['ultimate-page-builder-panel']) {
            // $.extend(self.data, _wpCustomizePageBuilderPreview);
            self.init();
        }
    });

    return self;

}(jQuery, _, wp, wp.customize) );