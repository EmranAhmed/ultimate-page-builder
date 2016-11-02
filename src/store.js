class store {

    constructor() {
        this.states     = window._upb_states;
        this.status     = window._upb_status;
        this.l10n       = window._upb_l10n;
        this.breadcrumb = [];
        this.preview    = 'upb-preview-frame';
    }

    reloadPreview() {
        window.frames[this.preview].window.location.reload();
    }

    getState() {
        return this.states;
    }

    getStatus() {
        return this.status;
    }

    isSaved() {
        return this.status.saved;
    }

    changeStatus() {
        this.status.saved = !this.status.saved
    }

}

export default new store();