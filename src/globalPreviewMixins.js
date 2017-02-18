import store from './store'
import extend from 'extend'
import {sprintf} from 'sprintf-js'

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
                this.getAjaxContentsDebounce();
                this.attributeWatch();
            }
        }, {deep : this.model._upb_options.preview.shortcode});

        this.$watch('model.attributes', function (newVal, oldVal) {
            //this.addClass();
            this.setPreviewData();
            this.attributeWatch();
            this.getAjaxContentsDebounce();
        }, {deep : true});

        this.$nextTick(function () {
            this.addKeyIndex(this.model._upb_options._keyIndex);
        });

        this.setPreviewData();
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

        uniqueId(){
            return `upb-${this._uid}`;
        },

        attributes(){
            return this.model.attributes;
        },

        contents(){
            return this.model.contents;
        },

        tag(){
            return this.model.tag;
        },

        enabled(){
            if (!_.isUndefined(this.model.attributes['enable'])) {
                return this.model.attributes.enable;
            }
            else {
                return true;
            }
        },

        active(){
            return this.model.attributes.active;
        },

        title(){
            return this.model.attributes.title;
        },

        deviceHiddenClasses(){
            if (!_.isUndefined(this.model.attributes['device-hidden'])) {
                return this.model.attributes['device-hidden'].join(' ');
            }
            else {
                return '';
            }
        },

        backgroundVariables(){

            let background = {};
            if (!_.isUndefined(this.model.attributes['background-type'])) {

                if (this.model.attributes['background-type'] == 'both' || this.model.attributes['background-type'] == 'color') {
                    background['--background-color'] = this.model.attributes['background-color'];
                }

                if (this.model.attributes['background-type'] == 'both' || this.model.attributes['background-type'] == 'image') {
                    background['--background-image']      = `url(${this.model.attributes['background-image']})`;
                    background['--background-position']   = this.model.attributes['background-position'];
                    background['--background-repeat']     = this.model.attributes['background-repeat'];
                    background['--background-attachment'] = this.model.attributes['background-attachment'];
                    background['--background-origin']     = this.model.attributes['background-origin'];
                    background['--background-size']       = this.model.attributes['background-size'];
                }

                if (this.model.attributes['background-type'] == 'gradient') {
                    background['--gradient-position']       = this.model.attributes['gradient-position'];
                    background['--gradient-start-color']    = this.model.attributes['gradient-start-color'];
                    background['--gradient-start-location'] = this.model.attributes['gradient-start-location'] + '%';
                    background['--gradient-end-color']      = this.model.attributes['gradient-end-color'];
                    background['--gradient-end-location']   = this.model.attributes['gradient-end-location'] + '%';
                }
            }
            return background;
        },

        elementID(){

            if (!_.isUndefined(this.model.attributes['element_id'])) {
                return this.model.attributes.element_id;
            }
            return false;
        },

        elementClass(){
            if (!_.isUndefined(this.model.attributes['element_class'])) {
                return this.model.attributes.element_class;
            }
            return false;
        },

        sidebarExpanded(){
            return store.sidebarExpanded
        },

        keyIndex(){
            return this.model._upb_options._keyIndex
        },

        messages(){
            return this.model._upb_options.meta.messages;
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
            if (_.isArray(this.contents)) {
                this.contents.map((m, i) => {
                    if (this.isElementRegistered(m.tag)) {
                        m._upb_options['_keyIndex'] = `${keyindex}/${i}`;
                    }
                    else {
                        console.info(`%c Element "${m.tag}" is used but not registered. It's going to remove...`, 'color:red; font-size:18px');
                        this.model.contents.splice(i, 1);
                        store.stateChanged();
                        this.$toast.warning(sprintf(this.l10n.elementNotRegistered, m.tag));
                    }
                });
            }
        },

        getAjaxContents(){
            if (this.model._upb_options.preview.ajax) {
                if (this.model._upb_options.preview.shortcode) {
                    store.wpAjax(this.model._upb_options.preview['ajax-hook'], {
                            attributes : this.attributes,
                            shortcode  : store.generateShortcode(this.tag, this.attributes, this.contents)
                        },
                        contents=> {
                            //this.$nextTick(function () {
                            if (_.isEmpty(contents)) {
                                console.info(`%c Empty content returns. Is your "${this.tag}" shortcode template available on: "shortcodes/${this.tag}.php" path?`, 'color:red; font-size:18px')
                            }

                            this.$set(this, 'xhrContents', contents)
                            //});
                        },
                        error=> {

                            if (error == 0) {
                                console.info(`%c You should add "${this.model._upb_options.preview['ajax-hook']}" wp ajax hook. like: "wp_ajax_${this.model._upb_options.preview['ajax-hook']}".`, 'color:red; font-size:18px')
                            }
                            else {
                                console.info(error);
                            }
                        }, {
                            cache : true
                        });
                }
                else {
                    store.wpAjax(this.model._upb_options.preview['ajax-hook'], this.attributes,
                        contents=> {
                            //this.$nextTick(function () {
                            this.$set(this, 'xhrContents', contents)
                            //});
                        },
                        error=> {

                            if (error == 0) {
                                console.info(`%c You need to implement "${this.model._upb_options.preview['ajax-hook']}" with wp ajax: "wp_ajax_${this.model._upb_options.preview['ajax-hook']}".`, 'color:red; font-size:18px')
                            }
                            else {
                                console.info(error);
                            }
                        },
                        {
                            cache : true
                        });
                }
            }
        },

        getAjaxContentsDebounce : _.debounce(function () {
            this.getAjaxContents();
        }, 300),

        inlineStyle(style = {}){
            return extend(false, {}, this.backgroundVariables, style);
        },

        addID(){

            if (!_.isUndefined(this.attributes['element_id'])) {
                return this.attributes.element_id;
            }
            return null;
        },

        isElementRegistered(tag){
            return store.isElementRegistered(tag);
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

        addPreviewClass(extra = false){

            let cssClasses = [];

            cssClasses.push(`upb-preview-element`);

            cssClasses.push(`${this.tag}-preview`);

            if (extra && _.isString(extra)) {
                cssClasses.push(extra);
            }

            if (extra && _.isArray(extra)) {
                cssClasses.push(...extra);
            }

            if (this.model._upb_options.hasMiniToolbar) {
                cssClasses.push(`upb-has-mini-toolbar`);
            }

            if (this.sidebarExpanded) {
                cssClasses.push(`upb-sidebar-expanded`);
            }
            else {
                cssClasses.push(`upb-sidebar-collapsed`);
            }

            if (this.enabled) {
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

        addClass(extra = false, combinePreview = true){

            let cssClasses = [];

            if (extra && _.isString(extra)) {
                cssClasses.push(extra);
            }

            if (extra && _.isArray(extra)) {
                cssClasses.push(...extra);
            }

            if (combinePreview) {
                cssClasses.push(this.addPreviewClass());
            }

            if (this.elementClass) {
                cssClasses.push(this.elementClass);
            }

            if (this.deviceHiddenClasses) {
                cssClasses.push(this.deviceHiddenClasses);
            }

            return cssClasses.join(' ');
        },

        openElementsPanel(){
            this.$router.replace(`/elements`);
        },

        openSettingsPanel(){
            this.$router.replace(`/settings`);
        },

        openLayoutsPanel(){
            this.$router.replace(`/layouts`);
        },

        // Alias of openElementItemsPanel
        openElementsItemPanel(path){
            this.openElementItemsPanel(path);
        },

        openElementItemsPanel(path){
            this.$router.replace(`/sections/${path}/contents`);
        },

        openElementSettingsPanel(path){
            this.$router.replace(`/sections/${path}/settings`);
        }
    }
}