<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	if ( ! class_exists( 'UPB_Customizer' ) ):
		class UPB_Customizer {

			public $manager;

			public function __construct( $wp_customize ) {

				$this->manager = $wp_customize;


				if ( ! current_user_can( 'edit_theme_options' ) ) {
					return;
				}


				$this->register_styles();
				$this->register_scripts();


				add_action( 'customize_controls_enqueue_scripts', array( $this, 'load_customize_scripts' ) );
				add_action( 'customize_register', array( $this, 'customize_register_types' ), 99 ); // Needs to run after core Navigation section is set up.
				add_action( 'customize_register', array( $this, 'customize_register' ), 99 ); // Needs to run after core Navigation section is set up.
				// add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_templates' ) );
				// add_action( 'customize_controls_print_footer_scripts', array( $this, 'available_items_template' ) );


				// Preview
				add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
				// add_action( 'customize_update_page_builder_settings', array( $this, 'update_page_builder_settings' ), 20, 2 );

			}

			public function load_customize_scripts() {
				wp_enqueue_style( 'upb-customizer' );
				wp_enqueue_script( 'upb-customizer' );


				// load blocks

				// load elements
				$data = sprintf( 'var _UPB_Elements = %s;', json_encode( UPB_Elements()->get_elements() ) );
				wp_scripts()->add_data( 'upb-customizer', 'data', $data );
			}

			public function load_customize_preview_scripts() {

				wp_enqueue_style( 'upb-customizer-preview' );

				wp_enqueue_script( 'upb-customizer-preview' );
				wp_enqueue_script( 'upb-elements-customizer-preview' );


				$data = sprintf( 'var _UPB_Preview_Data = %s;', json_encode( $this->current_data() ) );
				wp_scripts()->add_data( 'upb-customizer-preview', 'data', $data );
				
				//add_action( 'wp_print_footer_scripts', array( $this, 'current_data' ) );
			}

			function current_data() {
				// Why not wp_localize_script? Because we're not localizing, and it forces values into strings.
				$data = array(
					'id' => get_the_ID(),
					//'options'  => array(),
					//'contents' => '[row]contents[/row]',
				);

				if ( ! empty( $_SERVER[ 'REQUEST_URI' ] ) ) {
					$data[ 'requestUri' ] = esc_url_raw( home_url( wp_unslash( $_SERVER[ 'REQUEST_URI' ] ) ) );
				}

				return $data;
				//printf( '<script>var _UPB_Preview_Data = %s;</script>', wp_json_encode( $data ) );
			}

			public function customize_register_types() {

			}

			public function customize_register() {

			}


			public function customize_preview_init() {
				add_action( 'wp_enqueue_scripts', array( $this, 'load_customize_preview_scripts' ) );
			}


			public function register_styles() {

				$assets_path = UPB_PLUGIN_ASSETS_URL . 'css';

				$suffix = SCRIPT_DEBUG ? '' : '.min';

				$handle = 'upb-customizer';
				$src    = trailingslashit( $assets_path ) . "customizer.min.css";
				wp_register_style( $handle, $src );
				// $handle, $src, $deps = array(), $ver = false, $media = 'all'

				$handle = 'upb-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "customizer-preview.min.css";
				wp_register_style( $handle, $src );
			}

			public function register_scripts() {

				$assets_path = UPB_PLUGIN_ASSETS_URL . 'js';

				$suffix = SCRIPT_DEBUG ? '' : '.min';

				// Customizer Scripts
				//$handle = 'vue';
				//$src    = trailingslashit( $assets_path ) . "vue$suffix.js";
				//wp_register_script( $handle, $src, array(), '', TRUE );

				$handle = 'upb-customizer';
				$src    = trailingslashit( $assets_path ) . "customizer.min.js";
				wp_register_script( $handle, $src, array( 'jquery', 'wp-backbone', 'customize-controls' ), '', TRUE );
				// $handle, $src, $deps = array(), $ver = false, $in_footer = false


				// Preview Scripts
				$handle = 'upb-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "customizer-preview.min.js";
				wp_register_script( $handle, $src, array( 'customize-preview', 'wp-util' ), '', TRUE );


				$handle = 'upb-elements-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "upb-elements-customizer-preview.min.js";
				wp_register_script( $handle, $src, array( 'upb-customizer-preview' ), '', TRUE );


			}


		}
	endif;



