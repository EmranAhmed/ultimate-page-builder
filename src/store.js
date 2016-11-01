class store {

    constructor() {
        this.states      = window._upb_states;
        this.status      = window._upb_status;
        this.previewName = 'upb-preview-frame';
    }

    reloadPreview() {
        window.frames[this.previewName].window.location.reload();
    }

    changeBaz() {
        this.abcd.foo = !this.abcd.foo;
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