<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // $attributes, $contents, $settings

?>

<div class="upb-section">
    <style scoped>
        :scope {
            background-color : <?php echo esc_attr($attributes['background-color']) ?>;
            }
    </style>

    <?php echo do_shortcode( $contents ) ?>

</div>

