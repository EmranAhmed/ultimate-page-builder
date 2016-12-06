<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	// Column
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			array( 'id' => 'title', 'type' => 'text', 'value' => 'Column %s' ),
			array( 'id' => 'lg', 'type' => 'text', 'value' => '' ),
			array( 'id' => 'md', 'type' => 'text', 'value' => '' ),
			array( 'id' => 'sm', 'type' => 'text', 'value' => '' ),
			array( 'id' => 'xs', 'type' => 'text', 'value' => '1:1' ),
			array( 'id' => 'enable', 'type' => 'toggle', 'value' => TRUE ),
			array( 'id' => 'background', 'type' => 'color', 'value' => '#fff' ),
		);

		$contents = array();

		$_upb_options = array(
			'element' => array(
				'name' => 'Column',
				//'icon' => 'mdi mdi-format-text'
			),
			'tools'   => array(
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
			array( 'id' => 'title', 'title' => 'Row title', 'type' => 'text', 'value' => 'New Row %s' ),
			array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
			array( 'id' => 'background', 'title' => 'Background', 'type' => 'color', 'value' => '#fff' ),
		);

		$contents = array();

		$_upb_options = array(
			'help'    => '<h2>What to do?</h2><p>Add row and start</p>',
			'search'  => 'Search Rows',
			'tools'   => array(
				'list'     => apply_filters( 'upb_row_list_toolbar', array() ),
				'contents' => apply_filters( 'upb_row_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_row_settings_panel_toolbar', array() ),
			),
			'element' => array(
				'name' => 'Row',
				//'icon' => 'mdi mdi-format-text'
			),
			'meta'    => array(
				'contents' => apply_filters( 'upb_row_contents_panel_meta', array(
					'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
					'search' => 'Search Column',
					'title'  => '%s'
				) ),
				'settings' => apply_filters( 'upb_row_settings_panel_meta', array(
					'help'   => '<h2>Row Settings?</h2><p>row settings</p>',
					'search' => '',
					'title'  => '%s Settings'
				) ),
			),
		);

		$element->register( 'row', $attributes, $contents, $_upb_options );

	} );


	// Section
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			array( 'id' => 'title', 'title' => 'Section title', 'type' => 'text', 'value' => 'New Section %s' ),
			array( 'id' => 'enable', 'title' => 'Enable', 'type' => 'toggle', 'value' => TRUE ),
			array( 'id' => 'background-color', 'title' => 'Background Color', 'type' => 'color', 'value' => '#ffccff' ),
		);

		$contents = array();

		$_upb_options = array(
			'element' => array(
				'name' => 'Section',
				//'icon' => 'mdi mdi-format-text'
			),
			'tools'   => array(
				'list'     => apply_filters( 'upb_section_list_toolbar', array() ),
				'contents' => apply_filters( 'upb_section_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_section_settings_panel_toolbar', array() ),
			),
			'meta'    => array(
				'contents' => apply_filters( 'upb_section_contents_panel_meta', array(
					'help'   => '<h2>Want to add contents?</h2><p>Choose a section and drag elements</p>',
					'search' => 'Search Rows',
					'title'  => '%s'
				) ),
				'settings' => apply_filters( 'upb_section_settings_panel_meta', array(
					'help'   => '<h2>Section Settings?</h2><p>section settings</p>',
					'search' => '',
					'title'  => '%s Settings'
				) ),
			),

		);

		$element->register( 'section', $attributes, $contents, $_upb_options );

	} );


	//////  NON CORE

	// Text
	add_action( 'upb_register_element', function ( $element ) {

		$attributes = array(
			array( 'id' => 'title', 'type' => 'text', 'value' => 'Text Title' ),
			// array( 'id' => 'title', 'type' => 'textarea', 'value' => 'Text Title' ),
			array( 'id' => 'enable', 'type' => 'toggle', 'value' => TRUE ),
			array( 'id' => 'background', 'type' => 'color', 'value' => '#ffccff' ),
		);

		$contents = '';

		$_upb_options = array(

			'element' => array(
				'name' => 'Text',
				'icon' => 'mdi mdi-format-text'
			),

			'tools' => array(
				'list'     => apply_filters( 'upb_text_list_toolbar', array(
					'move' => array(
						'icon'  => 'mdi mdi-cursor-move',
						'class' => 'handle',
						'title' => 'Sort',
					),

					'delete' => array(
						'icon'  => 'mdi mdi-delete',
						'title' => 'Delete',
					),

					'enable' => array(
						'icon'  => 'mdi mdi-eye',
						'title' => 'Enabled',
					),

					'disable' => array(
						'icon'  => 'mdi mdi-eye-off',
						'title' => 'Disabled',
					)
				) ),
				'contents' => apply_filters( 'upb_text_contents_panel_toolbar', array() ),
				'settings' => apply_filters( 'upb_text_settings_panel_toolbar', array() ),
			)
		);

		$element->register( 'text', $attributes, $contents, $_upb_options );

	} );

