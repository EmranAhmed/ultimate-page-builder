<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }

    $active_class = empty( $attributes[ 'active' ] ) ? '' : 'active';
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes ) ?>">

    <a href="#" class="upb-accordion-item"><?php upb_shortcode_title( $attributes ) ?></a>
    <div class="upb-accordion-content <?php echo esc_attr( $active_class ) ?>">
        <div><?php echo do_shortcode( $contents ) ?></div>
    </div>
</div>