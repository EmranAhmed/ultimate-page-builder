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

        // array_push( $attributes, upb_column_clearfix_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

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

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

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
                'suffix' => 'px',
            ),
            'value'   => 0,
        ) );

        array_push( $attributes, array(
            'id'      => 'padding',
            'title'   => esc_html__( 'Margin', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Margin between two section', 'ultimate-page-builder' ),
            'type'    => 'spacing',
            'value'   => array( 10, '', 10, '' ),
            'options' => array(
                'top'    => TRUE,
                'right'  => FALSE,
                'bottom' => TRUE,
                'left'   => FALSE,
            )
        ) );

        /*$attributes = array_merge( $attributes,
                                   upb_media_query_based_input_group( array(
                                                                          'id'      => 'margin',
                                                                          'title'   => esc_html__( 'Margin', 'ultimate-page-builder' ),
                                                                          'desc'    => esc_html__( 'Space between two section', 'ultimate-page-builder' ),
                                                                          'type'    => 'range',
                                                                          'options' => array(
                                                                              'min'    => 0,
                                                                              'max'    => 200,
                                                                              'step'   => 1,
                                                                              'suffix' => 'px',
                                                                          ),
                                                                          'value'   => 0,
                                                                      ) ) );*/

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
