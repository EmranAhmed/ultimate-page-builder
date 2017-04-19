<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'UPB_List_Util' ) ):
        class UPB_List_Util extends WP_List_Util {

            private $input  = array();
            private $output = array();

            public function __construct( $input ) {

                parent::__construct( $input );
                $this->output = $this->input = $input;
            }

            /**
             * Plucks a certain field out of each object in the list.
             */
            public function pluck( $field, $index_key = NULL ) {

                if ( ! $index_key ) {
                    /*
                     * This is simple. Could at some point wrap array_column()
                     * if we knew we had an array of arrays.
                     */
                    foreach ( $this->output as $key => $value ) {
                        if ( is_object( $value ) ) {
                            if ( is_array( $field ) ) {
                                foreach ( $field as $val ) {
                                    $this->output[ $key ][ $val ] = $value->$val;
                                }
                            } else {
                                $this->output[ $key ] = $value->$field;
                            }
                        } else {
                            if ( is_array( $field ) ) {
                                foreach ( $field as $val ) {
                                    $this->output[ $key ][ $val ] = $value[ $val ];
                                }
                            } else {
                                $this->output[ $key ] = $value[ $field ];
                            }
                        }
                    }

                    return $this->output;
                }

                /*
                 * When index_key is not set for a particular item, push the value
                 * to the end of the stack. This is how array_column() behaves.
                 */
                $newlist = array();

                foreach ( $this->output as $value ) {
                    if ( is_object( $value ) ) {
                        if ( isset( $value->$index_key ) ) {
                            if ( is_array( $field ) ) {
                                foreach ( $field as $val ) {
                                    $newlist[ $value->$index_key ][ $val ] = isset( $value->$val ) ? $value->$val : NULL;
                                }
                            } else {
                                $newlist[ $value->$index_key ] = isset( $value->$field ) ? $value->$field : NULL;
                            }
                        } else {
                            if ( is_array( $field ) ) {
                                foreach ( $field as $val ) {
                                    $newlist[][ $val ] = isset( $value->$val ) ? $value->$val : NULL;
                                }
                            } else {
                                $newlist[] = isset( $value->$field ) ? $value->$field : NULL;
                            }
                        }
                    } else {
                        if ( isset( $value[ $index_key ] ) ) {

                            if ( is_array( $field ) ) {
                                foreach ( $field as $val ) {
                                    $newlist[ $value[ $index_key ] ][ $val ] = isset( $value[ $val ] ) ? $value[ $val ] : NULL;
                                }
                            } else {
                                $newlist[ $value[ $index_key ] ] = isset( $value[ $field ] ) ? $value[ $field ] : NULL;
                            }

                        } else {
                            if ( is_array( $field ) ) {
                                foreach ( $value[ $field ] as $val ) {
                                    $newlist[][ $val ] = isset( $value[ $val ] ) ? $value[ $val ] : NULL;
                                }
                            } else {
                                $newlist[] = isset( $value[ $field ] ) ? $value[ $field ] : NULL;
                            }
                        }
                    }
                }

                $this->output = $newlist;

                return $this->output;
            }
        }
    endif;