<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	add_action( 'upb_preview_loaded', function () {
		add_filter( 'body_class', function ( $classes ) {
			array_push( $classes, 'ultimate-page-builder-preview', 'ultimate-page-builder' );
			
			return $classes;
		} );
	} );
	
	add_action( 'wp_footer', function () {
		if ( upb_is_preview() ) {
			do_action( 'upb_preview_wp_footer' );
		}
	} );
	
	add_action( 'wp_head', function () {
		if ( upb_is_preview() ) {
			do_action( 'upb_preview_wp_head' );
			echo '<base target="_blank">';
			echo '<script type="text/javascript">';
			echo "Object.defineProperty(window, '_UPB_PREVIEW_DATA', { value : {}, writable: false });";
			echo '</script>';
		}
	} );
	
	add_action( 'after_setup_theme', function () {
		if ( upb_is_preview() ) {
			do_action( 'upb_preview_after_setup_theme' );
		}
	} );
	
	add_action( 'wp_enqueue_scripts', function () {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		if ( ! current_theme_supports( 'upb-custom-grid-layout' ) ) {
			wp_register_style( 'upb-grid', UPB_PLUGIN_ASSETS_URI . "css/upb-grid$suffix.css" );
		}
		
		if ( upb_is_preview() ) {
			
			// For Preview Conflict
			wp_deregister_script( 'elementor-frontend' );
			
			wp_register_style( 'upb-shortcode-preview-core', UPB_PLUGIN_ASSETS_URI . "css/upb-preview$suffix.css" );
			wp_enqueue_style( 'upb-shortcode-preview-core' );
			
			wp_register_script( 'upb-preview-element-inline-scripts', UPB_PLUGIN_ASSETS_URI . "js/upb-preview-element-inline-scripts{$suffix}.js", array( 'jquery', 'wp-util' ), FALSE, TRUE );
			wp_enqueue_script( 'upb-preview-element-inline-scripts' );
			
			// You can change grid system as you need :)
			if ( ! current_theme_supports( 'upb-custom-grid-layout' ) ) {
				wp_enqueue_style( 'upb-grid' );
			}
			
			wp_register_style( 'upb-preview-elements', upb_get_theme_file_uri( 'preview-css/upb-preview-elements.css' ) );
			wp_enqueue_style( 'upb-preview-elements' );
			
			do_action( 'upb_preview_enqueue_scripts' );
		}
	} );
	
	add_filter( 'upb_before_preview_content', function () {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_PATH . 'upb_before_content_wrapper.php';
		
		return ob_get_clean();
	} );
	
	add_filter( 'upb_preview_content', function ( $content ) {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_PATH . 'upb_on_content_wrapper.php';
		
		return ob_get_clean();
	} );
	
	add_filter( 'upb_after_preview_content', function () {
		ob_start();
		include_once UPB_PLUGIN_TEMPLATES_PATH . 'upb_after_content_wrapper.php';
		
		return ob_get_clean();
	} );