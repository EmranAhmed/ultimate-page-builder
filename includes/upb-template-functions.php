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

		$template_path = Ultimate_Page_Builder()->template_dir();
		$default_path  = Ultimate_Page_Builder()->template_path();

		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				'upb-template-' . $template_name
			)
		);

		// Get default template/
		if ( ! $template ) {
			$template = $default_path . $template_name;
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