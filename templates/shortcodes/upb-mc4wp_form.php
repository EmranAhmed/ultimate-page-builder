<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, $tag ) ?>">

    <div class="mailchimp-form-title"><?php echo esc_html( $attributes[ 'text' ] ) ?></div>
	<?php
		if ( function_exists( 'mc4wp_show_form' ) ) :
			mc4wp_show_form();
		endif;
	?>
</div>