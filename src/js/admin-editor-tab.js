jQuery(function ($) {
    $('#post-body-content').find('.wp-editor-tabs').prepend(`<a style="text-decoration: none" href="${_upb_admin_editor.edit_link}" class="wp-switch-editor">${_upb_admin_editor.edit_text}</a>`);
})