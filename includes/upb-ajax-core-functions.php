<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// AJAX Requests
	add_action( 'wp_ajax__upb_save', function () {
		
		// Should have edit_pages capabilities :)
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_send_json_error( 'upb_not_allowed', 403 );
		}
		
		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			wp_send_json_error( 'bad_nonce', 400 );
		}
		
		if ( ! is_array( $_POST[ 'states' ] ) ) {
			wp_send_json_error( 'missing_contents', 400 );
		}
		
		// SAVE ON PAGE META :D
		
		$post_id = absint( $_POST[ 'id' ] );
		
		if ( ! empty( $_POST[ 'shortcode' ] ) ) {
			
			$sections   = wp_kses_post_deep( $_POST[ 'states' ][ 'sections' ] );
			// $sections   = json_encode( $sections ); // Doesn't work when content is html like image
			$shortcodes = wp_kses_post( trim( $_POST[ 'shortcode' ] ) );
			
			update_post_meta( $post_id, '_upb_sections', $sections );
			update_post_meta( $post_id, '_upb_shortcodes', $shortcodes );
		} else {
			delete_post_meta( $post_id, '_upb_sections' );
			delete_post_meta( $post_id, '_upb_shortcodes' );
		}
		
		$settings = wp_kses_post_deep( $_POST[ 'states' ][ 'settings' ] );
		upb_settings()->set_settings( $settings );
		wp_send_json_success( TRUE );
	} );
	
	// Section Template Save
	add_action( 'wp_ajax__save_section', function () {
		
		// Should have manage_options capabilities :)
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'upb_not_allowed', 403 );
		}
		
		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			wp_send_json_error( 'bad_nonce', 400 );
		}
		
		if ( empty( $_POST[ 'contents' ] ) || ! is_array( $_POST[ 'contents' ] ) ) {
			wp_send_json_error( 'missing_contents', 400 );
		}
		
		$sections   = (array) get_option( '_upb_saved_sections', array() );
		$sections[] = wp_kses_post_deep( stripslashes_deep( $_POST[ 'contents' ] ) );
		
		$update = update_option( '_upb_saved_sections', $sections, FALSE );
		
		wp_send_json_success( $update );
	} );
	
	// Modify Saved Template
	add_action( 'wp_ajax__save_section_all', function () {
		
		// Should have manage_options capabilities :)
		
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'upb_not_allowed', 403 );
		}
		
		if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
			wp_send_json_error( 'bad_nonce', 400 );
		}
		
		if ( empty( $_POST[ 'contents' ] ) ) {
			$update = update_option( '_upb_saved_sections', array(), FALSE );
		} else {
			$sections = (array) wp_kses_post_deep( $_POST[ 'contents' ] );
			$update   = update_option( '_upb_saved_sections', $sections, FALSE );
		}
		
		wp_send_json_success( $update );
	} );
	
	// Panel Contents
	add_action( 'wp_ajax__get_upb_sections_panel_contents', function () {
		
		upb_check_ajax_access();
		
		$post_id = absint( $_POST[ 'id' ] );
		
		$sections = get_post_meta( $post_id, '_upb_sections', TRUE );
		// $sections = json_decode( $sections, TRUE ); // Doesn't work when content is html like image
		wp_send_json_success( upb_elements()->set_upb_options_recursive( $sections ) );
	} );
	
	add_action( 'wp_ajax__get_upb_settings_panel_contents', function () {
		
		upb_check_ajax_access();
		// return get_post_meta( get_the_ID(), '_upb_settings', TRUE );
		wp_send_json_success( upb_settings()->getAll() );
	} );
	
	add_action( 'wp_ajax__get_upb_elements_panel_contents', function () {
		
		upb_check_ajax_access();
		
		//wp_send_json_success( upb_elements()->getNonCore() );
		wp_send_json_success( upb_elements()->getAll() );
	} );
	
	add_action( 'wp_ajax__get_upb_layouts_panel_contents', function () {
		
		upb_check_ajax_access();
		
		wp_send_json_success( upb_layouts()->getAll() );
	} );
	
	// Get Saved Section
	add_action( 'wp_ajax__get_saved_sections', function () {
		
		upb_check_ajax_access();
		
		$saved_sections = (array) get_option( '_upb_saved_sections', array() );
		
		$saved_sections = upb_elements()->set_upb_options_recursive( wp_kses_post_deep( stripslashes_deep( $saved_sections ) ) );
		
		wp_send_json_success( $saved_sections );
	} );
	
	add_action( 'wp_ajax__add_upb_options', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_POST[ 'contents' ] ) ) {
			wp_send_json_error( 'no_contents', 400 );
		}
		
		$contents = upb_elements()->set_upb_options_recursive( wp_kses_post_deep( stripslashes_deep( $_POST[ 'contents' ] ) ) );
		
		wp_send_json_success( $contents );
	} );
