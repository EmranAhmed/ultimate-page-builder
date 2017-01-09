<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Core Elements
    // Column
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Column Title', 'ultimate-page-builder' ), '', esc_html__( 'Column 1', 'ultimate-page-builder' ) ) );

        $attributes = array_merge( $attributes, upb_column_device_input() );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => esc_html__( 'Column', 'ultimate-page-builder' ),
                //'icon' => 'mdi mdi-format-text'
            ),
            'tools'   => array(
                //'list'     => apply_filters( 'upb_column_list_toolbar', array() ),
                //'contents' => apply_filters( 'upb_column_contents_panel_toolbar', array() ),
                //'settings' => apply_filters( 'upb_column_settings_panel_toolbar', array() ),
            ),
            'meta'    => array(

                'contents' => apply_filters( 'upb_column_contents_panel_meta', array(
                    'help'   => '<h2>Column contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => esc_html__( 'Search Element', 'ultimate-page-builder' ),
                    'title'  => '%s'
                ) ),

                'settings' => apply_filters( 'upb_column_settings_panel_meta', array(
                    'help'   => '<h2>Element Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => esc_html__( '%s Settings', 'ultimate-page-builder' )
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
            'help'    => '<h2>What to do?</h2><p>Add row and start</p>',
            'search'  => 'Search Rows',
            'tools'   => array(
                //'list'     => apply_filters( 'upb_row_list_toolbar', array() ),
                //'contents' => apply_filters( 'upb_row_contents_panel_toolbar', array() ),
                //'settings' => apply_filters( 'upb_row_settings_panel_toolbar', array() ),
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

        $element->register( 'upb-row', $attributes, $contents, $_upb_options );

    } );


    // Section
    add_action( 'upb_register_element', function ( $element ) {


        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Section Title', 'ultimate-page-builder' ), '', esc_html__( 'New Section %s', 'ultimate-page-builder' ) ) );

        $attributes = array_merge( $attributes, upb_background_input_group() );

        array_push( $attributes, upb_enable_input( esc_html__( 'Section Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $contents = array();

        $_upb_options = array(
            'element' => array(
                'name' => 'Section',
                //'icon' => 'mdi mdi-format-text'
            ),
            'meta'    => array(
                'contents' => apply_filters( 'upb_section_contents_panel_meta', array(
                    'help'   => '<h2>Now what?</h2><p>Create your layout column. Or click on mini column to add elements.</p>',
                    'search' => 'Search Rows',
                    'title'  => '%s'
                ) ),
                'settings' => apply_filters( 'upb_section_settings_panel_meta', array(
                    'help'   => '<h2>Section Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => '%s Settings'
                ) ),
            ),
        );

        $element->register( 'upb-section', $attributes, $contents, $_upb_options );

    } );


    //  NON CORE

    // Text
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(
            array( 'id' => 'title', 'title' => 'Title', 'type' => 'text', 'value' => 'Text Title' ),
            // array( 'id' => 'title', 'type' => 'textarea', 'value' => 'Text Title' ),
            array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'background', 'title' => 'Background Color', 'type' => 'color', 'value' => '#ffccff' ),
        );

        $contents = '<p>Put Contents</p>';

        $_upb_options = array(

            'element' => array(
                'name' => 'Text',
                'icon' => 'mdi mdi-format-text'
            ),

            /*'tools' => array(
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
            ),*/

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

            'assets' => array(
                'preview'   => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                    //'inline_js' => 'console.log( upbComponentId );',
                ),
                'shortcode' => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                )
            )

        );

        $element->register( 'upb-text', $attributes, $contents, $_upb_options );

    } );


    // CF7
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(
            array( 'id' => 'title', 'title' => esc_html__( 'Title', 'ultimate-page-builder' ), 'type' => 'text', 'value' => esc_html( 'Contact form 1' ) ),
            array( 'id' => 'enable', 'title' => esc_html__( 'Enable', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => TRUE ),
            array(
                'id'          => 'id',
                'type'        => 'ajax',
                'title'       => esc_html__( 'Contact Form', 'ultimate-page-builder' ),
                'desc'        => esc_html__( 'Contact form list', 'ultimate-page-builder' ),
                'value'       => '',
                'hooks'       => array(
                    'ajax'   => '_upb_search_contact_form7', // wp_ajax hook
                    'filter' => '_upb_get_contact_form7', // filter hook
                ),
                'template'    => '<div> ID# %(id)s - %(title)s </div>',
                'placeholder' => esc_html__( 'Search contact form', 'ultimate-page-builder' ),
                'settings'    => array(
                    'allowClear' => TRUE
                )
            ),


        );

        $contents = FALSE;

        $_upb_options = array(

            'element' => array(
                'name' => esc_html__( 'Contact form 7', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-newspaper'
            ),

            'tools' => array(
                'list'     => apply_filters( 'upb_contact-form-7_list_toolbar', array(
                    array(
                        'id'    => 'move',
                        'icon'  => 'mdi mdi-cursor-move',
                        'class' => 'handle',
                        'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'delete',
                        'icon'  => 'mdi mdi-delete',
                        'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
                    ),
                    /*array(
                        'id'    => 'contents',
                        'icon'  => 'mdi mdi-table-edit',
                        'class' => 'show-contents',
                        'title' => 'Contents',
                    ),*/
                    array(
                        'id'    => 'settings',
                        'icon'  => 'mdi mdi-settings',
                        'class' => 'show-settings',
                        'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'clone',
                        'icon'  => 'mdi mdi-content-duplicate',
                        'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
                    )
                ) ),


                //'contents' => apply_filters( 'upb_contact-form-7_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_contact-form-7_settings_panel_toolbar', array() ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_contact-form-7_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => esc_html__( 'Search', 'ultimate-page-builder' ),
                    'title'  => '%s'
                ) ),

                'settings' => apply_filters( 'upb_contact-form-7_settings_panel_meta', array(
                    'help'   => '<h2>Text Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => esc_html__( '%s Settings', 'ultimate-page-builder' )
                ) ),

                'messages' => array(
                    'chooseForm' => esc_html__( 'Choose a form from left panel', 'ultimate-page-builder' )
                )
            ),

            'assets' => array(
                'preview'   => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                    //'inline_js' => 'console.log("Hello Again");',
                ),
                'shortcode' => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                )
            )

        );

        if ( shortcode_exists( 'contact-form-7' ) ) {
            $element->register( 'contact-form-7', $attributes, $contents, $_upb_options );
        }

    } );


    add_action( 'upb_register_element', function ( $element ) {


        // Accordion Item

        $attributes = array(
            array( 'id' => 'title', 'title' => esc_html__( 'Title', 'ultimate-page-builder' ), 'type' => 'text', 'value' => esc_html( 'Accordion Item' ) ),
            array( 'id' => 'enable', 'title' => esc_html__( 'Enable', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => TRUE ),
            array( 'id' => 'opened', 'title' => esc_html__( 'Auto Opened', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => FALSE ),
        );

        $contents = wp_kses_post( '<p>Accordion Item</p>' );

        $_upb_options = array(

            'element' => array(
                'name'  => esc_html__( 'Accordion Item', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-playlist-plus',
                'child' => TRUE
            ),

            'tools' => array(
                'list'     => apply_filters( 'upb_accordion-item_list_toolbar', array(
                    array(
                        'id'    => 'move',
                        'icon'  => 'mdi mdi-cursor-move',
                        'class' => 'handle',
                        'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'delete',
                        'icon'  => 'mdi mdi-delete',
                        'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
                    ),
                    /*array(
                        'id'    => 'contents',
                        'icon'  => 'mdi mdi-table-edit',
                        'class' => 'show-contents',
                        'title' => 'Contents',
                    ),*/
                    array(
                        'id'    => 'settings',
                        'icon'  => 'mdi mdi-settings',
                        'class' => 'show-settings',
                        'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'clone',
                        'icon'  => 'mdi mdi-content-duplicate',
                        'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
                    )
                ) ),
                'contents' => apply_filters( 'upb_accordion-item_contents_panel_toolbar', array() ),
                'settings' => apply_filters( 'upb_accordion-item_settings_panel_toolbar', array() ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_accordion-item_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => esc_html__( 'Search', 'ultimate-page-builder' ),
                    'title'  => '%s'
                ) ),

                'settings' => apply_filters( 'upb_accordion-item_settings_panel_meta', array(
                    'help'   => '<h2>Text Settings?</h2><p>section settings</p>',
                    'search' => esc_html__( 'Search', 'ultimate-page-builder' ),
                    'title'  => esc_html__( '%s Settings', 'ultimate-page-builder' )
                ) )
            ),

            'assets' => array(
                'preview'   => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                    //'inline_js' => 'console.log("Hello Again");',
                ),
                'shortcode' => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                )
            )

        );

        $element->register( 'upb-accordion-item', $attributes, $contents, $_upb_options );


        // Accordion

        $attributes = array(
            array( 'id' => 'title', 'title' => esc_html__( 'Title', 'ultimate-page-builder' ), 'type' => 'text', 'value' => esc_html( 'Accordion' ) ),
            array( 'id' => 'enable', 'title' => esc_html__( 'Enable', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => TRUE ),
        );

        $contents = array();

        $_upb_options = array(

            'element' => array(
                'name' => esc_html__( 'Accordion', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-format-line-weight'
            ),

            'tools' => array(
                'list' => apply_filters( 'upb_accordion_list_toolbar', array(
                    array(
                        'id'    => 'move',
                        'icon'  => 'mdi mdi-cursor-move',
                        'class' => 'handle',
                        'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'delete',
                        'icon'  => 'mdi mdi-delete',
                        'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'enable',
                        'icon'  => 'mdi mdi-eye',
                        'title' => esc_html__( 'Enabled', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'disable',
                        'icon'  => 'mdi mdi-eye-off',
                        'title' => esc_html__( 'Disabled', 'ultimate-page-builder' ),
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
                        'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
                    ),
                    array(
                        'id'    => 'clone',
                        'icon'  => 'mdi mdi-content-duplicate',
                        'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
                    )
                ) ),

                'contents' => apply_filters( 'upb_accordion_contents_panel_toolbar', array(

                    array(
                        'id'     => 'add-accordion-item',
                        'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-shape-plus',
                        'action' => 'addNew',
                        'data'   => apply_filters( 'upb_new_accordion_item', upb_elements()->generate_element( 'upb-accordion-item', '<p>Accordion Item</p>', array( 'title' => array( 'type' => 'text', 'value' => esc_html__( 'Accordion Item %s', 'ultimate-page-builder' ) ) ) ) )
                    ),

                    array(
                        'id'     => 'accordion-setting',
                        'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-settings',
                        'action' => 'showSettingsPanel'
                    )
                ) ),

                'settings' => apply_filters( 'upb_accordion_settings_panel_toolbar', array(
                    array(
                        'id'     => 'accordion-contents',
                        'title'  => esc_html__( 'Contents', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-table-edit',
                        'action' => 'showContentsPanel'
                    )
                ) ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_accordion_contents_panel_meta', array(
                    'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                    'search' => esc_html__( 'Search Item', 'ultimate-page-builder' ),
                    'title'  => '%s'
                ) ),

                'settings' => apply_filters( 'upb_accordion_settings_panel_meta', array(
                    'help'   => '<h2>Text Settings?</h2><p>section settings</p>',
                    'search' => '',
                    'title'  => esc_html__( '%s Settings', 'ultimate-page-builder' )
                ) ),

                'messages' => array(
                    'addElement' => esc_html__( 'Add Accordion Item', 'ultimate-page-builder' )
                )
            ),

            'assets' => array(
                'preview'   => array(
                    // 'css'       => upb_templates_uri( 'preview-css/sections.css' ),
                    // 'js'     => upb_templates_uri( 'preview-js/sections.js' ),
                    // 'inline_js' => ';(function () { console.log("Hello Again") }());',
                    // 'inline_js' => 'console.log( _UPB_PREVIEW_DATA[upbComponentId] );',
                ),
                'shortcode' => array(
                    // 'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    // 'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                )
            )
        );

        $element->register( 'upb-accordion', $attributes, $contents, $_upb_options );

    } );
