<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // AJAX Requests
    add_action( 'wp_ajax__upb_save', function () {

        // Should have edit_pages cap :)
        if ( ! current_user_can( 'edit_pages' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( ! is_array( $_POST[ 'states' ] ) ) {
            wp_send_json_error( 'missing_contents', 400 );
        }

        // SAVE ON PAGE META :D

        $post_id = absint( $_POST[ 'id' ] );

        if ( ! empty( $_POST[ 'shortcode' ] ) ) {

            $sections   = wp_kses_post_deep( $_POST[ 'states' ][ 'sections' ] );
            $shortcodes = wp_kses_post( trim( $_POST[ 'shortcode' ] ) );

            update_post_meta( $post_id, '_upb_sections', $sections );
            update_post_meta( $post_id, '_upb_shortcodes', $shortcodes );
        } else {
            delete_post_meta( $post_id, '_upb_sections' );
            delete_post_meta( $post_id, '_upb_shortcodes' );
        }

        $settings = wp_kses_post_deep( $_POST[ 'states' ][ 'settings' ] );
        upb_settings()->set_settings( $settings );

        wp_send_json_success( TRUE );

    } );

    // Section Template Save
    add_action( 'wp_ajax__save_section', function () {

        // Should have manage_options cap :)
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_POST[ 'contents' ] ) || ! is_array( $_POST[ 'contents' ] ) ) {
            wp_send_json_error( 'missing_contents', 400 );
        }

        $sections   = (array) get_option( '_upb_saved_sections', array() );
        $sections[] = wp_kses_post_deep( stripslashes_deep( $_POST[ 'contents' ] ) );

        $update = update_option( '_upb_saved_sections', $sections, FALSE );

        wp_send_json_success( $update );
    } );

    // Modify Saved Template
    add_action( 'wp_ajax__save_section_all', function () {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_POST[ 'contents' ] ) ) {
            $update = update_option( '_upb_saved_sections', array(), FALSE );
        } else {
            $sections = (array) wp_kses_post_deep( $_POST[ 'contents' ] );
            $update   = update_option( '_upb_saved_sections', $sections, FALSE );
        }

        wp_send_json_success( $update );
    } );

    // Panel Contents
    add_action( 'wp_ajax__get_upb_sections_panel_contents', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $post_id = absint( $_POST[ 'id' ] );

        $sections = get_post_meta( $post_id, '_upb_sections', TRUE );

        wp_send_json_success( upb_elements()->set_upb_options_recursive( $sections ) );

    } );

    add_action( 'wp_ajax__get_upb_settings_panel_contents', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        // return get_post_meta( get_the_ID(), '_upb_settings', TRUE );

        wp_send_json_success( upb_settings()->getAll() );
    } );

    add_action( 'wp_ajax__get_upb_elements_panel_contents', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        //wp_send_json_success( upb_elements()->getNonCore() );
        wp_send_json_success( upb_elements()->getAll() );
    } );

    add_action( 'wp_ajax__get_upb_layouts_panel_contents', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        wp_send_json_success( upb_layouts()->getAll() );
    } );

    // Get Saved Section
    add_action( 'wp_ajax__get_saved_sections', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        $saved_sections = (array) get_option( '_upb_saved_sections', array() );

        $saved_sections = upb_elements()->set_upb_options_recursive( wp_kses_post_deep( stripslashes_deep( $saved_sections ) ) );

        wp_send_json_success( $saved_sections );
    } );

    add_action( 'wp_ajax__add_upb_options', function () {

        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( empty( $_POST[ 'contents' ] ) ) {
            wp_send_json_error( 'no_contents', 400 );
        }

        $contents = upb_elements()->set_upb_options_recursive( wp_kses_post_deep( stripslashes_deep( $_POST[ 'contents' ] ) ) );

        wp_send_json_success( $contents );
    } );

    // Normal Post
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

    add_filter( '_upb_get_post', function ( $id ) {

        if ( empty( $id ) ) {
            return array();
        }

        $post = get_post( absint( $id ) );

        return array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
    } );

    // Icon Ajax
    add_action( 'wp_ajax__upb_search_material_icons', function () {
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

            // $pattern = "@${$query}@i";
            // preg_match_all( $pattern, $icon, $matches );

            $p = strpos( $icon, $query );

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

    add_filter( '_upb_get_material_icon', function ( $id ) {

        if ( empty( $id ) ) {
            return array();
        }

        $icons = upb_material_design_icons();

        return array( 'id' => $id, 'title' => esc_html( $icons[ $id ] ), 'text' => esc_html( $icons[ $id ] ) );
    } );


    // Contact form 7 Post
    add_action( 'wp_ajax__upb_contact_form7_preview', function () {
        if ( ! current_user_can( 'customize' ) ) {
            wp_send_json_error( 'upb_not_allowed', 403 );
        }

        if ( ! check_ajax_referer( '_upb', '_nonce', FALSE ) ) {
            wp_send_json_error( 'bad_nonce', 400 );
        }

        if ( ! empty( $_POST[ 'id' ] ) ) {

            $short_code = do_shortcode( sprintf( '[contact-form-7 id="%d" title="%s"]', $_POST[ 'id' ], esc_html( $_POST[ 'title' ] ) ) );

            wp_send_json_success( $short_code );
        } else {
            wp_send_json_success( '' );
        }
    } );

    add_action( 'wp_ajax__upb_search_contact_form7', function () {
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

    add_filter( '_upb_get_contact_form7', function ( $id ) {

        if ( empty( $id ) ) {
            return array();
        }

        $post = get_post( absint( $id ) );

        return array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
    } );