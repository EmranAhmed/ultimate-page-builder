<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	add_action( 'upb_register_tab', function ( $tab ) {

		$data = array(
			'title'    => 'Sections',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a section then click on it to manage column layouts or drag it to reorder.</p>',
			'search'   => 'Search Sections',
			'tools'    => apply_filters( 'upb_tab_sections_tools', array(
				array(
					'id'     => 'add-new-section',
					'title'  => 'Add Section',
					'icon'   => 'mdi mdi-package-variant',
					'action' => 'addNewSection',
					'data'   => apply_filters( 'upb_section_data', array(
						'id'       => 'section',
						'title'    => 'New Section',
						'tools'    => array(), // toolbar buttons
						'settings' => array(), // will open setting panel
						'contents' => array()  // show rows
					) )
				),
				array(
					'id'     => 'load-sections',
					'title'  => 'Load Section',
					'icon'   => 'mdi mdi-cube-outline',
					'action' => 'openSavedSectionPanel'
				),
				array(
					'id'     => 'saved-layouts',
					'title'  => 'Layouts',
					'icon'   => 'mdi mdi-view-quilt',
					'action' => 'openSavedLayoutPanel'
				),
			) ), // add section | load section | layouts
			'settings' => '', // it will open a panel with settings box
			'icon'     => 'mdi mdi-package-variant',
			'contents' => apply_filters( 'upb_tab_sections_contents', array() ),
		);
		$tab->register( 'sections', $data, TRUE );

		$data = array(
			'title'    => 'Elements',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a section</p>',
			'tools'    => apply_filters( 'upb_tab_elements_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-shape-plus',
			'contents' => apply_filters( 'upb_tab_elements_contents', array() ),
		);
		$tab->register( 'elements', $data, FALSE );

		$data = array(
			'title'    => 'Options',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a section</p>',
			'tools'    => apply_filters( 'upb_tab_options_settings', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-settings',
			'contents' => apply_filters( 'upb_tab_options_contents', array() ),
		);
		$tab->register( 'options', $data, FALSE );

		$data = array(
			'title'    => 'Logical',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a section</p>',
			'tools'    => apply_filters( 'upb_tab_logical_settings', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-json',
			'contents' => apply_filters( 'upb_tab_logical_contents', array() ),
		);
		$tab->register( 'logical', $data, FALSE );

	} );


	// Load CSS :)
	add_action( 'upb_boilerplate_print_styles', function () {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URL . "css/upb-boilerplate$suffix.css" );
	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	} );


	add_action( 'upb_boilerplate_enqueue_scripts', function () {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'upb-script', UPB_PLUGIN_ASSETS_URL . "js/upb-build$suffix.js", array( 'wp-util' ), '', TRUE );
		wp_enqueue_script( 'upb-boilerplate-script', UPB_PLUGIN_ASSETS_URL . "js/upb-boilerplate-script$suffix.js", array( 'jquery', 'upb-script' ), '', TRUE );


		$data = sprintf( "var _upb_states = %s;\n", upb_tabs()->getJSON() );
		$data .= sprintf( "var _upb_status = %s;\n", wp_json_encode( array( 'dirty' => FALSE, '_nonce' => wp_create_nonce( '_upb' ), '_id' => get_the_ID() ) ) );

		//$data .= sprintf( "var _upb_options = %s;", upb_options()->getJSON() );

		wp_script_add_data( 'upb-script', 'data', $data );

		wp_localize_script( 'upb-script', '_upb_l10n',
		                    apply_filters( '_upb_l10n_strings',
		                                   array(
			                                   'save'           => esc_attr__( 'Save' ),
			                                   'close'          => esc_attr__( 'Close' ),
			                                   'help'           => esc_attr__( 'Help' ),
			                                   'search'         => esc_attr__( 'Search' ),
			                                   'breadcrumbRoot' => esc_attr__( 'You are building' ),
			                                   'skeleton'       => esc_attr__( 'Skeleton preview' ),
			                                   'collapse'       => esc_attr__( 'Collapse' ),
			                                   'expand'         => esc_attr__( 'Expand' ),
			                                   'large'          => esc_attr__( 'Large device preview' ),
			                                   'medium'         => esc_attr__( 'Medium device preview' ),
			                                   'small'          => esc_attr__( 'Small device preview' ),
			                                   'xSmall'         => esc_attr__( 'Extra small preview' ),
		                                   )
		                    )
		);
	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$tabs = upb_tabs()->getAll();
		//printf( '<script>var _upb_tabs = %s;</script>', wp_json_encode( $tabs ) );
	} );


