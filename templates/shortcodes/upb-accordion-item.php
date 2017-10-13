<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
	
	$active_class = empty( $attributes[ 'active' ] ) ? '' : 'active';
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes ) ?>">
    <a href="#" class="upb-accordion-item <?php echo esc_attr( $active_class ) ?>"><?php upb_shortcode_title( $attributes ) ?></a>
    <div class="upb-accordion-content <?php echo esc_attr( $active_class ) ?>">
        <div><?php echo do_shortcode( $contents ) ?></div>
        <div style="clear: both"></div>
    </div>
</div>