<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'UPB_Elements' ) ):

        class UPB_Elements {

            private static $instance            = NULL;
            private        $short_code_elements = array();

            private $core_elements = array( 'upb-section', 'upb-row', 'upb-column' );

            private function __construct() {
                $this->props = new UPB_Elements_Props();
            }

            public static function getInstance() {

                if ( is_null( self::$instance ) ) {
                    self::$instance = new self();
                }

                return self::$instance;
            }

            public function register( $tag, $settings = array(), $contents = FALSE, $_upb_options = array() ) {

                if ( $this->has_element( $tag ) ) {
                    trigger_error( sprintf( esc_html__( 'Ultimate page builder element "%s" already registered.', 'ultimate-page-builder' ), $tag ), E_USER_WARNING );
                }

                $_upb_options[ 'focus' ] = FALSE;

                $_upb_options[ 'core' ] = FALSE;

                if ( in_array( $tag, $this->core_elements ) ) {
                    $_upb_options[ 'core' ] = TRUE;
                }

                if ( ! isset( $_upb_options[ 'element' ][ 'nested' ] ) ) {
                    $_upb_options[ 'element' ][ 'nested' ] = FALSE;
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

                // Assets
                if ( ! isset( $_upb_options[ 'assets' ] ) ) {
                    $_upb_options[ 'assets' ] = array();
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'preview' ] ) ) {
                    $_upb_options[ 'assets' ][ 'preview' ] = array();
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'preview' ][ 'js' ] ) ) {
                    $_upb_options[ 'assets' ][ 'preview' ][ 'js' ] = FALSE;
                }

                // each time init script
                if ( ! isset( $_upb_options[ 'assets' ][ 'preview' ][ 'inline_js' ] ) ) {
                    $_upb_options[ 'assets' ][ 'preview' ][ 'inline_js' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'preview' ][ 'css' ] ) ) {
                    $_upb_options[ 'assets' ][ 'preview' ][ 'css' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'shortcode' ] ) ) {
                    $_upb_options[ 'assets' ][ 'shortcode' ] = array();
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'shortcode' ][ 'js' ] ) ) {
                    $_upb_options[ 'assets' ][ 'shortcode' ][ 'js' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] ) ) {
                    $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'third_party_path' ] ) ) {
                    $_upb_options[ 'third_party_path' ] = FALSE;
                }

                ///

                $settings     = apply_filters( "upb_element_{$tag}_settings", $settings );
                $_upb_options = apply_filters( "upb_element_{$tag}_options", $_upb_options );


                if ( is_string( $contents ) ) {
                    $settings[] = array( 'id' => '_contents', 'title' => apply_filters( 'upb_element_content_field_title', 'Contents' ), 'type' => 'contents', 'value' => wp_kses_post( $contents ) );
                }

                foreach ( $settings as $key => $setting ) {
                    // $attributes[ $index ][ 'metaKey' ]   = $attribute[ 'id' ];

                    // Have Default but no value
                    if ( isset( $settings[ $key ][ 'default' ] ) && ! isset( $settings[ $key ][ 'value' ] ) ) {
                        $settings[ $key ][ 'value' ] = $settings[ $key ][ 'default' ];
                    }

                    // No Default but Have Value
                    if ( ! isset( $settings[ $key ][ 'default' ] ) && isset( $settings[ $key ][ 'value' ] ) ) {
                        $settings[ $key ][ 'default' ] = $settings[ $key ][ 'value' ];
                    }

                    if ( ! isset( $settings[ $key ][ 'use' ] ) ) {
                        $settings[ $key ][ 'use' ] = FALSE;
                    }

                    $settings[ $key ] = $this->props->filterOptions( $settings[ $key ] );

                    $settings[ $key ][ '_id' ] = $setting[ 'id' ];
                    //$attributes[ $index ][ 'metaValue' ] = $attribute[ 'value' ];
                    $settings[ $key ][ '_upb_field_type' ] = sprintf( 'upb-input-%s', $setting[ 'type' ] );
                }

                $this->short_code_elements[ $tag ] = array(
                    'tag'           => $tag,
                    'contents'      => $contents,
                    'attributes'    => ( empty( $settings ) ? FALSE : $this->to_attributes( $settings ) ),
                    '_upb_settings' => ( empty( $settings ) ? FALSE : $settings ),
                    '_upb_options'  => $_upb_options
                );

                $shortcode_fn        = sprintf( 'upb_register_shortcode_%s', str_ireplace( '-', '_', $tag ) );
                $preview_template_fn = sprintf( 'upb_register_preview_%s', str_ireplace( '-', '_', $tag ) );

                // Override functionality
                if ( ! shortcode_exists( $tag ) && is_callable( $shortcode_fn ) ) {
                    // To override short code functions :)
                    add_shortcode( $tag, $shortcode_fn );
                } else {
                    if ( ! shortcode_exists( $tag ) ) {

                        if ( ! empty( $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] ) ) {
                            wp_register_style( sprintf( 'upb-element-%s', $tag ), esc_url( $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] ), array(), FALSE );
                        }

                        if ( ! empty( $_upb_options[ 'assets' ][ 'shortcode' ][ 'js' ] ) ) {
                            wp_register_script( sprintf( 'upb-element-%s', $tag ), esc_url( $_upb_options[ 'assets' ][ 'shortcode' ][ 'js' ] ), array(), FALSE, TRUE );
                        }

                        add_shortcode( $tag, function ( $attrs, $contents = NULL ) use ( $tag, $_upb_options ) {

                            $attributes = upb_elements()->get_attributes( $tag, $attrs );
                            $settings   = upb_elements()->get_element( $tag, '_upb_settings' );
                            // $options   = upb_elements()->get_element( $tag, '_upb_options' );

                            ob_start();
                            upb_get_template( sprintf( "shortcodes/%s.php", $tag ), compact( 'attributes', 'contents', 'settings' ), $_upb_options[ 'third_party_path' ] );

                            return ob_get_clean();
                        } );
                    }
                }

                // Override functionality
                if ( is_callable( $preview_template_fn ) ) {
                    add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', $tag ), $preview_template_fn );
                } else {
                    add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', $tag ), function () use ( $tag, $_upb_options ) {

                        if ( ! current_user_can( 'customize' ) ) {
                            wp_send_json_error( 'upb_not_allowed', 403 );
                        }

                        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
                            wp_send_json_error( 'bad_nonce', 400 );
                        }

                        ob_start();
                        upb_get_template( sprintf( "previews/%s.php", $tag ), $_upb_options[ 'third_party_path' ] );
                        wp_send_json_success( ob_get_clean() );
                    } );
                }
            }

            public function get_elements() {
                return $this->short_code_elements;
            }

            public function getAll() {
                return array_values( $this->short_code_elements );
            }

            public function getNamed() {
                return array_keys( $this->short_code_elements );
            }

            public function getNonCore() {
                return array_filter( array_values( $this->short_code_elements ), function ( $tag ) {
                    return ! in_array( $tag[ 'tag' ], $this->core_elements );
                } );
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

            public function get_attributes( $tag, $attrs = array() ) {
                $attributes = $this->get_element( $tag, 'attributes' );

                if ( $attributes ) {

                    $settings = $this->to_settings( $tag, $attributes );

                    foreach ( $settings as $index => $setting ) {
                        if ( isset( $attrs[ $setting[ 'id' ] ] ) ) {
                            $settings[ $index ][ 'value' ] = $attrs[ $setting[ 'id' ] ];
                        }
                    }

                    $attributes = $this->to_attributes( $settings );

                    if ( isset( $attributes[ '_contents' ] ) ) {
                        unset( $attributes[ '_contents' ] );
                    }

                    return $attributes;
                }

                return array();
            }

            public function generate_element( $tag, $contents = array(), $attributes = array() ) {

                if ( ! $this->has_element( $tag ) ) {
                    throw new Exception( sprintf( 'Ultimate page builder element "%s" is not registered.', $tag ) );
                }

                $el = $this->get_element( $tag );

                if ( ! empty( $contents ) && is_array( $contents ) ) {

                    if ( isset( $contents[ 0 ] ) ) {
                        foreach ( $contents as $content ) {
                            array_push( $el[ 'contents' ], $content );
                        }
                    } else {
                        array_push( $el[ 'contents' ], $contents );
                    }
                }

                if ( ! empty( $contents ) && is_string( $contents ) ) {
                    $el[ 'contents' ] = wp_kses_post( $contents );
                }


                if ( ! empty( $attributes ) ) {
                    $el[ 'attributes' ]    = array_merge( $el[ 'attributes' ], $this->to_attributes( $attributes ) );
                    $el[ '_upb_settings' ] = array_merge( $el[ '_upb_settings' ], $el[ 'attributes' ] );
                }

                return $el;
            }

            public function has_element( $tag ) {
                return isset( $this->short_code_elements[ $tag ] );
            }

            public function to_attributes( $attributes ) {

                $new_attributes = array();
                foreach ( $attributes as $index => $attribute ) {

                    $attribute = $this->props->filterOptions( $attribute );

                    // NEW ATTRIBUTE
                    if ( isset( $attribute[ 'id' ] ) ) {
                        $new_attributes[ $attribute[ 'id' ] ] = $attribute[ 'value' ];
                    } else {
                        $new_attributes[ $index ] = $attribute[ 'value' ];
                    }
                }

                return $new_attributes;
            }

            public function to_settings( $tag, $attributes ) {

                $settings = (array) $this->get_element( $tag, '_upb_settings' );

                // Keeps Old Attribute
                /*foreach ( $attributes as $key => $value ) {
                    $settings[ $key ][ 'value' ] = $value;
                }*/


                // Always new attribute
                foreach ( $settings as $key => $value ) {
                    $settings[ $key ][ 'value' ] = $attributes[ $value[ 'id' ] ];
                    $settings[ $key ]            = $this->props->filterOptions( $settings[ $key ] );
                }

                return $settings;
            }

            public function set_upb_options( $contents ) {

                foreach ( $contents as $index => $content ) {

                    if ( ! isset( $content[ 'contents' ] ) and is_array( $this->get_element( $content[ 'tag' ], 'contents' ) ) ) {
                        $contents[ $index ][ 'contents' ] = $this->get_element( $content[ 'tag' ], 'contents' );
                    }

                    if ( is_string( $this->get_element( $content[ 'tag' ], 'contents' ) ) ) {
                        $contents[ $index ][ 'attributes' ][ '_contents' ] = wp_kses_post( $content[ 'contents' ] );
                        $content[ 'attributes' ][ '_contents' ]            = wp_kses_post( $content[ 'contents' ] );
                    }

                    //if ( ! isset( $contents[ $index ][ '_upb_settings' ] ) ) {


                    $contents[ $index ][ '_upb_settings' ] = $this->to_settings( $content[ 'tag' ], $content[ 'attributes' ] );
                    $contents[ $index ][ 'attributes' ]    = $this->to_attributes( $contents[ $index ][ '_upb_settings' ] );


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

                    if ( is_string( $this->get_element( $content[ 'tag' ], 'contents' ) ) ) {
                        $contents[ $index ][ 'attributes' ][ '_contents' ] = wp_kses_post( $content[ 'contents' ] );
                        $content[ 'attributes' ][ '_contents' ]            = wp_kses_post( $content[ 'contents' ] );
                    }

                    // $contents[ $index ][ 'attributes' ] = $this->toBoolean( $content[ 'attributes' ] );


                    //if ( ! isset( $contents[ $index ][ '_upb_settings' ] ) ) {
                    $contents[ $index ][ '_upb_settings' ] = $this->to_settings( $content[ 'tag' ], $content[ 'attributes' ] );
                    $contents[ $index ][ 'attributes' ]    = $this->to_attributes( $contents[ $index ][ '_upb_settings' ] );

                    // print_r($contents[ $index ][ 'attributes' ]);
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
