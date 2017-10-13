<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
	<?php
		// Check /wp-includes/widgets/class-wp-widget-archives.php line#135
		
		$instance = wp_parse_args( array(
			                           'title'        => sanitize_text_field( upb_get_shortcode_title( $attributes ) ),
			                           'dropdown'     => $attributes[ 'dropdown' ] ? 1 : 0,
			                           'count'        => $attributes[ 'count' ] ? 1 : 0,
			                           'hierarchical' => $attributes[ 'count' ] ? 1 : 0
		                           ), array(
			                           'title'        => '',
			                           'count'        => '',
			                           'dropdown'     => '',
			                           'hierarchical' => ''
		                           ) );
		
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Categories', $attributes );
		
		the_widget( 'WP_Widget_Categories', $instance, $args );
	?>
</div>