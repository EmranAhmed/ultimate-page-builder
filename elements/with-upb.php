<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// Text
	add_action( 'upb_register_element', function ( $element ) {
		
		$attributes = array();
		
		array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Text Title', 'ultimate-page-builder' ) ) );
		
		array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );
		
		array_push( $attributes, upb_responsive_hidden_input() );
		
		$attributes = array_merge( $attributes, upb_css_class_id_input_group() );
		
		$contents = '<p>Text Contents</p>';
		
		$_upb_options = array(
			
			/*'preview' => array(
				'shortcode' => TRUE // It Does Not Require Preview Template But Shortcode template :)
			),*/
			
			'element' => array(
				'name' => 'UPB Editor',
				'icon' => 'mdi mdi-format-text',
			),
			
			'meta' => array(
				'contents' => apply_filters( 'upb_text_contents_panel_meta', array(
					'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
				) ),
				
				'settings' => apply_filters( 'upb_text_settings_panel_meta', array(
					'help' => '<h2>Text Settings?</h2><p>section settings</p>',
				) ),
			),
			
			'assets' => array(
				'preview'   => array(
					//'css' => upb_templates_uri( 'preview-css/sections.css' ),
					//'js'  => upb_templates_uri( 'preview-js/sections.js' ),
					//'inline_js' => 'console.log( upbComponentId );',
				),
				'shortcode' => array(
					//'css' => upb_templates_uri( 'preview-css/sections.css' ),
					//'js'  => upb_templates_uri( 'preview-js/sections.js' ),
					//'inline_js' => 'console.log( "Hello" );',
				)
			)
		);
		
		$element->register( 'upb-text', $attributes, $contents, $_upb_options );
		
	} );
	
	// Accordion
	add_action( 'upb_register_element', function ( $element ) {
		
		// Accordion Item
		
		$attributes = array();
		
		array_push( $attributes, upb_title_input( esc_html__( 'Accordion Item Title', 'ultimate-page-builder' ), '', esc_html__( 'Accordion Item 1', 'ultimate-page-builder' ) ) );
		
		array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );
		
		array_push( $attributes, array( 'id' => 'active', 'title' => esc_html__( 'Default Active', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => FALSE ) );
		
		$contents = wp_kses_post( '<p>Accordion Item</p>' );
		
		$_upb_options = array(
			
			'element' => array(
				'name'  => esc_html__( 'Accordion Item', 'ultimate-page-builder' ),
				'icon'  => 'mdi mdi-playlist-plus',
				'child' => TRUE
			),
			
			'meta' => array(
				'contents' => apply_filters( 'upb_accordion-item_contents_panel_meta', array(
					'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
				) ),
				
				'settings' => apply_filters( 'upb_accordion-item_settings_panel_meta', array(
					'help' => '<h2>Text Settings?</h2><p>section settings</p>',
				) )
			),
			
			'assets' => array(
				'preview'   => array(
					//'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
					//'inline_js' => ';(function ($, upb) { $(".upb-accordion-toggle").upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
				),
				'shortcode' => array()
			)
		
		);
		
		$element->register( 'upb-accordion-item', $attributes, $contents, $_upb_options );
		
		
		// Accordion
		
		$attributes = array();
		
		array_push( $attributes, upb_title_input( esc_html__( 'Accordion Title', 'ultimate-page-builder' ), '', esc_html__( 'Accordion', 'ultimate-page-builder' ) ) );
		
		array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );
		
		array_push( $attributes, upb_responsive_hidden_input() );
		
		$attributes = array_merge( $attributes, upb_css_class_id_input_group() );
		
		$contents = array(
			upb_elements()->generate_element( 'upb-accordion-item', '<p>Authoritatively formulate one-to-one interfaces with sustainable information. Collaboratively impact value-added meta-services rather than superior growth.</p>', array( 'active' => TRUE, 'title' => esc_html__( 'Accordion Item 1', 'ultimate-page-builder' ) ) ),
			upb_elements()->generate_element( 'upb-accordion-item', '<p>Holisticly customize top-line leadership skills for wireless solutions. Appropriately actualize principle-centered products rather than sustainable.</p>', array( 'active' => FALSE, 'title' => esc_html__( 'Accordion Item 2', 'ultimate-page-builder' ) ) )
		);
		
		$_upb_options = array(
			
			'element' => array(
				'name' => esc_html__( 'UPB Accordion', 'ultimate-page-builder' ),
				'icon' => 'mdi mdi-view-day'
			),
			
			'tools' => array(
				'contents' => array(
					array(
						'id'     => 'add-new',
						'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
						'icon'   => 'mdi mdi-shape-plus',
						'action' => 'addNew',
						'data'   => apply_filters( 'upb_new_accordion_item', upb_elements()->generate_element( 'upb-accordion-item', '<p>Accordion Item</p>', array( 'title' => esc_html__( 'Accordion Item %s', 'ultimate-page-builder' ) ) ) )
					),
					array(
						'id'     => 'settings',
						'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
						'icon'   => 'mdi mdi-settings',
						'action' => 'showSettingsPanel'
					)
				),
			),
			
			'meta' => array(
				'contents' => apply_filters( 'upb_accordion_contents_panel_meta', array(
					'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
				) ),
				
				'settings' => apply_filters( 'upb_accordion_settings_panel_meta', array(
					'help' => '<h2>Text Settings?</h2><p>section settings</p>',
				) ),
				
				'messages' => array(
					'addElement' => esc_html__( 'Add Accordion Item', 'ultimate-page-builder' )
				)
			),
			
			'assets' => array(
				'preview'   => array(
					'css'       => upb_templates_uri( 'shortcode-css/upb-accordion.css' ),
					'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
					'inline_js' => ';(function ($, upb) {  $(document.body).triggerHandler("upb_accordion_preview_inline_js", [upb]);    }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
				),
				'shortcode' => array(
					'css'            => upb_templates_uri( 'shortcode-css/upb-accordion.css' ),
					'js'             => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
					'inline_js_once' => 'upb_accordion_inline_script' // callable function
				)
			)
		);
		
		$element->register( 'upb-accordion', $attributes, $contents, $_upb_options );
		
	} );
	
	// Tabs
	add_action( 'upb_register_element', function ( $element ) {
		
		// Tab Item
		
		$attributes = array();
		
		array_push( $attributes, upb_title_input( esc_html__( 'Tab Item Title', 'ultimate-page-builder' ), '', esc_html__( 'Tab Item 1', 'ultimate-page-builder' ) ) );
		
		array_push( $attributes, array( 'id' => 'active', 'title' => esc_html__( 'Default Active', 'ultimate-page-builder' ), 'type' => 'toggle', 'value' => FALSE ) );
		
		$contents = wp_kses_post( '<p>Tab Contents</p>' );
		
		$_upb_options = array(
			
			'element' => array(
				'name'  => esc_html__( 'Tab Item', 'ultimate-page-builder' ),
				'icon'  => 'mdi mdi-playlist-plus',
				'child' => TRUE
			),
			
			'meta' => array(
				'contents' => apply_filters( 'upb_tab-item_contents_panel_meta', array(
					'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
				) ),
				
				'settings' => apply_filters( 'upb_tab-item_settings_panel_meta', array(
					'help' => '<h2>Text Settings?</h2><p>section settings</p>',
				) )
			),
			
			'assets' => array(
				'preview'   => array(
					//'js'        => upb_templates_uri( 'shortcode-js/upb-accordion.js' ),
					//'inline_js' => ';(function ($, upb) { $(".upb-accordion-toggle").upbAccordion()  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
				),
				'shortcode' => array()
			)
		
		);
		
		$element->register( 'upb-tab-item', $attributes, $contents, $_upb_options );
		
		
		// Tabs
		
		$attributes = array();
		
		array_push( $attributes, upb_title_input( esc_html__( 'Tabs Title', 'ultimate-page-builder' ), '', esc_html__( 'Tab', 'ultimate-page-builder' ) ) );
		
		array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );
		
		array_push( $attributes, upb_responsive_hidden_input() );
		
		$attributes = array_merge( $attributes, upb_css_class_id_input_group() );
		
		$contents = array(
			upb_elements()->generate_element( 'upb-tab-item', '<p>Authoritatively formulate one-to-one interfaces with sustainable information. Collaboratively impact value-added meta-services rather than superior growth.</p>', array( 'active' => TRUE, 'title' => esc_html__( 'Tab 1', 'ultimate-page-builder' ) ) ),
			upb_elements()->generate_element( 'upb-tab-item', '<p>Holisticly customize top-line leadership skills for wireless solutions. Appropriately actualize principle-centered products rather than sustainable.</p>', array( 'active' => FALSE, 'title' => esc_html__( 'Tab 2', 'ultimate-page-builder' ) ) )
		);
		
		$_upb_options = array(
			
			'element' => array(
				'name' => esc_html__( 'UPB Tabs', 'ultimate-page-builder' ),
				'icon' => 'mdi mdi-tab'
			),
			
			'tools' => array(
				'contents' => array(
					array(
						'id'     => 'add-tab-item',
						'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
						'icon'   => 'mdi mdi-shape-plus',
						'action' => 'addNew',
						'data'   => apply_filters( 'upb_new_tab_item', upb_elements()->generate_element( 'upb-tab-item', '<p>Tab Contents</p>', array( 'title' => esc_html__( 'Tab Item %s', 'ultimate-page-builder' ) ) ) )
					),
					array(
						'id'     => 'tab-setting',
						'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
						'icon'   => 'mdi mdi-settings',
						'action' => 'showSettingsPanel'
					)
				),
			),
			
			'meta' => array(
				'contents' => apply_filters( 'upb_tab_contents_panel_meta', array(
					'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
				) ),
				
				'settings' => apply_filters( 'upb_tab_settings_panel_meta', array(
					'help' => '<h2>Text Settings?</h2><p>section settings</p>',
				) ),
				
				'messages' => array(
					'addElement' => esc_html__( 'Add Tab Item', 'ultimate-page-builder' )
				)
			),
			
			'assets' => array(
				'preview'   => array(
					'css'       => upb_templates_uri( 'shortcode-css/upb-tab.css' ),
					'js'        => upb_templates_uri( 'shortcode-js/upb-tab.js' ),
					'inline_js' => ';(function ($, upb) {  $(document.body).triggerHandler("upb_tab_preview_inline_js", [upb]);  }(jQuery, _UPB_PREVIEW_DATA[upbComponentId]));',
				),
				'shortcode' => array(
					'css'            => upb_templates_uri( 'shortcode-css/upb-tab.css' ),
					'js'             => upb_templates_uri( 'shortcode-js/upb-tab.js' ),
					'inline_js_once' => 'upb_tab_inline_script' // callable function
				)
			)
		);
		
		$element->register( 'upb-tab', $attributes, $contents, $_upb_options );
	} );
	
	// Headings
	add_action( 'upb_register_element', function ( $element ) {
		
		$attributes = array();
		
		array_push( $attributes, array(
			'id'       => 'type',
			'title'    => esc_html__( 'Heading type', 'ultimate-page-builder' ),
			'type'     => 'select2-icon',
			'value'    => 'h1',
			'options'  => array(
				'h1' => array(
					'title' => esc_html__( 'Heading 1', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-1',
				),
				'h2' => array(
					'title' => esc_html__( 'Heading 2', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-2',
				),
				'h3' => array(
					'title' => esc_html__( 'Heading 3', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-3',
				),
				'h4' => array(
					'title' => esc_html__( 'Heading 4', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-4',
				),
				'h5' => array(
					'title' => esc_html__( 'Heading 5', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-5',
				),
				'h6' => array(
					'title' => esc_html__( 'Heading 6', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-header-6',
				),
			),
			'settings' => array(
				'allowClear' => FALSE
			)
		) );
		
		array_push( $attributes, array(
			'id'      => 'align',
			'title'   => esc_html__( 'Heading align', 'ultimate-page-builder' ),
			'type'    => 'radio-icon',
			'value'   => 'left',
			'options' => array(
				'left'   => array(
					'title' => esc_html__( 'Left Align', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center Align', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right Align', 'ultimate-page-builder' ),
					'icon'  => 'mdi mdi-format-align-right',
				),
			),
		) );
		
		array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );
		
		array_push( $attributes, upb_responsive_hidden_input() );
		
		$attributes = array_merge( $attributes, upb_css_class_id_input_group() );
		
		$contents = 'Heading';
		
		$_upb_options = array(
			
			'element' => array(
				'name' => 'UPB Heading',
				'icon' => 'mdi mdi-format-header-pound'
			),
			
			'meta' => array(
				'settings' => apply_filters( 'upb_heading_settings_panel_meta', array(
					'help' => '<h2>Heading Settings?</h2><p>section settings</p>',
				) ),
			),
			
			'assets' => array(
				'preview'   => array(
					//'css' => upb_templates_uri( 'preview-css/sections.css' ),
					//'js'  => upb_templates_uri( 'preview-js/sections.js' ),
					//'inline_js' => 'console.log( upbComponentId );',
				),
				'shortcode' => array(
					//'css' => upb_templates_uri( 'preview-css/sections.css' ),
					'inline_css' => 'upb_heading_inline_style',
					//'js'  => upb_templates_uri( 'preview-js/sections.js' ),
				)
			)
		);
		
		$element->register( 'upb-heading', $attributes, $contents, $_upb_options );
		
	} );
	
	
	/*    add_action( 'upb_register_element', function ( $element ) {

			$attributes = array();

			array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Text Title', 'ultimate-page-builder' ) ) );

			array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

			array_push( $attributes,

						array(
							'id'    => 'image',
							'title' => esc_html__( 'Label', 'ultimate-page-builder' ),
							'desc'  => wp_kses_post( __( 'Description', 'ultimate-page-builder' ) ),
							'type'  => 'media-image',
							'value' => '',
							// 'attribute'=>'src' // id, src
							// 'size'=>'full' // large, medium, thumbnail etc...
						)

			);

			array_push( $attributes, upb_responsive_hidden_input() );

			$attributes = array_merge( $attributes, upb_css_class_id_input_group() );

			$contents = FALSE;

			$_upb_options = array(

				'element' => array(
					'name'  => 'UPB Child',
					'icon'  => 'mdi mdi-format-text',
					'child' => TRUE
				),

				'meta' => array(
					'contents' => array(
						'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
					),

					'settings' => array(
						'help' => '<h2>Text Settings?</h2><p>section settings</p>',
					),
				)
			);

			$element->register( 'upb-child', $attributes, $contents, $_upb_options );


			$attributes = array();

			array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Text Title', 'ultimate-page-builder' ) ) );

			array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

			array_push( $attributes, upb_responsive_hidden_input() );

			$attributes = array_merge( $attributes, upb_css_class_id_input_group() );

			$contents = array();

			$_upb_options = array(

				'preview' => array(
					'shortcode' => TRUE,
				),

				'element' => array(
					'name' => 'UPB Parent',
					'icon' => 'mdi mdi-format-text'
				),

				'meta' => array(
					'contents' => array(
						'help' => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
					),

					'settings' => array(
						'help' => '<h2>Text Settings?</h2><p>section settings</p>',
					),
				),

				'tools' => array(
					'contents' => array(
						array(
							'id'     => 'new',
							'title'  => esc_html__( 'Add New', 'ultimate-page-builder' ),
							'icon'   => 'mdi mdi-shape-plus',
							'action' => 'addNew',
							'data'   => upb_elements()->generate_element( 'upb-child', FALSE, array( 'title' => esc_html__( 'Item %s', 'ultimate-page-builder' ) ) )
						),
						array(
							'id'     => 'setting',
							'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
							'icon'   => 'mdi mdi-settings',
							'action' => 'showSettingsPanel'
						)
					),
				),
			);

			$element->register( 'upb-parent', $attributes, $contents, $_upb_options );

		} );*/

