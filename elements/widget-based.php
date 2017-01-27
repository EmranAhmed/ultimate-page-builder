<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );


    // Archives
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Archives', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, array(
            'id'    => 'dropdown',
            'title' => esc_html__( 'Display as dropdown', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'count',
            'title' => esc_html__( 'Show post counts', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Archives Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_archives_settings_panel_meta', array(
                    'help' => '<h2>WordPress Archives Widget</h2><p>A monthly archive of your site&#8217;s Posts.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_archives', $attributes, $contents, $_upb_options );

    } );

    // Custom Menu
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Custom Menu', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        if ( ! empty( wp_get_nav_menus() ) ):

            $menus = wp_list_pluck( wp_get_nav_menus(), 'name', 'term_id' );
            ksort( $menus );
            $menus[ 0 ] = esc_attr__( '-- Select --', 'ultimate-page-builder' );

            array_push( $attributes, array(
                'id'      => 'nav_menu',
                'title'   => esc_html__( 'Select Menu', 'ultimate-page-builder' ),
                'type'    => 'select',
                'value'   => FALSE,
                'options' => $menus
            ) );
        endif;

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Custom Menu Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_nav_menu_widget_settings_panel_meta', array(
                    'help' => '<h2>WordPress Custom Menu Widget</h2><p>Add a custom menu as element.</p>',
                ) ),
                'messages' => array(
                    'chooseMenu' => esc_html__( 'Choose a menu from left panel', 'ultimate-page-builder' )
                )
            )
        );

        $element->register( 'upb-wp_nav_menu_widget', $attributes, $contents, $_upb_options );

    } );

    // Calendar
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Calendar', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Calendar Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_calendar_settings_panel_meta', array(
                    'help' => '<h2>WordPress Calendar Widget</h2><p>A calendar of your site&#8217;s Posts.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_calendar', $attributes, $contents, $_upb_options );

    } );

    // Categories
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Categories', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, array(
            'id'    => 'dropdown',
            'title' => esc_html__( 'Display as dropdown', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'count',
            'title' => esc_html__( 'Show post counts', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'hierarchical',
            'title' => esc_html__( 'Show hierarchy', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );


        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Categories Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_categories_settings_panel_meta', array(
                    'help' => '<h2>WordPress Calendar Widget</h2><p>A list or dropdown of categories.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_categories', $attributes, $contents, $_upb_options );

    } );

    // Links
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Links', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        $categories      = wp_list_pluck( get_terms( 'link_category' ), 'name', 'term_id' );
        $categories[ 0 ] = esc_attr__( 'All Links', 'ultimate-page-builder' );
        ksort( $categories );

        array_push( $attributes, array(
            'id'      => 'category',
            'title'   => esc_html__( 'Select Link Category', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Get list from link_category term', 'ultimate-page-builder' ),
            'type'    => 'select',
            'value'   => '0',
            'options' => $categories
        ) );

        array_push( $attributes, array(
            'id'      => 'orderby',
            'title'   => esc_html__( 'Sort by', 'ultimate-page-builder' ),
            'type'    => 'select',
            'value'   => 'name',
            'options' => array(
                'name'   => esc_html__( 'Link title', 'ultimate-page-builder' ),
                'rating' => esc_html__( 'Link rating', 'ultimate-page-builder' ),
                'id'     => esc_html__( 'Link ID', 'ultimate-page-builder' ),
                'rand'   => esc_html__( 'Random', 'ultimate-page-builder' ),
            )
        ) );


        array_push( $attributes, array(
            'id'    => 'images',
            'title' => esc_html__( 'Show Link Image', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'name',
            'title' => esc_html__( 'Show Link Name', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'description',
            'title' => esc_html__( 'Show Link Description', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'rating',
            'title' => esc_html__( 'Show Link Rating', 'ultimate-page-builder' ),
            'type'  => 'toggle',
            'value' => FALSE,
        ) );

        array_push( $attributes, array(
            'id'    => 'limit',
            'title' => esc_html__( 'Number of links to show', 'ultimate-page-builder' ),
            'type'  => 'text',
            'value' => '-1',
        ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Links Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_links_settings_panel_meta', array(
                    'help' => '<h2>WordPress Links Widget</h2><p>Your blogroll.</p>',
                ) )
            )
        );

        //$element->register( 'upb-wp_widget_links', $attributes, $contents, $_upb_options );

    } );

    // Meta
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Meta', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Meta Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_calendar_settings_panel_meta', array(
                    'help' => '<h2>WordPress Meta Widget</h2><p>Login, RSS, &amp; WordPress.org links.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_meta', $attributes, $contents, $_upb_options );

    } );

    // Pages
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Pages', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, array(
            'id'      => 'sortby',
            'title'   => esc_html__( 'Sort by', 'ultimate-page-builder' ),
            'type'    => 'select',
            'value'   => 'menu_order',
            'options' => array(
                'post_title' => esc_html__( 'Page title', 'ultimate-page-builder' ),
                'menu_order' => esc_html__( 'Page order', 'ultimate-page-builder' ),
                'ID'         => esc_html__( 'Page ID', 'ultimate-page-builder' ),
            )
        ) );

        array_push( $attributes, array(
            'id'          => 'exclude',
            'type'        => 'ajax',
            'multiple'    => TRUE,
            'title'       => esc_html__( 'Exclude', 'ultimate-page-builder' ),
            'desc'        => esc_html__( 'Exclude Pages', 'ultimate-page-builder' ),
            'value'       => array(),
            'hooks'       => array(
                'search' => '_upb_search_pages', // wp_ajax search
                'load'   => '_upb_load_pages', // wp_ajax load
            ),
            'template'    => 'ID# %(id)s - %(title)s',
            'placeholder' => esc_html__( 'Search page to exclude', 'ultimate-page-builder' )
        ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Pages Widget', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_pages_settings_panel_meta', array(
                    'help' => '<h2>WordPress Pages Widget</h2><p>A list of your site&#8217;s Pages.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_pages', $attributes, $contents, $_upb_options );
    } );

    // Recent Comments
    add_action( 'upb_register_element', function ( $element ) {

        $attributes = array();

        array_push( $attributes, upb_title_input( esc_html__( 'Title', 'ultimate-page-builder' ), '', esc_html__( 'Recent Comments', 'ultimate-page-builder' ) ) );

        array_push( $attributes, upb_enable_input( esc_html__( 'Enable / Disable', 'ultimate-page-builder' ), '' ) );

        array_push( $attributes, array(
            'id'      => 'number',
            'title'   => esc_html__( 'Number of comments', 'ultimate-page-builder' ),
            'desc'    => esc_html__( 'Number of comments to show.', 'ultimate-page-builder' ),
            'type'    => 'number',
            'value'   => 5,
            'options' => array(
                'min'  => 1,
                'step' => 1,
                'size' => 3,
            )
        ) );

        array_push( $attributes, upb_responsive_hidden_input() );

        $attributes = array_merge( $attributes, upb_css_class_id_input_group() );

        $contents = FALSE;

        $_upb_options = array(

            'preview' => array(
                'ajax' => TRUE,
            ),

            'element' => array(
                'name' => esc_html__( 'Recent Comments', 'ultimate-page-builder' ),
                'icon' => 'mdi mdi-wordpress'
            ),

            'meta' => array(
                'settings' => apply_filters( 'upb-wp_widget_recent_comments_settings_panel_meta', array(
                    'help' => '<h2>WordPress Pages Widget</h2><p>A list of your site&#8217;s Pages.</p>',
                ) )
            )
        );

        $element->register( 'upb-wp_widget_recent_comments', $attributes, $contents, $_upb_options );
    } );