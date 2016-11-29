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

				do_action( 'ultimate_page_builder_loaded', $this );
			}

			public function constants() {
				define( 'UPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
				define( 'UPB_PLUGIN_ASSETS_URL', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
				define( 'UPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
				define( 'UPB_PLUGIN_INCLUDE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
				define( 'UPB_PLUGIN_TEMPLATES_DIR', trailingslashit( plugin_dir_path( __FILE__ ) . 'templates' ) );
				define( 'UPB_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
				define( 'UPB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
				define( 'UPB_PLUGIN_FILE', __FILE__ );
			}

			public function includes() {

				// Common
				require_once UPB_PLUGIN_INCLUDE_DIR . "upb-hooks.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "upb-functions.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "upb-elements.php";

				// Tabs
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-tabs.php";

				// PostType Settings
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-settings.php";

				// Elements
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-elements.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-elements-props.php";

				// Boilerplate
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-boilerplate.php";

				// Preview
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-preview.php";

			}

			public function hooks() {
				add_action( 'init', array( $this, 'language' ) );
			}

			public function language() {
				load_plugin_textdomain( 'ultimate-page-builder', FALSE, trailingslashit( UPB_PLUGIN_DIRNAME ) . 'languages' );
			}

		}

		Ultimate_Page_Builder::init();
	endif;
