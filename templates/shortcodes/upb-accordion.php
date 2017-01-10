<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, 'upb-section' ) ?>">
    <style scoped>
        :scope {
        <?php upb_shortcode_scoped_style_background($attributes) ?>
            }
    </style>

    <div class="upb-accordion">
        <?php echo do_shortcode( $contents ) ?>
    </div>
</div>