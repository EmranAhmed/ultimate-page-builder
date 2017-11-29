<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	function upb_elements_register_action() {
		do_action( 'upb_register_element', upb_elements() );
	}
	
	add_action( 'wp_loaded', 'upb_elements_register_action' );
	
	/**
	 * Remove Element Example
	 */
	
	/*add_action( 'upb_remove_elements', function () {
		upb_elements()->remove( 'upb-tab' );
	} );*/
	
	function upb_remove_elements_action() {
		do_action( 'upb_remove_elements' );
	}
	
	add_action( 'wp_loaded', 'upb_remove_elements_action', 20 );
	
	function upb_tabs_register_action() {
		do_action( 'upb_register_tab', upb_tabs() );
	}
	
	add_action( 'wp_loaded', 'upb_tabs_register_action' );
	
	function upb_settings_register_action() {
		do_action( 'upb_register_setting', upb_settings() );
	}
	
	add_action( 'wp_loaded', 'upb_settings_register_action' );
	
	function upb_layouts_register_action() {
		do_action( 'upb_register_layout', upb_layouts() );
	}
	
	add_action( 'wp_loaded', 'upb_layouts_register_action' );
	
	// Icons Name
	add_filter( 'upb_icon_popup_icons', function ( $icons, $provider ) {
		
		switch ( $provider ) {
			case 'materialdesign':
				$icons = upb_material_design_icons();
				break;
			
			case 'fontawesome':
				$icons = upb_font_awesome_icons();
				break;
			
			case 'dashicons':
				$icons = upb_dash_icon_icons();
				break;
		}
		
		return $icons;
		
	}, 10, 2 );
	
	// Content Load
	
	add_filter( 'upb-before-contents', function ( $contents, $shortcodes ) {
		ob_start();
		
		upb_get_template( 'wrapper/before.php', compact( 'contents', 'shortcodes' ) );
		
		return ob_get_clean();
	}, 10, 2 );
	
	add_filter( 'upb-on-contents', function ( $contents, $shortcodes ) {
		ob_start();
		upb_get_template( 'wrapper/contents.php', compact( 'contents', 'shortcodes' ) );
		
		return ob_get_clean();
	}, 10, 2 );
	
	add_filter( 'upb-after-contents', function ( $contents, $shortcodes ) {
		ob_start();
		
		upb_get_template( 'wrapper/after.php', compact( 'contents', 'shortcodes' ) );
		
		return ob_get_clean();
	}, 10, 2 );
	
	add_filter( 'the_content', function ( $contents ) {
		
		if ( upb_is_enabled() ):
			$position   = get_post_meta( get_the_ID(), '_upb_settings_page_position', TRUE );
			$shortcodes = get_post_meta( get_the_ID(), '_upb_shortcodes', TRUE );
			
			return apply_filters( $position, $contents, $shortcodes );
		endif;
		
		return $contents;
		
	}, 20 ); // Priority 20 for Restrict Content Pro plugin support
	
	// Body Class
	add_filter( 'body_class', function ( $classes ) {
		if ( upb_is_enabled() ):
			array_push( $classes, 'ultimate-page-builder' );
		endif;
		
		return $classes;
	} );
	
	// Scripts
	add_action( 'wp_enqueue_scripts', function () {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		if ( upb_is_enabled() ):
			
			if ( ! current_theme_supports( 'upb-custom-grid-layout' ) ) {
				wp_enqueue_style( 'upb-grid' );
			}
			
			// Load Element Assets
			upb_enqueue_element_scripts();
		
		endif;
	}, 20 ); // 20 Priority. 1st Load themes scripts then plugins scripts.
	
	add_action( 'wp_head', function () {
		if ( upb_is_enabled() ):
			// Load Element Inline CSS
			upb_enqueue_element_inline_style();
			upb_print_element_inline_style();
		endif;
	}, 20 );
	
	add_action( 'wp_footer', function () {
		if ( upb_is_enabled() ):
			// Load Element Inline Script
			upb_enqueue_element_inline_script();
			upb_print_element_inline_script();
		endif;
	}, 20 );
	
	// Add Toolbar Menus
	add_action( 'wp_before_admin_bar_render', function () {
		global $wp_admin_bar;
		
		$enabled = array(
			'id'    => 'edit-with-upb',
			'title' => esc_html__( 'Edit with Ultimate Page Builder', 'ultimate-page-builder' ),
			'href'  => esc_url( upb_get_edit_link() ),
			'meta'  => array( 'class' => 'edit-with-upb' ),
		);
		
		$use = array(
			'id'    => 'use-upb',
			'title' => esc_html__( 'Use Ultimate Page Builder', 'ultimate-page-builder' ),
			'href'  => esc_url( upb_get_edit_link() ),
			'meta'  => array( 'class' => 'use-upb' ),
		);
		
		if ( is_singular() && upb_is_buildable() && upb_is_enabled() ):
			$wp_admin_bar->add_menu( $enabled );
		endif;
		
		if ( is_singular() && upb_is_buildable() && ! upb_is_enabled() ):
			$wp_admin_bar->add_menu( $use );
		endif;
		
	} );
	
	// Add Resource Hints
	add_filter( 'wp_resource_hints', function ( $urls, $relation_type ) {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		/*if ( wp_script_is( 'upb-scoped-css-polyfill', 'queue' ) && 'prefetch' === $relation_type ) {
			$urls[] = array(
				'href' => esc_url( UPB_PLUGIN_ASSETS_URI . "js/upb-scoped-polyfill{$suffix}.js" ),
			);
		}*/
		
		return $urls;
	}, 11, 2 );