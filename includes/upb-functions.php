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

    function upb_is_valid_url( $url ) {
        return filter_var( $url, FILTER_VALIDATE_URL ) !== FALSE;
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
                'upb-container-no-gutter'       => esc_html__( 'Fixed Container without gutter', 'ultimate-page-builder' ),
                'upb-no-container'              => esc_html__( 'No Container', 'ultimate-page-builder' ),
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

        $devices = upb_devices();

        $hidden_devices = apply_filters( 'upb_responsive_hidden', array_map( function ( $device ) {
            return array(
                'id'    => sprintf( 'hidden-%s', $device[ 'id' ] ),
                'title' => $device[ 'title' ],
                'icon'  => $device[ 'icon' ],
            );
        }, $devices ) );

        return array_values( $hidden_devices );
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

    function upb_column_clearfix_input( $title = '', $desc = '', $default = array() ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Clearfix', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : esc_html__( 'Show Clearfix element between columns', 'ultimate-page-builder' );

        $devices = upb_devices();

        $options = array_map( function ( $device ) {
            return array(
                'id'    => $device[ 'id' ],
                'title' => $device[ 'title' ],
                'icon'  => $device[ 'icon' ],
            );
        }, $devices );

        $options = upb_list_pluck( $options, array( 'title', 'icon' ), 'id' );

        return apply_filters( 'upb_column_clearfix_input', array(
            'id'      => 'clearfix', // esc_attr( $id ),
            'title'   => esc_html( $title ),
            'desc'    => wp_kses_post( $desc ),
            'type'    => 'checkbox-icon',
            'value'   => $default,
            'options' => $options
        ) );
    }

    function upb_material_icon_input( $id, $title = '', $desc = '', $default = '' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Material Icons', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : sprintf( __( 'Search material design icons. Using <a target="_blank" href="%s">%s</a>', 'ultimate-page-builder' ), 'https://cdn.materialdesignicons.com/1.8.36/', esc_html__( 'Material Design Icons - 1.8.36', 'ultimate-page-builder' ) );

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
            'placeholder' => esc_html__( 'Search Material Design Icons', 'ultimate-page-builder' ),
        ) );
    }

    function upb_font_awesome_icon_input( $id, $title = '', $desc = '', $default = '' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'FontAwesome Icons', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : sprintf( __( 'Search FontAwesome icons. Using <a target="_blank" href="%s">%s</a>', 'ultimate-page-builder' ), 'http://fontawesome.io/icons/', esc_html__( 'Font Awesome Icons - 4.7', 'ultimate-page-builder' ) );

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
            'placeholder' => esc_html__( 'Search FontAwesome Icons', 'ultimate-page-builder' ),
        ) );
    }

    function upb_dashicons_icon_input( $id, $title = '', $desc = '', $default = '' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Dashicons Icon', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : sprintf( __( 'Search Dashicons icon. Using <a target="_blank" href="%s">%s</a>', 'ultimate-page-builder' ), 'https://developer.wordpress.org/resource/dashicons/', esc_html__( 'Dashicons', 'ultimate-page-builder' ) );

        return apply_filters( 'upb_dashicons_icon_input', array(
            'id'          => esc_attr( $id ),
            'title'       => esc_html( $title ),
            'desc'        => wp_kses_post( $desc ),
            'type'        => 'ajax-icon-select',
            'value'       => $default,
            'hooks'       => array(
                'search' => '_upb_dashicons_icon_search',
                'load'   => '_upb_dashicons_icon_load',
            ),
            'placeholder' => esc_html__( 'Search Dashicons Icon', 'ultimate-page-builder' ),
        ) );
    }

    function upb_title_input( $title = '', $desc = '', $default = 'New %s' ) {

        $title = trim( $title ) ? trim( $title ) : esc_html__( 'Title', 'ultimate-page-builder' );
        $desc  = trim( $desc ) ? trim( $desc ) : FALSE;

        return apply_filters( 'upb_title_input', array(
            'id'          => 'title',
            'title'       => esc_html( $title ),
            'placeholder' => esc_html__( 'Element Title', 'ultimate-page-builder' ),
            'desc'        => wp_kses_post( $desc ),
            'type'        => 'text',
            'value'       => esc_attr( $default ),
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

    function upb_background_input_group( $args = array() ) {

        $defaults = array(
            'gradient' => TRUE,
            'color'    => TRUE,
            'image'    => TRUE,
            'both'     => TRUE,
        );

        $args = wp_parse_args( $args, $defaults );

        $options           = array();
        $options[ 'none' ] = array( 'title' => esc_html__( 'No background', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-close-octagon-outline' );

        if ( $args[ 'gradient' ] ) {
            $options[ 'gradient' ] = array( 'title' => esc_html__( 'Gradient background', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-gradient' );
        }

        if ( $args[ 'both' ] ) {

            $args[ 'color' ] = TRUE;
            $args[ 'image' ] = TRUE;

            $options[ 'both' ] = array( 'title' => esc_html__( 'Background Image and Color', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-folder-multiple-image' );
        }

        if ( $args[ 'color' ] ) {
            $options[ 'color' ] = array( 'title' => esc_html__( 'Background Color', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-format-color-fill' );
        }

        if ( $args[ 'image' ] ) {
            $options[ 'image' ] = array( 'title' => esc_html__( 'Background Image', 'ultimate-page-builder' ), 'icon' => 'mdi mdi-image' );
        }

        $inputs = array();

        array_push( $inputs, array(
            'id'      => 'background-type',
            'title'   => esc_html__( 'Background type', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Choose your element background type', 'ultimate-page-builder' ),
            'type'    => 'radio-icon',
            'value'   => 'none',
            'options' => $options
        ) );

        if ( $args[ 'gradient' ] ) {

            array_push( $inputs, array(
                'id'       => 'gradient-position',
                'title'    => esc_html__( 'Gradient Position', 'ultimate-page-builder' ),
                'desc'     => sprintf( __( 'Element gradient background position. <a target="_blank" href="%s">%s</a> or <a target="_blank" href="%s">%s</a>', 'ultimate-page-builder' ), esc_url( 'https://uigradients.com/' ), 'uiGradients', esc_url( 'https://webgradients.com/' ), 'webGradients' ),
                'type'     => 'radio-icon',
                'value'    => 'to left',
                'options'  => array(
                    'to left'         => array(
                        'title' => esc_html__( 'Left', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-left'
                    ),
                    'to right'        => array(
                        'title' => esc_html__( 'Right', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-right'
                    ),
                    'to top'          => array(
                        'title' => esc_html__( 'Top', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-up'
                    ),
                    'to bottom'       => array(
                        'title' => esc_html__( 'Bottom', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-down'
                    ),
                    'to top left'     => array(
                        'title' => esc_html__( 'Top Left', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-top-left'
                    ),
                    'to top right'    => array(
                        'title' => esc_html__( 'Top Right', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-top-right'
                    ),
                    'to bottom left'  => array(
                        'title' => esc_html__( 'Bottom Left', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-bottom-left'
                    ),
                    'to bottom right' => array(
                        'title' => esc_html__( 'Bottom Right', 'ultimate-page-builder' ),
                        'icon'  => 'mdi mdi-arrow-bottom-right'
                    ),
                ),
                'required' => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'          => 'gradient-start-color',
                'title'       => esc_html__( 'Gradient Start Color', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Element gradient background start color. If you have only one color to start use start color on color stop 1 also.', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'RGBA Color', 'ultimate-page-builder' ),
                'type'        => 'color',
                'value'       => '#ffffff',
                'options'     => array(
                    'alpha' => TRUE,
                ),
                'required'    => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'       => 'gradient-start-location',
                'title'    => esc_html__( 'Gradient Start Location', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Element gradient background start color location', 'ultimate-page-builder' ),
                'type'     => 'range',
                'value'    => '0',
                'options'  => array(
                    'suffix' => '%',
                    'max'    => '100',
                ),
                'required' => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'          => 'gradient-color-stop-1',
                'title'       => esc_html__( 'Color Stop 1', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Element gradient color stop 1. If you have only one color to start use start color on color stop 1 also.', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'RGBA Color', 'ultimate-page-builder' ),
                'type'        => 'color',
                'value'       => '#ffffff',
                'options'     => array(
                    'alpha' => TRUE,
                ),
                'required'    => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'       => 'gradient-color-stop-1-location',
                'title'    => esc_html__( 'Color Stop 1 Location', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Element gradient color stop 1 location', 'ultimate-page-builder' ),
                'type'     => 'range',
                'value'    => '0',
                'options'  => array(
                    'suffix' => '%',
                    'max'    => '100',
                ),
                'required' => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'          => 'gradient-end-color',
                'title'       => esc_html__( 'Gradient End Color', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Element gradient background end color', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'RGBA Color', 'ultimate-page-builder' ),
                'type'        => 'color',
                'value'       => '#000000',
                'options'     => array(
                    'alpha' => TRUE,
                ),
                'required'    => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );

            array_push( $inputs, array(
                'id'       => 'gradient-end-location',
                'title'    => esc_html__( 'Gradient End Location', 'ultimate-page-builder' ),
                'desc'     => esc_html__( 'Element gradient background end color location', 'ultimate-page-builder' ),
                'type'     => 'range',
                'value'    => '100',
                'options'  => array(
                    'suffix' => '%',
                    'max'    => '100',
                ),
                'required' => array(
                    array( 'background-type', '=', 'gradient' )
                )
            ) );
        }

        if ( $args[ 'color' ] ) {
            array_push( $inputs, array(
                'id'          => 'background-color',
                'title'       => esc_html__( 'Background Color', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Element background color', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'RGBA Color', 'ultimate-page-builder' ),
                'type'        => 'color',
                'value'       => '#ffffff',
                'options'     => array(
                    'alpha' => TRUE,
                ),
                'required'    => array(
                    array( 'background-type', '=', array( 'color', 'both' ) )
                )
            ) );
        }

        if ( $args[ 'image' ] ) {
            array_push( $inputs, array(
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
            ) );

            array_push( $inputs, array(
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
            ) );

            array_push( $inputs, array(
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
            ) );

            array_push( $inputs, array(
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
            ) );

            array_push( $inputs, array(
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
            ) );

            array_push( $inputs, array(
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
            ) );
        }

        return apply_filters( 'upb_background_input_group', $inputs );
    }

    function upb_css_class_id_input_group( $default_class = '', $default_id = '' ) {
        return apply_filters( 'upb_css_class_id_input_group', array(
            array(
                'id'          => 'element_class',
                'title'       => esc_html__( 'Custom CSS Class', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'CSS Class Name', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Custom CSS Class. Separate classes with space', 'ultimate-page-builder' ),
                'type'        => 'text',
                'value'       => esc_attr( $default_class )
            ),

            array(
                'id'          => 'element_id',
                'title'       => esc_html__( 'Custom CSS ID', 'ultimate-page-builder' ),
                'placeholder' => esc_html__( 'Unique ID', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'CSS ID of an element should be unique.', 'ultimate-page-builder' ),
                'type'        => 'text',
                'value'       => esc_attr( $default_id ),
            )
        ) );
    }

    function upb_media_query_based_input_group( $input, $with_global = TRUE ) {

        $get_devices = upb_devices();

        $options = array_map( function ( $device ) {
            return array(
                'id'    => $device[ 'id' ],
                'title' => $device[ 'title' ],
                'icon'  => $device[ 'icon' ],
            );
        }, $get_devices );

        if ( $with_global ) {
            array_unshift( $options, array(
                'id'    => '',
                'title' => esc_html__( 'Global', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-earth',
            ) );
        }

        $devices = upb_list_pluck( $options, array( 'title', 'icon' ), 'id' );

        $inputs = array_map( function ( $device, $key ) use ( $input, $options ) {

            $input[ 'id' ]          = empty( $key ) ? $input[ 'id' ] : sprintf( '%s-%s', $input[ 'id' ], $key );
            $input[ 'title' ]       = empty( $key ) ? $input[ 'title' ] : sprintf( esc_html__( '%s for %s device', 'ultimate-page-builder' ), $input[ 'title' ], $device[ 'title' ] );
            $input[ 'value' ]       = empty( $key ) ? $input[ 'value' ] : ( ( $input[ 'device-value' ] && isset( $input[ 'device-value' ][ $key ] ) ) ? $input[ 'device-value' ][ $key ] : $input[ 'value' ] );
            $input[ 'device' ]      = empty( $key ) ? '' : $key;
            $input[ 'deviceIcon' ]  = $device[ 'icon' ];
            $input[ 'deviceTitle' ] = $device[ 'title' ];

            return $input;

        }, $devices, array_keys( $devices ) );

        return $inputs;
    }

    function upb_icon_providers() {
        return apply_filters( 'upb_icon_providers', array(
            array(
                'id'    => 'materialdesign',
                'title' => esc_html__( 'Material Design', 'ultimate-page-builder' )
            ),
            array(
                'id'    => 'dashicons',
                'title' => esc_html__( 'DashIcons Icon', 'ultimate-page-builder' )
            )
        ) );
    }


    // End Build-In Inputs

    // Helpers

    /**
     * Pluck a certain field out of each object in a list.
     *
     * This has the same functionality and prototype of
     * array_column() (PHP 5.5) but also supports objects and multiple field.
     *
     * @param array            $list      List of objects or arrays
     * @param int|string|array $field     Field from the object to place instead of the entire object
     * @param int|string       $index_key Optional. Field from the object to use as keys for the new array.
     *                                    Default null.
     *
     * @return array Array of found values. If `$index_key` is set, an array of found values with keys
     *               corresponding to `$index_key`. If `$index_key` is null, array keys from the original
     *               `$list` will be preserved in the results.
     */
    function upb_list_pluck( $list, $field, $index_key = NULL ) {
        $util = new UPB_List_Util( $list );

        return $util->pluck( $field, $index_key );
    }

    /**
     * Action Hook Information
     *
     * @param $hook_name
     */
    function upb_hook_info( $hook_name ) {
        global $wp_filter;
        $docs     = array();
        $template = "\t - %s Priority - %s.\n\tin file %s #%s\n\n";
        echo '<pre>';
        echo "\t# Hook Name \"" . $hook_name . "\"";
        echo "\n\n";
        if ( isset( $wp_filter[ $hook_name ] ) ) {
            foreach ( $wp_filter[ $hook_name ] as $pri => $fn ) {
                foreach ( $fn as $fnname => $fnargs ) {
                    if ( is_array( $fnargs[ 'function' ] ) ) {
                        $reflClass = new ReflectionClass( $fnargs[ 'function' ][ 0 ] );
                        $reflFunc  = $reflClass->getMethod( $fnargs[ 'function' ][ 1 ] );
                        $class     = $reflClass->getName();
                        $function  = $reflFunc->name;
                    } else {
                        $reflFunc  = new ReflectionFunction( $fnargs[ 'function' ] );
                        $class     = FALSE;
                        $function  = $reflFunc->name;
                        $isClosure = (bool) $reflFunc->isClosure();
                    }
                    if ( $class ) {
                        $functionName = sprintf( 'Class "%s::%s"', $class, $function );
                    } else {
                        $functionName = ( $isClosure ) ? "Anonymous Function $function" : "Function \"$function\"";
                    }
                    printf( $template, $functionName, $pri, str_ireplace( ABSPATH, '', $reflFunc->getFileName() ), $reflFunc->getStartLine() );
                    $docs[] = array( $functionName, $pri );
                }
            }
            echo "\tAction Hook Commenting\n\t----------------------\n\n";
            echo "\t/**\n\t* " . $hook_name . " hook\n\t*\n";
            foreach ( $docs as $doc ) {
                echo "\t* @hooked " . $doc[ 0 ] . " - " . $doc[ 1 ] . "\n";
            }
            echo "\t*/";
            echo "\n\n";
            echo "\tdo_action( '" . $hook_name . "' );";
        }
        echo '</pre>';
    }

    // Returns TRUE for "1", "true", "on" and "yes". Returns FALSE otherwise.

    function upb_return_boolean( $data ) {
        return filter_var( $data, FILTER_VALIDATE_BOOLEAN );
    }

    /**
     * Usages:
     *
     * add_filter('upb_element_{$tag}_attributes', function($attributes){
     *
     * return upb_remove_element_attribute('margin', $attributes);
     * });
     *
     * OR
     *
     *  add_filter('upb_element_{$tag}_attributes', function($attributes){
     *
     * return upb_remove_element_attribute(array('margin', 'padding'), $attributes);
     * });
     */

    function upb_remove_element_attribute( $id, $attributes ) {

        if ( empty( $attributes ) ) {
            return $attributes;
        } else {
            $new_attributes = array();
            foreach ( (array) $attributes as $attribute ) {

                if ( is_string( $id ) && $attribute[ 'id' ] == $id ) {
                    // Skip
                } elseif ( is_array( $id ) && in_array( $attribute[ 'id' ], $id ) ) {
                    // Skip
                } else {
                    array_push( $new_attributes, $attribute );
                }
            }

            return $new_attributes;
        }
    }

    /**
     * Usages:
     *
     * add_filter('upb_element_{$tag}_attributes', function($attributes){
     *
     * return upb_replace_element_attribute('margin', array(
     *      'id'=>'margin',
     *      'type'=>'spacing',
     *      'title'=>'title'
     *      ...
     *      ...
     * ), $attributes);
     * });
     *
     */

    function upb_replace_element_attribute( $id, $attribute, $attributes ) {

        if ( empty( $attributes ) ) {
            return $attributes;
        } else {
            $new_attributes = array();
            foreach ( (array) $attributes as $attr ) {

                if ( is_string( $id ) && $attr[ 'id' ] == $id ) {
                    array_push( $new_attributes, $attribute );
                } else {
                    array_push( $new_attributes, $attr );
                }
            }

            return $new_attributes;
        }
    }


    /**
     * @param $id
     * @param $attribute
     * @param $attributes
     *
     * @return array
     *
     * Usages:
     *
     * add_filter( 'upb_element_{$tag}_attributes', function ( $attributes ) {
     *
     * return upb_add_attribute_after( 'space', array(
     *      'id'      => 'margin',
     *      'title'   => esc_html__( 'Margin', 'ultimate-page-builder' ),
     *      'desc'    => esc_html__( 'Margin between two section', 'ultimate-page-builder' ),
     *      'type'    => 'spacing',
     *      'value'   => array( '10px', 'initial', '10px', 'auto' ),
     *      'unit'    => 'px',
     *      'options' => array(
     *          'top'    => TRUE,
     *          'right'  => FALSE,
     *          'bottom' => TRUE,
     *          'left'   => FALSE,
     *      )
     * ), $attributes );
     * } );
     */
    function upb_add_attribute_after( $id, $attribute, $attributes ) {

        if ( empty( $attributes ) ) {
            return $attributes;
        } else {
            $new_attributes = array();
            foreach ( (array) $attributes as $attr ) {
                array_push( $new_attributes, $attr );
                if ( is_string( $id ) && $attr[ 'id' ] == $id ) {

                    if ( isset( $attribute[ 'id' ] ) ) {
                        array_push( $new_attributes, $attribute );
                    } else {
                        foreach ( (array) $attribute as $attrs ) {
                            if ( is_array( $attrs ) ) {
                                array_push( $new_attributes, $attrs );
                            }
                        }
                    }
                }
            }

            return $new_attributes;
        }
    }

    function upb_is_shortcode_enabled( $attributes ) {
        // if not set then return true;
        return isset( $attributes[ 'enable' ] ) ? ! empty( $attributes[ 'enable' ] ) : TRUE;
    }

    function upb_get_shortcode_class( $attributes, $extra = FALSE ) {

        $classes = array();
        if ( isset( $attributes[ 'hidden-device' ] ) ) {
            $classes = array_merge( $classes, $attributes[ 'hidden-device' ] );
        }

        if ( isset( $attributes[ 'element_class' ] ) ) {
            array_push( $classes, $attributes[ 'element_class' ] );
        }

        if ( ! empty( $extra ) && is_string( $extra ) ) {
            array_push( $classes, $extra );
        }

        if ( ! empty( $extra ) && is_array( $extra ) ) {
            $classes = array_merge( $classes, $extra );
        }

        return implode( ' ', apply_filters( 'upb_get_shortcode_class', array_unique( $classes ) ) );
    }

    function upb_get_shortcode_id( $attributes ) {
        return isset( $attributes[ 'element_id' ] ) ? apply_filters( 'upb_get_shortcode_id', $attributes[ 'element_id' ] ) : FALSE;
    }

    function upb_shortcode_id( $attributes ) {
        echo esc_attr( upb_get_shortcode_id( $attributes ) );
    }

    function upb_shortcode_attribute_id( $attributes ) {
        $id = trim( esc_attr( upb_get_shortcode_id( $attributes ) ) );
        if ( ! empty( $id ) ) {
            echo 'id="' . esc_attr( upb_get_shortcode_id( $attributes ) ) . '"';
        }
    }

    function upb_shortcode_class( $attributes, $extra = FALSE ) {
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

            if ( $attributes[ 'background-type' ] == 'gradient' ) {
                printf( 'background-image: %s;', sprintf(
                    "linear-gradient(%s, %s %s, %s %s, %s %s)",
                    esc_attr( $attributes[ 'gradient-position' ] ),
                    esc_attr( $attributes[ 'gradient-start-color' ] ),
                    esc_attr( $attributes[ 'gradient-start-location' ] ) . '%',
                    esc_attr( $attributes[ 'gradient-color-stop-1' ] ),
                    esc_attr( $attributes[ 'gradient-color-stop-1-location' ] ) . '%',
                    esc_attr( $attributes[ 'gradient-end-color' ] ),
                    esc_attr( $attributes[ 'gradient-end-location' ] ) . '%'
                ) );
            }
        }

        do_action( 'upb_shortcode_scoped_style_background', $attributes );
    }

    function upb_enqueue_shortcode_scripts() {

        if ( upb_is_enabled() ):

            $post_ID = get_queried_object_id();

            $shortcodes = get_post_meta( $post_ID, '_upb_shortcodes', TRUE );

            array_map( function ( $element ) use ( $shortcodes ) {

                if ( has_shortcode( $shortcodes, $element[ 'tag' ] ) ) {

                    $handle = sprintf( 'upb-element-%s', $element[ 'tag' ] );

                    if ( ! empty( $element[ '_upb_options' ][ 'assets' ][ 'shortcode' ][ 'js' ] ) ) {
                        wp_enqueue_script( $handle );
                    }

                    if ( ! empty( $element[ '_upb_options' ][ 'assets' ][ 'shortcode' ][ 'css' ] ) ) {
                        wp_enqueue_style( $handle );
                    }

                    do_action( 'upb_enqueue_shortcode_scripts', $element[ 'tag' ] );
                }
            }, upb_elements()->get_all() );
        endif;
    }

    /**
     * Example:
     *
     * add_action('upb_boilerplate_print_footer_scripts', function(){
     *     ob_start();
     *     upb_get_template('x-template.php');
     *     $contents = ob_get_clean();
     *     upb_add_script_template('template-id', $contents);
     * });
     */
    function upb_add_script_template( $id, $contents ) {
        echo '<script type="text/x-template" id="' . upb_get_script_template_id( $id ) . '">';
        echo $contents;
        echo '</script>';
    }

    function upb_get_script_template_id( $id ) {
        return 'upb-' . $id . '-template">';
    }

    function upb_hex2RGB( $hex, $opacity = FALSE ) {

        if ( substr( strtolower( $hex ), 0, 3 ) == 'rgb' ) {
            return $hex;
        }

        $hex = str_replace( "#", "", $hex );

        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        $rgb = array( $r, $g, $b );

        if ( $opacity ) {
            if ( abs( $opacity ) > 1 ) {
                $opacity = 1.0;
            }
            $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode( ",", $rgb ) . ')';
        }

        return $output;
    }

    function upb_rgb2HEX( $rgb ) {

        if ( substr( strtolower( $rgb ), 0, 1 ) == '#' ) {
            return $rgb;
        }

        $hex = "#";
        $hex .= str_pad( dechex( $rgb[ 0 ] ), 2, "0", STR_PAD_LEFT );
        $hex .= str_pad( dechex( $rgb[ 1 ] ), 2, "0", STR_PAD_LEFT );
        $hex .= str_pad( dechex( $rgb[ 2 ] ), 2, "0", STR_PAD_LEFT );

        return $hex;
    }
