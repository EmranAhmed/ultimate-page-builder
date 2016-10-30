<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	function upb_is_ios() {
		return wp_is_mobile() && preg_match( '/iPad|iPod|iPhone/', $_SERVER[ 'HTTP_USER_AGENT' ] );
	}

	function upb_is_ie() {
		global $is_IE;

		return wp_is_mobile() && $is_IE;
	}

	function upb_elements() {
		return UPB_Elements::getInstance();
	}

	function upb_tabs() {
		return UPB_Tabs::getInstance();
	}

	function upb_is_preview() {

		if ( apply_filters( 'upb_has_access', TRUE ) && is_page() && isset( $_GET[ 'upb-preview' ] ) && $_GET[ 'upb-preview' ] == '1' && is_user_logged_in() ) {
			return TRUE;
		}

		return FALSE;

	}

	function upb_is_boilerplate() {

		if ( apply_filters( 'upb_has_access', TRUE ) && is_page() && isset( $_GET[ 'upb' ] ) && $_GET[ 'upb' ] == '1' && is_user_logged_in() ) {
			return TRUE;
		}

		return FALSE;

	}

