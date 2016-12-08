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

				$options[ 'id' ]      = $id;
				$options[ '_id' ]     = $_id;
				$options[ 'desc' ]    = isset( $options[ 'desc' ] ) ? $options[ 'desc' ] : FALSE;
				$options[ 'default' ] = isset( $options[ 'default' ] ) ? $options[ 'default' ] : '';

				// if no option saved show default else show saved one
				$options = $this->setAttrBasedOnType( $id, $options );

				$options[ 'placeholder' ]      = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : $options[ 'value' ];
				$setting[ '_upb_field_type' ]  = 'upb-input-' . $options[ 'type' ];
				$setting[ '_upb_field_attrs' ] = $options;

				// Saved as

				$setting[ 'metaId' ]    = $id;
				$setting[ 'metaKey' ]   = $_id;
				$setting[ 'metaValue' ] = $options[ 'value' ];
				$this->settings[]       = $setting;
			}

			private function setAttrBasedOnType( $id, $options ) {

				$value = $this->get_setting( $id );

				switch ( $options[ 'type' ] ):

					case 'color':
						$options[ 'alpha' ] = isset( $options[ 'alpha' ] ) ? $options[ 'alpha' ] : FALSE;
						$options[ 'value' ] = ( $value === FALSE ) ? $options[ 'default' ] : $value;
						break;

					case 'toggle':
						$options[ 'value' ] = ( $value === FALSE ) ? $options[ 'default' ] : $value;
						break;

					default:

						$options[ 'value' ] = ( $value === FALSE ) ? $options[ 'default' ] : $value;
						break;
				endswitch;

				return $options;

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