<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! class_exists( 'UPB_Elements' ) ):

		class UPB_Elements {

			private static $instance            = NULL;
			private        $short_code_elements = array();

			private $core_elements = array( 'section', 'row', 'column' );

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


				if ( in_array( $tag, $this->core_elements ) ) {
					$_upb_options[ 'core' ] = TRUE;
				}


				if ( ! isset( $_upb_options[ 'preview' ] ) ) {
					$_upb_options[ 'preview' ] = array(
						//	'component' => 'upb-' . $tag,
						'template' => $tag,
						'mixins'   => '{}' // javascript object, like: { methods:{ abcd(){} } } or window.abcdMixins = {}

					);
				}

				//if ( ! isset( $_upb_options[ 'preview' ][ 'component' ] ) ) {
				$_upb_options[ 'preview' ][ 'component' ] = 'upb-' . $tag;
				//}

				if ( ! isset( $_upb_options[ 'preview' ][ 'mixins' ] ) ) {
					$_upb_options[ 'preview' ][ 'mixins' ] = '{}';
				}

				if ( ! isset( $_upb_options[ 'preview' ][ 'template' ] ) ) {
					$_upb_options[ 'preview' ][ 'template' ] = $tag;
				}


				$attributes   = apply_filters( "upb_element_{$tag}_attributes", $attributes );
				$_upb_options = apply_filters( "upb_element_{$tag}_options", $_upb_options );


				if ( is_string( $contents ) ) {
					$attributes[] = array( 'id' => '_contents', 'title' => 'Contents', 'type' => 'contents', 'value' => $contents );
				}

				foreach ( $attributes as $index => $attribute ) {
					//$attributes[ $index ][ 'metaKey' ]   = $attribute[ 'id' ];
					$attributes[ $index ][ '_id' ] = $attribute[ 'id' ];
					//$attributes[ $index ][ 'metaValue' ] = $attribute[ 'value' ];
					$attributes[ $index ][ '_upb_field_type' ] = sprintf( 'upb-input-%s', $attribute[ 'type' ] );
				}


				$this->short_code_elements[ $tag ] = array(
					'tag'           => $tag,
					'contents'      => $contents,
					'attributes'    => ( empty( $attributes ) ? FALSE : $this->to_attributes( $attributes ) ),
					'_upb_settings' => ( empty( $attributes ) ? FALSE : $attributes ),
					'_upb_options'  => $_upb_options
				);


				$shortcode_fn    = sprintf( 'upb_register_shortcode_%s', $tag );
				$vue_template_fn = sprintf( 'upb_shortcode_preview_%s', $tag );

				if ( ! is_callable( $shortcode_fn ) ) {
					trigger_error( sprintf( 'Ultimate page builder shortcode "%s" template function "%s" not found.', $tag, $shortcode_fn ), E_USER_WARNING );
				} else {
					add_shortcode( $tag, $shortcode_fn );
				}

				if ( ! is_callable( $vue_template_fn ) ) {
					trigger_error( sprintf( 'Ultimate page builder shortcode preview "%s" template function "%s" not found.', $tag, $vue_template_fn ), E_USER_WARNING );
				} else {
					add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', $tag ), $vue_template_fn );
				}

			}


			public function get_elements() {
				return $this->short_code_elements;
			}

			public function getAll() {
				return array_values( $this->short_code_elements );
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

			public function generate_element( $tag, $contents = array(), $attributes = array() ) {

				if ( ! $this->has_element( $tag ) ) {
					throw new Exception( sprintf( 'Ultimate page builder element "%s" is not registered.', $tag ) );
				}

				$el = $this->get_element( $tag );

				if ( ! empty( $contents ) ) {

					if ( isset( $contents[ 0 ] ) ) {
						foreach ( $contents as $content ) {
							array_push( $el[ 'contents' ], $content );
						}
					} else {
						array_push( $el[ 'contents' ], $contents );
					}
				}

				if ( ! empty( $attributes ) ) {
					$el[ 'attributes' ]    = array_merge( $el[ 'attributes' ], $this->to_attributes( $attributes ) );
					$el[ '_upb_settings' ] = array_merge( $el[ '_upb_settings' ], $el[ 'attributes' ] );
				}

				return $el;
			}

			public function demo_data( $tag, $contents = array(), $attributes = array() ) {

				if ( ! $this->has_element( $tag ) ) {
					throw new Exception( sprintf( 'Ultimate page builder element "%s" is not registered.', $tag ) );
				}

				$el = $this->get_element( $tag );

				if ( ! empty( $contents ) ) {

					if ( isset( $contents[ 0 ] ) ) {
						foreach ( $contents as $content ) {
							array_push( $el[ 'contents' ], $content );
						}
					} else {
						array_push( $el[ 'contents' ], $contents );
					}
				}

				if ( ! empty( $attributes ) ) {
					$el[ 'attributes' ] = array_merge( $el[ 'attributes' ], $this->to_attributes( $attributes ) );
				}

				return $el;
			}

			public function has_element( $tag ) {
				return isset( $this->short_code_elements[ $tag ] );
			}

			public function to_attributes( $attributes ) {

				$new_attributes = array();
				foreach ( $attributes as $index => $attribute ) {

					if ( isset( $attribute[ 'id' ] ) ) {
						$new_attributes[ $attribute[ 'id' ] ] = isset( $attribute[ 'value' ] ) ? $attribute[ 'value' ] : '';
					} else {
						$new_attributes[ $index ] = isset( $attribute[ 'value' ] ) ? $attribute[ 'value' ] : '';
					}
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

					// For normal element attr
					$settings[ $key ][ 'value' ] = $attributes[ $value[ 'id' ] ];
					//$settings[ $key ][ '_upb_field_type' ] = sprintf( 'upb-input-%s', $attributes[ $value[ 'type' ] ] );


					//$settings[ $key ][ 'metaKey' ]   = $value[ 'id' ];
					//$settings[ $key ][ 'metaValue' ] = $attributes[ $value[ 'id' ] ];


					if ( isset( $attributes[ $key ] ) ) {
						// For Keywise element attr
						//$settings[ $key ][ 'value' ] = $attributes[ $key ];
					}
				}


				return $settings;
			}

			public function set_upb_options( $contents ) {

				foreach ( $contents as $index => $content ) {

					if ( ! isset( $content[ 'contents' ] ) and is_array( $this->get_element( $content[ 'tag' ], 'contents' ) ) ) {
						$contents[ $index ][ 'contents' ] = $this->get_element( $content[ 'tag' ], 'contents' );
					}

					//if ( ! isset( $contents[ $index ][ '_upb_settings' ] ) ) {
					$contents[ $index ][ '_upb_settings' ] = $this->to_settings( $content[ 'tag' ], $content[ 'attributes' ] );
					//}

					//if ( ! isset( $contents[ $index ][ '_upb_options' ] ) ) {
					$contents[ $index ][ '_upb_options' ] = $this->get_element( $content[ 'tag' ], '_upb_options' );
					//}
				}

				return $contents;
			}

			public function set_upb_options_recursive( $contents ) {


				foreach ( $contents as $index => $content ) {


					if ( ! isset( $content[ 'contents' ] ) and is_array( $this->get_element( $content[ 'tag' ], 'contents' ) ) ) {
						$contents[ $index ][ 'contents' ] = $this->get_element( $content[ 'tag' ], 'contents' );
					}

					//if ( ! isset( $contents[ $index ][ '_upb_settings' ] ) ) {
					$contents[ $index ][ '_upb_settings' ] = $this->to_settings( $content[ 'tag' ], $content[ 'attributes' ] );
					//}

					//if ( ! isset( $contents[ $index ][ '_upb_options' ] ) ) {
					$contents[ $index ][ '_upb_options' ] = $this->get_element( $content[ 'tag' ], '_upb_options' );
					//}

					if ( ! empty( $content[ 'contents' ] ) && is_array( $content[ 'contents' ] ) ) {
						$contents[ $index ][ 'contents' ] = $this->set_upb_options_recursive( $content[ 'contents' ] );
					}
				}

				return $contents;

			}
		}

	endif;
