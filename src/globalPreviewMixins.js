import store from './store'
import extend from 'extend'

export default{
    props : {
        index  : {
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
            l10n        : store.l10n,
            xhrContents : ''
        }
    },

    created(){

        this.$watch('model.contents', function (contents) {

            this.setPreviewData();
            this.addKeyIndex(this.model._upb_options._keyIndex);

            if (_.isArray(contents)) {
                //this.setPreviewData();
                this.getAjaxContents();
                this.attributeWatch();
            }
        });

        this.$watch('model.attributes', function (newVal, oldVal) {
            //this.addClass();
            this.setPreviewData();
            this.attributeWatch();
            this.getAjaxContents();
        }, {deep : true});

        this.setPreviewData();

        this.$nextTick(function () {
            this.addKeyIndex(this.model._upb_options._keyIndex);
        });

        this.getAjaxContents();
    },

    beforeDestroy(){
        this.deletePreviewData();
        this.removeInlineScript();
    },

    mounted(){
        this.loadScripts();
    },

    updated(){
        this.loadScripts();
    },

    computed : {

        ajaxContents(){
            return this.xhrContents;
        },

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
            return store.sidebarExpanded
        },

        $router(){
            return store.panel._router;
        },

        $route(){
            return store.panel._route;
        }
    },

    methods : {

        addKeyIndex(keyindex){
            if (_.isArray(this.model.contents)) {

                //console.log(this.model.tag, this.model.contents);

                this.model.contents.map((m, i) => {
                    m._upb_options['_keyIndex'] = `${keyindex}/${i}`;
                });
            }
        },

        getAjaxContents(){
            if (this.model._upb_options.preview.ajax) {
                store.wpAjax(this.model._upb_options.preview['ajax-hook'], this.attributes, contents=> {

                    //this.$nextTick(function () {
                    Vue.set(this, 'xhrContents', contents)
                    //});
                }, error=> {

                    if (error == 0) {
                        console.info(`You need to implement "${this.model._upb_options.preview['ajax-hook']}" with wp ajax: "wp_ajax_${this.model._upb_options.preview['ajax-hook']}".`)
                    }
                    else {
                        console.info(error);
                    }
                });
            }
        },

        inlineStyle(style = {}){
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

            if (remove) {
                this.removeInlineScript();
            }

            if (this.model._upb_options.assets.preview.inline_js) {

                let previewDocument = store.previewDocument();
                let script          = document.createElement('script');
                //let prefixInlineJS  = `upb_preview_assets_${this.unique_id}-inline-js`;
                let prefixInlineJS  = `upb_preview_assets_${this.model.tag}-inline-js`;

                script.id        = prefixInlineJS;
                script.type      = 'text/javascript';
                script.innerHTML = `;(function(upbComponentId){
                    try{
                        ${this.model._upb_options.assets.preview.inline_js}
                    }catch(e){
                        console.info(e.message, upbComponentId)
                    }
                    }('${this.unique_id}'));`;

                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }
        },

        loadScripts(){

            let previewDocument = store.previewDocument();

            //let prefixInlineJS = `upb_preview_assets_${this.unique_id}-inline-js`;
            let prefixInlineJS = `upb_preview_assets_${this.model.tag}-inline-js`;
            let prefixJS       = `upb_preview_assets_${this.model.tag}-js`;
            let prefixCSS      = `upb_preview_assets_${this.model.tag}-css`;

            // JS Already Loaded Re-Init InlineJS
            if ((this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixJS}`).length > 0) && this.model._upb_options.assets.preview.inline_js) {
                _.delay(()=> {
                    this.inlineScriptInit(true);
                }, 200);
            }

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
            if (this.model._upb_options.assets.preview.js && previewDocument.querySelectorAll(`#${prefixJS}`).length < 1) {

                let script   = document.createElement('script');
                script.id    = prefixJS;
                script.type  = 'text/javascript';
                script.src   = this.model._upb_options.assets.preview.js;
                script.async = true;

                // Load InlineJS
                if (this.model._upb_options.assets.preview.inline_js) {
                    script.onload = () => {
                        this.inlineScriptInit(true);
                    }
                }
                previewDocument.getElementsByTagName('body')[0].appendChild(script);
            }

            // NOTE: If inline_js wrapped with <script> tag. then appendChild cannot execute script
            // No JS but have InlineJS
            if (!this.model._upb_options.assets.preview.js && this.model._upb_options.assets.preview.inline_js) {
                this.inlineScriptInit(true);
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

            cssClasses.push(`element-id-${this.unique_id}`);

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