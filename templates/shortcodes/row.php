<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );


    // $attributes, $contents, $settings


    $grid = upb_grid_system();

?>


<div class="<?php echo esc_attr( $attributes[ 'container' ] ) ?>">

    <div class="<?php echo esc_attr( $grid[ 'groupClass' ] ) ?>">

        <style scoped>
            :scope {
                background : <?php echo esc_attr($attributes['background']) ?>;
                }
        </style>

        <?php echo do_shortcode( $contents ) ?>
    </div>
</div>