<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>" <?php upb_shortcode_unique_selector( $shortcode_atts ) ?>>
	<?php
		echo do_shortcode( sprintf( '[contact-form-7 id="%d" title="%s"]', absint( $attributes[ 'id' ] ), esc_html( upb_get_shortcode_title( $attributes ) ) ) );
	?>
</div>