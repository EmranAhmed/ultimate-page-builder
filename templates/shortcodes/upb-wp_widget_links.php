<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
	<?php
		
		$instance = wp_parse_args( array(
			                           'title'       => sanitize_text_field( upb_get_shortcode_title( $attributes ) ),
			                           'category'    => absint( $attributes[ 'category' ] ),
			                           'orderby'     => sanitize_text_field( $attributes[ 'orderby' ] ),
			                           'images'      => $attributes[ 'images' ] ? 1 : 0,
			                           'name'        => $attributes[ 'name' ] ? 1 : 0,
			                           'description' => $attributes[ 'description' ] ? 1 : 0,
			                           'rating'      => $attributes[ 'rating' ] ? 1 : 0,
			                           'limit'       => sanitize_text_field( $attributes[ 'limit' ] ),
		                           ), array(
			                           'title'       => '',
			                           'category'    => '',
			                           'orderby'     => 'name',
			                           'images'      => 0,
			                           'name'        => 0,
			                           'description' => 0,
			                           'rating'      => 0,
			                           'limit'       => '-1',
		                           ) );
		
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Links', $attributes );
		
		the_widget( 'WP_Widget_Links', $instance, $args );
	?>
</div>