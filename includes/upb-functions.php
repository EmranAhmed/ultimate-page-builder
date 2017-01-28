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

    function upb_elements_path( $path = '' ) {
        return UPB_PLUGIN_ELEMENTS_PATH . untrailingslashit( $path );
    }

    function upb_elements_uri( $path = '' ) {
        return UPB_PLUGIN_ELEMENTS_URI . untrailingslashit( $path );
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

    function upb_get_edit_link( $post = 0 ) {
        if ( is_admin() ) {
            return esc_url( add_query_arg( 'upb', '1', wp_get_shortlink( $post ) ) );
        } else {
            return esc_url( add_query_arg( 'upb', '1', get_permalink( $post ) ) );
        }
    }

    function upb_get_preview_link() {
        //$query = array( 'upb-preview' => TRUE, 'rand' => time() );
        $query = array( 'upb-preview' => TRUE );

        return esc_url( add_query_arg( $query, get_preview_post_link( get_the_ID() ) ) );
    }

    // Class instances
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

    function upb_is_buildable( $post = '' ) {
        return apply_filters( 'upb_has_access', TRUE ) && UPB()->is_post_type_allowed( $post );
    }

    function upb_is_preview() {
        return ( upb_is_buildable() && isset( $_GET[ 'upb-preview' ] ) && $_GET[ 'upb-preview' ] == '1' && is_user_logged_in() );
    }

    function upb_is_boilerplate() {
        return ( upb_is_buildable() && isset( $_GET[ 'upb' ] ) && $_GET[ 'upb' ] == '1' && is_user_logged_in() );
    }

    function upb_is_preview_request() {
        return ( isset( $_GET[ 'upb-preview' ] ) && $_GET[ 'upb-preview' ] == '1' && is_user_logged_in() );
    }

    function upb_is_boilerplate_request() {
        return ( isset( $_GET[ 'upb' ] ) && $_GET[ 'upb' ] == '1' && is_user_logged_in() );
    }

    function upb_is_enabled() {
        return UPB()->is_enabled();
    }

    // Check valid ajax request
    function upb_check_ajax_access() {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        do_action( 'upb_check_ajax_access' );
    }

    // Grid
    function upb_grid_system( $key = FALSE ) {

        $grid = apply_filters( 'upb_grid_system', array(
            'name'              => esc_html__( 'UPB Grid', 'ultimate-page-builder' ),
            'simplifiedRatio'   => esc_html__( 'Its recommended to use simplified form of column grid ratio like: %s', 'ultimate-page-builder' ),
            'allGridClass'      => 'upb-col',
            'prefixClass'       => 'upb-col',
            'separator'         => '-', // col- deviceId - grid class
            'groupClass'        => 'upb-row',
            'groupWrapper'      => array(
                'upb-container-fluid'           => esc_html__( 'Fluid Container', 'ultimate-page-builder' ),
                'upb-container-fluid-no-gutter' => esc_html__( 'Fluid Container without gutter', 'ultimate-page-builder' ),
                'upb-container'                 => esc_html__( 'Fixed Container', 'ultimate-page-builder' ),
                'upb-container-no-gutter'       => esc_html__( 'Fixed Container without gutter', 'ultimate-page-builder' )
            ),
            'defaultDeviceId'   => 'xs', // We should set default column element attributes as like defaultDeviceId, If xs then [column xs='...']
            'deviceSizeTitle'   => esc_html__( 'Screen Sizes', 'ultimate-page-builder' ),
            'devices'           => upb_preview_devices(),
            'totalGrid'         => 12,
            'allowedGrid'       => array( 1, 2, 3, 4, 6, 12 ),
            'nonAllowedMessage' => esc_html__( "Sorry, UPB Grid doesn't support %s grid column.", 'ultimate-page-builder' )
        ) );


        if ( $key ) {
            return isset( $grid[ $key ] ) ? $grid[ $key ] : NULL;
        }

        return $grid;
    }

    function upb_preview_devices() {
        return apply_filters( 'upb_preview_devices', array(
            array(
                'id'     => 'lg',
                'title'  => esc_html__( 'Large', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-desktop-mac',
                'width'  => '100%',
                'active' => TRUE
            ),
            array(
                'id'     => 'md',
                'title'  => esc_html__( 'Medium', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-laptop-mac',
                'width'  => '992px',
                'active' => FALSE
            ),
            array(
                'id'     => 'sm',
                'title'  => esc_html__( 'Small', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-tablet-ipad',
                'width'  => '768px',
                'active' => FALSE
            ),
            array(
                'id'     => 'xs',
                'title'  => esc_html__( 'Extra Small', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-cellphone-iphone',
                'width'  => '480px',
                'active' => FALSE
            ),
        ) );
    }

    function upb_devices( $key = FALSE ) {

        // Because Preview device and grid device may not same
        $devices = upb_grid_system( 'devices' );

        if ( ! $key ) {
            return array_values( $devices );
        } else {
            return array_map( function ( $device ) use ( $key ) {
                return $device[ $key ];
            }, array_values( $devices ) );
        }
    }

    function upb_sample_grid_layout() {
        return apply_filters( 'upb_sample_grid_layout', array(
            array(
                'class' => 'grid-1-1',
                'value' => '1:1',
            ),
            array(
                'class' => 'grid-1-2',
                'value' => '1:2 + 1:2',
            ),
            array(
                'class' => 'grid-1-3__2-3',
                'value' => '1:3 + 2:3',
            ),
            array(
                'class' => 'grid-2-3__1-3',
                'value' => '2:3 + 1:3',
            ),
            array(
                'class' => 'grid-1-3__1-3__1-3',
                'value' => '1:3 + 1:3 + 1:3',
            ),
            array(
                'class' => 'grid-1-4__2-4__1-4',
                'value' => '1:4 + 2:4 + 1:4',
            ),
            array(
                'class' => 'grid-1-4__1-4__1-4__1-4',
                'value' => '1:4 + 1:4 + 1:4 + 1:4',
            )
        ) );
    }

    function upb_responsive_hidden() {
        $devices = apply_filters( 'upb_responsive_hidden', array(
            array(
                'id'    => 'hidden-lg',
                'title' => esc_html__( 'Large', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-desktop-mac',
            ),
            array(
                'id'    => 'hidden-md',
                'title' => esc_html__( 'Medium', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-laptop-mac'
            ),
            array(
                'id'    => 'hidden-sm',
                'title' => esc_html__( 'Small', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-tablet-ipad'
            ),
            array(
                'id'    => 'hidden-xs',
                'title' => esc_html__( 'Extra Small', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-cellphone-iphone'
            ),
        ) );

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
                $columns[] = ( ( $grid[ 'allGridClass' ] ) ? $grid[ 'allGridClass' ] . ' ' : '' ) . $grid[ 'prefixClass' ] . $grid[ 'separator' ] . $name . $grid[ 'separator' ] . ( ( absint( $grid[ 'totalGrid' ] ) / absint( $col[ 1 ] ) ) * absint( $col[ 0 ] ) );
            }
        }

        return implode( ' ', $columns );
    }

    // Build-In Inputs
    function upb_responsive_hidden_input( $title = '', $desc = '', $default = array() ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Hide on device', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : esc_html__( 'Hide element on specific media device', 'ultimate-page-builder' );

        return apply_filters( 'upb_responsive_hidden_input', array(
            'id'      => 'device-hidden',
            'title'   => esc_html( $title ),
            'desc'    => wp_kses_post( $desc ),
            'type'    => 'device-hidden',
            'value'   => $default,
            'options' => upb_responsive_hidden()
        ) );
    }

    function upb_material_icon_input( $id, $title = '', $desc = '', $default = '' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Material Icons', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : esc_html__( 'Search material icons and use it.', 'ultimate-page-builder' );

        return apply_filters( 'upb_material_icon_input', array(
            'id'          => esc_attr( $id ),
            'title'       => esc_html( $title ),
            'desc'        => wp_kses_post( $desc ),
            'type'        => 'ajax-icon-select',
            'value'       => $default,
            'hooks'       => array(
                'search' => '_upb_material_icon_search',
                'load'   => '_upb_material_icon_load',
            ),
            'placeholder' => esc_html__( 'Search material icons', 'ultimate-page-builder' ),
        ) );
    }

    function upb_font_awesome_icon_input( $id, $title = '', $desc = '', $default = '' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'FontAwesome Icons', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : esc_html__( 'Search FontAwesome icons and use it.', 'ultimate-page-builder' );

        return apply_filters( 'upb_font_awesome_icon_input', array(
            'id'          => esc_attr( $id ),
            'title'       => esc_html( $title ),
            'desc'        => wp_kses_post( $desc ),
            'type'        => 'ajax-icon-select',
            'value'       => $default,
            'hooks'       => array(
                'search' => '_upb_font_awesome_icon_search',
                'load'   => '_upb_font_awesome_icon_load',
            ),
            'placeholder' => esc_html__( 'Search FontAwesome icons', 'ultimate-page-builder' ),
        ) );
    }

    function upb_background_input_group() {

        return apply_filters( 'upb_background_input_group', array(

            array(
                'id'      => 'background-type',
                'title'   => esc_html__( 'Background type', 'ultimate-page-builder' ),
                'desc'    => esc_html__( 'Choose your element background type', 'ultimate-page-builder' ),
                'type'    => 'radio-icon',
                'value'   => 'none',
                'options' => array(
                    'none'  => array( 'title' => esc_html__( 'No background', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-close-octagon-outline' ),
                    'color' => array( 'title' => esc_html__( 'Background Color', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-format-color-fill' ),
                    'image' => array( 'title' => esc_html__( 'Background Image', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-image' ),
                    'both'  => array( 'title' => esc_html__( 'Background Image and Color', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-folder-multiple-image' ),
                    // 'video' => array( 'title' => esc_html__( 'Background Video', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-file-video' )
                )
            ),

            array(
                'id'       => 'background-color',
                'title'    => esc_html__( 'Background Color', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Element background color', 'ultimate-page-builder' ),
                'type'     => 'color',
                'value'    => '#ffffff',
                'alpha'    => TRUE,
                'required' => array(
                    array( 'background-type', '=', array( 'color', 'both' ) )
                )
            ),

            array(
                'id'          => 'background-image',
                'title'       => esc_html__( 'Background Image', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Element background image', 'ultimate-page-builder' ),
                'type'        => 'background-image',
                'value'       => '',
                'use'         => 'background-position',
                'placeholder' => esc_html__( 'Choose background image', 'ultimate-page-builder' ),
                'buttons'     => array(
                    'add'    => esc_html__( 'Add Background', 'ultimate-page-builder' ),
                    'remove' => esc_html__( 'Remove', 'ultimate-page-builder' ),
                    'choose' => esc_html__( 'Choose', 'ultimate-page-builder' ),
                ),
                'required'    => array(
                    array( 'background-type', '=', array( 'image', 'both' ) )
                )
            ),

            array(
                'id'          => 'background-position',
                'title'       => esc_html__( 'Background Image Position', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Change Background Image Position. You can move background image pointer to see preview.', 'ultimate-page-builder' ),
                'type'        => 'background-image-position',
                'value'       => '0% 0%',
                'placeholder' => '0% 0%',
                'required'    => array(
                    array( 'background-image', '!=', '' ),
                    array( 'background-type', '=', array( 'image', 'both' ) ),
                )
            ),

            array(
                'id'       => 'background-repeat',
                'title'    => esc_html__( 'Background Image repeat', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Change Background Image repeat.', 'ultimate-page-builder' ),
                'type'     => 'select',
                'value'    => 'repeat',
                'options'  => array(
                    'repeat'    => esc_html__( 'Repeat', 'ultimate-page-builder' ),
                    'no-repeat' => esc_html__( 'No Repeat', 'ultimate-page-builder' ),
                    'repeat-x'  => esc_html__( 'Repeat Horizontally', 'ultimate-page-builder' ),
                    'repeat-y'  => esc_html__( 'Repeat Vertically', 'ultimate-page-builder' ),
                    'initial'   => esc_html__( 'Initial', 'ultimate-page-builder' ),
                    'inherit'   => esc_html__( 'Inherit from parent element', 'ultimate-page-builder' ),
                ),
                'required' => array(
                    array( 'background-image', '!=', '' ),
                    array( 'background-type', '=', array( 'image', 'both' ) ),
                )
            ),

            array(
                'id'       => 'background-attachment',
                'title'    => esc_html__( 'Background Attachment', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Change Background Image Attachment.', 'ultimate-page-builder' ),
                'type'     => 'select',
                'value'    => 'scroll',
                'options'  => array(
                    'scroll'  => esc_html__( 'Scroll', 'ultimate-page-builder' ),
                    'fixed'   => esc_html__( 'Fixed', 'ultimate-page-builder' ),
                    'local'   => esc_html__( 'Local', 'ultimate-page-builder' ),
                    'initial' => esc_html__( 'Initial', 'ultimate-page-builder' ),
                    'inherit' => esc_html__( 'Inherit from parent element', 'ultimate-page-builder' ),
                ),
                'required' => array(
                    array( 'background-image', '!=', '' ),
                    array( 'background-type', '=', array( 'image', 'both' ) ),
                )
            ),

            array(
                'id'       => 'background-origin',
                'title'    => esc_html__( 'Background origin', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Change Background Image origin.', 'ultimate-page-builder' ),
                'type'     => 'select',
                'value'    => 'padding-box',
                'options'  => array(
                    'padding-box' => esc_html__( 'Padding Box', 'ultimate-page-builder' ),
                    'border-box'  => esc_html__( 'Border Box', 'ultimate-page-builder' ),
                    'content-box' => esc_html__( 'Content Box', 'ultimate-page-builder' ),
                    'initial'     => esc_html__( 'Initial', 'ultimate-page-builder' ),
                    'inherit'     => esc_html__( 'Inherits from parent element', 'ultimate-page-builder' ),
                ),
                'required' => array(
                    array( 'background-image', '!=', '' ),
                    array( 'background-type', '=', array( 'image', 'both' ) ),
                )
            ),

            array(
                'id'       => 'background-size',
                'title'    => esc_html__( 'Background size', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Change Background Image size.', 'ultimate-page-builder' ),
                'type'     => 'select',
                'value'    => 'auto',
                'options'  => array(
                    'auto'    => esc_html__( 'Auto', 'ultimate-page-builder' ),
                    'cover'   => esc_html__( 'Cover', 'ultimate-page-builder' ),
                    'contain' => esc_html__( 'Contain', 'ultimate-page-builder' ),
                    'initial' => esc_html__( 'Initial', 'ultimate-page-builder' ),
                    'inherit' => esc_html__( 'Inherits from parent element', 'ultimate-page-builder' ),
                ),
                'required' => array(
                    array( 'background-image', '!=', '' ),
                    array( 'background-type', '=', array( 'image', 'both' ) ),
                )
            ),

        ) );
    }

    function upb_title_input( $title = '', $desc = '', $default = 'New %s' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Title', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : FALSE;

        return apply_filters( 'upb_title_input', array(
            'id'    => 'title',
            'title' => esc_html( $title ),
            'desc'  => wp_kses_post( $desc ),
            'type'  => 'text',
            'value' => esc_attr( $default ),
        ) );
    }

    function upb_css_class_id_input_group( $default_class = '', $default_id = '' ) {
        return apply_filters( 'upb_css_class_id_input_group', array(
            array(
                'id'    => 'element_class',
                'title' => esc_html__( 'Custom CSS Class', 'ultimate-page-builder' ),
                'desc'  => esc_html__( 'Custom CSS Class. Separate classes with space', 'ultimate-page-builder' ),
                'type'  => 'text',
                'value' => esc_attr( $default_class )
            ),

            array(
                'id'    => 'element_id',
                'title' => esc_html__( 'Custom CSS ID', 'ultimate-page-builder' ),
                'desc'  => esc_html__( 'CSS ID of an element should be unique.', 'ultimate-page-builder' ),
                'type'  => 'text',
                'value' => esc_attr( $default_id ),
            )
        ) );
    }

    function upb_enable_input( $title = '', $desc = '', $default = TRUE ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Enable / Disable', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : esc_html__( 'Enable or Disable Element', 'ultimate-page-builder' );

        return apply_filters( 'upb_enable_input', array(
            'id'    => 'enable',
            'title' => esc_html( $title ),
            'desc'  => wp_kses_post( $desc ),
            'type'  => 'toggle',
            'value' => (bool) $default,
        ) );
    }

    function upb_column_device_input( $defaults = array() ) {

        // $defaults = array('md'=>'1:1', 'sm'=>'1:1')

        $devices = upb_devices( 'id' );

        if ( empty( $defaults ) ) {
            foreach ( $devices as $device ) {
                $defaults[ $device ] = '';
            }
            $defaults[ upb_grid_system( 'defaultDeviceId' ) ] = '1:1';
        }

        return array_map( function ( $device, $defaultDevice, $defaultValue ) {
            $value = $device == $defaultDevice ? $defaultValue : '';

            return array( 'id' => $device, 'type' => 'hidden', 'value' => $value );
        }, $devices, array_keys( $defaults ), $defaults );
    }

    function upb_row_wrapper_input() {
        $groups = upb_grid_system( 'groupWrapper' );
        if ( $groups ):
            $default = array_keys( $groups );

            return apply_filters( 'upb_row_wrapper_input', array( 'id' => 'container', 'title' => esc_html__( 'Container Type', 'ultimate-page-builder' ), 'type' => 'radio', 'value' => $default[ 0 ], 'options' => $groups ) );
        endif;

        return apply_filters( 'upb_row_wrapper_input', array() );
    }

    // End Build-In Inputs

    // Helpers

    // Returns TRUE for "1", "true", "on" and "yes". Returns FALSE otherwise.
    function upb_return_boolean( $data ) {
        return filter_var( $data, FILTER_VALIDATE_BOOLEAN );
    }

    function upb_is_shortcode_enabled( $attributes ) {
        // if not set then return true;
        return isset( $attributes[ 'enable' ] ) ? ! empty( $attributes[ 'enable' ] ) : TRUE;
    }

    function upb_get_shortcode_class( $attributes, $extra = '' ) {

        $classes = array();
        if ( isset( $attributes[ 'hidden-device' ] ) ) {
            $classes = array_merge( $classes, $attributes[ 'hidden-device' ] );
        }

        if ( isset( $attributes[ 'element_class' ] ) ) {
            array_push( $classes, $attributes[ 'element_class' ] );
        }

        if ( ! empty( $extra ) ) {
            array_push( $classes, $extra );
        }

        return implode( ' ', apply_filters( 'upb_get_shortcode_class', $classes ) );
    }

    function upb_get_shortcode_id( $attributes ) {
        return isset( $attributes[ 'element_id' ] ) ? apply_filters( 'upb_get_shortcode_id', $attributes[ 'element_id' ] ) : FALSE;
    }

    function upb_shortcode_id( $attributes ) {
        echo esc_attr( upb_get_shortcode_id( $attributes ) );
    }

    function upb_shortcode_class( $attributes, $extra = '' ) {
        echo esc_attr( upb_get_shortcode_class( $attributes, $extra ) );
    }

    function upb_get_shortcode_title( $attributes ) {
        return isset( $attributes[ 'title' ] ) ? apply_filters( 'upb_get_shortcode_title', $attributes[ 'title' ] ) : '';
    }

    function upb_shortcode_title( $attributes ) {
        echo esc_html( upb_get_shortcode_title( $attributes ) );
    }

    function upb_shortcode_scoped_style_background( $attributes ) {

        if ( isset( $attributes[ 'background-type' ] ) ) {

            if ( $attributes[ 'background-type' ] == 'both' || $attributes[ 'background-type' ] == 'color' ) {
                printf( 'background-color: %s;', esc_attr( $attributes[ 'background-color' ] ) );
            }

            if ( $attributes[ 'background-type' ] == 'both' || $attributes[ 'background-type' ] == 'image' ) {
                printf( 'background-image: %s;', sprintf( "url('%s')", esc_url( $attributes[ 'background-image' ] ) ) );
                printf( 'background-position: %s;', esc_attr( $attributes[ 'background-position' ] ) );
                printf( 'background-repeat: %s;', esc_attr( $attributes[ 'background-repeat' ] ) );
                printf( 'background-attachment: %s;', esc_attr( $attributes[ 'background-attachment' ] ) );
                printf( 'background-origin: %s;', esc_attr( $attributes[ 'background-origin' ] ) );
                printf( 'background-size: %s;', esc_attr( $attributes[ 'background-size' ] ) );
            }
        }

        do_action( 'upb_shortcode_scoped_style_background', $attributes );
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

    // add_action upb_boilerplate_print_footer_scripts with upb_get_template
    function upb_add_script_template( $id, $contents ) {
        echo '<script type="text/x-template" id="upb-' . $id . '-template">';
        echo $contents;
        echo '</script>';
    }

    function upb_get_script_template_id( $id ) {
        return 'upb-' . $id . '-template">';
    }
