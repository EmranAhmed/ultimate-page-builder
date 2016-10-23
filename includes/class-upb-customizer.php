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

				$this->register_styles( wp_styles() );
				$this->register_scripts( wp_scripts() );

				//

				$this->includes();
				$this->hooks();
			}

			public function includes() {
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-customizer-panel.php";
			}

			public function hooks() {
				add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_scripts' ) );
				add_action( 'customize_register', array( $this, 'register_types' ), 99 ); // Needs to run after core Navigation section is set up.
				add_action( 'customize_register', array( $this, 'customize_register' ), 99 ); // Needs to run after core Navigation section is set up.
				// add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_templates' ) );
				// add_action( 'customize_controls_print_footer_scripts', array( $this, 'available_items_template' ) );


				// Preview
				add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
				// add_action( 'customize_update_page_builder_settings', array( $this, 'update_page_builder_settings' ), 20, 2 );

			}

			public function customize_scripts() {
				wp_enqueue_style( 'upb-customizer' );
				wp_enqueue_script( 'upb-customizer' );


				// load blocks

				// load elements
				$data = sprintf( 'var _UPB_Elements = %s;', json_encode( UPB_Elements()->get_elements() ) );
				wp_scripts()->add_data( 'upb-customizer', 'data', $data );
			}

			public function customize_preview_scripts() {

				wp_enqueue_style( 'upb-customizer-preview' );

				wp_enqueue_script( 'upb-customizer-preview' );
				wp_enqueue_script( 'upb-elements-customizer-preview' );

				$data = sprintf( 'var _UPB_Page_Data = %s;', json_encode( $this->export_post_data() ) );
				wp_scripts()->add_data( 'upb-customizer-preview', 'data', $data );

				//add_action( 'wp_print_footer_scripts', array( $this, 'current_data' ) );
			}

			public function export_post_data() {
				// Why not wp_localize_script? Because we're not localizing, and it forces values into strings.
				$data = array(
					'id'      => get_the_ID(),
					'enabled' => get_post_meta( get_the_ID(), 'upb_enabled', TRUE )
				);

				if ( ! empty( $_SERVER[ 'REQUEST_URI' ] ) ) {
					$data[ 'requestUri' ] = esc_url_raw( home_url( wp_unslash( $_SERVER[ 'REQUEST_URI' ] ) ) );
				}

				return $data;
				//printf( '<script>var _UPB_Preview_Data = %s;</script>', wp_json_encode( $data ) );
			}

			public function register_types() {
				// Require JS-rendered control types.
				$this->manager->register_panel_type( 'UPB_Customizer_Panel' );


				// require_once get_template_directory() . '/inc/page-builder/class-starter-page-builder-options-section.php';
				//$this->manager->register_section_type( 'Starter_Page_Builder_Options_Section' );
				//$this->manager->register_section_type( 'Starter_Page_Builder_General_Section' );

			}

			public function customize_register() {

				// Panel
				$this->add_panel();

				// Global Setting Section
				$this->global_section();

				// Page Setting Section: Auto generated

				// enable page builder
				//

				$this->post_section();

				// Blocks Section

				// Elements Section

				// Layout Section: Auto generated


			}


			public function add_panel() {

				$panel = new UPB_Customizer_Panel( $this->manager, 'upb-panel', array(
					'title'       => __( 'Page Builder' ),
					'description' => '<p>' . __( 'This panel is used for managing ultimate page builder' ) . '</p>',
					'priority'    => 30,
				) );

				$this->manager->add_panel( $panel );

				return $this;
			}

			public function global_section() {

				$this->manager->add_section( 'upb-global-section', array(
					'title'       => __( 'Global Options' ),
					'panel'       => 'upb-panel',
					'priority'    => 5,
					'description' => 'Global Options',
				) );

				return $this;
			}

			public function post_section() {

				$this->manager->add_section( 'upb-post-section', array(
					'title'       => __( 'Page Settings' ),
					'panel'       => 'upb-panel',
					'priority'    => 15,
					'description' => 'Global Options',
				) );

				return $this;
			}


			public function elements_section() {

				$this->manager->add_section( 'upb-elements-section', array(
					'title'       => __( 'Elements' ),
					'panel'       => 'upb-panel',
					'priority'    => 10,
					'description' => '',
				) );

				return $this;
			}


			public function customize_preview_init() {
				add_action( 'wp_enqueue_scripts', array( $this, 'customize_preview_scripts' ) );
			}

			public function register_styles( WP_Styles $wp_styles ) {

				$assets_path = UPB_PLUGIN_ASSETS_URL . 'css';

				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

				$handle = 'upb-customizer';
				$src    = trailingslashit( $assets_path ) . "customizer$suffix.css";
				$wp_styles->add( $handle, $src );

				$handle = 'upb-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "customizer-preview$suffix.css";
				$wp_styles->add( $handle, $src );
			}

			public function register_scripts( WP_Scripts $wp_scripts ) {

				$assets_path = UPB_PLUGIN_ASSETS_URL . 'js';

				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

				$handle = 'upb-customizer';
				$src    = trailingslashit( $assets_path ) . "customizer$suffix.js";
				$args   = array(
					'in_footer' => TRUE,
				);
				$wp_scripts->add( $handle, $src, array( 'jquery', 'wp-backbone', 'customize-controls' ), FALSE, $args );

				// Preview Scripts
				$handle = 'upb-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "customizer-preview$suffix.js";
				$wp_scripts->add( $handle, $src, array( 'customize-preview', 'wp-util' ), FALSE, $args );

				$handle = 'upb-elements-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "upb-elements-customizer-preview$suffix.js";
				$wp_scripts->add( $handle, $src, array( 'upb-customizer-preview' ), FALSE, $args );
			}
		}
	endif;



