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

				if ( isset( $this->tabs[ $id ] ) && is_array( $this->tabs[ $id ] ) ) {
					throw new Exception( sprintf( __('Ultimate Page builder tab "%s" already registered.', 'ultimate-page-builder'), $tab[ 'title' ] ) );
				} else {

					if ( ! isset( $tab[ 'action' ] ) ) {
						$tab[ 'action' ] = 'upb_tab_' . $id;
					}

					if ( $active ) {
						$tab[ 'active' ] = TRUE;
					} else {
						$tab[ 'active' ] = FALSE;
					}

					$tab[ 'id' ] = $id;

					$this->tabs[] = $tab;
				}

			}

			public function getAll() {
				return $this->tabs;
			}

			public function getJSON() {
				return wp_json_encode( $this->tabs );
			}
		}
	endif;