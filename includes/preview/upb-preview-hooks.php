<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	add_action( 'upb_preview_loaded', function () {
		add_filter( 'show_admin_bar', '__return_false' );
	} );

	add_action( 'upb_preview_loaded', function () {
		add_filter( 'body_class', function ( $classes ) {
			array_push( $classes, 'upb-preview' );

			return $classes;
		} );
	} );

	add_action( 'wp_footer', function () {
		// JS Layouts
		if ( upb_is_preview() ) {



		}
	}, 20 );

	add_filter( 'upb_before_preview_content', function () {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_DIR . 'upb_before_content_wrapper.php';

		return ob_get_clean();
	} );

	add_filter( 'upb_preview_content', function ( $content ) {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_DIR . 'upb_on_content_wrapper.php';

		return ob_get_clean();
	} );

	add_filter( 'upb_after_preview_content', function () {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_DIR . 'upb_after_content_wrapper.php';

		return ob_get_clean();
	} );
