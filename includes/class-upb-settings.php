<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Settings' ) ):

		class UPB_Settings {

			private static $instance = NULL;

			private $settings = array();

			private $prefix = '_upb_settings_page_';

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
				return $this->settings;
			}

			public function getID() {
				return get_the_ID();
			}

			public function getJSON() {
				return wp_json_encode( $this->settings );
			}


			public function register( $id, $options ) {


				// _upb_settings_page_ enabled
				// _upb_settings_page_ position

				// type: text | textarea | toggle | radio | select, desc


				$_id = $this->prefix . $id;

				$options[ 'id' ]          = $_id;
				$options[ '_id' ]         = $id;
				$options[ 'desc' ]        = isset( $options[ 'desc' ] ) ? $options[ 'desc' ] : FALSE;
				$options[ 'default' ]     = isset( $options[ 'default' ] ) ? $options[ 'default' ] : '';
				$options[ 'value' ]       = $this->get_setting( $id );
				$options[ 'placeholder' ] = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : $options[ 'title' ];


				$setting[ '_upb_field_type' ]  = 'upb-input-' . $options[ 'type' ];
				$setting[ '_upb_field_attrs' ] = $options;
				$setting[ $id ]                = $options[ 'value' ];

				$this->settings[] = $setting;

			}

			public function get_setting( $id ) {
				$_id = $this->prefix . $id;

				return get_post_meta( get_the_ID(), $_id, TRUE );
			}

			public function set_setting( $id, $value ) {
				$_id = $this->prefix . $id;

				return update_post_meta( get_the_ID(), $_id, $value );
			}
		}


	endif;