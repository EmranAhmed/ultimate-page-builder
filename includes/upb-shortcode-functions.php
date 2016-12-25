<?php

    defined( 'ABSPATH' ) or die( 'Keep Quit' );

    if ( ! function_exists( 'upb_register_shortcode_column' ) ):
        function upb_register_shortcode_column( $attrs, $contents = NULL ) {

            $attributes = upb_elements()->get_attributes( 'column', $attrs );
            $settings   = upb_elements()->get_element( 'column', '_upb_settings' );

            ob_start();

            upb_get_template( "shortcodes/column.php", compact( 'attributes', 'contents', 'settings' ) );

            return ob_get_clean();
        }
    endif;


    if ( ! function_exists( 'upb_register_shortcode_row' ) ):
        function upb_register_shortcode_row( $attrs, $contents = NULL ) {

            $attributes = upb_elements()->get_attributes( 'row', $attrs );
            $settings   = upb_elements()->get_element( 'row', '_upb_settings' );

            ob_start();

            upb_get_template( "shortcodes/row.php", compact( 'attributes', 'contents', 'settings' ) );

            return ob_get_clean();
        }
    endif;


    if ( ! function_exists( 'upb_register_shortcode_section' ) ):
        function upb_register_shortcode_section( $attrs, $contents = NULL ) {

            $attributes = upb_elements()->get_attributes( 'section', $attrs );
            $settings   = upb_elements()->get_element( 'section', '_upb_settings' );

            ob_start();

            upb_get_template( "shortcodes/section.php", compact( 'attributes', 'contents', 'settings' ) );

            return ob_get_clean();
        }
    endif;


    if ( ! function_exists( 'upb_register_shortcode_text' ) ):
        function upb_register_shortcode_text( $attrs, $contents = NULL ) {

            $default  = upb_elements()->get_attributes( 'text' );
            $settings = upb_elements()->get_element( 'text', '_upb_settings' );

            $attributes = shortcode_atts( $default, $attrs, 'text' );

            ob_start();

            upb_get_template( "shortcodes/text.php", compact( 'attributes', 'contents', 'settings' ) );

            return ob_get_clean();
        }
    endif;
