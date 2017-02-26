<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<script type="text/html" id="tmpl-upb-attachment-display-settings">
    <h2><?php _e( 'Attachment Display Settings' ); ?></h2>

    <# if ( 'undefined' !== typeof data.sizes ) { #>
        <label class="setting">
            <span><?php _e( 'Size' ); ?></span>
            <select class="size" name="size"
                    data-setting="size"
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

                        foreach ( $sizes as $value => $name ) : ?>
                    <# var size = data.sizes['<?php echo esc_js( $value ); ?>'];
                        if ( size ) { #>
                        <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, 'full' ); ?>>
                            <?php echo esc_html( $name ); ?> &ndash; {{ size.width }} &times; {{ size.height }}
                        </option>
                        <# } #>
                            <?php endforeach; ?>
                            </select>
        </label>
        <# } #>
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        wp.media.view.Settings.AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay.extend({
            template : function (view) {
                return wp.media.template('upb-attachment-display-settings')(view);
            }
        });
    });
</script>
