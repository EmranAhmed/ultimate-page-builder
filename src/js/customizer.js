(function (api, wp, $) {

    api.PageBuilder               = api.PageBuilder || {};
    api.PageBuilder.data          = {id : '', options : {}, contents : ''};
    api.PageBuilder.vue           = {};
    api.PageBuilder.iframe        = null;
    api.PageBuilder.iframeMounted = false;

    api.PageBuilder.Panel = api.Panel.extend({
        attachEvents : function () {

            api.Panel.prototype.attachEvents.call(this);

            let options   = $('#page-builder-options-wrap'),
                panelMeta = this.container.find('.panel-meta'),
                button    = panelMeta.find('.customize-page-builder-options-toggle');

            button.on('click keydown', (event) => {

                if (api.utils.isKeydownButNotEnterEvent(event)) {
                    return;
                }

                event.preventDefault();

                if ('true' === button.attr('aria-expanded')) {
                    button.attr('aria-expanded', 'false');
                    panelMeta.removeClass('open');
                    panelMeta.removeClass('active-page-builder-options');
                    options.slideUp('fast');
                }
                else {
                    button.attr('aria-expanded', 'true');
                    panelMeta.addClass('open');
                    panelMeta.addClass('active-page-builder-options');
                    options.slideDown('fast');
                }

                return false;

            });

        },

        ready : function () {
            api.Panel.prototype.ready.call(this);

            this.container.find('#enable-page-builder').on('click', function () {
                api('enable_page_builder', (setting) => {
                    if ($(this).prop('checked')) {
                        setting.set($(this).val());
                    }
                    else {
                        setting.set('');
                    }

                });
            });
        },
    });

    /**
     * Extends wp.customize.panelConstructor with section constructor for page_builder_panel.
     */
    $.extend(api.panelConstructor, {
        page_builder_panel : api.PageBuilder.Panel
    });

    api.PageBuilder.Preview = {
        init : function () {

            this.preview = api.previewer;

            this.preview.bind('page_builder_data', (data) => {

                this.setState(data);
                this.setVue();
                this.setIframeVue();

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

                var x    = $(api.previewer.container).find('iframe')[0].contentWindow.window.document;
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

        setState : function (data) {
            api.PageBuilder.data = $.extend(api.PageBuilder.data, data);
        },
        getState : function () {
            return api.PageBuilder.data;
        },

        setIframeVue : function () {
            api.PageBuilder.iframe = $(api.previewer.container).find('iframe')[0].contentWindow.window.document;

            api.PageBuilder.vueIframe = new Vue({
                delimiters       : ['${', '}'],
                unsafeDelimiters : ['$!{', '}'],
                data             : api.PageBuilder.data,
                el               : $('#starter-app', api.PageBuilder.iframe)[0]
            });
        },
        setVue : function () {




        }
    };

    api.bind('ready', () => {


        // init vue state here

        //console.log(api.panel.has('page_builder_panel'));

        //if ( ! api.panel.has( 'page_builder_panel' ) ) {

        //    alert('NO page_builder_panel');
        //    return;
        //}

        //api.PageBuilder.Preview.preview = api.previewer;
        api.PageBuilder.Preview.init();

    });

    // wp.customize.previewer.refresh();

})(wp.customize, wp, jQuery);