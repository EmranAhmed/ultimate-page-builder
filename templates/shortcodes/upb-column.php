<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes, esc_attr( upb_make_column_class( $attributes, 'upb-col' ) ) ) ?>">
    <?php echo do_shortcode( $contents ) ?>
</div>