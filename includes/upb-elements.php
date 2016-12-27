<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Column
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(


            array( 'id' => 'title', 'title' => 'Title', 'type' => 'text', 'value' => 'Column 1' ),
            array( 'id' => 'lg', 'type' => 'hidden', 'value' => '' ),
            array( 'id' => 'md', 'type' => 'hidden', 'value' => '' ),
            array( 'id' => 'sm', 'type' => 'hidden', 'value' => '' ),
            array( 'id' => 'xs', 'type' => 'hidden', 'value' => '1:1' ),
            // array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'background', 'title' => 'Background', 'type' => 'color', 'value' => '#ffccff' ),
        );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => 'Column',
                //'icon' => 'mdi mdi-format-text'
            ),
            'tools'   => array(
                'list'     => apply_filters( 'upb_column_list_toolbar', array() ),
                'contents' => apply_filters( 'upb_column_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_column_settings_panel_toolbar', array() ),
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_column_contents_panel_meta', array(
                    'help'   => '<h2>Column contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => 'Search Element',
                    'title'  => '%s'
                ) ),
                'settings' => apply_filters( 'upb_column_settings_panel_meta', array(
                    'help'   => '<h2>Element Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => '%s Settings'
                ) ),
            ),
        );

        $element->register( 'column', $attributes, $contents, $_upb_options );

    } );


    // Row ( Section have row dependency that's why we should reg row before section )
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(
            array( 'id' => 'title', 'title' => 'Row title', 'type' => 'text', 'value' => 'New Row 1' ),
            array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'background', 'title' => 'Background', 'type' => 'color', 'value' => '#fff' ),
            array(
                'id'      => 'background-image',
                'title'   => 'Background Image',
                'type'    => 'image',
                'value'   => '',
                'buttons' => array(
                    'add'    => 'Add',
                    'remove' => 'Remove',
                    'choose' => 'Select...',
                )
            )

        );


        $grid = apply_filters( 'upb_grid_system', array() );

        if ( isset( $grid[ 'groupWrapper' ] ) ):

            $default = array_keys( $grid[ 'groupWrapper' ] );

            $attributes[] = array( 'id' => 'container', 'title' => 'Container Type', 'type' => 'radio', 'value' => $default[ 0 ], 'options' => $grid[ 'groupWrapper' ] );
        endif;


        $contents = array();

        $_upb_options = array(
            'help'    => '<h2>What to do?</h2><p>Add row and start</p>',
            'search'  => 'Search Rows',
            'tools'   => array(
                'list'     => apply_filters( 'upb_row_list_toolbar', array() ),
                'contents' => apply_filters( 'upb_row_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_row_settings_panel_toolbar', array() ),
            ),
            'element' => array(
                'name' => 'Row',
                //'icon' => 'mdi mdi-format-text'
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_row_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => 'Search Column',
                    'title'  => '%s'
                ) ),
                'settings' => apply_filters( 'upb_row_settings_panel_meta', array(
                    'help'   => '<h2>Row Settings?</h2><p>row settings</p>',
                    'search' => '',
                    'title'  => '%s Settings'
                ) ),
            ),
        );

        $element->register( 'row', $attributes, $contents, $_upb_options );

    } );


    // Section
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(
            array(
                'id'       => 'multi',
                'title'    => 'Select Multiple',
                'type'     => 'select',
                'multiple' => TRUE,
                'value'    => array( '1' ),
                'options'  => array( '1' => 'ONE', '2' => 'TWO' )
            ),


            array(
                'id'      => 'multix',
                'title'   => 'Checkbox Multiple',
                'type'    => 'checkbox',
                'value'   => array( '1', '3' ),
                'options' => array( '1' => 'A', '2' => 'B', '3' => 'C' )
            ),

            array(
                'id'      => 'hide',
                'title'   => 'Device Hidden',
                'type'    => 'device-hidden',
                'value'   => array(),
                'options' => upb_responsive_hidden()
            ),

            array( 'id' => 'title', 'title' => 'Section title', 'type' => 'text', 'value' => 'New Section %s' ),
            array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'background-color', 'title' => 'Background Color', 'type' => 'color', 'value' => '#ffccff' ),
        );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => 'Section',
                //'icon' => 'mdi mdi-format-text'
            ),
            'tools'   => array(
                'list'     => apply_filters( 'upb_section_list_toolbar', array() ),
                'contents' => apply_filters( 'upb_section_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_section_settings_panel_toolbar', array() ),
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_section_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => 'Search Rows',
                    'title'  => '%s'
                ) ),
                'settings' => apply_filters( 'upb_section_settings_panel_meta', array(
                    'help'   => '<h2>Section Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => '%s Settings'
                ) ),
            ),
            'assets'  => array(
                'preview' => array(
                    'css' => '',
                    'js'  => ''
                )
            )
        );

        $element->register( 'section', $attributes, $contents, $_upb_options );

    } );


    //////  NON CORE

    // Text
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(
            array( 'id' => 'title', 'title' => 'Title', 'type' => 'text', 'value' => 'Text Title' ),
            // array( 'id' => 'title', 'type' => 'textarea', 'value' => 'Text Title' ),
            array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'background', 'title' => 'Background Color', 'type' => 'color', 'value' => '#ffccff' ),
        );

        $contents = 'Put Contents';

        $_upb_options = array(

            'element' => array(
                'name' => 'Text',
                'icon' => 'mdi mdi-format-text'
            ),

            'tools' => array(
                'list'     => apply_filters( 'upb_text_list_toolbar', array(
                    array(
                        'id'    => 'move',
                        'icon'  => 'mdi mdi-cursor-move',
                        'class' => 'handle',
                        'title' => 'Sort',
                    ),
                    array(
                        'id'    => 'delete',
                        'icon'  => 'mdi mdi-delete',
                        'title' => 'Delete',
                    ),
                    array(
                        'id'    => 'contents',
                        'icon'  => 'mdi mdi-table-edit',
                        'class' => 'show-contents',
                        'title' => 'Contents',
                    ),
                    array(
                        'id'    => 'settings',
                        'icon'  => 'mdi mdi-settings',
                        'class' => 'show-settings',
                        'title' => 'Settings',
                    ),
                    array(
                        'id'    => 'clone',
                        'icon'  => 'mdi mdi-content-duplicate',
                        'title' => 'Clone',
                    )
                ) ),
                'contents' => apply_filters( 'upb_text_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_text_settings_panel_toolbar', array() ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_text_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => 'Search',
                    'title'  => '%s'
                ) ),

                'settings' => apply_filters( 'upb_text_settings_panel_meta', array(
                    'help'   => '<h2>Text Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => '%s Settings'
                ) ),
            ),

        );

        $element->register( 'text', $attributes, $contents, $_upb_options );

    } );

