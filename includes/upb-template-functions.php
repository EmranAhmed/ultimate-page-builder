<?php
    defined( 'ABSPATH' ) or die( 'Keep Quit' );

    /**
     * Load Template from theme directory, If not found then load from plugin template
     * directory.
     *
     * @param $template_name
     *
     * @return mixed|void
     */
    function upb_locate_template( $template_name ) {

        $template_path = UPB()->template_dir();
        $default_path  = UPB()->template_path();

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

    function upb_get_template( $template_name, $template_args = array() ) {

        $located = apply_filters( 'upb_get_template', upb_locate_template( $template_name ) );

        do_action( 'upb_before_get_template', $template_name, $template_args );

        extract( $template_args );

        if ( file_exists( $located ) ) {
            include $located;
        } else {
            trigger_error( sprintf( 'Ultimate page builder try to load "%s" but template "%s" not found.', $located, $template_name ), E_USER_WARNING );
        }

        do_action( 'upb_after_get_template', $template_name, $template_args );
    }

    function upb_get_theme_file_path( $file ) {

        $template_dir = UPB()->template_dir();
        $default_path = UPB()->template_path();

        if ( file_exists( get_stylesheet_directory() . '/' . $template_dir . '/' . $file ) ) {
            $path = get_stylesheet_directory() . '/' . $template_dir . '/' . $file;
        } elseif ( file_exists( get_template_directory() . '/' . $template_dir . '/' . $file ) ) {
            $path = get_template_directory() . '/' . $template_dir . '/' . $file;
        } else {
            $path = $default_path . '/' . $file;
        }

        return apply_filters( 'upb_get_theme_file_path', $path, $file );
    }

    function upb_get_theme_file_uri( $file ) {

        $template_dir = UPB()->template_dir();
        $default_uri  = UPB()->template_uri();

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