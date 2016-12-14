<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	function upb_elements_register_action() {
		do_action( 'upb_register_element', upb_elements() );
	}

	add_action( 'wp_loaded', 'upb_elements_register_action' );

	function upb_tabs_register_action() {
		do_action( 'upb_register_tab', upb_tabs() );
	}

	add_action( 'wp_loaded', 'upb_tabs_register_action' );

	function upb_settings_register_action() {
		do_action( 'upb_register_setting', upb_settings() );
	}

	add_action( 'wp_loaded', 'upb_settings_register_action' );


	// AJAX Requests
	add_action( 'wp_ajax__upb_save', function () {

		// Should have edit_pages cap :)
		if ( ! current_user_can( 'edit_pages' ) ) {
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

		print_r( $_POST[ 'contents' ] );

		// SAVE ON PAGE META :D
	} );


	// Section Template Save
	add_action( 'wp_ajax__save_section', function () {

		// Should have manage_options cap :)
		if ( ! current_user_can( 'manage_options' ) ) {
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

		$sections   = (array) get_option( '_upb_saved_sections', array() );
		$sections[] = $_POST[ 'contents' ];

		$update = update_option( '_upb_saved_sections', $sections, FALSE );

		wp_send_json_success( $update );
	} );


	// Modify Saved Template
	add_action( 'wp_ajax__save_section_all', function () {

		if ( ! current_user_can( 'manage_options' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		if ( empty( $_POST[ 'contents' ] ) ) {
			$update = update_option( '_upb_saved_sections', array(), FALSE );
		} else {
			$sections = (array) $_POST[ 'contents' ];
			$update   = update_option( '_upb_saved_sections', $sections, FALSE );
		}

		wp_send_json_success( $update );
	} );

	// Get Element Option
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

	// Section Panel Contents
	add_action( 'wp_ajax__get_upb_sections_panel_contents', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );

		wp_send_json_success( upb_elements()->set_upb_options_recursive(


			array(
				array(
					'tag'        => 'section',
					'contents'   => array(
						array(
							'tag'        => 'row',
							'contents'   => array(
								array(
									'tag'        => 'column',
									'contents'   => array(),
									'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'COL 1', 'lg' => '1:3', 'md' => '2:4', 'sm' => '', 'xs' => '' )
								),
								array(
									'tag'        => 'column',
									'contents'   => array(),
									'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'COL 2', 'lg' => '1:3', 'md' => '1:4', 'sm' => '', 'xs' => '' )
								),
								array(
									'tag'        => 'column',
									'contents'   => array(),
									'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'COL 3', 'lg' => '1:3', 'md' => '1:4', 'sm' => '', 'xs' => '' )
								),
							),
							'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'ROW GEN' )
						)

					),
					'attributes' => array( 'enable' => TRUE, 'background-color' => '#fff', 'title' => 'Section A' )
				),
				array(
					'tag'        => 'section',
					'contents'   => array(),
					'attributes' => array( 'enable' => TRUE, 'background-color' => '#ddd', 'title' => 'Section B' )
				)
			)


		) );
	} );

	// Settings Panel Contents
	add_action( 'wp_ajax__get_upb_settings_panel_contents', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );

		wp_send_json_success( upb_settings()->getAll() );
	} );

	// Elements Panel Contents
	add_action( 'wp_ajax__get_upb_element_list', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );


		wp_send_json_success( upb_elements()->getAll() );
	} );

	// Get Saved Section
	add_action( 'wp_ajax__get_saved_sections', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		$saved_sections = (array) get_option( '_upb_saved_sections', array() );

		$saved_sections = upb_elements()->set_upb_options_recursive( $saved_sections );

		wp_send_json_success( $saved_sections );
	} );
