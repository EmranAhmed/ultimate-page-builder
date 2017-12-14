<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	if ( ! class_exists( 'UPB_Preview' ) ):
		
		class UPB_Preview {
			
			protected static $_instance = NULL;
			
			public static function init() {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self();
				}
				
				return self::$_instance;
			}
			
			public function __construct() {
				$this->includes();
				$this->hooks();
				
				do_action( 'upb_preview_init', $this );
			}
			
			public function includes() {
				require_once UPB_PLUGIN_INCLUDE_PATH . "preview/upb-preview-hooks.php";
				require_once UPB_PLUGIN_INCLUDE_PATH . "preview/upb-preview-functions.php";
			}
			
			public function hooks() {
				add_action( 'wp', array( $this, 'after_wp_setup' ) );
				// After Long Journey We show preview content
				add_filter( 'the_content', array( $this, 'preview_content' ), 9999999 );
			}
			
			public function after_wp_setup() {
				if ( upb_is_preview() ):
					do_action( 'upb_preview_loaded', $this );
				endif;
			}
			
			public function preview_content( $content ) {
				
				if ( upb_is_preview() ):
					$contents = array(
						'before'  => apply_filters( 'upb_before_preview_content', '' ),
						'content' => apply_filters( 'upb_preview_content', $content ),
						'after'   => apply_filters( 'upb_after_preview_content', '' )
					);
					
					return apply_filters( 'upb_preview_contents', implode( '', $contents ), $contents, $content );
				
				endif;
				
				return $content;
			}
		}
		
		UPB_Preview::init();
	endif;