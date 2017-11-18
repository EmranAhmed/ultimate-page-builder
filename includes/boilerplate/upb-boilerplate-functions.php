<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    function upb_boilerplate_body_class( $class = '' ) {

        $classes = array( 'wp-core-ui', 'upb-boilerplate' );
        if ( wp_is_mobile() ) {
            array_push( $classes, 'mobile' );
        }
        if ( upb_is_ios() ) {
            array_push( $classes, 'ios' );
        }

        if ( is_rtl() ) {
            array_push( $classes, 'rtl' );
        }

        array_push( $classes, 'locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) ) );

        if ( ! empty( $class ) ) {
            array_push( $classes, $class );
        }

        echo esc_attr( implode( ' ', apply_filters( 'upb_boilerplate_body_class', array_unique( $classes ) ) ) );

    }

    function upb_boilerplate_title() {
        echo sprintf( '%s &rightarrow; %s', esc_html( 'Ultimate Page Builder' ), esc_html( get_the_title() ) );
    }

    function upb_editor_allow_br_tags( $init ) {
        $init[ 'forced_root_block' ] = FALSE;

        return $init;
    }

    function upb_load_wp_editor() {

        // Remove all 3rd party integrations to prevent plugin conflicts.
        remove_all_actions( 'before_wp_tiny_mce' );
        remove_all_filters( 'mce_external_plugins' );
        remove_all_filters( 'mce_buttons' );
        remove_all_filters( 'tiny_mce_before_init' );
        add_filter( 'tiny_mce_before_init', '_mce_set_direction' );

        // Editor is modified
        add_filter( 'user_can_richedit', '__return_true' );

        if ( apply_filters( 'upb_use_br_tags', FALSE ) ) {
            add_filter( 'tiny_mce_before_init', 'upb_editor_allow_br_tags' );
        }

        // Allow integrations to use hooks above before the editor is primed.
        do_action( 'upb_before_wp_editor' );

        ob_start();
        wp_editor( '%%UPB_EDITOR_CONTENTS%%',
                   'upb-editor-template',
                   apply_filters( 'upb_editor_template_settings', array(
                       'quicktags'        => array(
                           'buttons' => 'strong,em,del,ul,ol,li,close,fullscreen'
                       ), // note that spaces in this list seem to cause an issue
                       'teeny'            => TRUE,
                       'textarea_rows'    => get_option( 'default_post_edit_rows', 10 ),
                       'tinymce'          => array(
                           'toolbar1' => 'bold,italic,underline,bullist,numlist,wp_adv,wp_fullscreen,fullscreen',
                           'toolbar2' => 'strikethrough,forecolor,link,unlink,alignleft,aligncenter,alignright,alignjustify,outdent,indent',
                           'toolbar3' => 'formatselect,pastetext,removeformat,charmap,undo,redo'
                       ),
                       'editor_class'     => 'upb-wp-editor',
                       'drag_drop_upload' => TRUE
                   ) )
        );

        return ob_get_clean();
    }

    function upb_wp_editor_template() {
        // return upb_load_wp_editor();
	    return '';
    }

    function upb_allowed_attributes() {
        $tags = wp_kses_allowed_html( 'post' );

        $attrs = array();
        foreach ( $tags as $tag => $attr ) {
            if ( ! isset( $attrs[ $tag ] ) ) {
                $attrs[ $tag ] = array();
            }

            $attrs[ $tag ] = array_keys( $attr );
        }

        return $attrs;
    }
