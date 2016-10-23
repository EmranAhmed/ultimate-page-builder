'use strict';

(function (api, wp, $) {

    api.UltimatePageBuilder = api.UltimatePageBuilder || {};
    api.UltimatePageBuilder.data = { id: '', options: {}, contents: '' };

    api.UltimatePageBuilder.Panel = api.Panel.extend({
        attachEvents: function attachEvents() {

            api.Panel.prototype.attachEvents.call(this);

            var options = $('#page-builder-options-wrap'),
                panelMeta = this.container.find('.panel-meta'),
                button = panelMeta.find('.customize-page-builder-options-toggle');

            button.on('click keydown', function (event) {

                if (api.utils.isKeydownButNotEnterEvent(event)) {
                    return;
                }

                event.preventDefault();

                if ('true' === button.attr('aria-expanded')) {
                    button.attr('aria-expanded', 'false');
                    panelMeta.removeClass('open');
                    panelMeta.removeClass('active-page-builder-options');
                    options.slideUp('fast');
                } else {
                    button.attr('aria-expanded', 'true');
                    panelMeta.addClass('open');
                    panelMeta.addClass('active-page-builder-options');
                    options.slideDown('fast');
                }

                return false;
            });
        },

        ready: function ready() {
            api.Panel.prototype.ready.call(this);

            this.container.find('#enable-page-builder').on('click', function () {
                var _this = this;

                api('enable_page_builder', function (setting) {
                    if ($(_this).prop('checked')) {
                        setting.set($(_this).val());
                    } else {
                        setting.set('');
                    }
                });
            });
        }
    });

    /**
     * Extends wp.customize.panelConstructor with section constructor for page_builder_panel.
     */
    $.extend(api.panelConstructor, {
        page_builder_panel: api.PageBuilder.Panel
    });

    api.UltimatePageBuilder.Preview = {
        init: function init() {
            var _this2 = this;

            this.preview = api.previewer;

            this.preview.bind('page_builder_data', function (data) {

                _this2.setState(data);
                _this2.setVue();
                _this2.setIframeVue();

                ////

                /* $('#starter-app', api.PageBuilder.iframe).droppable({
                 drop: function(event, ui) {
                 //ACTION ON DROP HERE
                 }
                 });
                  $('.customize-control, .preview-desktop').draggable({
                 iframeFix: true,    //Core jquery ui params needs for fix iframe bug
                 iframeScroll: true  //This param needs for activate iframeScroll
                 });*/

                var x = $(api.previewer.container).find('iframe')[0].contentWindow.window.document;
                var drag = $('.customize-control').prop('draggable', true);
                var drop = api.PageBuilder.iframe.getElementById("#starter-app");
                //drag.draggable = true;

                /*$(x).find('*').on('drop', function (event) {
                 event.preventDefault();
                 event.stopPropagation();
                 console.log('Drop event');
                 });*/

                /*$(x).find('*').on('dragenter', function (event) {
                 event.preventDefault();
                 event.stopPropagation();
                 console.log('Drag Enter');
                 });*/

                /*$(x).find('*').on('dragover', function (event) {
                 event.preventDefault();
                 event.stopPropagation();
                 console.log('Drag Over');
                 });*/

                ///
            });
        },

        setState: function setState(data) {
            api.UltimatePageBuilder.data = $.extend(api.PageBuilder.data, data);
        },
        getState: function getState() {
            return api.UltimatePageBuilder.data;
        },

        setIframeVue: function setIframeVue() {
            api.UltimatePageBuilder.iframe = $(api.previewer.container).find('iframe')[0].contentWindow.window.document;
        }
    };

    api.bind('ready', function () {

        // init vue state here

        //console.log(api.panel.has('page_builder_panel'));

        //if ( ! api.panel.has( 'page_builder_panel' ) ) {
        //    alert('NO page_builder_panel');
        //    return;
        //}

        //api.PageBuilder.Preview.preview = api.previewer;
        api.UltimatePageBuilder.Preview.init();
    });

    // wp.customize.previewer.refresh();
})(wp.customize, wp, jQuery);