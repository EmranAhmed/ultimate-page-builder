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
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'upb-boilerplate-bootstrap', UPB_PLUGIN_ASSETS_URL . 'css/bootstrap.min.css' );
		wp_enqueue_style( 'upb-boilerplate-font-awesome', UPB_PLUGIN_ASSETS_URL . 'css/font-awesome.min.css' );
	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	} );


	add_action( 'upb_boilerplate_enqueue_scripts', function () {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'upb-boilerplate-script', UPB_PLUGIN_ASSETS_URL . "js/upb-boilerplate-script$suffix.js", array( 'jquery' ), '', TRUE );
		wp_enqueue_script( 'upb-script', UPB_PLUGIN_ASSETS_URL . "js/upb-build$suffix.js", array(), '', TRUE );


		$tabs = upb_tabs()->getAll();
		$data = sprintf( 'var _upb_store = %s;', wp_json_encode( $tabs ) );
		wp_scripts()->add_data( 'upb-script', 'data', $data );

	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$tabs = upb_tabs()->getAll();
		//printf( '<script>var _upb_tabs = %s;</script>', wp_json_encode( $tabs ) );
	} );


