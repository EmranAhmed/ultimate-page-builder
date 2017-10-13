<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div class="<?php upb_shortcode_class( $attributes, $attributes[ 'container' ] ) ?>">
    <div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php echo esc_attr( upb_grid_system( 'groupClass' ) ) ?>">
		<?php echo do_shortcode( $contents ) ?>
    </div>
</div>