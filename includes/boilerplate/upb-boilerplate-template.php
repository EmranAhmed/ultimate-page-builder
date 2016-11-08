<?php

if ( ! defined( 'IFRAME_REQUEST' ) ):
	define( 'IFRAME_REQUEST', TRUE );
endif;

if ( ! current_user_can( 'customize' ) ) {
	wp_die(
		'<h1>' . __( 'Cheatin&#8217; uh?' ) . '</h1>' .
		'<p>' . __( 'Sorry, you are not allowed to customize this site. UPB' ) . '</p>',
		403
	);
}

// Load Styles and Scripts
add_action( 'upb_boilerplate_print_scripts', 'print_head_scripts', 20 );
add_action( 'upb_boilerplate_print_footer_scripts', '_wp_footer_scripts' );
add_action( 'upb_boilerplate_print_styles', 'print_admin_styles', 20 );

do_action( 'upb_boilerplate_init' );

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
	<script type="text/javascript">
		var ajaxurl = <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
		(function (html) {html.className = html.className.replace(/\bno-js\b/, 'js')}(document.documentElement))
	</script>
	<?php
		do_action( 'upb_boilerplate_header' );
		do_action( 'upb_boilerplate_print_scripts' );
		do_action( 'upb_boilerplate_print_styles' );
	?>
</head>
<body class="<?php upb_boilerplate_body_class() ?>">
<div id="upb-pre-loader">
	<div>
		<?php esc_html_e( 'Loading...' ) ?>
	</div>
</div>
<div id="upb-wrapper" class="expanded preview-lg preview-default"> <!-- collapsed preview-lg preview-md preview-sm preview-xs -->

	<div id="upb-sidebar-wrapper">
		<div id="upb-sidebar">
			<div id="upb-sidebar-header">
				Loading...
			</div>
			<div id="upb-sidebar-contents">
				Loading...
			</div>
			<div id="upb-sidebar-footer">
				Loading...
			</div>
		</div>
	</div>
	<div id="upb-skeleton-wrapper">Structure</div>

	<div id="upb-preview-wrapper">
		<iframe
			src="<?php echo add_query_arg( 'upb-preview', TRUE, get_preview_post_link( get_the_ID() ) ) ?>"
			frameborder="0"
			name="upb-preview-frame"
			seamless="seamless"
			id="upb-preview-frame"></iframe>
	</div>

	<?php
		do_action( 'upb_boilerplate_contents' );
	?>

	<?php do_action( 'upb_boilerplate_print_footer_scripts' ); ?>
</div>
</body>
</html>