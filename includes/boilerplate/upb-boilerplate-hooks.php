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
					'action' => 'addNew',
					'data'   => apply_filters( 'upb_new_section_data', array(
						'id'       => 'section',
						'title'    => 'New Section %s',
						'help'     => '<h2>Want to add content?</h2><p>Choose a section and drag elements</p>',
						'search'   => 'Search Rows',
						'enable'   => TRUE,
						'focus'    => FALSE, // always false
						'tools'    => array(
							'list'     => apply_filters( 'upb_section_list_tools', array() ),
							'contents' => apply_filters( 'upb_section_contents_tools', array() ),
							'settings' => apply_filters( 'upb_section_settings_tools', array() ),
						), // toolbar buttons
						'settings' => apply_filters( 'upb_section_settings', array() ), // will open setting panel
						'contents' => apply_filters( 'upb_section_contents', array() )  // show rows
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


	add_filter( 'upb_section_list_tools', function ( $tools ) {
		$tools[ 'move' ] = array(
			'icon'  => 'mdi mdi-cursor-move',
			'class' => 'handle',
			'title' => 'Sort',
		);

		$tools[ 'delete' ] = array(
			'icon'  => 'mdi mdi-delete',
			'title' => 'Delete',
		);

		$tools[ 'enable' ]   = array(
			'icon'  => 'mdi mdi-eye',
			'title' => 'Enabled',
		);
		$tools[ 'disable' ]  = array(
			'icon'  => 'mdi mdi-eye-off',
			'title' => 'Disabled',
		);
		$tools[ 'contents' ] = array(
			'icon'  => 'mdi mdi-file-tree',
			'class' => 'show-contents',
			'title' => 'Contents',
		);
		$tools[ 'settings' ] = array(
			'icon'  => 'mdi mdi-settings',
			'class' => 'show-settings',
			'title' => 'Settings',
		);
		$tools[ 'clone' ]    = array(
			'icon'  => 'mdi mdi-content-duplicate',
			'title' => 'Clone',
		);

		return $tools;
	} );

	add_filter( 'upb_section_contents_tools', function () {
		return array(
			array(
				'id'     => 'add-new-row',
				'title'  => 'Add Row',
				'icon'   => 'mdi mdi-table-row-plus-after',
				'action' => 'addNew',
				'data'   => apply_filters( 'upb_new_row_data', array(
					'id'       => 'row',
					'title'    => 'New Row %s',
					'help'     => '<h2>Want to add content?</h2><p>Choose a section and drag elements</p>',
					'search'   => 'Search Rows',
					'enable'   => TRUE,
					'focus'    => FALSE, // always false
					'tools'    =>
						array(
							'list'     => apply_filters( 'upb_row_list_tools', array() ),
							'contents' => apply_filters( 'upb_row_contents_tools', array() ),
							'settings' => apply_filters( 'upb_row_settings_tools', array() ),
						), // toolbar buttons
					'settings' => apply_filters( 'upb_section_settings', array() ), // will open setting panel
					'contents' => apply_filters( 'upb_section_contents', array() )  // show rows
				) )
			),
			array(
				'id'     => 'section-setting',
				'title'  => 'Settings',
				'icon'   => 'mdi mdi-settings',
				'action' => 'showSettingsPanel'
			),
			array(
				'id'     => 'save-section',
				'title'  => 'Save Section',
				'icon'   => 'mdi mdi-cube-send',
				'action' => 'saveSectionLayout'
			),
		);
	} );


	add_filter( 'upb_row_list_tools', function ( $tools ) {
		$tools[ 'move' ] = array(
			'icon'  => 'mdi mdi-cursor-move',
			'class' => 'handle',
			'title' => 'Sort',
		);

		$tools[ 'delete' ] = array(
			'icon'  => 'mdi mdi-delete',
			'title' => 'Delete',
		);

		$tools[ 'enable' ]   = array(
			'icon'  => 'mdi mdi-eye',
			'title' => 'Enabled',
		);
		$tools[ 'disable' ]  = array(
			'icon'  => 'mdi mdi-eye-off',
			'title' => 'Disabled',
		);
		$tools[ 'contents' ] = array(
			'icon'  => 'mdi mdi-file-tree',
			'class' => 'show-contents',
			'title' => 'Contents',
		);
		$tools[ 'settings' ] = array(
			'icon'  => 'mdi mdi-settings',
			'class' => 'show-settings',
			'title' => 'Settings',
		);
		$tools[ 'clone' ]    = array(
			'icon'  => 'mdi mdi-content-duplicate',
			'title' => 'Clone',
		);

		return $tools;
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

		wp_enqueue_script( 'upb-script', UPB_PLUGIN_ASSETS_URL . "js/upb-build$suffix.js", array( 'jquery-ui-sortable', 'wp-util' ), '', TRUE );
		wp_enqueue_script( 'upb-boilerplate-script', UPB_PLUGIN_ASSETS_URL . "js/upb-boilerplate-script$suffix.js", array( 'jquery', 'upb-script' ), '', TRUE );


		$data = sprintf( "var _upb_states = %s;\n", upb_tabs()->getJSON() );
		$data .= sprintf( "var _upb_status = %s;\n", wp_json_encode( array( 'dirty' => FALSE, '_nonce' => wp_create_nonce( '_upb' ), '_id' => get_the_ID() ) ) );

		//$data .= sprintf( "var _upb_options = %s;", upb_options()->getJSON() );

		wp_script_add_data( 'upb-script', 'data', $data );

		wp_localize_script( 'upb-script', '_upb_l10n',
		                    apply_filters( '_upb_l10n_strings',
		                                   array(
			                                   'save'           => esc_attr__( 'Save' ),
			                                   'delete'         => esc_attr__( 'Are you sure to delete %s?' ),
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


