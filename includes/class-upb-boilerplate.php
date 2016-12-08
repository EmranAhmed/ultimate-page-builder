<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Boilerplate' ) ):

		class UPB_Boilerplate {
			protected static $_instance = NULL;

			public static function init() {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self();
				}

				return self::$_instance;
			}

			public function __construct() {

				$this->includes();
				$this->hooks();

				do_action( 'upb_boilerplate_init', $this );
			}

			public function includes() {
				require_once UPB_PLUGIN_INCLUDE_PATH . "boilerplate/upb-boilerplate-functions.php";
				require_once UPB_PLUGIN_INCLUDE_PATH . "boilerplate/upb-boilerplate-hooks.php";
			}

			public function hooks() {
				add_filter( 'template_include', array( $this, 'boilerplate_template' ), 99 );
			}

			public function boilerplate_template( $_template ) {

				if ( upb_is_boilerplate() ) {
					return UPB_PLUGIN_INCLUDE_PATH . "boilerplate/upb-boilerplate-template.php";
				}

				return $_template;
			}
		}

		UPB_Boilerplate::init();
	endif;