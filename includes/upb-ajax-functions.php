<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Core Ajax Functions
    require_once upb_include_path( 'upb-ajax-core-functions.php' );

    // Posts
    add_action( 'wp_ajax__upb_search_posts', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $result = array();

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            's'              => esc_sql( $_GET[ 'query' ] ),
            'orderby'        => 'title',
            'order'          => 'ASC'
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $result[] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'text'  => get_the_title(),
                );
            }
        }

        wp_reset_postdata();

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_load_posts', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $ids = array_map( 'esc_attr', $_GET[ 'id' ] );


        if ( empty( $ids ) ) {
            wp_send_json_success( array() );
        } else {

            $ids = array_unique( $ids );

            $posts = get_posts( array(
                                    'posts_per_page' => - 1,
                                    'orderby'        => 'ID',
                                    'sort_order'     => 'desc',
                                    'post__in'       => $ids,
                                    'post_type'      => 'post',
                                ) );

            $data = array();
            foreach ( $posts as $post ) :
                $data[] = array(
                    'id'    => $post->ID,
                    'title' => esc_html( $post->post_title ),
                    'text'  => esc_html( $post->post_title )
                );
            endforeach;

            wp_send_json_success( $data );
        }
    } );

    add_action( 'wp_ajax__upb_load_post', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $id = absint( $_GET[ 'id' ] );

        if ( empty( $id ) ) {
            wp_send_json_success( array() );
        } else {
            $post   = get_post( $id );
            $result = array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
            wp_send_json_success( $result );
        }
    } );

    // Pages
    add_action( 'wp_ajax__upb_search_pages', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $result = array();

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'page',
            'post_status'    => 'publish',
            's'              => esc_sql( $_GET[ 'query' ] ),
            'orderby'        => 'title',
            'order'          => 'ASC'
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $result[] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'text'  => get_the_title(),
                );
            }
        }

        wp_reset_postdata();

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_load_pages', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $ids = array_map( 'esc_attr', $_GET[ 'id' ] );


        if ( empty( $ids ) ) {
            wp_send_json_success( array() );
        } else {

            $ids = array_unique( $ids );

            $posts = get_posts( array(
                                    'posts_per_page' => - 1,
                                    'orderby'        => 'ID',
                                    'sort_order'     => 'desc',
                                    'post__in'       => $ids,
                                    'post_type'      => 'page',
                                ) );

            $data = array();
            foreach ( $posts as $post ) :
                $data[] = array(
                    'id'    => $post->ID,
                    'title' => esc_html( $post->post_title ),
                    'text'  => esc_html( $post->post_title )
                );
            endforeach;

            wp_send_json_success( $data );
        }
    } );

    add_action( 'wp_ajax__upb_load_page', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $id = absint( $_GET[ 'id' ] );

        if ( empty( $id ) ) {
            wp_send_json_success( array() );
        } else {
            $post   = get_post( $id );
            $result = array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
            wp_send_json_success( $result );
        }
    } );

    // Material Design Icon Ajax
    add_action( 'wp_ajax__upb_material_icon_search', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $query = esc_html( $_GET[ 'query' ] );

        $icons = upb_material_design_icons();

        $finds = array_filter( $icons, function ( $icon ) use ( $query ) {
            $p = strpos( strtolower( $icon ), $query );

            if ( $p === FALSE ) {
                return FALSE;
            } else {
                return TRUE;
            }
        } );

        $result = array_values( array_map( function ( $icon, $key ) {

            return array( 'id' => $key, 'title' => $icon, 'text' => $icon );

        }, $finds, array_keys( $finds ) ) );

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_material_icon_load', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'id' ] ) ) {
            wp_send_json_success( array() );
        }

        $query = esc_html( $_GET[ 'id' ] );

        $icons = upb_material_design_icons();

        $result = array( 'id' => $query, 'title' => esc_html( $icons[ $query ] ), 'text' => esc_html( $icons[ $query ] ) );

        wp_send_json_success( $result );
    } );

    // FontAwesome Icon Ajax
    add_action( 'wp_ajax__upb_font_awesome_icon_search', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $query = esc_html( $_GET[ 'query' ] );

        $icons = upb_font_awesome_icons();

        $finds = array_filter( $icons, function ( $icon ) use ( $query ) {
            $p = strpos( strtolower( $icon ), $query );

            if ( $p === FALSE ) {
                return FALSE;
            } else {
                return TRUE;
            }
        } );

        $result = array_values( array_map( function ( $icon, $key ) {

            return array( 'id' => $key, 'title' => $icon, 'text' => $icon );

        }, $finds, array_keys( $finds ) ) );

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_font_awesome_icon_load', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'id' ] ) ) {
            wp_send_json_success( array() );
        }

        $query = esc_html( $_GET[ 'id' ] );

        $icons = upb_font_awesome_icons();

        $result = array( 'id' => $query, 'title' => esc_html( $icons[ $query ] ), 'text' => esc_html( $icons[ $query ] ) );

        wp_send_json_success( $result );
    } );

    // Contact form 7 Ajax
    add_action( 'wp_ajax__upb_upb-contact-form-7_preview_contents', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( ! empty( $_POST[ 'id' ] ) ) {
            $short_code = do_shortcode( sprintf( '[contact-form-7 id="%d" title="%s"]', absint( $_POST[ 'id' ] ), esc_html( $_POST[ 'title' ] ) ) );
            wp_send_json_success( $short_code );
        } else {
            wp_send_json_success();
        }
    } );

    add_action( 'wp_ajax__upb_element_upb-contact-form-7_id_search', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $result = array();

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'all',
            's'              => esc_sql( $_GET[ 'query' ] ),
            'orderby'        => 'title',
            'order'          => 'ASC'
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $result[] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'text'  => get_the_title(),
                );
            }
        }

        wp_reset_postdata();

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_element_upb-contact-form-7_id_load', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $id = absint( $_GET[ 'id' ] );

        if ( empty( $id ) ) {
            wp_send_json_success( array() );
        } else {
            $post   = get_post( $id );
            $result = array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
            wp_send_json_success( $result );
        }
    } );

    // Contact form 7 multiple demo Ajax example
    add_action( 'wp_ajax__upb_element_upb-contact-form-7_idx_search', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_GET[ 'query' ] ) ) {
            wp_send_json_error( 'no_search_term', 400 );
        }

        $result = array();

        $args = array(
            'posts_per_page' => 10,
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'all',
            's'              => esc_sql( $_GET[ 'query' ] ),
            'orderby'        => 'title',
            'order'          => 'ASC'
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $result[] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'text'  => get_the_title(),
                );
            }
        }

        wp_reset_postdata();

        wp_send_json_success( $result );
    } );

    add_action( 'wp_ajax__upb_element_upb-contact-form-7_idx_load', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $ids = array_map( 'esc_attr', $_GET[ 'id' ] );


        if ( empty( $ids ) ) {
            wp_send_json_success( array() );
        } else {

            $ids = array_unique( $ids );

            $posts = get_posts( array(
                                    'posts_per_page' => - 1,
                                    'orderby'        => 'ID',
                                    'sort_order'     => 'desc',
                                    'post__in'       => $ids,
                                    'post_type'      => 'wpcf7_contact_form',
                                ) );

            $data = array();
            foreach ( $posts as $post ) :
                $data[] = array(
                    'id'    => $post->ID,
                    'title' => esc_html( $post->post_title ),
                    'text'  => esc_html( $post->post_title )
                );
            endforeach;

            wp_send_json_success( $data );
        }
    } );

    // WP_Widget_Archives
    add_action( 'wp_ajax__upb_upb-wp_widget_archives_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-widget-archives.php line#135
        $instance = wp_parse_args( array(
                                       'title'    => sanitize_text_field( $_POST[ 'title' ] ),
                                       'dropdown' => filter_var( $_POST[ 'dropdown' ], FILTER_VALIDATE_BOOLEAN ),
                                       'count'    => filter_var( $_POST[ 'count' ], FILTER_VALIDATE_BOOLEAN )
                                   ), array(
                                       'title'    => '',
                                       'count'    => 0,
                                       'dropdown' => ''
                                   ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Archives', $instance );

        ob_start();
        the_widget( 'WP_Widget_Archives', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( str_ireplace( 'onchange=', 'data-onchange=', $contents ) );
    } );

    // WP_Nav_Menu_Widget
    add_action( 'wp_ajax__upb_upb-wp_nav_menu_widget_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-nav-menu-widget.php line#95
        $instance = wp_parse_args( array(
                                       'title'    => sanitize_text_field( $_POST[ 'title' ] ),
                                       'nav_menu' => absint( $_POST[ 'nav_menu' ] ),
                                   ), array(
                                       'title'    => '',
                                       'nav_menu' => 0
                                   ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Nav_Menu_Widget', $instance );

        ob_start();
        the_widget( 'WP_Nav_Menu_Widget', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );

    // WP_Widget_Calendar
    add_action( 'wp_ajax__upb_upb-wp_widget_calendar_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-widget-calendar.php line#54
        $instance = wp_parse_args( array(
                                       'title' => sanitize_text_field( $_POST[ 'title' ] )
                                   ),
                                   array(
                                       'title' => ''
                                   ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Calendar', $instance );

        ob_start();
        the_widget( 'WP_Widget_Calendar', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );

    // WP_Widget_Categories
    add_action( 'wp_ajax__upb_upb-wp_widget_categories_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-widget-categories.php line#44
        $instance = wp_parse_args( array(
                                       'title'        => sanitize_text_field( $_POST[ 'title' ] ),
                                       'dropdown'     => filter_var( $_POST[ 'dropdown' ], FILTER_VALIDATE_BOOLEAN ),
                                       'count'        => filter_var( $_POST[ 'count' ], FILTER_VALIDATE_BOOLEAN ),
                                       'hierarchical' => filter_var( $_POST[ 'hierarchical' ], FILTER_VALIDATE_BOOLEAN ),
                                   ), array(
                                       'title'        => esc_html__( 'Categories', 'ultimate-page-builder' ),
                                       'dropdown'     => FALSE,
                                       'count'        => FALSE,
                                       'hierarchical' => FALSE,
                                   ) );


        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Categories', $instance );

        ob_start();
        the_widget( 'WP_Widget_Categories', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );

    // WP_Widget_Categories
    add_action( 'wp_ajax__upb_upb-wp_widget_links_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-widget-categories.php line#44
        $instance = wp_parse_args( array(
                                       'title'       => sanitize_text_field( $_POST[ 'title' ] ),
                                       'category'    => absint( $_POST[ 'category' ] ),
                                       'orderby'     => sanitize_text_field( $_POST[ 'orderby' ] ),
                                       'images'      => filter_var( $_POST[ 'images' ], FILTER_VALIDATE_BOOLEAN ),
                                       'name'        => filter_var( $_POST[ 'name' ], FILTER_VALIDATE_BOOLEAN ),
                                       'description' => filter_var( $_POST[ 'description' ], FILTER_VALIDATE_BOOLEAN ),
                                       'rating'      => filter_var( $_POST[ 'rating' ], FILTER_VALIDATE_BOOLEAN ),
                                       'limit'       => sanitize_text_field( $_POST[ 'limit' ] ),
                                   ),
                                   array(
                                       'title'       => esc_html__( 'Links', 'ultimate-page-builder' ),
                                       'category'    => '',
                                       'orderby'     => 'name',
                                       'images'      => 0,
                                       'name'        => 0,
                                       'description' => 0,
                                       'rating'      => 0,
                                       'limit'       => '-1',
                                   ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Categories', $instance );

        ob_start();
        the_widget( 'WP_Widget_Links', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );

    // WP_Widget_Meta
    add_action( 'wp_ajax__upb_upb-wp_widget_meta_preview_contents', function () {

        upb_check_ajax_access();

        // Check /wp-includes/widgets/class-wp-widget-calendar.php line#54
        $instance = wp_parse_args( array( 'title' => sanitize_text_field( $_POST[ 'title' ] ) ), array( 'title' => '' ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Meta', $instance );

        ob_start();
        the_widget( 'WP_Widget_Meta', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );

    // WP_Widget_Pages
    add_action( 'wp_ajax__upb_upb-wp_widget_pages_preview_contents', function () {

        upb_check_ajax_access();

        $instance = wp_parse_args( array(
                                       'title'   => sanitize_text_field( $_POST[ 'title' ] ),
                                       'sortby'  => sanitize_text_field( $_POST[ 'sortby' ] ),
                                       'exclude' => implode( ',', array_map( 'absint', $_POST[ 'exclude' ] ) ),
                                   ),
                                   array(
                                       'title'   => '',
                                       'sortby'  => 'menu_order',
                                       'exclude' => '',
                                   ) );

        $args = apply_filters( 'upb-element-wp-widget-args', array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widgettitle widget-title">',
            'after_title'   => '</h2>'
        ), 'WP_Widget_Pages', $instance );

        ob_start();
        the_widget( 'WP_Widget_Pages', $instance, $args );
        $contents = ob_get_clean();
        wp_send_json_success( $contents );
    } );