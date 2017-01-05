window.addEventListener('beforeunload', function (e) {
    let dialogText = 'Changes you made may not be saved.';
    if (_upb_status.dirty) {
        e.returnValue = dialogText;
        return dialogText;
    }
});