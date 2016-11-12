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

			public function register( $tag, $attributes = array(), $contents = FALSE, $_upb_options = array() ) {


				if ( $this->has_element( $tag ) ) {
					throw new Exception( sprintf( 'Ultimate page builder element "%s" already registered.', $tag ) );
				}

				$_upb_options[ 'focus' ] = FALSE;

				// @TODO: Already registered alert
				$this->short_code_elements[ $tag ] = array(
					'tag'           => $tag,
					'contents'      => $contents,
					'attributes'    => ( empty( $attributes ) ? FALSE : $this->to_attributes( $attributes ) ),
					'_upb_settings' => ( empty( $attributes ) ? FALSE : $attributes ),
					'_upb_options'  => $_upb_options
				);
			}

			public function get_elements() {
				return $this->short_code_elements;
			}

			public function get_element( $tag, $key = FALSE ) {

				if ( ! $this->has_element( $tag ) ) {
					return FALSE;
				}

				if ( $key ) {
					return $this->short_code_elements[ $tag ][ $key ];
				} else {
					return $this->short_code_elements[ $tag ];
				}
			}

			public function has_element( $tag ) {
				return isset( $this->short_code_elements[ $tag ] );
			}

			public function to_attributes( $attributes ) {

				$new_attributes = array();
				foreach ( $attributes as $index => $attribute ) {
					$new_attributes[ $index ] = isset( $attribute[ 'value' ] ) ? $attribute[ 'value' ] : '';
				}

				return $new_attributes;
			}

			public function to_settings( $tag, $attributes ) {

				$settings = $this->get_element( $tag, '_upb_settings' );

				// Keeps Old Attribute
				/*foreach ( $attributes as $key => $value ) {
					$settings[ $key ][ 'value' ] = $value;
				}*/

				// Always new attribute
				foreach ( $settings as $key => $value ) {
					if ( isset( $attributes[ $key ] ) ) {
						$settings[ $key ][ 'value' ] = $attributes[ $key ];
					}
				}

				return $settings;
			}

			public function set_upb_options( $contents ) {

				foreach ( $contents as $index => $content ) {

					if ( isset( $contents[ $index ][ '_upb_settings' ] ) or isset( $contents[ $index ][ '_upb_options' ] ) ) {
						continue;
					}

					$contents[ $index ][ '_upb_settings' ] = $this->to_settings( $content[ 'tag' ], $content[ 'attributes' ] );
					$contents[ $index ][ '_upb_options' ]  = $this->get_element( $content[ 'tag' ], '_upb_options' );
				}

				return $contents;
			}
		}

	endif;
