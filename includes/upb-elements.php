<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Core Elements
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

        $element->register( 'upb-column', $attributes, $contents, $_upb_options );

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

        $element->register( 'upb-row', $attributes, $contents, $_upb_options );

    } );


    // Section
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array(

            array(
                'id'        => 'images',
                'title'     => 'Image',
                'type'      => 'image',
                'attribute' => 'id', // src
                // 'size'      => 'full',
                'value'     => '',
                'buttons'   => array(
                    'add'    => 'Add',
                    'remove' => 'Remove',
                    'choose' => 'Select...',
                )
            ),


            array(
                'id'          => 'ajaxpost',
                'type'        => 'ajax',
                'title'       => 'Posts...',
                'desc'        => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',
                'value'       => '',
                'hooks'       => array(
                    'ajax'   => '_upb_search_posts', // wp_ajax hook
                    'filter' => '_upb_get_post', // filter hook
                ),
                'template'    => '<div> ID# %(id)s - %(title)s </div>',
                'placeholder' => 'Posts',
                'settings'    => array(
                    'allowClear' => TRUE
                )
            ),


            array(
                'id'          => 'ajaxicon',
                'type'        => 'icon-ajax',
                'title'       => 'Material Design Icons',
                'desc'        => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',
                'value'       => '',
                'hooks'       => array(
                    'ajax'   => '_upb_search_material_icons', // wp_ajax hook
                    'filter' => '_upb_get_material_icon', // filter hook
                ),
                'template'    => '<span class="select2-icon-input"><i class="%(id)s"></i>  %(title)s</div>',
                'placeholder' => 'Search Icons',
                'settings'    => array(
                    'allowClear' => TRUE,
                    'delay'      => 250,
                )
            ),


            /*array(
                'id'          => 'icon',
                'type'        => 'icons',
                'title'       => 'Icons',
                'desc'        => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',
                'value'       => '',
                'placeholder' => 'Choose Icon',
                'options'     => upb_material_design_icons(),
                'settings'    => array(
                    'allowClear' => TRUE
                )
            ),*/


            array(
                'id'       => 'multi',
                'title'    => 'Select Multiple',
                'desc'     => 'Globally e-enable next-generation leadership via maintainable users. Synergistically.',
                'type'     => 'select',
                'multiple' => TRUE,
                'value'    => array( '1' ),
                'options'  => array( '1' => 'ONE', '2' => 'TWO' )
            ),


            array(
                'id'      => 'multix',
                'title'   => 'Checkbox Multiple',
                'desc'    => 'Globally e-enable next-generation leadership via maintainable users. Synergistically.',
                'type'    => 'checkbox',
                'value'   => array( '1', '3' ),
                'options' => array( '1' => 'A', '2' => 'B', '3' => 'C' )
            ),

            array(
                'id'      => 'hide',
                'title'   => 'Device Hidden',
                'desc'    => 'Objectively scale backward-compatible customer service via.',
                'type'    => 'device-hidden',
                'value'   => array(),
                'options' => upb_responsive_hidden()
            ),


            array(
                'id'          => 'bgimageposition',
                'title'       => 'Background Image Position',
                'type'        => 'background-image-position',
                'desc'        => 'Dramatically simplify cost effective systems with..',
                'value'       => '0% 0%',
                'placeholder' => '0% 0%',
            ),

            array(
                'id'          => 'bgimage',
                'title'       => 'Background',
                'type'        => 'background-image',
                'desc'        => 'Dramatically empower enabled architectures via cutting-edge.',
                'value'       => '',
                'use'         => 'bgimageposition',
                'size'        => 'full',
                'placeholder' => 'Choose background',
                'buttons'     => array(
                    'add'    => 'Use',
                    'remove' => 'Remove',
                    'choose' => 'Choose',
                )
            ),


            array(
                'id'    => 'title',
                'desc'  => 'Dramatically empower enabled architectures via cutting-edge.',
                'title' => 'Section title',
                'type'  => 'text',
                'value' => 'New Section %s'
            ),
            array(
                'id'    => 'enable',
                'desc'  => 'Dramatically empower enabled architectures via cutting-edge.',
                'title' => 'Enable',
                'type'  => 'toggle',
                'value' => TRUE
            ),
            array(
                'id'    => 'background-color',
                'desc'  => 'Dramatically empower enabled architectures via cutting-edge.',
                'title' => 'Background Color',
                'type'  => 'color',
                'value' => '#ffccff'
            ),
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

            'assets' => array(
                'preview'   => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                ),
                'shortcode' => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
                )
            )

        );

        $element->register( 'upb-text', $attributes, $contents, $_upb_options );

    } );


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
                    'chooseForm' => esc_html__( 'Choose a form', 'ultimate-page-builder' )
                )
            ),

            'assets' => array(
                'preview'   => array(
                    //'css' => upb_templates_uri( 'preview-css/sections.css' ),
                    //'js'  => upb_templates_uri( 'preview-js/sections.js' ),
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

