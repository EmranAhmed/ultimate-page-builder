<?php
    defined( 'ABSPATH' ) or die( 'Keep Quit' );

    /**
     * Load Template from theme directory, If not found then load from plugin template
     * directory.
     *
     * @param        $template_name
     * @param string $third_party_path
     *
     * @return mixed|void
     */

    function upb_locate_template( $template_name, $third_party_path = FALSE ) {

        $template_path = UPB()->template_override_dir();
        $default_path  = UPB()->template_path();

        if ( $third_party_path && is_string( $third_party_path ) ) {
            $default_path = untrailingslashit( $third_party_path );
        }

        // Look within passed path within the theme - this is priority.
        $template = locate_template(
            array(
                trailingslashit( $template_path ) . trim( $template_name ),
                'upb-template-' . trim( $template_name )
            )
        );

        // Get default template/
        if ( empty( $template ) ) {
            $template = trailingslashit( $default_path ) . trim( $template_name );
        }

        // Return what we found.
        return apply_filters( 'upb_locate_template', $template, $template_name, $template_path );
    }
	
    function upb_get_template( $template_name, $template_args = array(), $third_party_path = FALSE ) {

        $located = apply_filters( 'upb_get_template', upb_locate_template( $template_name, $third_party_path ) );

        do_action( 'upb_before_get_template', $template_name, $template_args );

        extract( $template_args );

        if ( file_exists( $located ) ) {
            include $located;
        } else {
            trigger_error( sprintf( esc_html__( 'Ultimate page builder try to load "%s" but template "%s" not found.', 'ultimate-page-builder' ), $located, $template_name ), E_USER_WARNING );
        }

        do_action( 'upb_after_get_template', $template_name, $template_args );
    }

    function upb_get_theme_file_path( $file, $third_party_path = FALSE ) {

        $template_dir = UPB()->template_override_dir();
        $default_path = UPB()->template_path();

        if ( $third_party_path && is_string( $third_party_path ) ) {
            $default_path = untrailingslashit( $third_party_path );
        }

        if ( file_exists( get_stylesheet_directory() . '/' . $template_dir . '/' . $file ) ) {
            $path = get_stylesheet_directory() . '/' . $template_dir . '/' . $file;
        } elseif ( file_exists( get_template_directory() . '/' . $template_dir . '/' . $file ) ) {
            $path = get_template_directory() . '/' . $template_dir . '/' . $file;
        } else {
            $path = $default_path . '/' . $file;
        }

        return apply_filters( 'upb_get_theme_file_path', $path, $file );
    }

    function upb_get_theme_file_uri( $file, $third_party_uri = FALSE ) {

        $template_dir = UPB()->template_override_dir();
        $default_uri  = UPB()->template_uri();

        if ( $third_party_uri && is_string( $third_party_uri ) ) {
            $default_uri = untrailingslashit( $third_party_uri );
        }

        if ( file_exists( get_stylesheet_directory() . '/' . $template_dir . '/' . $file ) ) {
            $uri = get_stylesheet_directory_uri() . '/' . $template_dir . '/' . $file;
        } elseif ( file_exists( get_template_directory() . '/' . $template_dir . '/' . $file ) ) {
            $uri = get_template_directory_uri() . '/' . $template_dir . '/' . $file;
        } else {
            $uri = $default_uri . '/' . $file;
        }

        return apply_filters( 'upb_get_theme_file_uri', $uri, $file );
    }


    //get_theme_file_uri(); 4.7
    //get_theme_file_path(); 4.7