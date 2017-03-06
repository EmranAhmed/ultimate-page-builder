<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! current_user_can( 'customize' ) ) :
    wp_die(
        '<h1>' . esc_html__( 'Cheatin&#8217; uh?', 'ultimate-page-builder' ) . '</h1>' .
        '<p>' . esc_html__( 'Sorry, you are not allowed to build this page with Ultimate Page Builder', 'ultimate-page-builder' ) . '</p>',
        403
    );
endif;


// Load Styles and Scripts
//add_action( 'upb_boilerplate_print_scripts', 'print_head_scripts', 10 );

add_action( 'upb_boilerplate_print_scripts', 'wp_print_head_scripts' );

//add_action( 'upb_boilerplate_print_scripts', '_print_scripts' );

//add_action( 'upb_boilerplate_print_footer_scripts', '_wp_footer_scripts' );

add_action( 'upb_boilerplate_print_footer_scripts', 'wp_print_footer_scripts' );

//add_action( 'upb_boilerplate_print_footer_scripts', 'print_footer_scripts' );

add_action( 'upb_boilerplate_print_footer_scripts', 'wp_underscore_playlist_templates' );
add_action( 'upb_boilerplate_print_footer_scripts', 'wp_print_media_templates' );

add_action( 'upb_boilerplate_print_styles', 'wp_print_styles' );
// add_action( 'upb_boilerplate_print_styles', 'print_admin_styles' );

do_action( 'upb_boilerplate_template_init' );

do_action( 'upb_boilerplate_enqueue_scripts' );

// Let's roll.
@header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );

wp_user_settings();

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo get_option( 'blog_charset' ); ?>">
    <?php if ( upb_is_ie() ): ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <?php endif; ?>
    <?php if ( wp_is_mobile() ) : ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=1.2">
    <?php endif; ?>
    <title><?php upb_boilerplate_title() ?></title>
    <?php
        // ref: /wp-includes/script-loader.php
        // For Clean Slate We did not use wp_head hook on boilerplate template
        // that's why default registared scripts / styles will not load without re-registering :)
        // Only Admin CSS will load

        do_action( 'upb_boilerplate_header' );
        do_action( 'upb_boilerplate_print_scripts' );
        do_action( 'upb_boilerplate_print_styles' );
    ?>
    <script type="text/javascript">(function (html) {html.className = html.className.replace(/\bno-js\b/, 'js')}(document.documentElement))</script>
</head>
<body class="<?php upb_boilerplate_body_class() ?>">
<div id="upb-pre-loader">
    <div>
        <?php esc_html_e( 'Loading...', 'ultimate-page-builder' ) ?>
    </div>
</div>
<div id="upb-wrapper" class="expanded preview-lg preview-default"> <!-- collapsed preview-lg preview-md preview-sm preview-xs -->
    <div id="upb-sidebar-wrapper">
        <div id="upb-sidebar">
            <div id="upb-sidebar-header"></div>
            <div id="upb-sidebar-contents"></div>
            <div id="upb-sidebar-footer"></div>
        </div>
    </div>
    <div id="upb-skeleton-wrapper"></div>
    <div id="upb-preview-wrapper">
        <iframe data-url="<?php echo upb_get_preview_link() ?>" frameborder="0" name="upb-preview-frame" seamless="seamless" id="upb-preview-frame"></iframe>
    </div>
    <?php do_action( 'upb_boilerplate_contents' ); ?>
</div>
<?php do_action( 'upb_boilerplate_print_footer_scripts' ); ?>
</body>
</html>