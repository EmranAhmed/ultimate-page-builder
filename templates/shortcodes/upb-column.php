<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings

?>

<div class="<?php echo esc_attr( upb_make_column_class( $attributes, 'upb-col' ) ) ?>">

    <style scoped>
        :scope {
            background : <?php echo esc_attr($attributes['background']) ?>;
            }
    </style>

    <?php echo do_shortcode( $contents ) ?>

</div>

