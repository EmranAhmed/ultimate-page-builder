<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	// Load Styles and Scripts
	add_action( 'upb_boilerplate_print_scripts', 'print_head_scripts', 20 );
	add_action( 'upb_boilerplate_print_footer_scripts', '_wp_footer_scripts' );
	add_action( 'upb_boilerplate_print_styles', 'print_admin_styles', 20 );

	add_action( 'upb_register_tab', function ( $tab ) {

		$data = array(
			'title'    => 'Sections',
			'settings' => apply_filters( 'upb_tab_sections_settings', array() ),
			'icon'     => 'fa fa-server',
			'callback' => apply_filters( 'upb_tab_sections_callback', array() ),
		);
		$tab->register( 'upb_tab_sections', $data, TRUE );

	} );

	// Load CSS :)
	add_action( 'upb_boilerplate_print_styles', function () {
		wp_enqueue_style( 'upb-boilerplate-bootstrap', UPB_PLUGIN_ASSETS_URL . 'css/bootstrap.min.css' );
		wp_enqueue_style( 'upb-boilerplate-font-awesome', UPB_PLUGIN_ASSETS_URL . 'css/font-awesome.min.css' );
	} );