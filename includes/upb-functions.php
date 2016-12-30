<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // URI Functions
    function upb_assets_uri( $url = '' ) {
        return UPB_PLUGIN_ASSETS_URI . untrailingslashit( $url );
    }

    function upb_plugin_uri( $url = '' ) {
        return UPB_PLUGIN_URI . untrailingslashit( $url );
    }

    function upb_plugin_path( $path = '' ) {
        return UPB_PLUGIN_PATH . untrailingslashit( $path );
    }

    function upb_include_path( $path = '' ) {
        return UPB_PLUGIN_INCLUDE_PATH . untrailingslashit( $path );
    }

    function upb_templates_path( $path = '' ) {
        return UPB_PLUGIN_TEMPLATES_PATH . untrailingslashit( $path );
    }

    function upb_templates_uri( $path = '' ) {
        return UPB_PLUGIN_TEMPLATES_URI . untrailingslashit( $path );
    }


    function upb_elements() {
        return UPB_Elements::getInstance();
    }

    function upb_tabs() {
        return UPB_Tabs::getInstance();
    }

    function upb_settings() {
        return UPB_Settings::getInstance();
    }

    function upb_layouts() {
        return UPB_Layouts::getInstance();
    }

    // Conditional
    function upb_is_ios() {
        return wp_is_mobile() && preg_match( '/iPad|iPod|iPhone/', $_SERVER[ 'HTTP_USER_AGENT' ] );
    }

    function upb_is_ie() {
        global $is_IE;

        return wp_is_mobile() && $is_IE;
    }

    function upb_is_buildable() {
        return apply_filters( 'upb_has_access', TRUE ) && is_page();
    }

    function upb_is_preview() {

        if ( upb_is_buildable() && isset( $_GET[ 'upb-preview' ] ) && $_GET[ 'upb-preview' ] == '1' && is_user_logged_in() ) {
            return TRUE;
        }

        return FALSE;
    }

    function upb_is_boilerplate() {

        if ( upb_is_buildable() && isset( $_GET[ 'upb' ] ) && $_GET[ 'upb' ] == '1' && is_user_logged_in() ) {
            return TRUE;
        }

        return FALSE;

    }

    function upb_is_enabled() {
        return Ultimate_Page_Builder()->is_enabled();
    }


    function upb_grid_system() {
        return apply_filters( 'upb_grid_system', array() );
    }

    function upb_devices( $key = FALSE ) {
        $devices = apply_filters( 'upb_preview_devices', array() );

        if ( ! $key ) {
            return array_values( $devices );
        } else {
            return array_map( function ( $device ) use ( $key ) {
                return $device[ $key ];
            }, array_values( $devices ) );
        }
    }

    function upb_responsive_hidden() {
        $devices = apply_filters( 'upb_responsive_hidden', array() );

        return array_values( $devices );
    }

    function upb_make_column_class( $attributes, $extra = FALSE ) {

        $grid    = upb_grid_system();
        $devices = upb_devices( 'id' );

        $columns = array();

        if ( $extra ) {
            $columns[] = $extra;
        }

        foreach ( $attributes as $name => $value ) {
            if ( in_array( $name, $devices ) && ! empty( $value ) ) {
                $col       = explode( ':', $value );
                $columns[] = $grid[ 'prefixClass' ] . $grid[ 'separator' ] . $name . $grid[ 'separator' ] . ( ( absint( $grid[ 'totalGrid' ] ) / absint( $col[ 1 ] ) ) * absint( $col[ 0 ] ) );
            }
        }

        return implode( ' ', $columns );
    }

    function upb_enqueue_shortcode_assets() {

        if ( upb_is_enabled() ):

            $post_ID = get_queried_object_id();

            $shortcodes = get_post_meta( $post_ID, '_upb_shortcodes', TRUE );

            array_map( function ( $element ) use ( $shortcodes ) {

                if ( has_shortcode( $shortcodes, $element[ 'tag' ] ) ) {

                    if ( ! empty( $element[ '_upb_options' ][ 'assets' ][ 'shortcode' ][ 'js' ] ) ) {
                        wp_enqueue_script( sprintf( 'upb-element-%s', $element[ 'tag' ] ) );
                    }

                    if ( ! empty( $element[ '_upb_options' ][ 'assets' ][ 'shortcode' ][ 'css' ] ) ) {
                        wp_enqueue_style( sprintf( 'upb-element-%s', $element[ 'tag' ] ) );
                    }
                }
            }, upb_elements()->getAll() );
        endif;
    }


