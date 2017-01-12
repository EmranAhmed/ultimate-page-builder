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

                if ( ! isset( $_upb_options[ 'element' ][ 'child' ] ) ) {
                    $_upb_options[ 'element' ][ 'child' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'preview' ] ) ) {
                    $_upb_options[ 'preview' ] = array(
                        //	'component' => 'upb-' . $tag,
                        'template' => $tag,
                        'mixins'   => '{}' // javascript object, like: { methods:{ abcd(){} } } or window.abcdMixins = {}
                    );
                }

                if ( ! isset( $_upb_options[ 'previews' ] ) ) {
                    $_upb_options[ 'previews' ] = FALSE;

                    // previews=array( array('component'=>'', 'template'=>'') )
                }

                if ( is_array( $_upb_options[ 'previews' ] ) ) {
                    foreach ( $_upb_options[ 'previews' ] as $key => $previews ) {


                        if ( ! isset( $previews[ 'template' ] ) ) {
                            $_upb_options[ 'previews' ][ $key ][ 'template' ] = $previews[ 'component' ];
                        }

                        if ( ! isset( $previews[ 'mixins' ] ) ) {
                            $_upb_options[ 'previews' ][ $key ][ 'mixins' ] = '{}';
                        }

                        $_upb_options[ 'previews' ][ $key ][ 'component' ] = 'upb-preview-' . esc_html( $previews[ 'component' ] );
                    }
                }


                if ( isset( $_upb_options[ 'preview' ][ 'component' ] ) && is_string( $_upb_options[ 'preview' ][ 'component' ] ) ) {
                    $_upb_options[ 'preview' ][ 'component' ] = 'upb-preview-' . esc_html( $_upb_options[ 'preview' ][ 'component' ] );
                } else {
                    $_upb_options[ 'preview' ][ 'component' ] = 'upb-preview-' . $tag;
                }

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

                if ( ! isset( $_upb_options[ 'assets' ][ 'shortcode' ][ 'inline_js' ] ) ) {
                    $_upb_options[ 'assets' ][ 'shortcode' ][ 'inline_js' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] ) ) {
                    $_upb_options[ 'assets' ][ 'shortcode' ][ 'css' ] = FALSE;
                }

                if ( ! isset( $_upb_options[ 'third_party_path' ] ) ) {
                    $_upb_options[ 'third_party_path' ] = FALSE;
                }

                // Toolbar List

                if ( ! isset( $_upb_options[ 'tools' ] ) ) {
                    $_upb_options[ 'tools' ] = array();
                }

                if ( ! isset( $_upb_options[ 'tools' ][ 'list' ] ) ) {
                    $list_toolbar = array();

                    $list_toolbar[ 'move' ] = array(
                        'id'    => 'move',
                        'icon'  => 'mdi mdi-cursor-move',
                        'class' => 'handle',
                        'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
                    );

                    $list_toolbar[ 'delete' ] = array(
                        'id'    => 'delete',
                        'icon'  => 'mdi mdi-delete-forever',
                        'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
                    );

                    if ( in_array( 'enable', array_column( $settings, 'id' ) ) ) {
                        $list_toolbar[ 'enable' ] = array(
                            'id'    => 'enable',
                            'icon'  => 'mdi mdi-eye',
                            'title' => esc_html__( 'Enabled', 'ultimate-page-builder' ),
                        );

                        $list_toolbar[ 'disable' ] = array(
                            'id'    => 'disable',
                            'icon'  => 'mdi mdi-eye-off',
                            'title' => esc_html__( 'Disabled', 'ultimate-page-builder' ),
                        );
                    }

                    if ( is_array( $contents ) ) {
                        $list_toolbar[ 'contents' ] = array(
                            'id'    => 'contents',
                            'icon'  => 'mdi mdi-table-edit',
                            'class' => 'show-contents',
                            'title' => esc_html__( 'Contents', 'ultimate-page-builder' ),
                        );
                    }

                    if ( is_array( $settings ) && ! empty( $settings ) ) {
                        $list_toolbar[ 'settings' ] = array(
                            'id'    => 'settings',
                            'icon'  => 'mdi mdi-settings',
                            'class' => 'show-settings',
                            'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
                        );
                    }

                    $list_toolbar[ 'clone' ] = array(
                        'id'    => 'clone',
                        'icon'  => 'mdi mdi-content-duplicate',
                        'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
                    );

                    $_upb_options[ 'tools' ][ 'list' ] = apply_filters( "upb_{$tag}_list_toolbar", $list_toolbar );
                }

                // Contents Toolbar
                if ( ! isset( $_upb_options[ 'tools' ][ 'contents' ] ) ) {

                    $list_toolbar = array();
                    if ( is_array( $settings ) && ! empty( $settings ) ) {
                        $list_toolbar[] = array(
                            'id'     => "$tag-setting",
                            'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                            'icon'   => 'mdi mdi-settings',
                            'action' => 'showSettingsPanel'
                        );
                    }

                    $_upb_options[ 'tools' ][ 'contents' ] = apply_filters( "upb_{$tag}_contents_panel_toolbar", $list_toolbar );
                }

                // Settings Toolbar
                if ( ! isset( $_upb_options[ 'tools' ][ 'settings' ] ) ) {

                    $list_toolbar = array();
                    if ( is_array( $contents ) ) {
                        $list_toolbar[] = array(
                            'id'     => "{$tag}-contents",
                            'title'  => esc_html__( 'Contents', 'ultimate-page-builder' ),
                            'icon'   => 'mdi mdi-table-edit',
                            'action' => 'showContentPanel'
                        );
                    }

                    $_upb_options[ 'tools' ][ 'settings' ] = apply_filters( "upb_{$tag}_settings_panel_toolbar", $list_toolbar );
                }

                // Meta Toolbar
                if ( ! isset( $_upb_options[ 'meta' ] ) ) {
                    $_upb_options[ 'meta' ] = array();
                }

                if ( ! isset( $_upb_options[ 'meta' ][ 'contents' ] ) ) {
                    $_upb_options[ 'meta' ][ 'contents' ] = array();
                }
                if ( ! isset( $_upb_options[ 'meta' ][ 'settings' ] ) ) {
                    $_upb_options[ 'meta' ][ 'settings' ] = array();
                }
                if ( ! isset( $_upb_options[ 'meta' ][ 'messages' ] ) ) {
                    $_upb_options[ 'meta' ][ 'messages' ] = array();
                }

                // Meta Contents
                if ( ! isset( $_upb_options[ 'meta' ][ 'contents' ][ 'title' ] ) ) {
                    $_upb_options[ 'meta' ][ 'contents' ][ 'title' ] = '%s';
                }

                if ( ! isset( $_upb_options[ 'meta' ][ 'contents' ][ 'search' ] ) ) {
                    $_upb_options[ 'meta' ][ 'contents' ][ 'search' ] = esc_html__( 'Search', 'ultimate-page-builder' );
                }

                if ( ! isset( $_upb_options[ 'meta' ][ 'contents' ][ 'help' ] ) ) {
                    $_upb_options[ 'meta' ][ 'contents' ][ 'help' ] = '';
                }

                // Meta Settings
                if ( ! isset( $_upb_options[ 'meta' ][ 'settings' ][ 'title' ] ) ) {
                    $_upb_options[ 'meta' ][ 'settings' ][ 'title' ] = esc_html__( '%s Settings', 'ultimate-page-builder' );
                }

                if ( ! isset( $_upb_options[ 'meta' ][ 'settings' ][ 'search' ] ) ) {
                    $_upb_options[ 'meta' ][ 'settings' ][ 'search' ] = esc_html__( 'Search', 'ultimate-page-builder' );
                }

                if ( ! isset( $_upb_options[ 'meta' ][ 'settings' ][ 'help' ] ) ) {
                    $_upb_options[ 'meta' ][ 'settings' ][ 'help' ] = '';
                }

                // Meta Messages
                if ( ! isset( $_upb_options[ 'meta' ][ 'messages' ][ 'addElement' ] ) ) {
                    $_upb_options[ 'meta' ][ 'messages' ][ 'addElement' ] = esc_html__( 'Add Element', 'ultimate-page-builder' );
                }

                // WP Hooks
                $settings     = apply_filters( "upb_element_{$tag}_settings", $settings );
                $_upb_options = apply_filters( "upb_element_{$tag}_options", $_upb_options );

                if ( is_string( $contents ) ) {
                    $settings[] = array( 'id' => '_contents', 'title' => apply_filters( 'upb_element_content_field_title', esc_html__( 'Contents', 'ultimate-page-builder' ) ), 'type' => 'contents', 'value' => wp_kses_post( $contents ) );
                }

                foreach ( $settings as $key => $setting ) {

                    // Require
                    //===================
                    // require=>array(
                    // array('title', '!=', '' ),
                    // array( 'title', '=', 'xxx')
                    // array( 'title', '=', array('xxx', 'yyy'))
                    // )
                    //
                    // array( array('title', '!=', '') ) // if depended value is array check length or check text

                    if ( ! isset( $settings[ $key ][ 'require' ] ) || ! is_array( $settings[ $key ][ 'require' ] ) ) {
                        $settings[ $key ][ 'require' ] = FALSE;
                    }

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

                    $settings[ $key ][ '_upb_field_type' ] = sprintf( 'upb-input-%s', $setting[ 'type' ] );
                }

                $this->short_code_elements[ $tag ] = array(
                    'tag'           => $tag,
                    'contents'      => $contents,
                    'attributes'    => ( empty( $settings ) ? FALSE : $this->to_attributes( $settings ) ),
                    '_upb_settings' => ( empty( $settings ) ? FALSE : $settings ),
                    '_upb_options'  => $_upb_options
                );

                $shortcode_fn = sprintf( 'upb_register_shortcode_%s', str_ireplace( '-', '_', $tag ) );

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

                        if ( ! empty( $_upb_options[ 'assets' ][ 'shortcode' ][ 'inline_js' ] ) ) {
                            wp_add_inline_script( sprintf( 'upb-element-%s', $tag ), $_upb_options[ 'assets' ][ 'shortcode' ][ 'inline_js' ] );
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

                if ( ! empty( $_upb_options[ 'previews' ] ) ) {
                    foreach ( $_upb_options[ 'previews' ] as $preview ) {
                        $preview_template_fn = sprintf( 'upb_register_preview_%s', str_ireplace( '-', '_', esc_html( $preview[ 'template' ] ) ) );

                        if ( is_callable( $preview_template_fn ) ) {
                            add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', esc_html( $preview[ 'template' ] ) ), $preview_template_fn );
                        } else {
                            add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', esc_html( $preview[ 'template' ] ) ), function () use ( $preview, $_upb_options ) {

                                if ( ! current_user_can( 'customize' ) ) {
                                    wp_send_json_error( 'upb_not_allowed', 403 );
                                }

                                if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
                                    wp_send_json_error( 'bad_nonce', 400 );
                                }

                                ob_start();
                                upb_get_template( sprintf( "previews/%s.php", esc_html( $preview[ 'template' ] ) ), $_upb_options[ 'third_party_path' ] );
                                wp_send_json_success( ob_get_clean() );
                            } );
                        }
                    }
                }

                $preview_template_fn = sprintf( 'upb_register_preview_%s', str_ireplace( '-', '_', esc_html( $_upb_options[ 'preview' ][ 'template' ] ) ) );

                if ( is_callable( $preview_template_fn ) ) {
                    add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', esc_html( $_upb_options[ 'preview' ][ 'template' ] ) ), $preview_template_fn );
                } else {
                    add_action( sprintf( 'wp_ajax__get_upb_shortcode_preview_%s', esc_html( $_upb_options[ 'preview' ][ 'template' ] ) ), function () use ( $tag, $_upb_options ) {

                        if ( ! current_user_can( 'customize' ) ) {
                            wp_send_json_error( 'upb_not_allowed', 403 );
                        }

                        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
                            wp_send_json_error( 'bad_nonce', 400 );
                        }

                        ob_start();
                        upb_get_template( sprintf( "previews/%s.php", esc_html( $_upb_options[ 'preview' ][ 'template' ] ) ), $_upb_options[ 'third_party_path' ] );
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

                    $temp_settings = array();
                    $settings      = (array) $this->get_element( $tag, '_upb_settings' );

                    foreach ( $settings as $setting ) {
                        if ( isset( $attributes[ $setting[ 'id' ] ] ) ) {

                            $temp_settings[] = $this->props->filterOptions( array_merge( $setting, array(
                                'value' => $attributes[ $setting[ 'id' ] ]
                            ) ) );
                        }
                    }

                    $el[ 'attributes' ]    = array_merge( $el[ 'attributes' ], $this->to_attributes( $temp_settings ) );
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

                    //$settings[ $key ][ 'value' ] = NULL;
                    //if ( isset( $attributes[ $value[ 'id' ] ] ) ) {
                    $settings[ $key ][ 'value' ] = $attributes[ $value[ 'id' ] ];
                    //}
                    $settings[ $key ] = $this->props->filterOptions( $settings[ $key ] );
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
