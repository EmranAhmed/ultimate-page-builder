<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    function upb_is_ios() {
        return wp_is_mobile() && preg_match( '/iPad|iPod|iPhone/', $_SERVER[ 'HTTP_USER_AGENT' ] );
    }

    function upb_is_ie() {
        global $is_IE;

        return wp_is_mobile() && $is_IE;
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

    function upb_is_preview() {

        if ( apply_filters( 'upb_has_access', TRUE ) && is_page() && isset( $_GET[ 'upb-preview' ] ) && $_GET[ 'upb-preview' ] == '1' && is_user_logged_in() ) {
            return TRUE;
        }

        return FALSE;

    }

    function upb_is_boilerplate() {

        if ( apply_filters( 'upb_has_access', TRUE ) && is_page() && isset( $_GET[ 'upb' ] ) && $_GET[ 'upb' ] == '1' && is_user_logged_in() ) {
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


    function upb_devices() {
        $devices = apply_filters( 'upb_preview_devices', array() );

        return array_map( function ( $device ) {
            return $device[ 'id' ];
        }, array_values( $devices ) );
    }

    function upb_make_column_class( $attributes, $extra = FALSE ) {

        $grid    = upb_grid_system();
        $devices = upb_devices();

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

