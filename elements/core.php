<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // UPB Core Elements
    // Column
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Column Title', 'ultimate-page-builder' ), '', esc_html__( 'Column 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        // upb_column_device_input is MUST HAVE field for column
        $attributes = array_merge( $attributes, upb_column_device_input() );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => esc_html__( 'Column', 'ultimate-page-builder' ),
                //'icon' => 'mdi mdi-format-text'
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_column_contents_panel_meta', array(
                    'help' => '<h2>Column contents?</h2><p>Open elements panel and drop into column</p>',
                ) ),

                'settings' => apply_filters( 'upb_column_settings_panel_meta', array(
                    'help' => '<p>Change column settings and responsive options</p>',
                ) ),

                'messages' => array(
                    'addElement' => esc_html__( 'Add Element', 'ultimate-page-builder' )
                )
            ),
        );

        $element->register( 'upb-column', $attributes, $contents, $_upb_options );

    } );

    // Row ( Section have row dependency that's why we should reg row before section )
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Row Title', 'ultimate-page-builder' ), '', esc_html__( 'New Row 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Row Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        array_push( $attributes, upb_row_wrapper_input() );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => 'Row',
                //'icon' => 'mdi mdi-format-text'
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_row_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',

                ) ),
                'settings' => apply_filters( 'upb_row_settings_panel_meta', array(
                    'help' => '<h2>Row Settings?</h2><p>row settings</p>',
                ) ),
            ),
        );

        $element->register( 'upb-row', $attributes, $contents, $_upb_options );

    } );

    // Section
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Section Title', 'ultimate-page-builder' ), '', esc_html__( 'New Section %s', 'ultimate-page-builder' ) ) );

        $attributes = array_merge( $attributes, upb_background_input_group() );

        array_push( $attributes, upb_enable_input( esc_html__( 'Section Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        array_push( $attributes, array(
            'id'      => 'space',
            'title'   => esc_html__( 'Spacer', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
            'type'    => 'range',
            'options' => array(
                'min'    => 0,
                'max'    => 200,
                'step'   => 1,
                'prefix' => 'px',
                'suffix' => 'px',
            ),
            'value'   => 0,
        ) );

        array_push( $attributes, array(
            'id'      => 'spacex',
            'title'   => esc_html__( 'Number test', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
            'type'    => 'number',
            'options' => array(
                'min'    => 0,
                'max'    => 200,
                'step'   => 1,
                'prefix' => 'px',
                'suffix' => 'px',
            ),
            'value'   => 0,
        ) );

        array_push( $attributes, array(
            'id'      => 'checkboxicon',
            'title'   => esc_html__( 'Number test', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
            'type'    => 'checkbox-icon',
            'options' => array(
                'left'   => array(
                    'title' => esc_html__( 'Left Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-left',
                ),
                'center' => array(
                    'title' => esc_html__( 'Center Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-center',
                ),
                'right'  => array(
                    'title' => esc_html__( 'Right Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-right',
                ),
            ),
            'value'   => array( 'left' ),
        ) );

        array_push( $attributes, array(
            'id'      => 'radioicon',
            'title'   => esc_html__( 'Number test', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
            'type'    => 'radio-icon',
            'options' => array(
                'left'   => array(
                    'title' => esc_html__( 'Left Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-left',
                ),
                'center' => array(
                    'title' => esc_html__( 'Center Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-center',
                ),
                'right'  => array(
                    'title' => esc_html__( 'Right Align', 'ultimate-page-builder' ),
                    'icon'  => 'mdi mdi-format-align-right',
                ),
            ),
            'value'   => 'left',
        ) );

        array_push( $attributes, array(
            'id'      => 'image-select',
            'title'   => esc_html__( 'Number test', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
            'type'    => 'image-select',
            'options' => array(
                '1' => array(
                    'title' => esc_html__( 'Left Align', 'ultimate-page-builder' ),
                    'url'   => upb_assets_uri( 'images/1col.png' ),
                ),
                '2' => array(
                    'title' => esc_html__( 'Center Align', 'ultimate-page-builder' ),
                    'url'   => upb_assets_uri( 'images/2cl.png' ),
                ),
                '3' => array(
                    'title' => esc_html__( 'Right Align', 'ultimate-page-builder' ),
                    'url'   => upb_assets_uri( 'images/3cl.png' ),
                ),
            ),
            'value'   => '1',
        ) );

        array_push( $attributes, array(
            'id'    => 'msgexample',
            'type'  => 'message',
            'title' => esc_html__( "Completely leverage other's innovative e-services after 24/7.", 'ultimate-page-builder' ),
            'style' => 'info' // info, success, warning, error
        ) );


        // Example
        array_push( $attributes, array(
            'id'          => 'ajaxsinglesearch',
            'type'        => 'ajax',
            'title'       => esc_html__( 'Search Post', 'ultimate-page-builder' ),
            'desc'        => esc_html__( 'Search post by ajax', 'ultimate-page-builder' ),
            'value'       => array(),
            'hooks'       => array(
                'search' => '_upb_search_posts',
                'load'   => '_upb_load_post',
            ),
            'template'    => '#%(id)s - %(title)s',
            'placeholder' => esc_html__( 'Search contact form', 'ultimate-page-builder' ),
            /*'settings'    => array(
                'allowClear' => TRUE
            )*/
        ) );


        array_push( $attributes, array(
            'id'       => 'ajaxmultisearch',
            'type'     => 'ajax',
            'title'    => esc_html__( 'Search Post', 'ultimate-page-builder' ),
            'desc'     => esc_html__( 'Search post by ajax', 'ultimate-page-builder' ),
            'value'    => array(),
            'hooks'    => array(
                'search' => '_upb_search_posts',
                'load'   => '_upb_load_posts',
            ),
            'multiple' => TRUE,
            'template' => '#%(id)s - %(title)s',

            'placeholder' => esc_html__( 'Search contact form', 'ultimate-page-builder' ),
            /*'settings'    => array(
                'allowClear' => TRUE
            )*/
        ) );

        array_push( $attributes, array(
            'id'          => 'ajaxicon',
            'type'        => 'icon-ajax',
            'title'       => esc_html__( 'Search Icon', 'ultimate-page-builder' ),
            'desc'        => esc_html__( 'Search post by ajax', 'ultimate-page-builder' ),
            'value'       => '',
            'hooks'       => array(
                'search' => '_upb_material_icon_search',
                'load'   => '_upb_material_icon_load',
            ),
            'placeholder' => esc_html__( 'Search contact form', 'ultimate-page-builder' ),
            'settings'    => array(//'allowClear' => FALSE
            )
        ) );

        /*array_push( $attributes, array(
            'id'    => 'extraInputExample',
            'title' => esc_html__( 'Extra Input Example', 'ultimate-page-builder' ),
            'desc'  => esc_html__( 'An example of extra input', 'ultimate-page-builder' ),
            'type'  => 'extra',
            'value' => 0,
        ) );*/

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => 'Section',
                //'icon' => 'mdi mdi-format-text'
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_section_contents_panel_meta', array(
                    'help' => '<p>Create new row, generate columns for large, medium, small and extra small devices.</p>',
                ) ),
                'settings' => apply_filters( 'upb_section_settings_panel_meta', array(
                    'help' => '<h2>Section Settings?</h2><p>section settings</p>',
                ) ),
            ),
        );

        $element->register( 'upb-section', $attributes, $contents, $_upb_options );

    } );
