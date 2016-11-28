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




