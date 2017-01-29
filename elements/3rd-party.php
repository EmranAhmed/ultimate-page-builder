<?php
    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Contact Form 7
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Form Title', 'ultimate-page-builder' ), '', esc_html__( 'Contact form 1', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        array_push( $attributes, array(
            'id'          => 'id',
            'type'        => 'ajax-select',
            'title'       => esc_html__( 'Contact Form', 'ultimate-page-builder' ),
            'desc'        => esc_html__( 'Contact form list', 'ultimate-page-builder' ),
            'value'       => '',
            'template'    => '<div> ID# %(id)s - %(title)s </div>',
            'placeholder' => esc_html__( 'Search contact form', 'ultimate-page-builder' )
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