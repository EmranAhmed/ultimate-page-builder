<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );
    
    // $attributes, $contents, $settings, $tag

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, $tag ) ?>">
    <style scoped>
        :scope {
        <?php upb_shortcode_scoped_style_background($attributes) ?>
            }
    </style>

    <div class="upb-tab">
        <?php
            global $upb_tabs;
            $tab_contents = do_shortcode( $contents );
        ?>

        <ul class="upb-tab-items">
            <?php foreach ( $upb_tabs as $index => $tab ): ?>
                <li class="upb-tab-item <?php echo ( $tab[ 'active' ] ) ? 'active' : '' ?>"><?php echo esc_html( $tab[ 'title' ] ) ?></li>
            <?php endforeach; ?>
        </ul>

        <div class="upb-tab-contents">
            <?php echo $tab_contents ?>
        </div>

        <?php $upb_tabs = array(); ?>

    </div>
</div>