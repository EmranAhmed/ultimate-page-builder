<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<script type="text/html" id="tmpl-upb-attachment-display-settings">
    <h2><?php _e( 'Attachment Display Settings' ); ?></h2>

    <!--< # console.log(data.controller.options.upbOptions) # >-->

    <# if ( 'undefined' !== typeof data.sizes ) { #>
        <label class="setting">
            <span><?php _e( 'Size' ); ?></span>
            <select class="size" name="size" data-setting="size"
                <# if ( data.userSettings ) { #>
                    data-user-setting="imgsize"
                <# } #>>

                <?php
                    /** This filter is documented in wp-admin/includes/media.php */
                    $sizes = apply_filters( 'image_size_names_choose', array(
                        'thumbnail' => __( 'Thumbnail' ),
                        'medium'    => __( 'Medium' ),
                        'large'     => __( 'Large' ),
                        'full'      => __( 'Full Size' ),
                    ) );
                ?>
                <?php $sizes = apply_filters( 'upb_media_image_size_names_choose', $sizes ); ?>

                <?php foreach ( $sizes as $value => $name ) { ?>
                <# var size = data.sizes['<?php echo esc_js( $value ); ?>'];
                    if ( size ) { #>
                    <option value="<?php echo esc_attr( $value ); ?>"
                    <# if ( data.controller.options.upbOptions.size=='<?php echo esc_attr( $value ); ?>' ) { #>
                        selected="selected"
                    <# } #>>
                    <?php echo esc_html( $name ); ?> &ndash; {{ size.width }} &times; {{ size.height }} </option>
                <# } #>
                <?php } ?>
            </select>
        </label>
    <# } #>
</script>

<script type="text/html" id="tmpl-upb-attachment-details">
    <h2>
        <?php _e( 'Attachment Details' ); ?>
        <span class="settings-save-status">
				<span class="spinner"></span>
				<span class="saved"><?php esc_html_e( 'Saved.' ); ?></span>
			</span>
    </h2>
    <div class="attachment-info">
        <div class="thumbnail thumbnail-{{ data.type }}">
            <# if ( data.uploading ) { #>
                <div class="media-progress-bar"><div></div></div>
            <# } else if ( 'image' === data.type && data.sizes ) { #>
                <img src="{{ data.size.url }}" draggable="false" alt=""/>
            <# } else { #>
                <img src="{{ data.icon }}" class="icon" draggable="false" alt=""/>
            <# } #>
        </div>
        <div class="details">
            <div class="filename">{{ data.filename }}</div>
            <div class="uploaded">{{ data.dateFormatted }}</div>

            <div class="file-size">{{ data.filesizeHumanReadable }}</div>
            <# if ( 'image' === data.type && ! data.uploading ) { #>
                <# if ( data.width && data.height ) { #>
                    <div class="dimensions">{{ data.width }} &times; {{ data.height }}</div>
                <# } #>

                <# if ( data.can.save && data.sizes ) { #>
                    <a class="edit-attachment" href="{{ data.editLink }}&amp;image-editor" target="_blank"><?php _e( 'Edit Image' ); ?></a>
                <# } #>
            <# } #>

            <# if ( data.fileLength ) { #>
                <div class="file-length"><?php _e( 'Length:' ); ?> {{ data.fileLength }}</div>
            <# } #>

            <# if ( ! data.uploading && data.can.remove ) { #>
                <?php if ( MEDIA_TRASH ): ?>
                <# if ( 'trash' === data.status ) { #>
                    <button type="button" class="button-link untrash-attachment"><?php _e( 'Untrash' ); ?></button>
                <# } else { #>
                    <button type="button" class="button-link trash-attachment"><?php _ex( 'Trash', 'verb' ); ?></button>
                <# } #>
                <?php else: ?>
                    <button type="button" class="button-link delete-attachment"><?php _e( 'Delete Permanently' ); ?></button>
                <?php endif; ?>
            <# } #>

            <div class="compat-meta">
                <# if ( data.compat && data.compat.meta ) { #>
                    {{{ data.compat.meta }}}
                <# } #>
            </div>
        </div>
    </div>

    <label class="setting" data-setting="url">
        <span class="name"><?php _e( 'URL' ); ?></span>
        <input type="text" value="{{ data.url }}" readonly/>
    </label>

    <!-- MUST HAVE data-setting="title" otherwise after image upload URL and Preview will not shown :) -->
    <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
    <?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
        <label class="setting" data-setting="title">
            <span class="name"><?php _e('Title'); ?></span>
            <input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
        </label>
    <?php endif; ?>
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        wp.media.view.Settings.AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay.extend({
            template : function (view) {

                let upb_state  = this.controller.state().id;
                let templateId = 'attachment-display-settings';

                // console.log(this.controller.options.upbOptions.size);

                if ('upb-image-media' == upb_state) {
                    // Set Default Size
                    this.model.attributes.size = this.controller.options.upbOptions.size;
                    templateId                 = 'upb-attachment-display-settings';
                }

                return wp.media.template(templateId)(view);
            }
        });

        wp.media.view.Attachment.Details = wp.media.view.Attachment.Details.extend({
            template : function (view) {

                let upb_state  = this.controller.state().id;
                let templateId = 'attachment-details';

                if ('upb-image-media' == upb_state) {
                    templateId = 'upb-attachment-details';
                }

                return wp.media.template(templateId)(view);
            }
        })
    });
</script>
