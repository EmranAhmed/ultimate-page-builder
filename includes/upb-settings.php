<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Register Settings
    add_action( 'upb_register_setting', function ( $settings ) {

        $options = array(
            'type'    => 'toggle',
            'title'   => esc_html__( 'Enable / Disable', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Enable or Disable page builder for this page.', 'ultimate-page-builder' ),
            'default' => TRUE, // By Default Page builder is enabled :)
            'reload'  => TRUE
        );

        $settings->register( 'enable', $options );


        $options = array(
            'type'     => 'select',
            'title'    => esc_html__( 'Elements Position', 'ultimate-page-builder' ),
            'desc'     => esc_html__( 'Choose where you want to show page builder elements based on main contents', 'ultimate-page-builder' ),
            'default'  => 'upb-after-contents',
            'reload'   => TRUE,
            'options'  => array(
                'upb-before-contents' => esc_html__( 'Before Contents', 'ultimate-page-builder' ),
                'upb-on-contents'     => esc_html__( 'Instead of Contents', 'ultimate-page-builder' ),
                'upb-after-contents'  => esc_html__( 'After Contents', 'ultimate-page-builder' ),
            ),
            'required' => array(
                array( 'enable', '=', TRUE )
            )
        );

        $settings->register( 'position', $options );
    } );