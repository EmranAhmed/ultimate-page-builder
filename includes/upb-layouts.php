<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );


    add_action( 'upb_register_layout', function ( $layout ) {

        $template = array(

            'title'    => 'Blank',
            'desc'     => 'Blank Page',
            'template' => '',
            'preview'  => ''
        );

        $layout->register( $template );

    } );


