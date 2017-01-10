<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings
    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div class="<?php upb_shortcode_class( $attributes, esc_attr( upb_make_column_class( $attributes, 'upb-col' ) ) ) ?>">
    <?php echo do_shortcode( $contents ) ?>
</div>

