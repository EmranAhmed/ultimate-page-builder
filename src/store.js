import extend from "extend";
import sanitizeHtml from "sanitize-html";
import url from "url";

class store {

    constructor() {
        this.tabs                  = _upb_tabs;
        this.status                = _upb_status;
        this.routes                = _upb_routes || [];
        this.fields                = _upb_fields || [];
        this.upb_user_inputs_mixin = _upb_user_inputs_mixin || {};

        this.l10n                 = _upb_l10n;
        this.router_config        = _upb_router_config;
        this.devices              = _upb_preview_devices;
        this.hidden_devices       = _upb_responsive_hidden_devices;
        this.grid                 = _upb_grid_system;
        this.elements             = _upb_registered_elements;
        this.preview              = 'upb-preview-frame';
        this.panel                = '';
        this.subpanel             = '';
        this.sidebarExpanded      = true;
        this.currentPreviewDevice = '';
        this._el_id               = 0;
    }

    isLocal(link = '') {

        if (link.trim() === '') {
            return true;
        }

        let $link = url.parse(link.trim(), true);

        return this.l10n.skipHosts.includes($link.host)

        // return $link.host === window.location.host;
    }

    isElementRegistered(tag) {
        return this.elements.includes(tag);
    }

    previewDocument() {
        return window.frames[this.preview].contentWindow ? window.frames[this.preview].contentWindow.document : window.frames[this.preview].document;
    }

    previewWindow() {
        return window.frames[this.preview].contentWindow ? window.frames[this.preview].contentWindow : window.frames[this.preview];
    }

    reloadPreview() {
        if (window.frames[this.preview].contentWindow) {
            window.frames[this.preview].contentWindow.location.reload();
        }
        else {
            window.frames[this.preview].location.reload();
        }
    }

    getTabs() {
        return this.tabs;
    }

    addContentsToTab(tabId, contents = []) {
        this.getTabs().map((tab, index) => {
            if (tab.id == tabId) {
                if (_.isArray(contents) && !_.isEmpty(contents)) {
                    contents.map((content) => {
                        tab.contents.push(content);
                    })
                }
            }
        })
    }

    getContentsOfTab(tabId) {
        return this.getTabs().filter((tab) => {
            return tab.id == tabId;
        })
    }

    getSettings() {
        return this.getContentsOfTab('settings').pop().contents;
    }

    getSetting(id = false) {

        if (!id) {
            return null;
        }

        let setting = this.getSettings().filter(setting => {
            return setting.metaId == id;
        }).pop();

        if (_.isObject(setting)) {
            return setting.metaValue;
        }
        else {
            return null;
        }
    }

    loadTabContents() {
        this.getTabs().map((tab) => {

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

    addElementUniqueID(attributes) {
        attributes._upb_el_uid = this._el_id;
        this._el_id++;
        return attributes;
    }

    cleanup(contents, add_unique_id = true) {
        return contents.map((content) => {
            delete content['_upb_settings'];
            delete content['_upb_options'];
            delete content['_upb_field_attrs'];
            delete content['_upb_field_type'];

            /* if (content['contents'] && _.isString(content['contents'])) {
                 delete content.attributes._contents;
             }*/

            if (content.attributes) {
                if (add_unique_id) {
                    content.attributes = this.addElementUniqueID(content.attributes);
                }

                this.removePrivateAttributes(content.attributes);
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

        if (contents['layouts']) {
            delete contents.layouts;
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
        return shortcodes.map((shortcode) => {

            let attributes = extend(true, {}, shortcode.attributes);

            attributes = this.removePrivateAttributes(attributes);

            return wp.shortcode.string({
                tag     : shortcode.tag,
                attrs   : attributes,
                type    : this.filterBoolean(shortcode.contents) ? 'self-closing' : 'closed',
                content : this.getShortcodeContent(shortcode.contents)
            });
        }).join('');
    }

    removePrivateAttributes(attributes) {

        if (!_.isUndefined(attributes['_contents'])) {
            delete attributes._contents;
        }

        // If user use "__" as key prefix this will deleted :)
        Object.keys(attributes).map((key) => {
            if (key.substring(0, 2) == '__') {
                delete attributes[key];
            }
        });

        return attributes;
    }

    generateShortcode(tag, attrs, content = null) {

        let attributes = extend(true, {}, attrs);

        attributes = this.removePrivateAttributes(attributes);

        return wp.shortcode.string({
            tag     : tag,
            attrs   : attributes,
            type    : this.filterBoolean(content) ? 'self-closing' : 'closed',
            content : this.getShortcodeContent(content)
        })
    }

    filterBoolean(value) {
        return _.isString(value) && ['true', 'false', '0', '1', 'null', 'undefined', '-0'].includes(value.trim().toLowerCase());
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
            },
            cache   : true,
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
            },
            cache   : true,
        });
    }

    getShortCodePreviewTemplate(name = 'default', success, error) {

        wp.ajax.send(`_get_upb_shortcode_preview_${name}`, {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce,
                id     : this.status._id
            },
            cache   : true,
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

    wpAjax(action, query, success, error, options = {}) {
        wp.ajax.send(action, extend(true, {
            success : success,
            error   : error,
            data    : extend(true, {
                _nonce  : this.status._nonce,
                post_id : this.status._id,
            }, query)
            //,cache   : true,
            //type    : 'GET'
        }, options));
    }
}

export default new store();