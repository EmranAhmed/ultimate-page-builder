<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Settings' ) ):

		class UPB_Settings {

			private static $instance = NULL;

			private function __construct() {
				//$this->props = new UPB_Elements_Props();
			}

			public static function getInstance() {

				if ( is_null( self::$instance ) ) {
					self::$instance = new self();
				}

				return self::$instance;
			}

			public function getAll() {

				echo get_the_ID();
			}

			public function getID() {
				return get_the_ID();
			}

			public function getJSON() {

				$enabled          = (bool) get_post_meta( get_the_ID(), '_upb_enabled', TRUE );
				$display_position = (bool) get_post_meta( get_the_ID(), '_upb_position', TRUE );
				
				return wp_json_encode( array( 'enabled' => $enabled, 'position' => $display_position ) );
			}
		}


	endif;