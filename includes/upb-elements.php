<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Core Elements
    // Column
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Column Title', 'ultimate-page-builder' ), '', esc_html__( 'Column 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        // upb_column_device_input is MUST field for column
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
                'suffix' => 'px',
            ),
            'value'   => 0,
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

    //  NON CORE
    // Text
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Title', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = '<p>Put Contents</p>';

        $_upb_options = array(

            'element' => array(
                'name' => 'Text',
                'icon' => 'mdi mdi-format-text'
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_text_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                ) ),

                'settings' => apply_filters( 'upb_text_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
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

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Form Title', 'ultimate-page-builder' ), '', esc_html__( 'Contact form 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        array_push( $attributes, array(
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
        ) );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Contact form 7', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-newspaper'
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_contact-form-7_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',

                ) ),

                'settings' => apply_filters( 'upb_contact-form-7_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
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
            $element->register( 'upb-contact-form-7', $attributes, $contents, $_upb_options );
        }

    } );

    // Accordion
    add_action( 'upb_register_element', function ( $element ) {

        // Accordion Item

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Accordion Item Title', 'ultimate-page-builder' ), '', esc_html__( 'Accordion Item 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, array( 'id' => 'active', 'title' => esc_html__( 'Default Active', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => FALSE ) );

        $contents = wp_kses_post( '<p>Accordion Item</p>' );

        $_upb_options = array(

            'element' => array(
                'name'  => esc_html__( 'Accordion Item', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-playlist-plus',
                'child' => TRUE
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_accordion-item_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                ) ),

                'settings' => apply_filters( 'upb_accordion-item_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
                ) )
            ),

            'assets' => array(
                'preview'   => array(
                    //'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
                    //'inline_js' => ';(function ($, upb) { $(".upb-accordion-toggle").upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
                ),
                'shortcode' => array()
            )

        );

        $element->register( 'upb-accordion-item', $attributes, $contents, $_upb_options );


        // Accordion

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Accordion Title', 'ultimate-page-builder' ), '', esc_html__( 'Accordion', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = array(
            upb_elements()->generate_element( 'upb-accordion-item', '<p>Authoritatively formulate one-to-one interfaces with sustainable information. Collaboratively impact value-added meta-services rather than superior growth.</p>', array( 'active' => TRUE, 'title' => esc_html__( 'Accordion Item 1', 'ultimate-page-builder' ) ) ),
            upb_elements()->generate_element( 'upb-accordion-item', '<p>Holisticly customize top-line leadership skills for wireless solutions. Appropriately actualize principle-centered products rather than sustainable.</p>', array( 'active' => FALSE, 'title' => esc_html__( 'Accordion Item 2', 'ultimate-page-builder' ) ) )
        );

        $_upb_options = array(

            'element' => array(
                'name' => esc_html__( 'Accordion', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-view-day'
            ),

            'tools' => array(
                'contents' => array(
                    array(
                        'id'     => 'add-accordion-item',
                        'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-shape-plus',
                        'action' => 'addNew',
                        'data'   => apply_filters( 'upb_new_accordion_item', upb_elements()->generate_element( 'upb-accordion-item', '<p>Accordion Item</p>', array( 'title' => esc_html__( 'Accordion Item %s', 'ultimate-page-builder' ) ) ) )
                    ),
                    array(
                        'id'     => 'accordion-setting',
                        'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-settings',
                        'action' => 'showSettingsPanel'
                    )
                ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_accordion_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                ) ),

                'settings' => apply_filters( 'upb_accordion_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
                ) ),

                'messages' => array(
                    'addElement' => esc_html__( 'Add Accordion Item', 'ultimate-page-builder' )
                )
            ),

            'assets' => array(
                'preview'   => array(
                    'css'       => upb_templates_uri( 'shortcode-css/upb-accordion.css' ),
                    'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
                    //'inline_js' => ';(function ($, upb) { $(".upb-accordion-toggle", upb).upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
                    'inline_js' => ';(function ($, upb) { $(".upb-accordion-item").upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',

                ),
                'shortcode' => array(
                    'css'       => upb_templates_uri( 'shortcode-css/upb-accordion.css' ),
                    'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
                    'inline_js' => ';(function ($) { $(".upb-accordion-item").upbAccordion()  }(jQuery));'
                )
            )
        );

        $element->register( 'upb-accordion', $attributes, $contents, $_upb_options );

    } );

    // Tab
    add_action( 'upb_register_element', function ( $element ) {

        // Tab Item

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Tab Item Title', 'ultimate-page-builder' ), '', esc_html__( 'Tab Item 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, array( 'id' => 'active', 'title' => esc_html__( 'Default Active', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => FALSE ) );

        $contents = wp_kses_post( '<p>Tab Contents</p>' );

        $_upb_options = array(

            'element' => array(
                'name'  => esc_html__( 'Tab Item', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-playlist-plus',
                'child' => TRUE
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_tab-item_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                ) ),

                'settings' => apply_filters( 'upb_tab-item_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
                ) )
            ),

            'assets' => array(
                'preview'   => array(
                    //'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
                    //'inline_js' => ';(function ($, upb) { $(".upb-accordion-toggle").upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
                ),
                'shortcode' => array()
            )

        );

        $element->register( 'upb-tab-item', $attributes, $contents, $_upb_options );


        // Tab

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Tab Title', 'ultimate-page-builder' ), '', esc_html__( 'Tab', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = array(
            upb_elements()->generate_element( 'upb-tab-item', '<p>Authoritatively formulate one-to-one interfaces with sustainable information. Collaboratively impact value-added meta-services rather than superior growth.</p>', array( 'active' => TRUE, 'title' => esc_html__( 'Tab 1', 'ultimate-page-builder' ) ) ),
            upb_elements()->generate_element( 'upb-tab-item', '<p>Holisticly customize top-line leadership skills for wireless solutions. Appropriately actualize principle-centered products rather than sustainable.</p>', array( 'active' => FALSE, 'title' => esc_html__( 'Tab 2', 'ultimate-page-builder' ) ) )
        );

        $_upb_options = array(

            'element' => array(
                'name' => esc_html__( 'Tab', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-tab'
            ),

            'tools' => array(
                'contents' => array(
                    array(
                        'id'     => 'add-tab-item',
                        'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-shape-plus',
                        'action' => 'addNew',
                        'data'   => apply_filters( 'upb_new_tab_item', upb_elements()->generate_element( 'upb-tab-item', '<p>Tab Contents</p>', array( 'title' => esc_html__( 'Tab Item %s', 'ultimate-page-builder' ) ) ) )
                    ),
                    array(
                        'id'     => 'tab-setting',
                        'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                        'icon'   => 'mdi mdi-settings',
                        'action' => 'showSettingsPanel'
                    )
                ),
            ),

            'meta' => array(
                'contents' => apply_filters( 'upb_tab_contents_panel_meta', array(
                    'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
                ) ),

                'settings' => apply_filters( 'upb_tab_settings_panel_meta', array(
                    'help' => '<h2>Text Settings?</h2><p>section settings</p>',
                ) ),

                'messages' => array(
                    'addElement' => esc_html__( 'Add Tab Item', 'ultimate-page-builder' )
                )
            ),

            'assets' => array(
                'preview'   => array(
                    'css'       => upb_templates_uri( 'shortcode-css/upb-tab.css' ),
                    'js'        => upb_templates_uri( 'shortcode-js/upb-tab.js' ),
                    'inline_js' => ';(function ($, upb) { $(".upb-tab-item").upbTab()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
                ),
                'shortcode' => array(
                    'css'       => upb_templates_uri( 'shortcode-css/upb-tab.css' ),
                    'js'        => upb_templates_uri( 'shortcode-js/upb-tab.js' ),
                    'inline_js' => ';(function ($) { $(".upb-tab-item").upbTab()  }(jQuery));'
                )
            )
        );

        $element->register( 'upb-tab', $attributes, $contents, $_upb_options );
    } );