<?php
	defined( 'ABSPATH' ) or die( 'Keep Quit' );

	if ( ! function_exists( 'upb_shortcode_preview_section' ) ):
		function upb_shortcode_preview_section() {

			if ( ! current_user_can( 'customize' ) ) {
				status_header( 403 );
				wp_send_json_error( 'upb_not_allowed' );
			}

			if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
				status_header( 400 );
				wp_send_json_error( 'bad_nonce' );
			}

			ob_start();
			upb_get_template( "previews/section.php" );
			wp_send_json_success( ob_get_clean() );
		}
	endif;

	if ( ! function_exists( 'upb_shortcode_preview_row' ) ):
		function upb_shortcode_preview_row() {

			if ( ! current_user_can( 'customize' ) ) {
				status_header( 403 );
				wp_send_json_error( 'upb_not_allowed' );
			}

			if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
				status_header( 400 );
				wp_send_json_error( 'bad_nonce' );
			}

			ob_start();
			upb_get_template( "previews/row.php" );
			wp_send_json_success( ob_get_clean() );
		}
	endif;

	if ( ! function_exists( 'upb_shortcode_preview_column' ) ):
		function upb_shortcode_preview_column() {

			if ( ! current_user_can( 'customize' ) ) {
				status_header( 403 );
				wp_send_json_error( 'upb_not_allowed' );
			}

			if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
				status_header( 400 );
				wp_send_json_error( 'bad_nonce' );
			}

			ob_start();
			upb_get_template( "previews/column.php" );
			wp_send_json_success( ob_get_clean() );
		}
	endif;

	if ( ! function_exists( 'upb_shortcode_preview_text' ) ):
		function upb_shortcode_preview_text() {

			if ( ! current_user_can( 'customize' ) ) {
				status_header( 403 );
				wp_send_json_error( 'upb_not_allowed' );
			}

			if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
				status_header( 400 );
				wp_send_json_error( 'bad_nonce' );
			}

			ob_start();
			upb_get_template( "previews/text.php" );
			wp_send_json_success( ob_get_clean() );
		}
	endif;


