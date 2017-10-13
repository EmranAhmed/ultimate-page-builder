<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// $shortcode_atts, $attributes, $contents, $settings, $tag

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div <?php upb_shortcode_attribute_id( $attributes ) ?> class="<?php upb_shortcode_class( $attributes ) ?>" <?php upb_shortcode_unique_selector( $shortcode_atts ) ?>>
    <div class="upb-accordion">
        <?php echo do_shortcode( $contents ) ?>
    </div>
</div>