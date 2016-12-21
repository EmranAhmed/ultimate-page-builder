<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents

?>

<div class="upb-text">
    <style scoped>
        :scope {
            background : <?php echo esc_attr($attributes['background']) ?>;
            }
    </style>

    <?php echo do_shortcode( $contents ) ?>

</div>

