<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'UPB_Elements_Props' ) ):

        class UPB_Elements_Props {

            public function attributes( $options ) {

                $options[ 'desc' ]        = isset( $options[ 'desc' ] ) ? $options[ 'desc' ] : FALSE;
                $options[ 'default' ]     = isset( $options[ 'default' ] ) ? $options[ 'default' ] : '';
                $options[ 'placeholder' ] = isset( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : '';

                switch ( $options[ 'type' ] ) {
                    case 'editor':
                        if ( isset( $options[ 'value' ] ) && ! empty( $options[ 'value' ] ) ) {
                            $options[ 'value' ] = wpautop( $options[ 'value' ] );
                        }
                        break;

                    case 'select':
                    case 'select2':
                        if ( isset( $options[ 'multiple' ] ) && $options[ 'multiple' ] ) {
                            // $options[ 'default' ] = array();
                        }
                        break;

                    case 'image':
                        $options[ 'placeholder' ] = ! empty( $options[ 'placeholder' ] ) ? $options[ 'placeholder' ] : 'No Image';
                        $options[ 'size' ]        = isset( $options[ 'size' ] ) ? $options[ 'size' ] : 'full';
                        $options[ 'buttons' ]     = isset( $options[ 'buttons' ] )
                            ? $options[ 'buttons' ]
                            : array(
                                'add'    => 'Use Image',
                                'remove' => 'Remove',
                                'choose' => 'Select',
                            );
                        break;

                    case 'color':
                        $options[ 'alpha' ] = isset( $options[ 'alpha' ] ) ? $options[ 'alpha' ] : FALSE;
                        break;
                }

                return $options;
            }
        }
    endif;