<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	// Section
	add_filter( 'upb_section_list_toolbar', function ( $tools ) {
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
			'icon'  => 'mdi mdi-table-edit',
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

	add_filter( 'upb_section_contents_panel_toolbar', function () {
		return array(
			array(
				'id'     => 'add-new-row',
				'title'  => 'Add Row',
				'icon'   => 'mdi mdi-table-row-plus-after',
				'action' => 'addNew',
				'data'   => apply_filters( 'upb_new_row_data', upb_elements()->generate_element( 'row', upb_elements()->get_element( 'column' ) ) )
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

	add_filter( 'upb_section_settings_panel_toolbar', function () {
		return array(
			array(
				'id'     => 'section-contents',
				'title'  => 'Contents',
				'icon'   => 'mdi mdi-file-tree',
				'action' => 'showContentPanel'
			)
		);
	} );

	// Will Comes From DB
	add_filter( '_____upb_sections_panel_contents', function () {


		return array();

		/*return upb_elements()->set_upb_options(
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
									'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'COL 1', 'lg' => '1:2', 'md' => '1:2', 'sm' => '', 'xs' => '' )
								),
								array(
									'tag'        => 'column',
									'contents'   => array(),
									'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'COL 2', 'lg' => '1:2', 'md' => '1:2', 'sm' => '', 'xs' => '' )
								),
							),
							'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'ROW GEN' )
						)

					),
					'attributes' => array( 'enable' => TRUE, 'background' => '#fff', 'title' => 'Section A' )
				),
				array(
					'tag'        => 'section',
					'contents'   => array(),
					'attributes' => array( 'enable' => TRUE, 'background' => '#ddd', 'title' => 'Section B' )
				)
			)
		);*/

		/*return upb_elements()->set_upb_options(
			array(
				upb_elements()->demo_data( 'section', upb_elements()->demo_data( 'row', upb_elements()->demo_data( 'column' ) ) ),
				upb_elements()->demo_data( 'section', upb_elements()->demo_data( 'row', upb_elements()->demo_data( 'column' ) ) ),
				upb_elements()->demo_data( 'section', upb_elements()->demo_data( 'row', upb_elements()->demo_data( 'column' ) ) )
			)
		);*/

		// return get_post_meta( get_the_ID(), '_upb_sections', TRUE );
	} );


	// device previews

	add_filter( 'upb_preview_devices', function () {
		return array(
			array(
				'id'     => 'lg',
				'title'  => 'Large',
				'icon'   => 'mdi mdi-desktop-mac',
				'active' => TRUE
			),
			array(
				'id'     => 'md',
				'title'  => 'Medium',
				'icon'   => 'mdi mdi-laptop-mac',
				'active' => FALSE
			),
			array(
				'id'     => 'sm',
				'title'  => 'Small',
				'icon'   => 'mdi mdi-tablet-ipad',
				'active' => FALSE
			),
			array(
				'id'     => 'xs',
				'title'  => 'Extra Small',
				'icon'   => 'mdi mdi-cellphone-iphone',
				'active' => FALSE
			),
		);
	} );

	// grid system

	add_filter( 'upb_grid_system', function () {
		return array(
			'name'              => 'Bootstrap 3',
			'simplifiedRatio'   => 'Its recommended to use simplified form of your grid ratio like: %s',
			'prefixClass'       => 'col',
			'separator'         => '-', // col- deviceId - grid class
			'groupClass'        => 'row',
			'groupWrapper'      => array(
				array(
					'name'  => 'Full Width',
					'class' => 'container-fluid'
				),
				array(
					'name'  => 'Fixed Width',
					'class' => 'container'
				),
			),
			'defaultDeviceId'   => 'xs', // We should set default column element attributes as like defaultDeviceId, If xs then [column xs='...']
			'deviceSizeTitle'   => 'Screen Sizes',
			'devices'           => apply_filters( 'upb_preview_devices', array() ),
			'totalGrid'         => 12,
			'allowedGrid'       => array( 1, 2, 3, 4, 6, 12 ),
			'nonAllowedMessage' => "Sorry, Bootstrap 3 doesn't support %s grid column."
		);
	} );


	// Row
	add_filter( 'upb_row_list_toolbar', function ( $tools ) {
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
			'icon'  => 'mdi mdi-view-column',
			'class' => 'show-contents',
			'title' => 'Column',
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


	add_filter( 'upb_row_contents_panel_toolbar', function ( $tools ) {
		return array(
			'new'     => apply_filters( 'upb_new_column_data', upb_elements()->get_element( 'column' ) ),
			'layouts' => array(
				array(
					'class' => 'grid-1-1',
					'value' => '1:1',
				),
				array(
					'class' => 'grid-1-2',
					'value' => '1:2 + 1:2',
				),
				array(
					'class' => 'grid-1-3__2-3',
					'value' => '1:3 + 2:3',
				),
				array(
					'class' => 'grid-2-3__1-3',
					'value' => '2:3 + 1:3',
				),
				array(
					'class' => 'grid-1-3__1-3__1-3',
					'value' => '1:3 + 1:3 + 1:3',
				),
				array(
					'class' => 'grid-1-4__2-4__1-4',
					'value' => '1:4 + 2:4 + 1:4',
				),
				array(
					'class' => 'grid-1-4__1-4__1-4__1-4',
					'value' => '1:4 + 1:4 + 1:4 + 1:4',
				)
			)
		);
	} );

	// Register Tabs
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
					                                                     'data'   => apply_filters( 'upb_new_section_data',
					                                                                                upb_elements()->generate_element( 'section', upb_elements()->generate_element( 'row', upb_elements()->get_element( 'column' ), array(
						                                                                                'title' => array(
							                                                                                'type'  => 'text',
							                                                                                'value' => 'New Row 1'
						                                                                                )
					                                                                                ) ) ) )
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
			                                                     )
			), // add section | load section | layouts
			'icon'     => 'mdi mdi-package-variant',
			'contents' => apply_filters( 'upb_sections_panel_contents', array() ),
			// load from get_post_meta, if you load data then ajax data will not run
		);
		$tab->register( 'sections', $data, TRUE );


		$data = array(
			'title'    => 'Elements',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a Elements</p>',
			'tools'    => apply_filters( 'upb_tab_elements_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-shape-plus',
			'contents' => apply_filters( 'upb_tab_elements_contents', array() ),
		);
		$tab->register( 'elements', $data, FALSE );

		$data = array(
			'title'    => 'Settings',
			'help'     => '<p>Simply enable or disable page builder for this page or set other options.</p>',
			'tools'    => apply_filters( 'upb_tab_settings_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-settings',
			'contents' => apply_filters( 'upb_tab_settings_contents', array() ),
		);
		$tab->register( 'settings', $data, FALSE );


		/*$data = array(
			'title'    => 'Logical',
			'help'     => '<h2>Just Getting Starting?</h2><p>Add a section</p>',
			'tools'    => apply_filters( 'upb_tab_logical_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-json',
			'contents' => apply_filters( 'upb_tab_logical_contents', array() ),
		);
		$tab->register( 'logical', $data, FALSE );*/

	} );

	// Register Settings

	add_action( 'upb_register_setting', function ( $settings ) {


		$options = array(
			'type'    => 'toggle',
			'title'   => 'Enable',
			'default' => FALSE,
			'reload'  => TRUE
		);


		$settings->register( 'enable', $options );

		/*$options = array(
			'type'    => 'text',
			'title'   => 'Position',
			'default' => 'content',
			'reload'  => TRUE
		);


		$settings->register( 'position', $options );*/


		$options = array(
			'type'    => 'select',
			'title'   => 'Position',
			'default' => 'upb-after-preview',
			'reload'  => TRUE,
			'options' => array(
				'upb-before-preview' => 'Before Contents',
				'upb-on-preview'     => 'Instead of Contents',
				'upb-after-preview'  => 'After Contents',
			)
		);


		$settings->register( 'position', $options );


		$options = array(
			'type'    => 'color',
			'title'   => 'Color',
			'default' => '#ffccff',
			'alpha'   => TRUE //
		);


		$settings->register( 'color', $options );


	} );


	// Backend Scripts

	add_action( 'upb_boilerplate_enqueue_scripts', function () {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		// Color

		wp_register_script( 'iris', admin_url( "/js/iris.min.js" ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), FALSE, TRUE );
		wp_register_script( 'wp-color-picker', admin_url( "/js/color-picker$suffix.js" ), array( 'iris' ), FALSE, TRUE );
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array(
			'clear'         => __( 'Clear' ),
			'defaultString' => __( 'Default' ),
			'pick'          => __( 'Select Color' ),
			'current'       => __( 'Current Color' ),
		) );
		wp_register_script( 'wp-color-picker', admin_url( "/js/color-picker$suffix.js" ), array( 'iris' ), FALSE, TRUE );

		wp_register_script( 'wp-color-picker-alpha', UPB_PLUGIN_ASSETS_URL . "js/wp-color-picker-alpha$suffix.js", array( 'wp-color-picker' ), FALSE, TRUE );


	} );


	// Load CSS :)
	add_action( 'upb_boilerplate_print_styles', function () {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
			// In Production Mode :)
			wp_enqueue_style( 'upb-builder', UPB_PLUGIN_ASSETS_URL . "css/upb-builder$suffix.css" );
		}

		wp_enqueue_style( 'buttons' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URL . "css/upb-boilerplate$suffix.css" );


	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	} );

	add_action( 'upb_boilerplate_enqueue_scripts', function () {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';


		wp_enqueue_script( 'wp-color-picker-alpha' );
		wp_enqueue_media();

		wp_enqueue_script( 'upb-builder', UPB_PLUGIN_ASSETS_URL . "js/upb-builder$suffix.js", array( 'jquery-ui-sortable', 'wp-util', 'wp-color-picker' ), '', TRUE );

		wp_enqueue_script( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URL . "js/upb-boilerplate$suffix.js", array( 'jquery', 'upb-builder' ), '', TRUE );


		$data = sprintf( "var _upb_tabs = %s;\n", upb_tabs()->getJSON() );
		// $data = sprintf( "var _upb_tabs = %s;\n", wp_json_encode( array() ) );

		$data .= sprintf( "var _upb_router_config = %s;\n", wp_json_encode( array(
			                                                                    //'base' => esc_url( add_query_arg( 'upb-preview', TRUE, get_preview_post_link( get_the_ID() ) ) ),
			                                                                    'mode' => 'hash' // abstract, history, hash
		                                                                    ) ) );

		$data .= sprintf( "var _upb_router = %s;\n", wp_json_encode( array(
			                                                             array(
				                                                             //'name'      => 'elements',
				                                                             //'path'      => '/:tab(elements)',
				                                                             //'component' => 'ChildView',
			                                                             )
		                                                             ) ) );


		$data .= sprintf( "var _upb_status = %s;\n", wp_json_encode( array( 'dirty' => FALSE, '_nonce' => wp_create_nonce( '_upb' ), '_id' => get_the_ID() ) ) );

		/*$data .= sprintf( "var _upb_settings = %s;", upb_settings()->getJSON() );*/

		$data .= sprintf( "var _upb_preview_devices = %s;", wp_json_encode( apply_filters( 'upb_preview_devices', array() ) ) );

		$data .= sprintf( "var _upb_grid_system = %s;", wp_json_encode( apply_filters( 'upb_grid_system', array() ) ) );

		wp_script_add_data( 'upb-builder', 'data', $data );

		wp_localize_script( 'upb-builder', '_upb_l10n', apply_filters( '_upb_l10n_strings', array(
			'save'             => esc_attr__( 'Save' ),
			'create'           => esc_attr__( 'Create' ),
			'delete'           => esc_attr__( 'Are you sure to delete %s?' ),
			'column_manual'    => esc_attr__( 'Manual' ),
			'column_layout_of' => esc_attr__( 'Columns Layout of - %s' ),
			'column_order'     => esc_attr__( 'Column Order' ),
			'column_layout'    => esc_attr__( 'Column Layout' ),
			'close'            => esc_attr__( 'Close' ),
			'clone'            => esc_attr__( 'Clone of %s' ),
			'help'             => esc_attr__( 'Help' ),
			'search'           => esc_attr__( 'Search' ),
			'back'             => esc_attr__( 'Back' ),
			'breadcrumbRoot'   => esc_attr__( 'You are on' ),
			'skeleton'         => esc_attr__( 'Skeleton preview' ),
			'collapse'         => esc_attr__( 'Collapse' ),
			'expand'           => esc_attr__( 'Expand' ),
		) ) );
	} );

	add_action( 'upb_boilerplate_print_scripts', function () {
		//$tabs = upb_tabs()->getAll();
		//printf( '<script>console.log("HAY")</script>', wp_json_encode( $tabs ) );
	} );
	add_action( 'upb_boilerplate_print_scripts', function () {
		//$tabs = upb_tabs()->getAll();
		print( "<script>

var ChildView = {

  template: '<span> Elements </span>'
}

</script>" );
	} );



