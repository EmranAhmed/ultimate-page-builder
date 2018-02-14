<?php
	/**
	 * Plugin Name: Ultimate Page Builder
	 * Plugin URI: https://wordpress.org/plugins/ultimate-page-builder/
	 * Description: An Incredibly easiest and highly customizable drag and drop page builder helps create professional websites without writing a line of code.
	 * Author: Emran Ahmed
	 * Version: 1.0.11
	 * Domain Path: /languages
	 * Text Domain: ultimate-page-builder
	 * Author URI: https://themehippo.com/
	 */
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	if ( ! class_exists( 'Ultimate_Page_Builder' ) ):
		
		final class Ultimate_Page_Builder {
			
			public $version = '1.0.11';
			
			protected static $_instance = NULL;
			
			private $_enabled = FALSE;
			
			private $_inline_styles       = array();
			private $_inline_scripts      = array();
			private $_inline_scripts_once = array();
			
			public static function init() {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self();
				}
				
				return self::$_instance;
			}
			
			public function __construct() {
				$this->constants();
				$this->includes();
				$this->hooks();
			}
			
			public function add_inline_style_data( $handler, $output ) {
				$this->_inline_styles[ $handler ] = isset( $this->_inline_styles[ $handler ] ) ? $this->_inline_styles[ $handler ] : array();
				array_push( $this->_inline_styles[ $handler ], $output );
			}
			
			public function get_inline_style_data() {
				return $this->_inline_styles;
			}
			
			public function add_inline_script_data( $handler, $output ) {
				$this->_inline_scripts[ $handler ] = isset( $this->_inline_scripts[ $handler ] ) ? $this->_inline_scripts[ $handler ] : array();
				array_push( $this->_inline_scripts[ $handler ], $output );
			}
			
			public function get_inline_script_data() {
				return $this->_inline_scripts;
			}
			
			public function add_inline_script_once_data( $handler, $output ) {
				$this->_inline_scripts_once[ $handler ] = isset( $this->_inline_scripts_once[ $handler ] ) ? $this->_inline_scripts_once[ $handler ] : '';
				$this->_inline_scripts_once[ $handler ] = $output; // inline_js_once
			}
			
			public function get_inline_script_once_data() {
				return $this->_inline_scripts_once;
			}
			
			public function constants() {
				
				define( 'UPB_VERSION', esc_attr( $this->version ) );
				define( 'UPB_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
				define( 'UPB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
				
				define( 'UPB_PLUGIN_ASSETS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
				define( 'UPB_PLUGIN_IMAGES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'images' ) );
				define( 'UPB_PLUGIN_FONTS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'fonts' ) );
				
				define( 'UPB_PLUGIN_ELEMENTS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'elements' ) );
				define( 'UPB_PLUGIN_ELEMENTS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'elements' ) );
				
				define( 'UPB_PLUGIN_INCLUDE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
				define( 'UPB_PLUGIN_TEMPLATES_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'templates' ) );
				define( 'UPB_PLUGIN_TEMPLATES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'templates' ) );
				
				define( 'UPB_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
				define( 'UPB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
				define( 'UPB_PLUGIN_FILE', __FILE__ );
			}
			
			public function includes() {
				
				if ( $this->has_required_php_version() ) {
					// Common
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-functions.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-icon-functions.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-template-functions.php";
					
					// Defines
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-elements.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-settings.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-layouts.php";
					
					// List Utility
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-list-util.php";
					
					// TABS
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-tabs.php";
					
					// Settings
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-settings.php";
					
					// Elements
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-elements.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-elements-props.php";
					
					// Layouts
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-layouts.php";
					
					// Boilerplate
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-boilerplate.php";
					
					// Preview
					require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-preview.php";
					
					// Load
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-element-inline-scripts.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-hooks.php";
					require_once UPB_PLUGIN_INCLUDE_PATH . "upb-ajax-functions.php";
				}
			}
			
			public function hooks() {
				add_action( 'admin_notices', array( $this, 'php_requirement_notice' ) );
				add_action( 'init', array( $this, 'language' ) );
				
				if ( $this->has_required_php_version() ) {
					add_action( 'wp', array( $this, 'upb_enabled' ) );
					add_action( 'wp', array( $this, 'ui_functions' ), 11 );
					add_action( 'send_headers', array( $this, 'no_cache_headers' ) );
					add_filter( 'page_row_actions', array( $this, 'add_row_actions' ), 10, 2 );
					add_filter( 'post_row_actions', array( $this, 'add_row_actions' ), 10, 2 );
					
					// Show UPB Button
					add_action( 'media_buttons', array( $this, 'action_media_buttons' ) );
					add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
				}
				
				add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
				add_filter( 'plugin_action_links_' . UPB_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
				
				add_action( 'wp_head', array( $this, 'add_meta_generator' ), 9 );
				add_action( 'after_setup_theme', array( $this, 'plugin_loaded' ) );
			}
			
			public function plugin_loaded() {
				do_action( 'ultimate_page_builder_loaded', $this );
			}
			
			public function add_meta_generator() {
				
				// Use "ultimate_page_builder_loaded" hook to remove generator.
				// Example:
				// add_action('ultimate_page_builder_loaded', function($upb){
				//    remove_action('wp_head', array( $upb, 'add_meta_generator' ), 9 );
				//});
				echo '<meta name="generator" content="Ultimate Page Builder - ' . esc_attr( UPB_VERSION ) . '"/>' . "\n";
			}
			
			public function after_setup_theme() {
				if ( upb_is_preview_request() || upb_is_boilerplate_request() ) {
					show_admin_bar( FALSE );
				}
				
				if ( upb_is_preview_request() ) {
					do_action( 'after_setup_theme_preview' );
				}
				
				if ( upb_is_boilerplate_request() ) {
					do_action( 'after_setup_theme_boilerplate' );
				}
			}
			
			public function action_media_buttons() {
				
				global $post_type, $post;
				
				if ( $this->is_page_allowed( $post ) && in_array( $post_type, $this->get_allowed_post_types() ) ) {
					printf( '<a href="%s" class="button load-ultimate-page-builder ultimate-page-builder-button">' . '<span class="wp-media-buttons-icon dashicons dashicons-art"></span> %s' . '</a>', upb_get_edit_link(), __( 'Edit with <strong>Ultimate Page Builder</strong>', 'ultimate-page-builder' ) );
				}
			}
			
			public function has_required_php_version() {
				return version_compare( PHP_VERSION, '5.4' ) >= 0;
			}
			
			public function php_requirement_notice() {
				if ( ! $this->has_required_php_version() ) {
					$class   = 'notice notice-error';
					$text    = esc_html__( 'Please check PHP version requirement.', 'ultimate-page-builder' );
					$link    = esc_url( 'https://wordpress.org/about/requirements/' );
					$message = wp_kses( __( "<strong>Ultimate Page Builder</strong> require PHP 5.4 or above.", 'ultimate-page-builder' ), array( 'strong' => array() ) );
					
					printf( '<div class="%1$s"><p>%2$s <a target="_blank" href="%3$s">%4$s</a></p></div>', $class, $message, $link, $text );
				}
			}
			
			public function is_page_allowed( $post ) {
				
				if ( is_object( $post ) ) {
					
					$non_allowed_posts = array_unique( array(
						                                   get_option( 'page_for_posts' ),
						                                   get_option( 'woocommerce_shop_page_id' ),
						                                   get_option( 'woocommerce_cart_page_id' ),
						                                   get_option( 'woocommerce_checkout_page_id' ),
						                                   get_option( 'woocommerce_pay_page_id' ),
						                                   get_option( 'woocommerce_thanks_page_id' ),
						                                   get_option( 'woocommerce_myaccount_page_id' ),
						                                   get_option( 'woocommerce_edit_address_page_id' ),
						                                   get_option( 'woocommerce_view_order_page_id' ),
						                                   get_option( 'woocommerce_terms_page_id' ),
					                                   ) );
					
					$non_allowed_posts_id = apply_filters( 'upb_non_allowed_posts_id', $non_allowed_posts );
					$post_id              = absint( $post->ID );
					
					if ( in_array( $post_id, $non_allowed_posts_id ) ) {
						return FALSE;
					}
				}
				
				return TRUE;
			}
			
			public function add_row_actions( $actions, $post ) {
				
				if ( upb_is_buildable( $post ) ) {
					$actions[ 'edit_with_upb' ] = sprintf( '<a href="%s">%s</a>', upb_get_edit_link( $post ), esc_html__( 'Edit with Ultimate Page Builder', 'ultimate-page-builder' ) );
				}
				
				return $actions;
			}
			
			public function get_post( $post_id = '' ) {
				
				// Allow pass through of full post objects
				if ( isset( $post_id->ID ) ) {
					return $post_id;
				}
				
				// Get post by ID
				if ( is_int( $post_id ) ) {
					return get_post( $post_id );
				}
				
				// Or, in the dashboard use a query string
				if ( is_admin() && isset( $_GET[ 'post' ] ) ) {
					return get_post( $_GET[ 'post' ] );
				}
				
				// Or, use the queried object
				if ( '' == $post_id ) {
					$post = get_queried_object();
					if ( is_a( $post, 'WP_POST' ) ) {
						return $post;
					}
				}
				
				// Otherwise there's just no way...
				
				return FALSE;
				
			}
			
			public function get_allowed_post_types() {
				return apply_filters( 'upb_allowed_post_types', array( 'page' ) );
			}
			
			public function is_post_type_allowed( $post_id = '' ) {
				$post = $this->get_post( $post_id );
				
				return ( $this->is_page_allowed( $post ) && $post && in_array( $post->post_type, $this->get_allowed_post_types() ) );
			}
			
			public function ui_functions() {
				if ( upb_is_preview() or upb_is_boilerplate() ):
					// Tell W3TC not to minify while the builder is active.
					if ( ! defined( 'DONOTMINIFY' ) ) {
						define( 'DONOTMINIFY', TRUE );
					}
					
					if ( ! defined( 'DONOTCACHEPAGE' ) ) {
						define( 'DONOTCACHEPAGE', TRUE );
					}
					
					if ( ! defined( 'DONOTCACHEDB' ) ) {
						define( 'DONOTCACHEDB', TRUE );
					}
					
					if ( ! defined( 'DONOTCDN' ) ) {
						define( 'DONOTCDN', TRUE );
					}
					
					if ( ! defined( 'DONOTCACHCEOBJECT' ) ) {
						define( 'DONOTCACHCEOBJECT', TRUE );
					}
					
					// Tell Autoptimize not to minify while the builder is active.
					add_filter( 'autoptimize_filter_noptimize', '__return_true' );
					
					// Disable JETPack Image Issue
					add_filter( 'jetpack_photon_skip_image', '__return_true' );
					
					if ( class_exists( 'WPSEO_Frontend' ) ) {
						$seo = WPSEO_Frontend::get_instance();
						remove_action( 'wp_head', array( $seo, 'head' ), 1 );
						remove_action( 'template_redirect', array( $seo, 'clean_permalink' ), 1 );
					}
				endif;
			}
			
			public function no_cache_headers() {
				if ( upb_is_preview() or upb_is_boilerplate() ):
					
					nocache_headers();
					
					// header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
					// header( 'Cache-Control: no-store, no-cache, must-revalidate' );
					// header( 'Cache-Control: post-check=0, pre-check=0', FALSE );
					// header( 'Pragma: no-cache' );
					// header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
				endif;
			}
			
			public function upb_enabled() {
				
				$enable = upb_return_boolean( get_post_meta( get_the_ID(), '_upb_settings_page_enable', TRUE ) );
				
				if ( ! upb_is_preview() && $enable && $this->is_post_type_allowed() ) {
					$this->_enabled = TRUE;
				}
			}
			
			public function is_enabled() {
				return $this->_enabled;
			}
			
			public function language() {
				load_plugin_textdomain( 'ultimate-page-builder', FALSE, trailingslashit( UPB_PLUGIN_DIRNAME ) . 'languages' );
			}
			
			public function template_path() {
				return apply_filters( 'upb_template_path', untrailingslashit( $this->plugin_path() ) . '/templates' );
			}
			
			public function template_uri() {
				return apply_filters( 'upb_template_uri', untrailingslashit( $this->plugin_uri() ) . '/templates' );
			}
			
			public function plugin_path() {
				return untrailingslashit( plugin_dir_path( __FILE__ ) );
			}
			
			public function plugin_basename() {
				return plugin_basename( __FILE__ );
			}
			
			public function template_override_dir() {
				return apply_filters( 'upb_template_override_dir', 'ultimate-page-builder' );
			}
			
			public function plugin_uri() {
				return untrailingslashit( plugins_url( '/', __FILE__ ) );
			}
			
			public function plugin_row_meta( $links, $file ) {
				if ( $file == UPB_PLUGIN_BASENAME ) {
					$row_meta = array(
						'documentation' => '<a href="' . esc_url( apply_filters( 'upb_documentation_url', 'https://upb-guide.themehippo.com/' ) ) . '" title="' . esc_attr( esc_html__( 'View Documentation', 'ultimate-page-builder' ) ) . '">' . esc_html__( 'Documentation', 'ultimate-page-builder' ) . '</a>',
						'support'       => '<a href="' . esc_url( apply_filters( 'upb_support_url', 'https://wordpress.org/support/plugin/ultimate-page-builder/' ) ) . '" title="' . esc_attr( esc_html__( 'Support', 'ultimate-page-builder' ) ) . '">' . esc_html__( 'Support', 'ultimate-page-builder' ) . '</a>',
					);
					
					return array_merge( $links, $row_meta );
				}
				
				return (array) $links;
			}
			
			public function plugin_action_links( $links ) {
				$action_links = array(//    'settings' => '<a href="' . admin_url( 'admin.php?page=upb-settings' ) . '" title="' . esc_attr__( 'View Settings', 'ultimate-page-builder' ) . '">' . esc_html__( 'Settings', 'ultimate-page-builder' ) . '</a>',
				);
				
				return array_merge( $action_links, $links );
			}
		}
		
		function UPB() {
			return Ultimate_Page_Builder::init();
		}
		
		// Global for backwards compatibility.
		$GLOBALS[ 'ultimate_page_builder' ] = UPB();
	
	endif;