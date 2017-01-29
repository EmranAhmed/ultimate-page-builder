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

    <div>
        <?php

            $instance = wp_parse_args( array(
                                           'title'  => sanitize_text_field( upb_get_shortcode_title( $attributes ) ),
                                           'number' => absint( $attributes[ 'number' ] ),
                                       ), array(
                                           'title'  => '',
                                           'number' => 5,
                                       ) );

            $args = apply_filters( 'upb-element-wp-widget-args', array(
                'before_widget' => '<div class="widget %s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h2 class="widgettitle widget-title">',
                'after_title'   => '</h2>'
            ), 'WP_Widget_Recent_Comments', $attributes );

            the_widget( 'WP_Widget_Recent_Comments', $instance, $args );
        ?>
    </div>
</div>