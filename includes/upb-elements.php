<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	// Column
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			'title'      => array( 'type' => 'text', 'value' => 'Column %s' ),
			'lg'         => array( 'type' => 'text', 'value' => '' ),
			'md'         => array( 'type' => 'text', 'value' => '' ),
			'sm'         => array( 'type' => 'text', 'value' => '' ),
			'xs'         => array( 'type' => 'text', 'value' => '1:1' ),
			'enable'     => array( 'type' => 'toggle', 'value' => TRUE ),
			'background' => array( 'type' => 'color', 'value' => '#fff' ),
		);

		$contents = array();

		$_upb_options = array(
			//'help'   => '<h2>What to do?</h2><p>Add row and start</p>',
			//'search' => 'Search Columns',
			'tools' => array(
				'list'     => apply_filters( 'upb_column_list_toolbar', array() ),
				'contents' => apply_filters( 'upb_column_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_column_settings_panel_toolbar', array() ),
			)
		);

		$element->register( 'column', $attributes, $contents, $_upb_options );

	} );


	// Row ( Section have row dependency that's why we should reg row before section )
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			'title'      => array( 'type' => 'text', 'value' => 'New Row %s' ),
			'enable'     => array( 'type' => 'toggle', 'value' => TRUE ),
			'background' => array( 'type' => 'color', 'value' => '#fff' ),
		);

		$contents = array();

		$_upb_options = array(
			'help'   => '<h2>What to do?</h2><p>Add row and start</p>',
			'search' => 'Search Rows',
			'tools'  => array(
				'list'     => apply_filters( 'upb_row_list_toolbar', array() ),
				'contents' => apply_filters( 'upb_row_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_row_settings_panel_toolbar', array() ),
			)
		);

		$element->register( 'row', $attributes, $contents, $_upb_options );

	} );

	// Section
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			'title'            => array( 'type' => 'text', 'value' => 'New Section %s' ),
			'enable'           => array( 'type' => 'toggle', 'value' => TRUE ),
			'background-color' => array( 'type' => 'color', 'value' => '#ffccff' ),
		);

		$contents = array();

		$_upb_options = array(
			'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
			'search' => 'Search Rows',
			'tools'  => array(
				'list'     => apply_filters( 'upb_section_list_toolbar', array() ),
				'contents' => apply_filters( 'upb_section_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_section_settings_panel_toolbar', array() ),
			)
		);

		$element->register( 'section', $attributes, $contents, $_upb_options );

	} );


