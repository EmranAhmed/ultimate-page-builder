<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }

    $active_class = empty( $attributes[ 'active' ] ) ? '' : 'active';

    global $upb_tabs;

    $upb_tabs[] = $attributes;
?>
<div class="upb-tab-content <?php echo esc_attr( $active_class ) ?>">
    <?php echo do_shortcode( $contents ) ?>
</div>

