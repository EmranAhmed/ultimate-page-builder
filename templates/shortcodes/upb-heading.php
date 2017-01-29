<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings, $tag

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
    <style scoped>
        :scope {
        <?php upb_shortcode_scoped_style_background($attributes) ?> text-align : <?php echo esc_attr( $attributes[ 'align' ] ) ?>;
            }
    </style>
    <<?php echo esc_attr( $attributes[ 'type' ] ) ?>>
    <?php echo do_shortcode( $contents ) ?>
    </<?php echo esc_attr( $attributes[ 'type' ] ) ?>>
</div>

