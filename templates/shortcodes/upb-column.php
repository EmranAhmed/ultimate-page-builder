<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings, $tag
?>

<div class="<?php upb_shortcode_class( $attributes, esc_attr( upb_make_column_class( $attributes, 'upb-col' ) ) ) ?>">
    <?php echo do_shortcode( $contents ) ?>
</div>