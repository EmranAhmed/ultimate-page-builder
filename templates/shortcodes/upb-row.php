<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div class="<?php upb_shortcode_class( $attributes, $attributes[ 'container' ] ) ?>">
    <div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php echo esc_attr( upb_grid_system( 'groupClass' ) ) ?>">
        <?php echo do_shortcode( $contents ) ?>
    </div>
</div>