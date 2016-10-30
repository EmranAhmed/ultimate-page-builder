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


