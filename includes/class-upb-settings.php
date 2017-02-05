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

            private function get_the_ID() {
                return absint( $_POST[ 'id' ] );
            }

            public function getAll() {

                $saved_settings = array();

                foreach ( $this->settings as $i => $options ) {

                    $options = $this->setAttrBasedOnType( $options[ 'id' ], $options );

                    $saved_settings[ $i ][ '_upb_field_type' ]  = 'upb-input-' . $options[ 'type' ];
                    $saved_settings[ $i ][ '_upb_field_attrs' ] = $options;

                    $saved_settings[ $i ][ 'metaType' ]  = $options[ 'type' ];
                    $saved_settings[ $i ][ 'metaId' ]    = $options[ 'id' ];
                    $saved_settings[ $i ][ 'metaKey' ]   = $options[ '_id' ];
                    $saved_settings[ $i ][ 'metaValue' ] = $options[ 'value' ];
                }

                return $saved_settings;
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

                $options[ 'value' ]       = $options[ 'default' ];
                $options[ 'placeholder' ] = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : '';
                $options[ 'use' ]         = isset( $options[ 'use' ] ) ? $options[ 'use' ] : FALSE;
                $options[ 'require' ]     = isset( $options[ 'require' ] ) ? $options[ 'require' ] : FALSE;


                if (
                    $options[ 'type' ] == 'select2'
                    || $options[ 'type' ] == 'icon-select'
                    || $options[ 'type' ] == 'select-icon'
                    || $options[ 'type' ] == 'ajax-icon-select'
                    || $options[ 'type' ] == 'ajax-select'
                ) {
                    $options[ 'settings' ][ 'placeholder' ] = $options[ 'placeholder' ];
                }

                switch ( $options[ 'type' ] ) {
                    case 'select':
                    case 'select2':
                    case 'select-icon':
                        if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] && ! is_array( $options[ 'default' ] ) ) {
                            $options[ 'default' ] = array();
                        }
                        break;

                    case 'checkbox':
                    case 'checkbox-icon':
                    case 'device-hidden':

                        if ( ! is_array( $options[ 'default' ] ) ) {
                            $options[ 'default' ] = array();
                        }

                        break;

                    case 'media-image':
                    case 'background-image':
                        $options[ 'placeholder' ] = ! empty( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : esc_html__( 'No Image', 'ultimate-page-builder' );
                        $options[ 'size' ]        = isset( $options[ 'size' ] ) ? $options[ 'size' ] : 'full'; //  ‘thumbnail’, ‘medium’, ‘large’, ‘full’
                        $options[ 'attribute' ]   = isset( $options[ 'attribute' ] ) ? $options[ 'attribute' ] : 'id'; // id / src
                        $options[ 'buttons' ]     = isset( $options[ 'buttons' ] )
                            ? $options[ 'buttons' ]
                            : array(
                                'add'    => esc_html__( 'Use Image', 'ultimate-page-builder' ),
                                'remove' => esc_html__( 'Remove', 'ultimate-page-builder' ),
                                'choose' => esc_html__( 'Select', 'ultimate-page-builder' ),
                            );
                        break;


                    case 'range':
                    case 'number':

                        if ( ! isset( $options[ 'options' ] ) ) {
                            $options[ 'options' ] = array();
                        }

                        $options[ 'options' ][ 'min' ]    = isset( $options[ 'options' ][ 'min' ] ) ? (int) $options[ 'options' ][ 'min' ] : 0;
                        $options[ 'options' ][ 'max' ]    = isset( $options[ 'options' ][ 'max' ] ) ? (int) $options[ 'options' ][ 'max' ] : 100;
                        $options[ 'options' ][ 'step' ]   = isset( $options[ 'options' ][ 'step' ] ) ? $options[ 'options' ][ 'step' ] : '';
                        $options[ 'options' ][ 'size' ]   = isset( $options[ 'options' ][ 'size' ] ) ? $options[ 'options' ][ 'size' ] : 3;
                        $options[ 'options' ][ 'prefix' ] = isset( $options[ 'options' ][ 'prefix' ] ) ? esc_html( $options[ 'options' ][ 'prefix' ] ) : '';
                        $options[ 'options' ][ 'suffix' ] = isset( $options[ 'options' ][ 'suffix' ] ) ? esc_html( $options[ 'options' ][ 'suffix' ] ) : '';
                        break;
                }

                $this->settings[] = $options;
            }

            private function setAttrBasedOnType( $id, $options ) {

                $value = $this->get_setting( $id );

                switch ( $options[ 'type' ] ):

                    case 'ajax-icon-select':
                    case 'ajax-select':
                        $options[ 'value' ]   = empty( $value ) ? $options[ 'default' ] : $value;
                        $options[ 'options' ] = array();

                        if ( ! isset( $options[ 'hooks' ] ) ) {
                            $options[ 'hooks' ] = array();
                        }

                        // _upb_setting_[ID]_search
                        // _upb_setting_[ID]_load

                        // wp_ajax__upb_setting_[ID]_search
                        // wp_ajax__upb_setting_[ID]_load

                        if ( ! isset( $options[ 'hooks' ][ 'ajaxOptions' ] ) ) {
                            $options[ 'hooks' ][ 'ajaxOptions' ] = NULL;
                        }

                        if ( ! isset( $options[ 'hooks' ][ 'search' ] ) ) {
                            $options[ 'hooks' ][ 'search' ] = sprintf( '_upb_setting_%s_search', $id );
                        }

                        if ( ! isset( $options[ 'hooks' ][ 'load' ] ) ) {
                            $options[ 'hooks' ][ 'load' ] = sprintf( '_upb_setting_%s_load', $id );
                        }

                        break;

                    case 'color':
                        if ( ! isset( $options[ 'options' ] ) ) {
                            $options[ 'options' ] = array();
                        }
                        $options[ 'options' ][ 'alpha' ] = isset( $options[ 'options' ][ 'alpha' ] ) ? $options[ 'options' ][ 'alpha' ] : FALSE;
                        $options[ 'value' ]              = empty( $value ) ? $options[ 'default' ] : $value;
                        break;

                    case 'select':
                    case 'select2':
                    case 'checkbox':
                    case 'select-icon':
                    case 'icon-select':
                    case 'checkbox-icon':
                        $options[ 'value' ] = empty( $value ) ? $options[ 'default' ] : $value;
                        break;

                    case 'toggle':
                        $options[ 'value' ] = ( $value === '' ) ? $options[ 'default' ] : $value;
                        $options[ 'value' ] = upb_return_boolean( $options[ 'value' ] );
                        break;

                    case 'editor':
                        $options[ 'value' ] = ( $value === '' ) ? wp_kses_post( $options[ 'default' ] ) : wp_kses_post( $value );
                        break;

                    case 'textarea':
                        $options[ 'value' ] = ( $value === '' ) ? esc_textarea( $options[ 'default' ] ) : esc_textarea( $value );
                        break;

                    case 'range':
                    case 'number':
                        $options[ 'value' ] = ( $value === '' ) ? (int) $options[ 'default' ] : (int) $value;
                        break;

                    default:
                        $options[ 'value' ] = ( $value === '' ) ? esc_html( $options[ 'default' ] ) : esc_html( $value );
                        break;
                endswitch;

                return apply_filters( 'upb_setting_filter_options', $options, $options[ 'type' ] );

            }

            public function get_setting( $id ) {
                $_id = $this->prefix . $id;

                return get_post_meta( $this->get_the_ID(), $_id, TRUE );
            }

            public function set_setting( $type, $id, $value ) {
                $_id = $this->prefix . $id;


                return update_post_meta( $this->get_the_ID(), $_id, $value );
            }

            public function set_settings( $settings ) {
                foreach ( $settings as $setting ) {
                    $this->set_setting( $setting[ 'metaType' ], $setting[ 'metaId' ], $setting[ 'metaValue' ] );
                }
            }
        }
    endif;