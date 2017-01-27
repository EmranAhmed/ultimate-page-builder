<?php
    /**
     * Plugin Name: Ultimate Page Builder
     * Plugin URI: https://wordpress.org/plugins/ultimate-page-builder/
     * Description: An Incredibly easiest and highly customizable drag and drop page builder helps create professional websites without writing a line of code.
     * Author: Emran Ahmed
     * Version: 1.0.0-beta.11
     * Domain Path: /languages
     * Text Domain: ultimate-page-builder
     * Author URI: https://themehippo.com/
     */

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if ( ! class_exists( 'Ultimate_Page_Builder' ) ):

        final class Ultimate_Page_Builder {

            protected static $_instance = NULL;

            private $_enabled = FALSE;

            public static function init() {
                if ( is_null( self::$_instance ) ) {
                    self::$_instance = new self();
                }

                return self::$_instance;
            }

            public function __construct() {

                $this->constants();
                $this->includes();
                $this->hooks();

                do_action( 'ultimate_page_builder_loaded', $this );
            }

            public function constants() {
                define( 'UPB_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
                define( 'UPB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

                define( 'UPB_PLUGIN_ASSETS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
                define( 'UPB_PLUGIN_VENDOR_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'vendor' ) );

                define( 'UPB_PLUGIN_ELEMENTS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'elements' ) );
                define( 'UPB_PLUGIN_ELEMENTS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'elements' ) );

                define( 'UPB_PLUGIN_INCLUDE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
                define( 'UPB_PLUGIN_TEMPLATES_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'templates' ) );
                define( 'UPB_PLUGIN_TEMPLATES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'templates' ) );

                define( 'UPB_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
                define( 'UPB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
                define( 'UPB_PLUGIN_FILE', __FILE__ );
            }

            public function includes() {

                if ( $this->has_required_php_version() ) {
                    // Common
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-functions.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-icon-functions.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-template-functions.php";

                    // Defines
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-elements.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-settings.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-layouts.php";

                    // TABS
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-tabs.php";

                    // Settings
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-settings.php";

                    // Elements
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-elements.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-elements-props.php";

                    // Layouts
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-layouts.php";

                    // Boilerplate
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-boilerplate.php";


                    // Preview
                    require_once UPB_PLUGIN_INCLUDE_PATH . "class-upb-preview.php";

                    // Load
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-hooks.php";
                    require_once UPB_PLUGIN_INCLUDE_PATH . "upb-ajax-functions.php";
                }
            }

            public function hooks() {
                add_action( 'admin_notices', array( $this, 'php_requirement_notice' ) );
                add_action( 'init', array( $this, 'language' ) );

                if ( $this->has_required_php_version() ) {
                    add_action( 'wp', array( $this, 'upb_enabled' ) );
                    add_action( 'wp', array( $this, 'ui_functions' ), 11 );
                    add_action( 'send_headers', array( $this, 'no_cache_headers' ) );
                    add_filter( 'page_row_actions', array( $this, 'add_row_actions' ), 10, 2 );
                    add_filter( 'post_row_actions', array( $this, 'add_row_actions' ), 10, 2 );

                    // Show UPB Button
                    add_action( 'media_buttons', array( $this, 'action_media_buttons' ) );

                    add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
                }
            }

            public function after_setup_theme() {
                if ( upb_is_preview_request() || upb_is_boilerplate_request() ) {
                    show_admin_bar( FALSE );
                }

                if ( upb_is_preview_request() ) {
                    do_action( 'after_setup_theme_preview' );
                }
                if ( upb_is_boilerplate_request() ) {
                    do_action( 'after_setup_theme_boilerplate' );
                }
            }

            public function action_media_buttons( $editor_id ) {

                global $post_type, $post;

                if ( $this->is_page_allowed( $post ) && in_array( $post_type, $this->get_allowed_post_types() ) ) {
                    printf( '<a href="%s" class="button load-ultimate-page-builder">' .
                            '<span class="wp-media-buttons-icon dashicons dashicons-hammer"></span> %s' .
                            '</a>',
                            upb_get_edit_link(),
                            esc_html__( 'Edit with Ultimate Page Builder', 'ultimate-page-builder' )
                    );
                }
            }

            public function has_required_php_version() {
                return version_compare( PHP_VERSION, '5.5' ) >= 0;
            }

            public function php_requirement_notice() {
                if ( ! $this->has_required_php_version() ) {
                    $class   = 'notice notice-error';
                    $text    = esc_html__( 'Please check PHP version requirement.', 'ultimate-page-builder' );
                    $link    = esc_url( 'https://wordpress.org/about/requirements/' );
                    $message = wp_kses( __( "<strong>Ultimate Page Builder</strong> require PHP 5.5 or above.", 'ultimate-page-builder' ), array( 'strong' => array() ) );

                    printf( '<div class="%1$s"><p>%2$s <a target="_blank" href="%3$s">%4$s</a></p></div>', $class, $message, $link, $text );
                }
            }

            public function is_page_allowed( $post ) {

                if ( is_object( $post ) ) {

                    $posts = array_unique( array(
                                               get_option( 'page_for_posts' ),
                                               get_option( 'woocommerce_shop_page_id' ),
                                               get_option( 'woocommerce_cart_page_id' ),
                                               get_option( 'woocommerce_checkout_page_id' ),
                                               get_option( 'woocommerce_pay_page_id' ),
                                               get_option( 'woocommerce_thanks_page_id' ),
                                               get_option( 'woocommerce_myaccount_page_id' ),
                                               get_option( 'woocommerce_edit_address_page_id' ),
                                               get_option( 'woocommerce_view_order_page_id' ),
                                               get_option( 'woocommerce_terms_page_id' ),
                                           ) );

                    $non_allowed_post_ids = apply_filters( 'upb_non_allowed_pages', $posts );

                    //print_r($non_allowed_post_ids);
                    if ( in_array( $post->ID, $non_allowed_post_ids ) ) {
                        return FALSE;
                    }
                }

                return TRUE;
            }

            public function add_row_actions( $actions, $post ) {

                if ( upb_is_buildable( $post ) ) {
                    $actions[ 'edit_with_upb' ] = sprintf( '<a href="%s">%s</a>', upb_get_edit_link( $post ), esc_html__( 'Edit with Ultimate Page Builder', 'ultimate-page-builder' ) );
                }

                return $actions;
            }

            public function get_post( $post_id = '' ) {

                // Allow pass through of full post objects
                if ( isset( $post_id->ID ) ) {
                    return $post_id;
                }

                // Get post by ID
                if ( is_int( $post_id ) ) {
                    return get_post( $post_id );
                }

                // Or, in the dashboard use a query string
                if ( is_admin() && isset( $_GET[ 'post' ] ) ) {
                    return get_post( $_GET[ 'post' ] );
                }

                // Or, use the queried object
                if ( '' == $post_id ) {
                    $post = get_queried_object();
                    if ( is_a( $post, 'WP_POST' ) ) {
                        return $post;
                    }
                }

                // Otherwise there's just no way...

                return FALSE;

            }

            public function get_allowed_post_types() {
                return apply_filters( 'upb_allowed_post_types', array( 'page' ) );
            }

            public function is_post_type_allowed( $post_id = '' ) {
                $post = $this->get_post( $post_id );

                return ( $this->is_page_allowed( $post ) && $post && in_array( $post->post_type, $this->get_allowed_post_types() ) );
            }

            public function ui_functions() {
                if ( upb_is_preview() or upb_is_boilerplate() ):
                    // Tell W3TC not to minify while the builder is active.
                    define( 'DONOTMINIFY', TRUE );
                    // Tell Autoptimize not to minify while the builder is active.
                    add_filter( 'autoptimize_filter_noptimize', '__return_true' );
                endif;
            }

            public function no_cache_headers() {
                if ( upb_is_preview() or upb_is_boilerplate() ):
                    header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
                    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
                    header( 'Cache-Control: post-check=0, pre-check=0', FALSE );
                    header( 'Pragma: no-cache' );
                    header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
                endif;
            }

            public function upb_enabled() {

                $enable = upb_return_boolean( get_post_meta( get_the_ID(), '_upb_settings_page_enable', TRUE ) );

                if ( ! upb_is_preview() && $enable && $this->is_post_type_allowed() ) {
                    $this->_enabled = TRUE;
                }
            }

            public function is_enabled() {
                return $this->_enabled;
            }

            public function language() {
                load_plugin_textdomain( 'ultimate-page-builder', FALSE, trailingslashit( UPB_PLUGIN_DIRNAME ) . 'languages' );
            }

            public function template_path() {
                return apply_filters( 'upb_template_path', untrailingslashit( $this->plugin_path() ) . '/templates' );
            }

            public function template_uri() {
                return apply_filters( 'upb_template_uri', untrailingslashit( $this->plugin_uri() ) . '/templates' );
            }

            public function plugin_path() {
                return untrailingslashit( plugin_dir_path( __FILE__ ) );
            }

            public function plugin_basename() {
                return plugin_basename( __FILE__ );
            }

            public function template_dir() {
                return apply_filters( 'upb_template_dir', 'upb-templates' );
            }

            public function plugin_uri() {
                return untrailingslashit( plugins_url( '/', __FILE__ ) );
            }
        }

        function UPB() {
            return Ultimate_Page_Builder::init();
        }

        // Global for backwards compatibility.
        $GLOBALS[ 'ultimate_page_builder' ] = UPB();

    endif;