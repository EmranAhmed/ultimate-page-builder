class store {

    constructor() {
        this.states     = window._upb_states;
        this.status     = window._upb_status;
        this.l10n       = window._upb_l10n;
        this.breadcrumb = [];
        // this.preview    = 'upb-preview-frame';
    }

    // reloadPreview() {
    //    window.frames[this.preview].window.location.reload();
    // }

    getState() {
        return this.states;
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

    saveState(success, error) {
        wp.ajax.send("upb_save", {
            success : success,
            error   : error,
            data    : {
                nonce  : this.status._nonce,
                id     : this.status._id,
                states : this.states
            }
        });
    }
}

export default new store();