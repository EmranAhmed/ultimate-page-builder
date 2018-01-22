<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// Column
	add_filter( 'upb_upb-column_contents_panel_toolbar', function ( $toolbar ) {
		
		$new = array(
			'title'  => esc_html__( 'Elements Panel', 'ultimate-page-builder' ),
			'id'     => 'elements-panel',
			'icon'   => 'mdi mdi-shape-plus',
			'action' => 'showElementsPanel'
		);
		
		array_unshift( $toolbar, $new );
		
		return $toolbar;
		
	} );
	
	// Row
	add_filter( 'upb_upb-row_contents_panel_toolbar', function ( $toolbar ) {
		$toolbar[ 'new' ]     = apply_filters( 'upb_new_column_data', upb_elements()->get_element( 'upb-column' ) );
		$toolbar[ 'layouts' ] = upb_sample_grid_layout();
		
		return $toolbar;
	} );
	
	// Section
	add_filter( 'upb_upb-section_contents_panel_toolbar', function ( $toolbar ) {
		
		$new = array(
			'id'     => 'add-new-row',
			'title'  => esc_html__( 'Add Row', 'ultimate-page-builder' ),
			'icon'   => 'mdi mdi-table-row-plus-after',
			'action' => 'addNew',
			'data'   => apply_filters( 'upb_new_row_data', upb_elements()->generate_element( 'upb-row', upb_elements()->generate_element( 'upb-column', array(), array(
				'title' => esc_html__( 'Column 1', 'ultimate-page-builder' )
			) ), array(
				                                                                                 'title' => esc_html__( 'New Row %s', 'ultimate-page-builder' )
			                                                                                 ) ) )
		);
		
		$save = array(
			'id'     => 'save-section',
			'title'  => esc_html__( 'Save Section', 'ultimate-page-builder' ),
			'icon'   => 'mdi mdi-cube-send',
			'action' => 'saveSectionLayout'
		);
		
		array_unshift( $toolbar, $new );
		
		array_push( $toolbar, $save );
		
		return $toolbar;
	} );
	
	// Register Tabs
	add_action( 'upb_register_tab', function ( $tab ) {
		
		$data = array(
			'title'    => esc_html__( 'Sections', 'ultimate-page-builder' ),
			'help'     => wp_kses_post( __( '<h2>Just Getting Starting?</h2><p>Add a section then click on <i class="mdi mdi-table-edit"></i> icon to manage column layouts or click on <i class="mdi mdi-settings"></i> icon to change settings or use <i class="mdi mdi-cursor-move"></i> to reorder.</p>', 'ultimate-page-builder' ) ),
			'search'   => esc_html__( 'Search Sections', 'ultimate-page-builder' ),
			'tools'    => apply_filters( 'upb_tab_sections_tools', array(
				array(
					'id'     => 'add-new-section',
					'title'  => esc_html__( 'Add Section', 'ultimate-page-builder' ),
					'icon'   => 'mdi mdi-package-variant',
					'action' => 'addNew',
					'data'   => apply_filters( 'upb_new_section_data', upb_elements()->generate_element( 'upb-section', upb_elements()->generate_element( 'upb-row', upb_elements()->generate_element( 'upb-column', array(), array(
						'title' => esc_html__( 'Column 1', 'ultimate-page-builder' )
					) ), array(
						                                                                                                                                      'title' => esc_html__( 'Row 1', 'ultimate-page-builder' )
					                                                                                                                                      ) ) ) )
				),
				array(
					'id'     => 'load-sections',
					'title'  => esc_html__( 'Saved Sections', 'ultimate-page-builder' ),
					'icon'   => 'mdi mdi-cube-outline',
					'action' => 'openSubPanel',
					'data'   => 'sections'
				),
				array(
					'id'     => 'copy-layouts',
					'title'  => esc_html__( 'Copy Layout', 'ultimate-page-builder' ),
					'icon'   => 'mdi mdi-clipboard-text',
					'action' => 'copyLayoutToClipboard',
				),
			) ), // add section | load section | layouts
			'icon'     => 'mdi mdi-package-variant',
			'contents' => apply_filters( 'upb_sections_panel_contents', array() )
		);
		$tab->register( 'sections', $data, TRUE );
		
		
		$data = array(
			'title'    => esc_html__( 'Elements', 'ultimate-page-builder' ),
			'search'   => esc_html__( 'Search Element', 'ultimate-page-builder' ),
			'help'     => wp_kses_post( __( '<h2>How to use?</h2><p>Drag and drop an element to the right column and customize them based on your need.</p>', 'ultimate-page-builder' ) ),
			'tools'    => apply_filters( 'upb_tab_elements_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-shape-plus',
			'contents' => apply_filters( 'upb_tab_elements_contents', array() ),
		);
		$tab->register( 'elements', $data, FALSE );
		
		$data = array(
			'title'    => esc_html__( 'Settings', 'ultimate-page-builder' ),
			'help'     => wp_kses_post( __( '<p>Simply enable or disable page builder for the current page and select elements building position.</p>', 'ultimate-page-builder' ) ),
			'tools'    => apply_filters( 'upb_tab_settings_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-settings',
			'contents' => apply_filters( 'upb_tab_settings_contents', array() ),
		);
		$tab->register( 'settings', $data, FALSE );
		
		
		$data = array(
			'title'    => esc_html__( 'Pre-build Layouts', 'ultimate-page-builder' ),
			'search'   => esc_html__( 'Search Layouts', 'ultimate-page-builder' ),
			'help'     => wp_kses_post( __( '<p>Click on your desired pre-built layout to make available to the current page.</p>', 'ultimate-page-builder' ) ),
			'tools'    => apply_filters( 'upb_tab_layouts_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-palette',
			'contents' => apply_filters( 'upb_tab_layouts_contents', array() ),
		);
		$tab->register( 'layouts', $data, FALSE );
		
		/*
		$data = array(
			'title'    => esc_html__( 'Extra Panel', 'ultimate-page-builder' ),
			'search'   => esc_html__( 'Search in Extra Panel', 'ultimate-page-builder' ),
			'help'     => wp_kses_post( __( '<p>Extra Panel Help Text</p>', 'ultimate-page-builder' ) ),
			'tools'    => apply_filters( 'upb_tab_extra_panel_tools', array() ), // add section | load section | layouts
			'icon'     => 'mdi mdi-food',
			'contents' => apply_filters( 'upb_tab_extra_panel_contents', array() ),
		);
		$tab->register( 'extra', $data, FALSE );*/
		
	} );
	
	// Backend Scripts
	add_action( 'upb_boilerplate_enqueue_scripts', function () {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		wp_register_script( 'upb-common', UPB_PLUGIN_ASSETS_URI . "js/upb-common.js", array(), FALSE, TRUE );
		
		// wp_register_style( 'dashicons', includes_url( "/css/dashicons$suffix.css" ) );
		wp_deregister_style( 'select2');
		wp_register_style( 'select2', UPB_PLUGIN_ASSETS_URI . "css/select2$suffix.css" );
		
		if ( function_exists( 'WC' ) ):
			wp_register_style( 'woocommerce_admin_menu_styles', WC()->plugin_url() . '/assets/css/menu.css', array() );
		endif;
		
		wp_register_script( 'select2', UPB_PLUGIN_ASSETS_URI . "js/select2$suffix.js", array( 'jquery' ), FALSE, TRUE );
		
		// Color
		wp_register_script( 'iris', admin_url( "/js/iris.min.js" ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), FALSE, TRUE );
		// wp_register_script( 'wp-color-picker', admin_url( "/js/color-picker$suffix.js" ), array( 'iris' ), FALSE, TRUE );
		wp_register_script( 'upb-color-picker', UPB_PLUGIN_ASSETS_URI . "/js/upb-color-picker$suffix.js", array( 'iris' ), FALSE, TRUE );
		wp_localize_script( 'upb-color-picker', 'wpColorPickerL10n', array(
			'clear'         => esc_html__( 'Clear', 'ultimate-page-builder' ),
			'defaultString' => esc_html__( 'Default', 'ultimate-page-builder' ),
			'pick'          => esc_html__( 'Select Color', 'ultimate-page-builder' ),
			'current'       => esc_html__( 'Current Color', 'ultimate-page-builder' ),
		) );
		
		wp_register_script( 'upb-color-picker-alpha', UPB_PLUGIN_ASSETS_URI . "js/upb-color-picker-alpha$suffix.js", array( 'upb-color-picker' ), FALSE, TRUE );
		
	} );
	
	// Load Admin Styles :)
	add_action( 'upb_boilerplate_print_styles', function () {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		// ref: /wp-includes/script-loader.php
		// to Clean Slate We did not use wp_head hook on boilerplate template
		// that's why default registered scripts / styles does not load without re-registering :)
		// Only Admin CSS will load
		// wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'common' );
		wp_enqueue_style( 'buttons' );
		// wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'select2' );
		wp_enqueue_style( 'woocommerce_admin_menu_styles' );
		
		wp_enqueue_style( 'upb-color-picker', UPB_PLUGIN_ASSETS_URI . "css/upb-color-picker$suffix.css" );
		wp_enqueue_style( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URI . "css/upb-boilerplate$suffix.css" );
		
		wp_enqueue_style( 'upb-style', UPB_PLUGIN_ASSETS_URI . "css/upb-style$suffix.css" );
		
	} );
	
	add_action( 'upb_boilerplate_enqueue_scripts', function () {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_media();
		wp_enqueue_editor();
		wp_enqueue_script( 'upb-common' );
		wp_enqueue_script( 'upb-color-picker-alpha' );
		wp_enqueue_script( 'select2' );
		wp_enqueue_script( 'upb-vendor', UPB_PLUGIN_ASSETS_URI . "js/upb-vendor$suffix.js", array(), '', TRUE );
		wp_enqueue_script( 'upb-builder', UPB_PLUGIN_ASSETS_URI . "js/upb-builder$suffix.js", array( 'upb-vendor', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable', 'wp-util', 'upb-color-picker', 'shortcode' ), '', TRUE );
		wp_enqueue_script( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URI . "js/upb-boilerplate$suffix.js", array( 'jquery', 'upb-builder' ), '', TRUE );
		
		$data = sprintf( "const _upb_tabs = %s;\n", upb_tabs()->getJSON() );
		
		$data .= sprintf( "const _upb_router_config = %s;\n", wp_json_encode( array(
			                                                                      'mode' => 'hash' // abstract, history, hash
		                                                                      ) ) );
		
		$data .= sprintf( "const _upb_routes = %s;\n", wp_json_encode( apply_filters( 'upb_routes', array(
			/*array(
					'name'      => 'extra',
					'path'      => '/:tab(extra)',
					'component' => 'ExtraPanel',
			)*/ // you should register a tab before add routes. see line#128 for example.
		) ) ) );
		
		$data .= sprintf( "const _upb_fields = %s;\n", wp_json_encode( apply_filters( 'upb_fields', array(
			array(
				//'name'      => 'extra',
				//'component' => 'exampleExtraInput',
			)
		) ) ) );
		
		$data .= sprintf( "const _upb_user_inputs_mixin = %s;\n", wp_json_encode( apply_filters( 'upb_user_inputs_mixin', array(// 'text' => 'textInputMixinExample',
		) ) ) );
		
		$data .= sprintf( "const _upb_status = %s;\n", wp_json_encode( array( 'dirty' => FALSE, '_nonce' => wp_create_nonce( '_upb' ), '_id' => get_the_ID() ) ) );
		
		$data .= sprintf( "const _upb_preview_devices = %s;", wp_json_encode( upb_preview_devices() ) );
		
		$data .= sprintf( "const _upb_responsive_hidden_devices = %s;", wp_json_encode( upb_responsive_hidden_options() ) );
		
		$data .= sprintf( "const _upb_grid_system = %s;", wp_json_encode( upb_grid_system() ) );
		
		$data .= sprintf( "const _upb_registered_elements = %s;", wp_json_encode( upb_elements()->getNamed() ) );
		
		wp_script_add_data( 'upb-builder', 'data', $data );
		
		wp_localize_script( 'upb-builder', '_upb_l10n', apply_filters( '_upb_l10n_strings', array(
			'sectionSaving'        => esc_attr__( 'Section Saving...', 'ultimate-page-builder' ),
			'sectionSaved'         => esc_attr__( 'Section Saved.', 'ultimate-page-builder' ),
			'sectionNotSaved'      => esc_attr__( "Section Can't Save.", 'ultimate-page-builder' ),
			'elementNotRegistered' => esc_attr__( '"%s" is not registered.', 'ultimate-page-builder' ),
			'sectionDeleted'       => esc_attr__( "Section Removed.", 'ultimate-page-builder' ),
			'sectionAdded'         => esc_attr__( "%s Section Added.", 'ultimate-page-builder' ),
			'saving'               => esc_attr__( 'Saving', 'ultimate-page-builder' ),
			'saved'                => esc_attr__( 'Saved', 'ultimate-page-builder' ),
			'savingProblem'        => esc_attr__( 'Problem on Saving', 'ultimate-page-builder' ),
			'add'                  => esc_attr__( 'Add', 'ultimate-page-builder' ),
			'sectionCopied'        => esc_attr__( '%s data copied to clipboard', 'ultimate-page-builder' ),
			'searchSavedSection'   => esc_attr__( 'Search saved section', 'ultimate-page-builder' ),
			'layoutCopied'         => esc_attr__( '%s layout copied to clipboard', 'ultimate-page-builder' ),
			'layoutNotCopied'      => esc_attr__( 'Nothing to copy', 'ultimate-page-builder' ),
			'layoutAdded'          => esc_attr__( '%s Layout added', 'ultimate-page-builder' ),
			'layoutUse'            => esc_attr__( 'Use this layout', 'ultimate-page-builder' ),
			'pasteJSON'            => esc_attr__( 'Paste JSON Contents', 'ultimate-page-builder' ),
			'save'                 => esc_attr__( 'Save', 'ultimate-page-builder' ),
			'copy'                 => esc_attr__( 'Copy', 'ultimate-page-builder' ),
			'create'               => esc_attr__( 'Create', 'ultimate-page-builder' ),
			'delete'               => esc_attr__( 'Are you sure to delete %s?', 'ultimate-page-builder' ),
			'columnManual'         => esc_attr__( 'Manual', 'ultimate-page-builder' ),
			'columnLayoutOf'       => esc_attr__( 'Columns Layout of - %s', 'ultimate-page-builder' ),
			'columnOrder'          => esc_attr__( 'Column Order', 'ultimate-page-builder' ),
			'columnLayout'         => esc_attr__( 'Column layout', 'ultimate-page-builder' ),
			'columnTitle'          => esc_attr__( 'Drag to sort column or click to open contents panel', 'ultimate-page-builder' ),
			'close'                => esc_attr__( 'Close', 'ultimate-page-builder' ),
			'clone'                => esc_attr__( 'Clone of %s', 'ultimate-page-builder' ),
			'help'                 => esc_attr__( 'Help', 'ultimate-page-builder' ),
			'search'               => esc_attr__( 'Search', 'ultimate-page-builder' ),
			'back'                 => esc_attr__( 'Back', 'ultimate-page-builder' ),
			'breadcrumbRoot'       => esc_attr__( 'You are on', 'ultimate-page-builder' ),
			'skeleton'             => esc_attr__( 'Skeleton preview', 'ultimate-page-builder' ),
			'collapse'             => esc_attr__( 'Collapse', 'ultimate-page-builder' ),
			'expand'               => esc_attr__( 'Expand', 'ultimate-page-builder' ),
			'disabled'             => esc_attr__( 'Disabled', 'ultimate-page-builder' ),
			'enabled'              => esc_attr__( 'Enabled', 'ultimate-page-builder' ),
			'showDeviceColumn'     => esc_attr__( 'Show %s device column layouts', 'ultimate-page-builder' ),
			'enableDeviceColumn'   => esc_attr__( 'Click to enable %s device screen layout', 'ultimate-page-builder' ),
			'disableDeviceColumn'  => esc_attr__( 'Click to disable %s device screen layout', 'ultimate-page-builder' ),
			'reConfigDeviceColumn' => esc_attr__( '%s device column layouts should be same as other enabled device column layout', 'ultimate-page-builder' ),
			'iconDetailsTitle'     => esc_html__( 'Icon Details', 'ultimate-page-builder' ),
			// 'closeUrl'         => esc_url( get_permalink() ),
			'closeUrl'             => esc_url( set_url_scheme( add_query_arg( 'preview', 'true', get_permalink() ) ) ),
			'ajaxUrl'              => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
			// Templates
			'layoutPlaceholder'    => upb_images_uri( '/layout-placeholder.png' ),
			'editorTemplate'       => upb_wp_editor_template(),
			'editorSettings'       => array(
				'quicktags'    => array(
					'buttons' => 'strong,em,del,ul,ol,li,close,fullscreen'
				),
				'tinymce'      => array(
					'wpautop'  => TRUE,
					'toolbar1' => 'bold,italic,underline,bullist,numlist,wp_adv,wp_fullscreen,fullscreen',
					'toolbar2' => 'strikethrough,forecolor,link,unlink,alignleft,aligncenter,alignright,alignjustify,outdent,indent',
					'toolbar3' => 'formatselect,pastetext,removeformat,charmap,undo,redo'
				),
				'mediaButtons' => TRUE
			),
			'allowedTags'          => array_keys( wp_kses_allowed_html( 'post' ) ),
			'allowedAttributes'    => upb_allowed_attributes(),
			'allowedSchemes'       => wp_allowed_protocols(),
			'pageTitle'            => get_the_title(),
			'wpVersion'            => esc_attr( get_bloginfo( 'version' ) ),
			'skipHosts'            => array( $_SERVER[ 'HTTP_HOST' ] ) // You can add your cdn host also
		) ) );
	} );
	
	// Media Manager Extend
	add_action( 'upb_boilerplate_print_footer_scripts', function () {
		include upb_templates_path( 'upb_media_display_settings.php' );
	} );
	
	// Example Input
	add_action( 'upb_boilerplate_print_footer_scripts', function () {
		//$tabs = upb_tabs()->getAll();
		print( "<script type='text/javascript'>

//var textInputMixinExample = {
//    created: function(){
//        console.log('Text Input mixin example.')
//    }
//};


var ExtraPanel = {
  template: '<span> Extra Panel Template </span>',
  // template: '#template',
  props:[]
}
</script>" );
		
		print( '<script type="text/x-template" id="extra-input-template">
<li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <input class="text-input" type="text" v-model="input" :id="attributes._id" :placeholder="attributes.placeholder">
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
</li>
</script>' );
		
		print( "<script type='text/javascript'>
//var exampleExtraInput = {
  // template: '<span> Input Extra </span>',
//   template: '#extra-input-template',
//   created(){
//   console.log(this.attributes)
//    },
//}
</script>" );
	} );
	