<?php defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // $attributes, $contents, $settings

    if ( ! upb_is_shortcode_enabled( $attributes ) ) {
        return;
    }
?>

<div id="<?php upb_shortcode_id( $attributes ) ?>" class="<?php upb_shortcode_class( $attributes, 'upb-wp_widget_calendar' ) ?>">
    <style scoped>
        :scope {
        <?php upb_shortcode_scoped_style_background($attributes) ?>
            }
    </style>

    <div>
        <?php
            // Check /wp-includes/widgets/class-wp-widget-calendar.php line#54

            $instance = wp_parse_args( array(
                                           'title' => sanitize_text_field( upb_get_shortcode_title( $attributes ) )
                                       ),
                                       array(
                                           'title' => ''
                                       ) );

            $args = apply_filters( 'upb-element-wp-widget-args', array(
                'before_widget' => '<div class="widget %s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h2 class="widgettitle widget-title">',
                'after_title'   => '</h2>'
            ), 'WP_Widget_Calendar', $attributes );

            the_widget( 'WP_Widget_Calendar', $instance, $args );
        ?>
    </div>
</div>