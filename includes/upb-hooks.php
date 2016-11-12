<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	function upb_elements_register_action() {
		do_action( 'upb_register_element', upb_elements() );
	}

	add_action( 'wp_loaded', 'upb_elements_register_action', 70 );

	function upb_tabs_register_action() {
		do_action( 'upb_register_tab', upb_tabs() );
	}

	add_action( 'wp_loaded', 'upb_tabs_register_action', 90 );


	add_action( 'wp_ajax__get_upb_element_options', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		if ( empty( $_POST[ 'contents' ] ) || ! is_array( $_POST[ 'contents' ] ) ) {
			status_header( 400 );
			wp_send_json_error( 'missing_contents' );
		}

		wp_send_json_success( upb_elements()->set_upb_options( $_POST[ 'contents' ] ) );
	} );
