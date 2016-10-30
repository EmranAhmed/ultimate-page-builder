<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	add_action( 'upb_preview_init', function () {
		add_filter( 'show_admin_bar', '__return_false' );
	} );

	add_action( 'upb_preview_init', function () {
		add_filter( 'body_class', function ( $classes ) {
			array_push( $classes, 'upb-preview' );

			return $classes;
		} );
	} );


	add_action( 'wp_footer', function () {
		// JS Layouts
	}, 20 );
