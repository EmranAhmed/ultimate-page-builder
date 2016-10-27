<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	if ( ! class_exists( 'UPB_Customize' ) ):
		class UPB_Customize {

			public $manager;

			public function __construct( WP_Customize_Manager $wp_customize ) {

				$this->manager = $wp_customize;

				if ( ! current_user_can( 'edit_theme_options' ) ) {
					return;
				}

				$this->register_styles( wp_styles() );
				$this->register_scripts( wp_scripts() );

				$this->includes();
				$this->hooks();
			}

			public function includes() {
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-customize-panel.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-customize-setting.php";
				require_once UPB_PLUGIN_INCLUDE_DIR . "class-upb-customize-dynamic-control.php";
			}

			public function hooks() {

				add_filter( 'customize_refresh_nonces', array( $this, 'add_customize_nonce' ) );
				add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_scripts' ) );
				add_action( 'customize_register', array( $this, 'register_types' ), 99 ); // Needs to run after core Navigation section is set up.
				add_action( 'customize_register', array( $this, 'customize_register' ), 99 ); // Needs to run after core Navigation section is set up.


				add_filter( 'customize_dynamic_setting_class', array( $this, 'customize_dynamic_setting_class' ), 5, 3 );
				add_filter( 'customize_dynamic_setting_args', array( $this, 'customize_dynamic_setting_args' ), 10, 2 );


				add_action( 'wp_ajax_upb-generate-settings', array( $this, 'ajax_generate_settings' ) );
				add_action( 'wp_ajax_upb-fetch-settings', array( $this, 'ajax_fetch_settings' ) );


				// Preview
				add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );


			}

			public function customize_dynamic_setting_class( $class, $setting_id, $args ) {
				unset( $setting_id );
				if ( isset( $args[ 'type' ] ) ) {
					if ( 'upb' === $args[ 'type' ] ) {
						if ( isset( $args[ 'setting_class' ] ) ) {
							$class = $args[ 'setting_class' ];
						} else {
							$class = 'UPB_Customize_Setting';
						}
					}
				}

				return $class;
			}

			public function customize_dynamic_setting_args( $args, $setting_id ) {

				if ( preg_match( UPB_Customize_Setting::SETTING_ID_PATTERN, $setting_id, $matches ) ) {

					if ( current_theme_supports( 'ultimate-page-builder' ) ) {
						//	return $args;
					}
					if ( FALSE === $args ) {
						$args = array();
					}

					$args[ 'type' ] = 'upb';
				}

				return $args;
			}


			public function get_post_section_settings( $post_id ) {


				$setting_ids   = array();
				$setting_ids[] = UPB_Customize_Setting::get_post_meta_setting_id( $post_id, 'enable' );
				$setting_ids[] = UPB_Customize_Setting::get_post_meta_setting_id( $post_id, 'display_style' );
				//$setting_ids[] = UPB_Customize_Setting::get_post_meta_setting_id( $post_id, 'elements' );


				$this->manager->add_dynamic_settings( $setting_ids );

				$settings = array();

				//print_r($this->manager->settings()); die(__FILE__);

				foreach ( $this->manager->settings() as $setting ) {
					if ( $setting instanceof UPB_Customize_Setting ) {
						$settings[ $setting->id ] = $setting;
					}
				}

				return $settings;
			}

			public function get_setting_params( UPB_Customize_Setting $setting ) {
				if ( method_exists( $setting, 'json' ) ) { // New in 4.6-alpha.
					$setting_params = $setting->json();
				} else {
					// @codeCoverageIgnoreStart
					$setting_params = array(
						'value'     => $setting->js_value(),
						'transport' => $setting->transport,
						'dirty'     => $setting->dirty,
						'type'      => $setting->type,
					);
					// @codeCoverageIgnoreEnd
				}

				return $setting_params;
			}

			public function ajax_fetch_settings() {

				if ( ! current_user_can( 'customize' ) ) {
					status_header( 403 );
					wp_send_json_error( 'customize_not_allowed' );
				}
				if ( ! check_ajax_referer( 'upb-page-builder', 'upb-page-builder-nonce', FALSE ) ) {
					status_header( 400 );
					wp_send_json_error( 'bad_nonce' );
				}

				$post_id = intval( $_POST[ 'post_id' ] );


				/// Generate Settings


				$settings = $this->get_post_section_settings( $post_id );


				$setting_params = array();
				foreach ( $settings as $setting ) {
					if ( $setting->check_capabilities() ) {
						$setting->preview();
						$setting_params[ $setting->id ] = $this->get_setting_params( $setting );
					}
				}

				wp_send_json_success( $setting_params );

			}

			// make new page settings
			public function ajax_generate_settings() {

			}

			public function add_customize_nonce( $nonces ) {
				$nonces[ 'upb-page-builder' ] = wp_create_nonce( 'upb-page-builder' );

				return $nonces;
			}

			public function customize_scripts() {
				wp_enqueue_style( 'upb-customizer' );
				wp_enqueue_script( 'upb-customizer' );


				// load blocks

				// load elements
				$data = sprintf( 'var _UPB_Elements = %s;', wp_json_encode( UPB_Elements()->get_elements() ) );
				wp_scripts()->add_data( 'upb-customizer', 'data', $data );
			}

			public function customize_preview_scripts() {

				wp_enqueue_style( 'upb-customizer-preview' );
				wp_enqueue_script( 'upb-customizer-preview' );
				wp_enqueue_script( 'upb-elements-customizer-preview' );

				$data = sprintf( 'var _UPB_Page_Data = %s;', wp_json_encode( $this->export_post_data() ) );
				wp_scripts()->add_data( 'upb-customizer-preview', 'data', $data );

				//add_action( 'wp_print_footer_scripts', array( $this, 'current_data' ) );
			}

			public function export_post_data() {
				// Why not wp_localize_script? Because we're not localizing, and it forces values into strings.
				$data = array(
					'id' => get_the_ID(),
				);

				if ( ! empty( $_SERVER[ 'REQUEST_URI' ] ) ) {
					$data[ 'requestUri' ] = esc_url_raw( home_url( wp_unslash( $_SERVER[ 'REQUEST_URI' ] ) ) );
				}

				return $data;
				//printf( '<script>var _UPB_Preview_Data = %s;</script>', wp_json_encode( $data ) );
			}

			public function register_types() {

				// Require JS-rendered control types.
				$this->manager->register_panel_type( 'UPB_Customize_Panel' );
				$this->manager->register_control_type( 'UPB_Customize_Dynamic_Control' );


				// require_once get_template_directory() . '/inc/page-builder/class-starter-page-builder-options-section.php';
				//$this->manager->register_section_type( 'Starter_Page_Builder_Options_Section' );
				//$this->manager->register_section_type( 'Starter_Page_Builder_General_Section' );

			}

			public function customize_register() {

				// Panel
				$this->add_panel( 'upb-panel' );

				// Global Setting Section
				$this->global_section( 'upb-global-section', 'upb-panel' );


				// Page Setting Section: Auto generated

				//// Enable page builder
				////
				//// {
				////    Select Box with conditional
				////    Content + PB Element
				////    Element + Content
				////    Only Element
				//// }

				$this->post_section( 'upb-post-section', 'upb-panel' );

				// Blocks Section

				// Elements Section

				// Layout Section: Auto generated


			}


			public function add_panel( $id ) {

				$panel = new UPB_Customize_Panel( $this->manager, $id, array(
					'title'       => __( 'Page Builder' ),
					'description' => '<p>' . __( 'This panel is used for managing ultimate page builder' ) . '</p>',
					'priority'    => 30,
				) );

				$this->manager->add_panel( $panel );

				return $this;
			}

			public function global_section( $section_id, $panel_id ) {

				$this->manager->add_section( $section_id, array(
					'title'       => __( 'Global Options' ),
					'panel'       => $panel_id,
					'priority'    => 5,
					'description' => 'Global Options',
				) );

				return $this;
			}

			public function post_section( $section_id, $panel_id ) {

				$this->manager->add_section( $section_id, array(
					'title'       => __( 'Page Settings' ),
					'panel'       => $panel_id,
					'priority'    => 15,
					'description' => 'Page Settings Options',
				) );

				return $this;
			}

			public function elements_section( $section_id, $panel_id ) {

				$this->manager->add_section( $section_id, array(
					'title'       => __( 'Elements' ),
					'panel'       => $panel_id,
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

				$handle = 'customize-upb_dynamic-control';
				$src    = trailingslashit( $assets_path ) . "customize-upb_dynamic-control$suffix.js";
				$wp_scripts->add( $handle, $src, array( 'customize-controls' ), FALSE, TRUE );


				$handle = 'upb-customizer';
				$src    = trailingslashit( $assets_path ) . "customizer$suffix.js";

				$wp_scripts->add( $handle, $src, array( 'customize-upb_dynamic-control', 'jquery', 'wp-backbone', 'customize-controls' ), FALSE, TRUE );


				// Preview Scripts
				$handle = 'upb-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "customizer-preview$suffix.js";
				$wp_scripts->add( $handle, $src, array( 'customize-preview', 'wp-util' ), FALSE, TRUE );

				$handle = 'upb-elements-customizer-preview';
				$src    = trailingslashit( $assets_path ) . "upb-elements-customizer-preview$suffix.js";
				$wp_scripts->add( $handle, $src, array( 'upb-customizer-preview' ), FALSE, TRUE );
			}
		}
	endif;