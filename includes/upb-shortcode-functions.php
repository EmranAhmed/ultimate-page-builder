<?php

    defined( 'ABSPATH' ) or die( 'Keep Quit' );

    if ( ! function_exists( 'upb_register_shortcode_column' ) ):
        function upb_register_shortcode_column( $attrs, $contents = NULL ) {

            $default = upb_elements()->get_attributes( 'column' );

            $attributes = shortcode_atts( $default, $attrs, 'column' );

            ob_start();

            upb_get_template( "shortcodes/column.php", compact( 'attributes', 'contents' ) );

            return ob_get_clean();
        }
    endif;

    if ( ! function_exists( 'upb_register_shortcode_row' ) ):
        function upb_register_shortcode_row( $attrs, $contents = NULL ) {

            $default = upb_elements()->get_attributes( 'row' );

            $attributes = shortcode_atts( $default, $attrs, 'row' );

            ob_start();

            upb_get_template( "shortcodes/row.php", compact( 'attributes', 'contents' ) );

            return ob_get_clean();
        }
    endif;

    if ( ! function_exists( 'upb_register_shortcode_section' ) ):
        function upb_register_shortcode_section( $attrs, $contents = NULL ) {

            $default = upb_elements()->get_attributes( 'section' );

            $attributes = shortcode_atts( $default, $attrs, 'section' );

            ob_start();

            upb_get_template( "shortcodes/section.php", compact( 'attributes', 'contents' ) );

            return ob_get_clean();
        }
    endif;

    if ( ! function_exists( 'upb_register_shortcode_text' ) ):
        function upb_register_shortcode_text( $attrs, $contents = NULL ) {

            $default = upb_elements()->get_attributes( 'text' );

            $attributes = shortcode_atts( $default, $attrs, 'text' );

            ob_start();

            upb_get_template( "shortcodes/text.php", compact( 'attributes', 'contents' ) );

            return ob_get_clean();
        }
    endif;
