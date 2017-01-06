import store from './store'

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
        });

        this.$watch('model.attributes', function (newVal, oldVal) {
            this.addClass();
        }, {deep : true});
    },

    mounted(){
        this.addClass();
        this.loadScripts();
    },

    computed : {
        hasContents(){
            if (!_.isUndefined(this.model['contents'])) {
                return this.model.contents.length > 0;
            }
        },
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {

        inlineScriptInit(remove = false){

            // NOTE: If inline_js wrapped with <script> tag. then appendChild cannot execute script
            // So don't add <script> tag with inline_js

            if (this.model._upb_options.assets.preview.inline_js) {
                let previewDocument = store.previewDocument();
                let script          = document.createElement('script');
                let prefixInlineJS  = `upb_preview_assets_${this.model.tag}-inline-js`;
                script.id           = prefixInlineJS;
                script.type         = 'text/javascript';
                script.innerHTML    = this.model._upb_options.assets.preview.inline_js;

                if (remove && previewDocument.querySelectorAll(`#${prefixInlineJS}`).length > 0) {
                    previewDocument.getElementsByTagName('body')[0].removeChild(previewDocument.getElementById(prefixInlineJS));
                }

                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }
        },

        loadScripts(){

            let previewDocument = store.previewDocument();

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