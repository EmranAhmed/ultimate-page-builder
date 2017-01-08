import store from './store'
import extend from 'extend'

export default{
    props : {
        index : {
            type : Number
        },

        model : {
            type : Object
        }
    },

    data(){
        return {
            l10n : store.l10n
        }
    },

    created(){

        this.$watch('model.contents', function (newVal, oldVal) {
            this.addClass();
            this.setPreviewData();
        });

        this.$watch('model.attributes', function (newVal, oldVal) {
            this.attributeWatch();
        }, {deep : true});
    },

    beforeDestroy(){
        this.deletePreviewData();
        this.removeInlineScript();
    },

    mounted(){
        this.addClass();
        this.setPreviewData();
        this.loadScripts();
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
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {

        attributeWatch : _.debounce(function () {
            this.addClass();
            this.setPreviewData();
            this.inlineScriptInit(true);
        }, 800),

        setPreviewData(){
            store.previewWindow()._UPB_PREVIEW_DATA[this.unique_id] = extend(true, {}, {
                element    : this.$el,
                attributes : this.attributes,
                contents   : this.contents
            });
        },

        deletePreviewData(){
            return delete store.previewWindow()._UPB_PREVIEW_DATA[this.unique_id];
        },

        removeInlineScript(){
            if (this.model._upb_options.assets.preview.inline_js) {

                let prefixInlineJS  = `upb_preview_assets_${this.unique_id}-inline-js`;
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
                let prefixInlineJS  = `upb_preview_assets_${this.unique_id}-inline-js`;

                script.id   = prefixInlineJS;
                script.type = 'text/javascript';
                // script.innerHTML    =  ;

                script.innerHTML = `;(function(upbComponentId){
                    ${this.model._upb_options.assets.preview.inline_js}
                }( '${this.unique_id}' ));`;

                if (remove) {
                    this.removeInlineScript();
                }

                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }
        },

        loadScripts(){

            let previewDocument = store.previewDocument();

            let prefixInlineJS = `upb_preview_assets_${this.unique_id}-inline-js`;
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

            // re-load inline script when main script already added and inline run once
            if (this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixInlineJS}`).length > 0) {
                this.inlineScriptInit(true);
            }

            // no main script but need to load inline script
            if (!this.model._upb_options.assets.preview.js) {
                this.inlineScriptInit();
            }

            // load main script then load inline script
            if (this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixJS}`).length < 1) {

                let script    = document.createElement('script');
                script.id     = prefixJS;
                script.type   = 'text/javascript';
                script.src    = this.model._upb_options.assets.preview.js;
                script.async  = true;
                script.onload = _ => {
                    this.inlineScriptInit();
                };
                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }
        },

        addClass(){
            // No Content Class Added

            console.log(this.contents);

            if (this.hasContents) {
                this.$el.classList.remove('upb-preview-element-no-contents');
            }
            else {
                this.$el.classList.add('upb-preview-element-no-contents');
            }

            if (!this.model._upb_options.core) {
                this.$el.classList.add('upb-preview-element-non-core');
            }

            if (_.isArray(this.model.contents)) {
                this.$el.classList.add('upb-preview-element-type-container');
            }
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