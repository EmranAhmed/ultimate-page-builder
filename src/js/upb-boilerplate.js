jQuery($ => {
    $(window).on('beforeunload', () => {
        if (_upb_status.dirty) {
            return "";
        }
    });
});