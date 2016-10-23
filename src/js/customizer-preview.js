wp.customize.UltimatePageBuilder_Preview = ( function ($, _, wp, api) {

    api.bind('preview-ready', (data) => {
        if (api.settings.activePanels['upb-panel']) {
            api.preview.bind('active', () => {
                api.preview.send('_upb_page_data', _UPB_Page_Data);
            });
        }
    });

    return self;

}(jQuery, _, wp, wp.customize) );