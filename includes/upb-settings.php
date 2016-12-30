<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Register Settings
    add_action( 'upb_register_setting', function ( $settings ) {


        // print_r(upb_responsive_hidden()); die;

        $options = array(
            'type'        => 'icons',
            'title'       => 'Icons',
            'desc'        => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',
            'default'     => '',
            'options'     => upb_material_design_icons(),
            'placeholder' => 'Choose Icon',
            'settings'    => array(
                'allowClear' => TRUE
            )
        );

        $settings->register( 'testicon', $options );


        $options = array(
            'title'       => 'Background',
            'desc'        => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',
            'type'        => 'background-image',
            'default'     => '',
            'size'        => 'full',
            'use'         => 'test12',
            'placeholder' => 'Choose background',
            'buttons'     => array(
                'add'    => 'Use',
                'remove' => 'Remove',
                'choose' => 'Choose',
            )
        );

        $settings->register( 'test13', $options );


        $options = array(
            'title' => 'Background Image Position',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'type'        => 'background-image-position',
            'default'     => '0% 0%',
            //'use'         => 'test13',
            'placeholder' => 'Choose background',
        );

        $settings->register( 'test12', $options );


        $options = array(
            'type'  => 'checkbox',
            'title' => 'CheckBox',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

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
            'type'  => 'image-select',
            'title' => 'Image Select',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

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
            'type'  => 'image',
            'title' => 'Image Media',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

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
            'desc'     => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

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
            'type'  => 'toggle',
            'title' => 'Enable',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'default' => FALSE,
            'reload'  => TRUE
        );


        $settings->register( 'enable', $options );


        $options = array(
            'type'  => 'select',
            'title' => 'Position',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

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
            'desc'    => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

        );

        $settings->register( 'test1', $options );

        $options = array(
            'type'    => 'textarea',
            'title'   => 'TextArea',
            'default' => 'textarea',
            'desc'    => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

        );

        $settings->register( 'test2', $options );


        $options = array(
            'type'    => 'radio',
            'title'   => 'Radio',
            'default' => '1',
            'desc'    => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'options' => array( '1' => 'ONE', '2' => 'TWO' )
        );

        $settings->register( 'test3', $options );


        $options = array(
            'type'    => 'select',
            'title'   => 'Select',
            'default' => '1',
            'desc'    => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'options' => array( '1' => 'ONE', '2' => 'TWO' )
        );

        $settings->register( 'test4', $options );

        $options = array(
            'type'  => 'select',
            'title' => 'Select Multiple',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'multiple' => TRUE,
            'default'  => array( '1' ),
            'options'  => array( '1' => 'ONE', '2' => 'TWO' )
        );
        $settings->register( 'test5', $options );

        $options = array(
            'type'  => 'editor',
            'title' => 'Editor',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'default' => '<p>CONTENTS</p>',
        );
        $settings->register( 'test6', $options );


        // ==============================================


        $options = array(
            'type'  => 'color',
            'title' => 'Color',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'default' => '#ffccff',
            'alpha'   => TRUE //
        );


        $settings->register( 'color', $options );


        $options = array(
            'type'  => 'select2',
            'title' => 'Select2',
            'desc'  => 'Synergistically reintermediate world-class data vis-a-vis revolutionary applications. Distinctively.',

            'default'  => '1',
            'options'  => array( '1' => 'ONE', '2' => 'TWO' ),
            'settings' => array(
                'placeholder' => 'Placeholder',
                'allowClear'  => TRUE
            )
        );

        $settings->register( 'test7', $options );


    } );

