<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Elements' ) ):

		class UPB_Elements {

			private static $instance            = NULL;
			private        $short_code_elements = array();

			private function __construct() {
				$this->props = new UPB_Elements_Props();
			}

			public static function getInstance() {

				if ( is_null( self::$instance ) ) {
					self::$instance = new self();
				}

				return self::$instance;
			}


			public function register( $short_code ) {

				if ( ! isset( $short_code[ 'icon' ] ) ) {
					$short_code[ 'icon' ] = 'fa fa-globe';
				}
				if ( ! isset( $short_code[ 'description' ] ) ) {
					$short_code[ 'description' ] = '';
				}
				if ( ! isset( $short_code[ 'type' ] ) ) {
					$short_code[ 'type' ] = 'single'; // single, closed
				}
				if ( isset( $short_code[ 'default' ] ) && ! empty( $short_code[ 'default' ] ) ) {
					$short_code[ 'type' ] = 'single'; // single, closed
				}

				$this->short_code_elements[ $short_code[ 'id' ] ] = $short_code;

			}

			public function get_elements() {
				return $this->short_code_elements;
			}
		}

	endif;


