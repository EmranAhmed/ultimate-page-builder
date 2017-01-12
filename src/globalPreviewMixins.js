import store from './store'
import extend from 'extend'

export default{
    props : {
        index : {
            type : Number
        },

        model  : {
            type : Object
        },
        parent : {
            type : Object
        }
    },

    data(){
        return {
            l10n : store.l10n
        }
    },

    created(){

        this.$watch('sidebarExpanded', function (newVal, oldVal) {
            //this.addClass();
        });

        this.$watch('model.contents', function (newVal, oldVal) {

            this.setPreviewData();

            if (_.isArray(newVal)) {
                //this.setPreviewData();
                this.attributeWatch();
            }
        });

        this.$watch('model.attributes', function (newVal, oldVal) {
            //this.addClass();
            this.setPreviewData();
            this.attributeWatch();
        }, {deep : true});

        this.setPreviewData();

        this.$nextTick(function () {

            // First create
            _.delay(_=> {
                this.loadScripts();
            }, 100)

        });

    },

    beforeDestroy(){
        this.deletePreviewData();
        this.removeInlineScript();
    },

    mounted(){
        this.$nextTick(function () {
            _.delay(_=> {
                this.loadScripts();
            }, 100)
        });
    },

    computed : {

        hasContents(){
            if (_.isArray(this.model['contents'])) {
                return this.model.contents.length > 0;
            }

            return true;
        },

        unique_id(){
            return `upb-${this._uid}`;
        },

        attributes(){
            return this.model.attributes;
        },

        contents(){
            return this.model.contents;
        },

        isEnabled(){
            if (!_.isUndefined(this.model.attributes['enable'])) {
                return this.model.attributes.enable;
            }
            else {
                return true;
            }
        },

        hiddenDeviceClasses(){
            if (!_.isUndefined(this.model.attributes['hidden-device'])) {
                return this.model.attributes['hidden-device'].join(' ');
            }
            else {
                return '';
            }
        },

        backgroundVariables(){

            let background = {};
            if (!_.isUndefined(this.model.attributes['background-type'])) {

                if (this.model.attributes['background-type'] == 'both') {
                    background['--background-color']    = this.model.attributes['background-color'];
                    background['--background-image']    = `url(${this.model.attributes['background-image']})`;
                    background['--background-position'] = this.model.attributes['background-position']
                }

                if (this.model.attributes['background-type'] == 'color') {
                    background['--background-color'] = this.model.attributes['background-color'];
                }

                if (this.model.attributes['background-type'] == 'image') {
                    background['--background-image']    = `url(${this.model.attributes['background-image']})`;
                    background['--background-position'] = this.model.attributes['background-position']
                }
            }
            return background;
        },

        sidebarExpanded(){
            return this.$root.$data.store.sidebarExpanded
        },

        $router(){
            return this.$root.$data.store.panel._router;
        },

        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {

        inlineStyle(style = {}){

            //console.log(extend(false, {}, this.backgroundVariables, style));

            return extend(false, {}, this.backgroundVariables, style);
        },

        addID(){

            if (!_.isUndefined(this.model.attributes['element_id'])) {
                return this.model.attributes.element_id;
            }
            return null;
        },

        isElementRegistered(tag){
            return store.elements.includes(tag);
        },

        attributeWatch : _.debounce(function () {
            this.inlineScriptInit(true);
        }, 300),

        setPreviewData(){
            if (this.model._upb_options.assets.preview.inline_js) {

                if (!store.previewWindow()._UPB_PREVIEW_DATA[this.unique_id]) {
                    store.previewWindow()._UPB_PREVIEW_DATA[this.unique_id] = extend(true, {}, {
                        element    : this.$el,
                        attributes : this.attributes,
                        contents   : this.contents
                    });
                }
            }
        },

        deletePreviewData(){
            return delete store.previewWindow()._UPB_PREVIEW_DATA[this.unique_id];
        },

        removeInlineScript(){
            if (this.model._upb_options.assets.preview.inline_js) {

                //let prefixInlineJS  = `upb_preview_assets_${this.unique_id}-inline-js`;
                let prefixInlineJS  = `upb_preview_assets_${this.model.tag}-inline-js`;
                let previewDocument = store.previewDocument();

                if (previewDocument.querySelectorAll(`#${prefixInlineJS}`).length > 0) {
                    previewDocument.getElementsByTagName('body')[0].removeChild(previewDocument.getElementById(prefixInlineJS));
                }
            }
        },

        inlineScriptInit(remove = false){

            // NOTE: If inline_js wrapped with <script> tag. then appendChild cannot execute script
            // So don't add <script> tag with inline_js

            if (this.model._upb_options.assets.preview.inline_js) {
                let previewDocument = store.previewDocument();
                let script          = document.createElement('script');
                //let prefixInlineJS  = `upb_preview_assets_${this.unique_id}-inline-js`;
                let prefixInlineJS  = `upb_preview_assets_${this.model.tag}-inline-js`;

                script.id        = prefixInlineJS;
                script.type      = 'text/javascript';
                // script.innerHTML    =  ;
                script.innerHTML = `;(function(upbComponentId){
                try{ ${this.model._upb_options.assets.preview.inline_js} }catch(e){ console.info(e.message, upbComponentId) }
                }( '${this.unique_id}' ));`;

                if (remove) {
                    this.removeInlineScript();
                }
                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }
        },

        loadScripts(){

            let previewDocument = store.previewDocument();

            //let prefixInlineJS = `upb_preview_assets_${this.unique_id}-inline-js`;
            let prefixInlineJS = `upb_preview_assets_${this.model.tag}-inline-js`;
            let prefixJS       = `upb_preview_assets_${this.model.tag}-js`;
            let prefixCSS      = `upb_preview_assets_${this.model.tag}-css`;

            // Load CSS
            if (this.model._upb_options.assets.preview.css && previewDocument.querySelectorAll(`#${prefixCSS}`).length < 1) {

                let style  = document.createElement('link');
                style.rel  = 'stylesheet';
                style.id   = prefixCSS;
                style.type = 'text/css';
                style.href = this.model._upb_options.assets.preview.css;

                previewDocument.getElementsByTagName('head')[0].appendChild(style);
            }

            // Load JS

            // NOTE: If inline_js wrapped with <script> tag. then appendChild cannot execute script

            // no main script but need to load inline script
            if (!this.model._upb_options.assets.preview.js && this.model._upb_options.assets.preview.inline_js) {
                this.inlineScriptInit(true);
                //console.log('no main script but need to load inline script')
            }

            // main script id added and inline_js
            // When user add new element or same element on other place
            if ((this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixJS}`).length > 0) && this.model._upb_options.assets.preview.inline_js) {

                // Script loaded then call inline script.
                previewDocument.getElementById(`${prefixJS}`).onload = _ => {
                    this.inlineScriptInit(true);
                    //console.log('Script loaded then call inline script.');
                };

                // Script will not load because its already loaded
                _.delay(_=> {
                    this.inlineScriptInit(true);
                    //console.log('_.delay Script will not load because its already loaded');
                }, 200);

            }

            // New element
            if (this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixJS}`).length < 1) {

                let script    = document.createElement('script');
                script.id     = prefixJS;
                script.type   = 'text/javascript';
                script.src    = this.model._upb_options.assets.preview.js;
                script.async  = true;
                script.onload = _ => {
                    //console.log('preview js loaded')
                    this.inlineScriptInit(true);
                };
                previewDocument.getElementsByTagName('body')[0].appendChild(script);

                //console.log('preview js added')

            }
        },

        addClass(extra = false){

            let cssClasses = [];

            cssClasses.push(`upb-preview-element`);
            cssClasses.push(`${this.model.tag}-preview`);

            if (extra && _.isString(extra)) {
                cssClasses.push(extra);
            }

            if (extra && _.isArray(extra)) {
                cssClasses.push(...extra);
            }

            if (this.model._upb_options.hasMiniToolbar) {
                cssClasses.push(`upb-has-mini-toolbar`);
            }

            if (!_.isUndefined(this.model.attributes['element_class'])) {
                cssClasses.push(this.model.attributes.element_class);
            }

            if (this.hiddenDeviceClasses) {
                cssClasses.push(this.hiddenDeviceClasses);
            }

            if (this.sidebarExpanded) {
                cssClasses.push(`upb-sidebar-expanded`);
            }
            else {
                cssClasses.push(`upb-sidebar-collapsed`);
            }

            if (this.isEnabled) {
                cssClasses.push(`upb-preview-element-enabled`);
            }
            else {
                cssClasses.push(`upb-preview-element-disabled`);
            }

            if (!this.hasContents) {
                cssClasses.push(`upb-preview-element-no-contents`);
            }

            if (!this.model._upb_options.core) {
                cssClasses.push(`upb-preview-element-non-core`);
            }

            if (_.isArray(this.model.contents)) {
                cssClasses.push(`upb-preview-element-type-container`);
            }

            return cssClasses.join(' ');
        },

        openElementsPanel(){
            this.$router.replace(`/elements`);
        },

        // Alias of openElementItemsPanel
        openElementsItemPanel(path){
            this.openElementItemsPanel(path);
        },
        openElementItemsPanel(path){
            this.$router.replace(`/sections/${path}/contents`);
        }
    }
}