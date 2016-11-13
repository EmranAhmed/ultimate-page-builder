import extend from 'extend';

class store {

    constructor() {
        this.tabs       = window._upb_tabs;
        this.status     = window._upb_status;
        this.l10n       = window._upb_l10n;
        this.breadcrumb = [];
        this.devices    = window._upb_preview_devices;
        this.grid       = window._upb_grid_system;
        // this.preview    = 'upb-preview-frame';
    }

    // reloadPreview() {
    //    window.frames[this.preview].window.location.reload();
    // }

    getTabs() {
        return this.tabs;
    }

    getStatus() {
        return this.status;
    }

    isDirty() {
        return this.status.dirty;
    }

    changeStatus() {
        this.status.dirty = !this.status.dirty
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

            if (content['contents']) {
                this.cleanup(content['contents']);
            }
            return content;
        });
    }

    saveState(success, error) {

        const state = {};

        this.tabs.map((data) => {
            let newdata       = extend(true, {}, data);
            state[data['id']] = this.cleanup(newdata.contents);
        });

        wp.ajax.send("_upb_save", {
            success : success,
            error   : error,
            data    : {
                _nonce : this.status._nonce,
                id     : this.status._id,
                states : state
            }
        });
    }

    upbElementOptions(contents, success, error) {
        wp.ajax.send("_get_upb_element_options", {
            success : success,
            error   : error,
            data    : {
                _nonce   : this.status._nonce,
                contents : contents
            }
        });
    }
}

export default new store();