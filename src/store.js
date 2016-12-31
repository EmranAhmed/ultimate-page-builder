import extend from 'extend'
import sanitizeHtml from 'sanitize-html'

class store {

    constructor() {
        this.tabs   = window._upb_tabs;
        this.status = window._upb_status;
        this.routes = window._upb_routes || [];

        this.l10n          = window._upb_l10n;
        this.router_config = window._upb_router_config;
        this.devices       = window._upb_preview_devices;
        this.grid          = window._upb_grid_system;
        this.preview       = 'upb-preview-frame';
        this.panel         = '';
        this.subpanel      = '';
    }

    reloadPreview() {
        window.frames[this.preview].contentWindow.location.reload();
    }

    getTabs() {
        return this.tabs;
    }

    addContentsToTab(tabId, contents = []) {
        this.getTabs().map((tab, index)=> {
            if (tab.id == tabId) {
                if (_.isArray(contents) && !_.isEmpty(contents)) {
                    contents.map((content)=> {
                        tab.contents.push(content);
                    })
                }
            }
        })
    }

    loadTabContents() {
        this.getTabs().map((tab)=> {

            this.getPanelContents(`_get_upb_${tab.id}_panel_contents`, function (contents) {
                tab.contents = extend(true, [], contents);
            }, function (error) {
                console.log(error);
            })

        });
    }

    getStatus() {
        return this.status;
    }

    isDirty() {
        return this.status.dirty;
    }

    stateChanged() {
        this.status.dirty = true
    }

    stateSaved() {
        this.status.dirty = false
    }

    cleanup(contents) {
        return contents.map((content) => {
            delete content['_upb_settings'];
            delete content['_upb_options'];
            delete content['_upb_field_attrs'];
            delete content['_upb_field_type'];

            if (content['contents'] && _.isString(content['contents'])) {
                delete content.attributes._contents;
            }

            if (content['contents'] && _.isArray(content['contents'])) {
                this.cleanup(content['contents']);
            }

            return content;
        });
    }

    closeSubPanel() {
        this.subpanel = '';
    }

    getNonce() {
        return this.status._nonce;
    }

    getId() {
        return this.status._id;
    }

    saveState(success, error) {

        const contents = {};

        this.tabs.map((data) => {
            let newdata          = extend(true, {}, data);
            contents[data['id']] = this.cleanup(newdata.contents);
        });

        if (contents['elements']) {
            delete contents.elements;
        }

        wp.ajax.send("_upb_save", {
            success : success,
            error   : error,
            data    : {
                _nonce    : this.status._nonce,
                id        : this.status._id,
                states    : contents,
                shortcode : this.getShortcode(contents.sections)
            }
        });
    }

    getShortcode(shortcodes) {
        return shortcodes.map((shortcode)=> {
            return wp.shortcode.string({
                tag     : shortcode.tag,
                attrs   : shortcode.attributes,
                content : this.getShortcodeContent(shortcode.contents)
            });
        }).join('');
    }

    getShortcodeContent(content) {

        if (_.isArray(content)) {
            return this.getShortcode(content);
        }

        if (_.isString(content)) {
            return this.wpKsesPost(content);
        }
        return null;
    }

    getPanelContents(panel_hook, success, error) {

        wp.ajax.send(panel_hook, {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce,
                id     : this.status._id
            }
        });
    }

    getSavedSections(success, error) {

        wp.ajax.send('_get_saved_sections', {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce
            }
        });
    }

    saveSectionToOption(contents, success, error) {

        wp.ajax.send('_save_section', {
            success : success,
            error   : error,
            data    : {
                _nonce   : this.status._nonce,
                contents : this.cleanup([extend(true, {}, contents)]).pop()
            }
        });
    }

    saveAllSectionToOption(contents, success, error) {

        wp.ajax.send('_save_section_all', {
            success : success,
            error   : error,
            data    : {
                _nonce   : this.status._nonce,
                contents : this.cleanup(extend(true, [], contents))
            }
        });
    }

    getSavedLayouts(success, error) {

        wp.ajax.send('_get_saved_layouts', {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce
            }
        });
    }

    loadPreviewAssets(name, assets) {
        _.each(assets, (url, type)=> {
            if (!_.isEmpty(url)) {
                let prefix  = `upb_preview_assets_${name}-${type}`;
                let preview = jQuery(window.frames[this.preview].contentWindow.document);

                if (jQuery(`#${prefix}`, preview).length > 0) {
                    return false;
                }

                if (type == 'css') {
                    jQuery('head', preview).append(`<link rel="stylesheet" id="${prefix}" type="text/css" href="${url}" />`);
                }

                if (type == 'js') {
                    jQuery('head', preview).append(`<script id="${prefix}" type="text/javascript" src="${url}"></script>`);
                }
            }
        });
    }

    getShortCodePreviewTemplate(name = 'default', success, error) {

        wp.ajax.send(`_get_upb_shortcode_preview_${name}`, {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce,
                id     : this.status._id
            }
        });
    }

    getAllUPBElements(success, error) {
        wp.ajax.send("_get_upb_elements_panel_contents", {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce
            }
        });
    }

    wpKsesPost(contents) {
        return sanitizeHtml(contents, {
            allowedTags       : this.l10n.allowedTags,
            allowedAttributes : this.l10n.allowedAttributes,
            allowedSchemes    : this.l10n.allowedSchemes
        });
    }

    addUPBOptions(contents, success, error) {
        wp.ajax.send(`_add_upb_options`, {
            success : success,
            error   : error,
            data    : {
                _nonce   : this.status._nonce,
                post_id  : this.status._id,
                contents : contents
            }
        });
    }

    wpAjax(action, query, success, error) {
        wp.ajax.send(action, {
            success : success,
            error   : error,
            data    : extend(true, {
                _nonce  : this.status._nonce,
                post_id : this.status._id,
            }, query)
        });
    }
}

export default new store();