<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Tabs' ) ):

		class UPB_Tabs {

			private static $instance = NULL;
			private        $tabs     = array();

			private function __construct() {
				//$this->props = new UPB_Elements_Props();
			}

			public static function getInstance() {

				if ( is_null( self::$instance ) ) {
					self::$instance = new self();
				}

				return self::$instance;
			}

			public function register( $id, $tab, $active = FALSE ) {

				// id, active, settings, contents, title, icon, class, callback

				if ( ! isset( $tab[ 'action' ] ) ) {
					$tab[ 'action' ] = 'upb_tab_' . $id . '_action';
				}

				if ( $active ) {
					$tab[ 'active' ] = $active;
				}

				$this->tabs[ $id ] = $tab;

			}

			public function getAll() {
				return $this->tabs;
			}
		}


	endif;