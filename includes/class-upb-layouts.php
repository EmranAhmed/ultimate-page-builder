<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'UPB_Layouts' ) ):

        class UPB_Layouts {

            private static $instance = NULL;

            private $layouts = array();

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
                return $this->layouts;
            }

            public function getID() {
                return get_the_ID();
            }

            public function register( $layouts ) {

                // title, desc, preview, template

                $layouts[ 'title' ]    = isset( $layouts[ 'title' ] ) ? esc_html( $layouts[ 'title' ] ) : '';
                $layouts[ 'desc' ]     = isset( $layouts[ 'desc' ] ) ? wp_kses_post( $layouts[ 'desc' ] ) : FALSE;
                $layouts[ 'template' ] = isset( $layouts[ 'template' ] ) ? $layouts[ 'template' ] : FALSE;
                $layouts[ 'preview' ]  = isset( $layouts[ 'preview' ] ) ? $layouts[ 'preview' ] : FALSE;

                $this->layouts[] = $layouts;
            }
        }
    endif;