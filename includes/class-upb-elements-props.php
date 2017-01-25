<?php
    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'UPB_Elements_Props' ) ):

        class UPB_Elements_Props {

            public function filterOptions( $options, $tag = '' ) {

                $options[ 'desc' ]        = isset( $options[ 'desc' ] ) ? $options[ 'desc' ] : FALSE;
                $options[ 'default' ]     = isset( $options[ 'default' ] ) ? $options[ 'default' ] : '';
                $options[ 'placeholder' ] = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : '';

                if (
                    $options[ 'type' ] == 'select2'
                    || $options[ 'type' ] == 'icons'
                    || $options[ 'type' ] == 'ajax'
                    || $options[ 'type' ] == 'icon-ajax'
                ) {
                    $options[ 'settings' ][ 'placeholder' ] = $options[ 'placeholder' ];
                }

                switch ( $options[ 'type' ] ) {
                    case 'editor':
                        if ( isset( $options[ 'value' ] ) && ! empty( $options[ 'value' ] ) ) {
                            $options[ 'value' ] = wp_kses_post( $options[ 'value' ] );
                        }
                        break;

                    case 'image':
                    case 'background-image':
                        $options[ 'placeholder' ] = ! empty( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : esc_html__( 'No Image', 'ultimate-page-builder' );
                        $options[ 'size' ]        = isset( $options[ 'size' ] ) ? $options[ 'size' ] : 'full'; // ‘thumbnail’, ‘medium’, ‘large’, ‘full’
                        $options[ 'attribute' ]   = isset( $options[ 'attribute' ] ) ? $options[ 'attribute' ] : 'id'; // id, src

                        $options[ 'buttons' ] = isset( $options[ 'buttons' ] )
                            ? $options[ 'buttons' ]
                            : array(
                                'add'    => esc_html__( 'Use Image', 'ultimate-page-builder' ),
                                'remove' => esc_html__( 'Remove', 'ultimate-page-builder' ),
                                'choose' => esc_html__( 'Select', 'ultimate-page-builder' ),
                            );
                        break;

                    case 'color':
                        $options[ 'alpha' ] = isset( $options[ 'alpha' ] ) ? $options[ 'alpha' ] : FALSE;
                        break;

                    case 'toggle':
                        $options[ 'value' ] = filter_var( $options[ 'value' ], FILTER_VALIDATE_BOOLEAN );
                        break;

                    case 'icon-ajax':
                    case 'ajax':

                        $options[ 'options' ] = array();

                        if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] ) {
                            $options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';

                            // Processing saved attributes
                            if ( is_null( $options[ 'value' ] ) ) {
                                $options[ 'value' ] = $options[ 'default' ];
                            }

                            if ( ! is_array( $options[ 'value' ] ) ) {
                                $options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
                            }
                        } else {
                            if ( ! isset( $options[ 'settings' ] ) || ! isset( $options[ 'settings' ][ 'allowClear' ] ) ) {
                                $options[ 'settings' ][ 'allowClear' ] = TRUE;
                            }
                        }

                        if ( ! isset( $options[ 'hooks' ] ) ) {
                            $options[ 'hooks' ] = array();
                        }

                        // _upb_element_[tag]_[id]_search
                        // _upb_element_[tag]_[id]_load

                        // wp_ajax__upb_element_[tag]_[id]_search
                        // wp_ajax__upb_element_[tag]_[id]_load

                        if ( ! isset( $options[ 'hooks' ][ 'ajaxOptions' ] ) ) {
                            $options[ 'hooks' ][ 'ajaxOptions' ] = NULL;
                        }

                        if ( ! isset( $options[ 'hooks' ][ 'search' ] ) ) {
                            $options[ 'hooks' ][ 'search' ] = sprintf( '_upb_element_%s_%s_search', $tag, $options[ 'id' ] );
                        }

                        if ( ! isset( $options[ 'hooks' ][ 'load' ] ) ) {
                            $options[ 'hooks' ][ 'load' ] = sprintf( '_upb_element_%s_%s_load', $tag, $options[ 'id' ] );
                        }
                        break;

                    case 'range':
                    case 'number':

                        if ( ! isset( $options[ 'options' ] ) ) {
                            $options[ 'options' ] = array();
                        }

                        $options[ 'options' ][ 'min' ]    = isset( $options[ 'options' ][ 'min' ] ) ? (int) $options[ 'options' ][ 'min' ] : 0;
                        $options[ 'options' ][ 'max' ]    = isset( $options[ 'options' ][ 'max' ] ) ? (int) $options[ 'options' ][ 'max' ] : 100;
                        $options[ 'options' ][ 'step' ]   = isset( $options[ 'options' ][ 'step' ] ) ? $options[ 'options' ][ 'step' ] : '';
                        $options[ 'options' ][ 'prefix' ] = isset( $options[ 'options' ][ 'prefix' ] ) ? esc_html( $options[ 'options' ][ 'prefix' ] ) : '';
                        $options[ 'options' ][ 'suffix' ] = isset( $options[ 'options' ][ 'suffix' ] ) ? esc_html( $options[ 'options' ][ 'suffix' ] ) : '';

                        $options[ 'value' ] = (int) $options[ 'value' ];
                        break;

                    case 'select':
                    case 'select2':
                        if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] ) {
                            $options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';

                            // Processing saved attributes
                            if ( is_null( $options[ 'value' ] ) ) {
                                $options[ 'value' ] = $options[ 'default' ];
                            }

                            if ( ! is_array( $options[ 'value' ] ) ) {
                                $options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
                            }
                        } else {
                            if ( ! isset( $options[ 'settings' ] ) || ! isset( $options[ 'settings' ][ 'allowClear' ] ) ) {
                                $options[ 'settings' ][ 'allowClear' ] = TRUE;
                            }
                        }
                        break;

                    case 'checkbox':
                    case 'checkbox-icon':
                    case 'device-hidden':

                        $options[ 'delimiter' ] = isset( $options[ 'delimiter' ] ) ? $options[ 'delimiter' ] : ',';

                        if ( is_null( $options[ 'value' ] ) ) {
                            $options[ 'value' ] = $options[ 'default' ];
                        }

                        if ( ! is_array( $options[ 'value' ] ) ) {
                            $options[ 'value' ] = explode( $options[ 'delimiter' ], $options[ 'value' ] );
                        }

                        break;

                    case 'textarea':
                        $options[ 'value' ] = empty( $options[ 'value' ] ) ? esc_textarea( $options[ 'default' ] ) : esc_textarea( $options[ 'value' ] );
                        break;

                    case 'message':
                        $options[ 'value' ] = NULL;
                        if ( ! isset( $options[ 'style' ] ) ) {
                            $options[ 'style' ] = 'info'; // info, success, warning, error
                        }
                        break;

                    default:
                        if ( is_null( $options[ 'value' ] ) ) {
                            $options[ 'value' ] = esc_html( $options[ 'default' ] );
                        }
                        break;
                }

                return apply_filters( 'upb_elements_filter_option', $options, $tag );
            }
        }
    endif;