<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
	
	if ( ! upb_is_shortcode_enabled( $attributes ) ) {
		return;
	}
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
	<?php
		// Check /wp-includes/widgets/class-wp-nav-menu-widget.php line#95
		
		$instance = wp_parse_args( array(
			                           'title'    => sanitize_text_field( upb_get_shortcode_title( $attributes ) ),
			                           'nav_menu' => absint( $attributes[ 'nav_menu' ] ),
		                           ), array(
			                           'title'    => '',
			                           'nav_menu' => 0
		                           ) );
		
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Nav_Menu_Widget', $attributes );
		
		the_widget( 'WP_Nav_Menu_Widget', $instance, $args );
	?>
</div>