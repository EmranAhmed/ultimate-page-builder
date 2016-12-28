<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Register Settings
    add_action( 'upb_register_setting', function ( $settings ) {


        // print_r(upb_responsive_hidden()); die;


        $options = array(
            'title'       => 'Background',
            'type'        => 'background-image',
            'default'     => '',
            'size'        => 'full',
            'placeholder' => 'Choose background',
            'buttons'     => array(
                'add'    => 'Use',
                'remove' => 'Remove',
                'choose' => 'Choose',
            )
        );

        $settings->register( 'test13', $options );


        $options = array(
            'title'       => 'Background Image Position',
            'type'        => 'background-image-position',
            'default'     => '',
            'use'         => 'test13',
            'placeholder' => 'Choose background',
        );

        $settings->register( 'test12', $options );


        $options = array(
            'type'      => 'checkbox',
            'title'     => 'CheckBox',
            'default'   => array( '1', '2' ),
            'delimiter' => ',',
            'options'   => array(
                '1' => '1 Column',
                '2' => '2 Column',
                '3' => '3 Column',
            )
        );

        $settings->register( 'test11', $options );


        $options = array(
            'type'    => 'image-select',
            'title'   => 'Image Select',
            'default' => '1',
            'options' => array(
                '1' => array(
                    'label' => '1 Column',
                    'url'   => upb_assets_uri( 'images/1col.png' )
                ),
                '2' => array(
                    'label' => '2 Column',
                    'url'   => upb_assets_uri( 'images/2cl.png' )
                ),
                '3' => array(
                    'label' => '3 Column',
                    'url'   => upb_assets_uri( 'images/3cl.png' )
                ),
            )
        );

        $settings->register( 'test10', $options );


        $options = array(
            'type'        => 'image',
            'title'       => 'Image Media',
            'placeholder' => 'No Image is Selected',
            'size'        => 'full',
            'buttons'     => array(
                'add'    => 'Add',
                'remove' => 'Remove',
                'choose' => 'Select...',
            )
        );

        $settings->register( 'test9', $options );


        $options = array(
            'type'     => 'select2',
            'title'    => 'Select multi',
            //'default'  => array( '2' ),
            'multiple' => TRUE,
            'options'  => array( '1' => 'ONE', '2' => 'TWO', '3' => 'Three' ),
            'settings' => array(
                'placeholder' => 'Placeholder',
                'allowClear'  => TRUE
            )
        );

        $settings->register( 'test8', $options );


        $options = array(
            'type'    => 'toggle',
            'title'   => 'Enable',
            'default' => FALSE,
            'reload'  => TRUE
        );


        $settings->register( 'enable', $options );


        $options = array(
            'type'    => 'select',
            'title'   => 'Position',
            'default' => 'upb-after-contents',
            'reload'  => TRUE,
            'options' => array(
                'upb-before-contents' => 'Before Contents',
                'upb-on-contents'     => 'Replace Contents',
                'upb-after-contents'  => 'After Contents',
            )
        );


        $settings->register( 'position', $options );

        //=================================================


        $options = array(
            'type'    => 'text',
            'title'   => 'Test Title',
            'default' => 'xyz',
        );

        $settings->register( 'test1', $options );

        $options = array(
            'type'    => 'textarea',
            'title'   => 'TextArea',
            'default' => 'textarea',
        );

        $settings->register( 'test2', $options );


        $options = array(
            'type'    => 'radio',
            'title'   => 'Radio',
            'default' => '1',
            'options' => array( '1' => 'ONE', '2' => 'TWO' )
        );

        $settings->register( 'test3', $options );


        $options = array(
            'type'    => 'select',
            'title'   => 'Select',
            'default' => '1',
            'options' => array( '1' => 'ONE', '2' => 'TWO' )
        );

        $settings->register( 'test4', $options );

        $options = array(
            'type'     => 'select',
            'title'    => 'Select Multiple',
            'multiple' => TRUE,
            'default'  => array( '1' ),
            'options'  => array( '1' => 'ONE', '2' => 'TWO' )
        );
        $settings->register( 'test5', $options );

        $options = array(
            'type'    => 'editor',
            'title'   => 'Editor',
            'default' => 'CONTENTS',
        );
        $settings->register( 'test6', $options );


        // ==============================================


        $options = array(
            'type'    => 'color',
            'title'   => 'Color',
            'default' => '#ffccff',
            'alpha'   => TRUE //
        );


        $settings->register( 'color', $options );


        $options = array(
            'type'     => 'select2',
            'title'    => 'Select2',
            'default'  => '1',
            'options'  => array( '1' => 'ONE', '2' => 'TWO' ),
            'settings' => array(
                'placeholder' => 'Placeholder',
                'allowClear'  => TRUE
            )
        );

        $settings->register( 'test7', $options );


    } );

