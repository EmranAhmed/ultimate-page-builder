<?php
	/**
	 * Plugin Name: Ultimate Page Builder
	 * Plugin URI: http://wordpress.org/plugins/ultimate-page-builder/
	 * Description: Ultimate Page builder from Customizer
	 * Author: Emran Ahmed
	 * Version: 1.0.0
	 * Domain Path: /languages
	 * Text Domain: ultimate-page-builder
	 * Author URI: http://themehippo.com/
	 */

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'Ultimate_Page_Builder' ) ):
		class Ultimate_Page_Builder {

			protected static $_instance = NULL;

			public static function instance() {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self();
				}

				return self::$_instance;
			}


			public function __construct() {

				$this->define_constants();
				$this->includes();
				$this->hooks();

				do_action( 'ultimate_page_builder_loaded', $this );
			}

			public function define_constants() {
				define( 'UPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
				define( 'UPB_PLUGIN_ASSETS_URL', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
				define( 'UPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
				define( 'UPB_PLUGIN_INCLUDE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
				define( 'UPB_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
				define( 'UPB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
				define( 'UPB_PLUGIN_FILE', __FILE__ );
			}


			public function includes() {
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-elements.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-elements-props.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "upb-functions.php";
			}

			public function hooks() {
				add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
				add_action( 'customize_register', array( $this, 'customize_register' ) );
			}

			public function load_plugin_textdomain() {
				load_plugin_textdomain( 'ultimate-page-builder', FALSE, trailingslashit( UPB_PLUGIN_DIRNAME ) . 'languages' );
			}

			public function customize_register( $wp_customize ) {
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-customizer.php";
				$wp_customize->ultimate_page_builder = new UPB_Customizer( $wp_customize );
			}


		}


		Ultimate_Page_Builder::instance();
	endif;











