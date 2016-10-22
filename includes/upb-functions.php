<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	function UPB_Elements() {
		return UPB_Elements::getInstance();
	}

	function upb_elements_register_action() {
		do_action( 'upb_register_element', UPB_Elements() );
	}

	add_action( 'wp_loaded', 'upb_elements_register_action' );