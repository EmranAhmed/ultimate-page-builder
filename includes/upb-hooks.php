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

	function upb_settings_register_action() {
		do_action( 'upb_register_setting', upb_settings() );
	}

	add_action( 'wp_loaded', 'upb_settings_register_action' );


	// AJAX Requests
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


	/*add_action( 'wp_ajax__get_upb_shortcode_preview', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		if ( ! isset( $_POST[ 'contents' ] ) ) {
			status_header( 400 );
			wp_send_json_error( 'missing_contents' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );


		wp_send_json_success( do_shortcode( stripslashes( $_POST[ 'contents' ] ) ) );
	} );*/


	add_action( 'wp_ajax__get_upb_shortcode_preview_section', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );

		wp_send_json_success( '
<section @mouseover.self="activeFocus()" @mouseout.self="removeFocus()" @click.self="openSettingsPanel()">

SECTION

{{ model.attributes }}

 <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>

</section>' );
	} );

	add_action( 'wp_ajax__get_upb_shortcode_preview_row', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );

		wp_send_json_success( '<div @mouseover="activeFocus()" @mouseout="removeFocus()" @click.self="openSettingsPanel(index)">

ROW

{{ model.attributes }}


<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>



</div>' );
	} );


	add_action( 'wp_ajax__get_upb_shortcode_preview_column', function () {

		if ( ! current_user_can( 'customize' ) ) {
			status_header( 403 );
			wp_send_json_error( 'upb_not_allowed' );
		}

		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			status_header( 400 );
			wp_send_json_error( 'bad_nonce' );
		}

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );

		wp_send_json_success( '<div>

Column {{ model.attributes }}


        <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>



</div>' );
	} );


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





