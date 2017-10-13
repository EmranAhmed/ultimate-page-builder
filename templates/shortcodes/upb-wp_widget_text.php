<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
	<?php
		
		$instance = wp_parse_args( array(
			                           'title'  => sanitize_text_field( upb_get_shortcode_title( $attributes ) ),
			                           'text'   => upb_return_boolean( $attributes[ 'filter' ] ) ? wp_kses_post( $attributes[ 'text' ] ) : esc_textarea( $attributes[ 'text' ] ),
			                           'filter' => upb_return_boolean( $attributes[ 'filter' ] ),
		                           ), array(
			                           'title'  => '',
			                           'text'   => '',
			                           'filter' => FALSE
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Text', $attributes );
		
		the_widget( 'WP_Widget_Text', $instance, $args );
	?>
</div>