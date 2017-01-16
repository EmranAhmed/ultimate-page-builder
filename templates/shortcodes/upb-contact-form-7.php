<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, 'upb-contact-form-7' ) ?>">
    <style scoped>
        :scope {
        <?php upb_shortcode_scoped_style_background($attributes) ?>
            }
    </style>

    <div>
        <?php
            echo do_shortcode( sprintf( '[contact-form-7 id="%d" title="%s"]', absint( $attributes[ 'id' ] ), esc_html( upb_get_shortcode_title( $attributes ) ) ) );
        ?>
    </div>

</div>

