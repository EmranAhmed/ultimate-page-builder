<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    // Column
    add_filter( 'upb_column_contents_panel_toolbar', function () {
        return array(
            array(
                'title'  => esc_html__( 'Add Element', 'ultimate-page-builder' ),
                'id'     => 'elements-panel',
                'icon'   => 'mdi mdi-shape-plus',
                'action' => 'showElementsPanel'
            ),
            array(
                'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                'id'     => 'column-settings',
                'icon'   => 'mdi mdi-settings',
                'action' => 'showSettingsPanel'
            )
        );
    } );

    add_filter( 'upb_column_settings_panel_toolbar', function () {
        return array(
            array(
                'id'     => 'column-contents',
                'title'  => esc_html__( 'Contents', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-file-tree',
                'action' => 'showContentPanel'
            )
        );
    } );

    add_filter( 'upb_column_list_toolbar', function ( $tools ) {
        $tools[ 'move' ] = array(
            'icon'  => 'mdi mdi-cursor-move',
            'class' => 'handle',
            'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
        );

        $tools[ 'delete' ] = array(
            'icon'  => 'mdi mdi-delete',
            'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
        );

        $tools[ 'enable' ]   = array(
            'icon'  => 'mdi mdi-eye',
            'title' => esc_html__( 'Enabled', 'ultimate-page-builder' ),
        );
        $tools[ 'disable' ]  = array(
            'icon'  => 'mdi mdi-eye-off',
            'title' => esc_html__( 'Disabled', 'ultimate-page-builder' ),
        );
        $tools[ 'contents' ] = array(
            'icon'  => 'mdi mdi-table-edit',
            'class' => 'show-contents',
            'title' => esc_html__( 'Contents', 'ultimate-page-builder' ),
        );
        $tools[ 'settings' ] = array(
            'icon'  => 'mdi mdi-settings',
            'class' => 'show-settings',
            'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
        );
        $tools[ 'clone' ]    = array(
            'icon'  => 'mdi mdi-content-duplicate',
            'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
        );

        return $tools;
    } );


    // Section
    add_filter( 'upb_section_list_toolbar', function ( $tools ) {
        $tools[ 'move' ] = array(
            'icon'  => 'mdi mdi-cursor-move',
            'class' => 'handle',
            'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
        );

        $tools[ 'delete' ] = array(
            'icon'  => 'mdi mdi-delete',
            'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
        );

        $tools[ 'enable' ]   = array(
            'icon'  => 'mdi mdi-eye',
            'title' => esc_html__( 'Enabled', 'ultimate-page-builder' ),
        );
        $tools[ 'disable' ]  = array(
            'icon'  => 'mdi mdi-eye-off',
            'title' => esc_html__( 'Disabled', 'ultimate-page-builder' ),
        );
        $tools[ 'contents' ] = array(
            'icon'  => 'mdi mdi-table-edit',
            'class' => 'show-contents',
            'title' => esc_html__( 'Contents', 'ultimate-page-builder' ),
        );
        $tools[ 'settings' ] = array(
            'icon'  => 'mdi mdi-settings',
            'class' => 'show-settings',
            'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
        );
        $tools[ 'clone' ]    = array(
            'icon'  => 'mdi mdi-content-duplicate',
            'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
        );

        return $tools;
    } );

    add_filter( 'upb_section_contents_panel_toolbar', function () {
        return array(
            array(
                'id'     => 'add-new-row',
                'title'  => esc_html__( 'Add Row', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-table-row-plus-after',
                'action' => 'addNew',
                'data'   => apply_filters( 'upb_new_row_data', upb_elements()->generate_element(
                    'row', upb_elements()->generate_element(
                    'column', array(), array(
                    'title' => array(
                        'type'  => 'text',
                        'value' => esc_html__( 'Column 1', 'ultimate-page-builder' )
                    )
                ) ), array(
                        'title' => array(
                            'type'  => 'text',
                            'value' => esc_html__( 'New Row %s', 'ultimate-page-builder' )
                        )
                    ) ) )
            ),
            array(
                'id'     => 'section-setting',
                'title'  => esc_html__( 'Settings', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-settings',
                'action' => 'showSettingsPanel'
            ),
            array(
                'id'     => 'save-section',
                'title'  => esc_html__( 'Save Section', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-cube-send',
                'action' => 'saveSectionLayout'
            ),
        );
    } );

    add_filter( 'upb_section_settings_panel_toolbar', function () {
        return array(
            array(
                'id'     => 'section-contents',
                'title'  => esc_html__( 'Contents', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-file-tree',
                'action' => 'showContentPanel'
            )
        );
    } );

    // device previews

    add_filter( 'upb_preview_devices', function () {
        return array(
            array(
                'id'     => 'lg',
                'title'  => esc_html__( 'Large', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-desktop-mac',
                'width'  => '100%',
                'active' => TRUE
            ),
            array(
                'id'     => 'md',
                'title'  => esc_html__( 'Medium', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-laptop-mac',
                'width'  => '992px',
                'active' => FALSE
            ),
            array(
                'id'     => 'sm',
                'title'  => esc_html__( 'Small', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-tablet-ipad',
                'width'  => '768px',
                'active' => FALSE
            ),
            array(
                'id'     => 'xs',
                'title'  => esc_html__( 'Extra Small', 'ultimate-page-builder' ),
                'icon'   => 'mdi mdi-cellphone-iphone',
                'width'  => '480px',
                'active' => FALSE
            ),
        );
    } );

    add_filter( 'upb_responsive_hidden', function () {
        return array(
            array(
                'id'    => 'hidden-lg',
                'title' => esc_html__( 'Large', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-desktop-mac',
            ),
            array(
                'id'    => 'hidden-md',
                'title' => esc_html__( 'Medium', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-laptop-mac'
            ),
            array(
                'id'    => 'hidden-sm',
                'title' => esc_html__( 'Small', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-tablet-ipad'
            ),
            array(
                'id'    => 'hidden-xs',
                'title' => esc_html__( 'Extra Small', 'ultimate-page-builder' ),
                'icon'  => 'mdi mdi-cellphone-iphone'
            ),
        );
    } );

    // grid system

    add_filter( 'upb_grid_system', function () {
        return array(
            'name'              => esc_html__( 'UPB Grid', 'ultimate-page-builder' ),
            'simplifiedRatio'   => esc_html__( 'Its recommended to use simplified form of your grid ratio like: %s', 'ultimate-page-builder' ),
            'prefixClass'       => 'upb-col',
            'separator'         => '-', // col- deviceId - grid class
            'groupClass'        => 'upb-row',
            'groupWrapper'      => array(
                'upb-container-fluid'           => esc_html__( 'Fluid Container', 'ultimate-page-builder' ),
                'upb-container-fluid-no-gutter' => esc_html__( 'Fluid Container without gutter', 'ultimate-page-builder' ),
                'upb-container'                 => esc_html__( 'Fixed Container', 'ultimate-page-builder' ),
                'upb-container-no-gutter'       => esc_html__( 'Fixed Container without gutter', 'ultimate-page-builder' )
            ),
            'defaultDeviceId'   => 'xs', // We should set default column element attributes as like defaultDeviceId, If xs then [column xs='...']
            'deviceSizeTitle'   => esc_html__( 'Screen Sizes', 'ultimate-page-builder' ),
            'devices'           => apply_filters( 'upb_preview_devices', array() ),
            'totalGrid'         => 12,
            'allowedGrid'       => array( 1, 2, 3, 4, 6, 12 ),
            'nonAllowedMessage' => esc_html__( "Sorry, UPB Grid doesn't support %s grid column.", 'ultimate-page-builder' )
        );
    } );


    // Row
    add_filter( 'upb_row_list_toolbar', function ( $tools ) {
        $tools[ 'move' ] = array(
            'icon'  => 'mdi mdi-cursor-move',
            'class' => 'handle',
            'title' => esc_html__( 'Sort', 'ultimate-page-builder' ),
        );

        $tools[ 'delete' ] = array(
            'icon'  => 'mdi mdi-delete',
            'title' => esc_html__( 'Delete', 'ultimate-page-builder' ),
        );

        $tools[ 'enable' ] = array(
            'icon'  => 'mdi mdi-eye',
            'title' => esc_html__( 'Enabled', 'ultimate-page-builder' ),
        );

        $tools[ 'disable' ]  = array(
            'icon'  => 'mdi mdi-eye-off',
            'title' => esc_html__( 'Disabled', 'ultimate-page-builder' ),
        );
        $tools[ 'contents' ] = array(
            'icon'  => 'mdi mdi-view-column',
            'class' => 'show-contents',
            'title' => esc_html__( 'Columns', 'ultimate-page-builder' ),
        );
        $tools[ 'settings' ] = array(
            'icon'  => 'mdi mdi-settings',
            'class' => 'show-settings',
            'title' => esc_html__( 'Settings', 'ultimate-page-builder' ),
        );
        $tools[ 'clone' ]    = array(
            'icon'  => 'mdi mdi-content-duplicate',
            'title' => esc_html__( 'Clone', 'ultimate-page-builder' ),
        );

        return $tools;
    } );


    add_filter( 'upb_row_contents_panel_toolbar', function ( $tools ) {
        return array(
            'new'     => apply_filters( 'upb_new_column_data', upb_elements()->get_element( 'column' ) ),
            'layouts' => array(
                array(
                    'class' => 'grid-1-1',
                    'value' => '1:1',
                ),
                array(
                    'class' => 'grid-1-2',
                    'value' => '1:2 + 1:2',
                ),
                array(
                    'class' => 'grid-1-3__2-3',
                    'value' => '1:3 + 2:3',
                ),
                array(
                    'class' => 'grid-2-3__1-3',
                    'value' => '2:3 + 1:3',
                ),
                array(
                    'class' => 'grid-1-3__1-3__1-3',
                    'value' => '1:3 + 1:3 + 1:3',
                ),
                array(
                    'class' => 'grid-1-4__2-4__1-4',
                    'value' => '1:4 + 2:4 + 1:4',
                ),
                array(
                    'class' => 'grid-1-4__1-4__1-4__1-4',
                    'value' => '1:4 + 1:4 + 1:4 + 1:4',
                )
            )
        );
    } );

    // Register Tabs
    add_action( 'upb_register_tab', function ( $tab ) {


        $data = array(
            'title'    => esc_html__( 'Sections', 'ultimate-page-builder' ),
            'help'     => wp_kses_post( __( '<h2>Just Getting Starting?</h2><p>Add a section then click on <i class="mdi mdi-table-edit"></i> icon to manage column layouts or click on <i class="mdi mdi-settings"></i> icon to change settings or use <i class="mdi mdi-cursor-move"></i> to reorder.</p>', 'ultimate-page-builder' ) ),
            'search'   => esc_html__( 'Search Sections', 'ultimate-page-builder' ),
            'tools'    => apply_filters( 'upb_tab_sections_tools', array(
                                                                     array(
                                                                         'id'     => 'add-new-section',
                                                                         'title'  => esc_html__( 'Add Section', 'ultimate-page-builder' ),
                                                                         'icon'   => 'mdi mdi-package-variant',
                                                                         'action' => 'addNew',
                                                                         'data'   => apply_filters( 'upb_new_section_data',
                                                                                                    upb_elements()->generate_element(
                                                                                                        'section', upb_elements()->generate_element(
                                                                                                        'row', upb_elements()->generate_element(
                                                                                                        'column', array(), array(
                                                                                                        'title' => array(
                                                                                                            'type'  => 'text',
                                                                                                            'value' => esc_html__( 'Column 1', 'ultimate-page-builder' )
                                                                                                        )
                                                                                                    ) ), array(
                                                                                                            'title' => array(
                                                                                                                'type'  => 'text',
                                                                                                                'value' => esc_html__( 'Row 1', 'ultimate-page-builder' )
                                                                                                            )
                                                                                                        ) ) ) )
                                                                     ),
                                                                     array(
                                                                         'id'     => 'load-sections',
                                                                         'title'  => esc_html__( 'Saved Sections', 'ultimate-page-builder' ),
                                                                         'icon'   => 'mdi mdi-cube-outline',
                                                                         'action' => 'openSubPanel',
                                                                         'data'   => 'sections'
                                                                     ),
                                                                     array(
                                                                         'id'     => 'copy-layouts',
                                                                         'title'  => esc_html__( 'Copy Layout', 'ultimate-page-builder' ),
                                                                         'icon'   => 'mdi mdi-clipboard-text',
                                                                         'action' => 'copyLayoutToClipboard',
                                                                     ),
                                                                 )
            ), // add section | load section | layouts
            'icon'     => 'mdi mdi-package-variant',
            'contents' => apply_filters( 'upb_sections_panel_contents', array() ),
            // load from get_post_meta, if you load data then ajax data will not run
        );
        $tab->register( 'sections', $data, TRUE );


        $data = array(
            'title'    => esc_html__( 'Elements', 'ultimate-page-builder' ),
            'search'   => esc_html__( 'Search Element', 'ultimate-page-builder' ),
            'help'     => wp_kses_post( __( '<h2>How to use?</h2><p>Just drag an element and drop it to right side column layout.</p>', 'ultimate-page-builder' ) ),
            'tools'    => apply_filters( 'upb_tab_elements_tools', array() ), // add section | load section | layouts
            'icon'     => 'mdi mdi-shape-plus',
            'contents' => apply_filters( 'upb_tab_elements_contents', array() ),
        );
        $tab->register( 'elements', $data, FALSE );

        $data = array(
            'title'    => esc_html__( 'Settings', 'ultimate-page-builder' ),
            'help'     => wp_kses_post( __( '<p>Simply enable or disable page builder for this page or set other options.</p>', 'ultimate-page-builder' ) ),
            'tools'    => apply_filters( 'upb_tab_settings_tools', array() ), // add section | load section | layouts
            'icon'     => 'mdi mdi-settings',
            'contents' => apply_filters( 'upb_tab_settings_contents', array() ),
        );
        $tab->register( 'settings', $data, FALSE );


        $data = array(
            'title'    => esc_html__( 'Pre-build Layouts', 'ultimate-page-builder' ),
            'search'   => esc_html__( 'Search Layouts', 'ultimate-page-builder' ),
            'help'     => wp_kses_post( __( '<p>Pre build layouts</p>', 'ultimate-page-builder' ) ),
            'tools'    => apply_filters( 'upb_tab_layouts_tools', array() ), // add section | load section | layouts
            'icon'     => 'mdi mdi-palette',
            'contents' => apply_filters( 'upb_tab_layouts_contents', array() ),
        );
        $tab->register( 'layouts', $data, FALSE );

    } );


    // Backend Scripts
    add_action( 'upb_boilerplate_enqueue_scripts', function () {

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        // Color

        wp_register_style( 'dashicon', includes_url( "/css/dashicons$suffix.css" ) );
        wp_register_style( 'select2', UPB_PLUGIN_ASSETS_URI . "css/select2$suffix.css" );
        wp_register_script( 'select2', UPB_PLUGIN_ASSETS_URI . "js/select2$suffix.js", array( 'jquery' ), FALSE, TRUE );

        wp_register_script( 'iris', admin_url( "/js/iris.min.js" ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), FALSE, TRUE );
        wp_register_script( 'wp-color-picker', admin_url( "/js/color-picker$suffix.js" ), array( 'iris' ), FALSE, TRUE );
        wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array(
            'clear'         => esc_html__( 'Clear', 'ultimate-page-builder' ),
            'defaultString' => esc_html__( 'Default', 'ultimate-page-builder' ),
            'pick'          => esc_html__( 'Select Color', 'ultimate-page-builder' ),
            'current'       => esc_html__( 'Current Color', 'ultimate-page-builder' ),
        ) );

        wp_register_script( 'wp-color-picker-alpha', UPB_PLUGIN_ASSETS_URI . "js/wp-color-picker-alpha$suffix.js", array( 'wp-color-picker' ), FALSE, TRUE );

    } );


    // Load Scripts :)
    add_action( 'upb_boilerplate_print_styles', function () {
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        // ref: /wp-includes/script-loader.php
        // to Clean Slate We did not use wp_head hook on boilerplate template
        // that's why default registared scripts / styles will not load without re-registering :)
        // Only Admin CSS will load
        wp_enqueue_style( 'dashicon' );
        wp_enqueue_style( 'common' );
        wp_enqueue_style( 'buttons' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'select2' );

        wp_enqueue_style( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URI . "css/upb-boilerplate$suffix.css" );

        if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
            // In Production Mode :)
            wp_enqueue_style( 'upb-style', UPB_PLUGIN_ASSETS_URI . "css/upb-style$suffix.css" );
        }

    } );

    add_action( 'upb_boilerplate_print_scripts', function () {
        //$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        echo '<script type="text/javascript">(function (html) {html.className = html.className.replace(/\bno-js\b/, \'js\')}(document.documentElement))</script>';
    } );

    add_action( 'upb_boilerplate_enqueue_scripts', function () {

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker-alpha' );
        wp_enqueue_script( 'select2' );

        wp_enqueue_script( 'upb-builder', UPB_PLUGIN_ASSETS_URI . "js/upb-builder$suffix.js", array( 'jquery-ui-sortable', 'wp-util', 'wp-color-picker', "shortcode" ), '', TRUE );

        wp_enqueue_script( 'upb-boilerplate', UPB_PLUGIN_ASSETS_URI . "js/upb-boilerplate$suffix.js", array( 'jquery', 'upb-builder' ), '', TRUE );


        $data = sprintf( "var _upb_tabs = %s;\n", upb_tabs()->getJSON() );

        $data .= sprintf( "var _upb_router_config = %s;\n", wp_json_encode( array(
                                                                                'mode' => 'hash' // abstract, history, hash
                                                                            ) ) );

        $data .= sprintf( "var _upb_routes = %s;\n", wp_json_encode( apply_filters( 'upb_routes', array(
            array(
                'name'      => 'logical',
                'path'      => '/:tab(logical)',
                'component' => 'LogicalPanel',
            ) // you should register a tab before add router
        ) ) ) );


        $data .= sprintf( "var _upb_status = %s;\n", wp_json_encode( array( 'dirty' => FALSE, '_nonce' => wp_create_nonce( '_upb' ), '_id' => get_the_ID() ) ) );

        $data .= sprintf( "var _upb_preview_devices = %s;", wp_json_encode( apply_filters( 'upb_preview_devices', array() ) ) );

        $data .= sprintf( "var _upb_grid_system = %s;", wp_json_encode( apply_filters( 'upb_grid_system', array() ) ) );

        wp_script_add_data( 'upb-builder', 'data', $data );

        wp_localize_script( 'upb-builder', '_upb_l10n', apply_filters( '_upb_l10n_strings', array(
            'sectionSaving'      => esc_attr__( 'Section Saving...', 'ultimate-page-builder' ),
            'sectionSaved'       => esc_attr__( 'Section Saved.', 'ultimate-page-builder' ),
            'sectionNotSaved'    => esc_attr__( "Section Can't Save.", 'ultimate-page-builder' ),
            'sectionDeleted'     => esc_attr__( "Section Removed.", 'ultimate-page-builder' ),
            'sectionAdded'       => esc_attr__( "%s Section Added.", 'ultimate-page-builder' ),
            'saving'             => esc_attr__( 'Saving', 'ultimate-page-builder' ),
            'saved'              => esc_attr__( 'Saved', 'ultimate-page-builder' ),
            'savingProblem'      => esc_attr__( 'Problem on Saving', 'ultimate-page-builder' ),
            'add'                => esc_attr__( 'Add', 'ultimate-page-builder' ),
            'sectionCopied'      => esc_attr__( '%s data copied to clipboard', 'ultimate-page-builder' ),
            'searchSavedSection' => esc_attr__( 'Search saved section', 'ultimate-page-builder' ),
            'layoutCopied'       => esc_attr__( '%s layout copied to clipboard', 'ultimate-page-builder' ),
            'layoutNotCopied'    => esc_attr__( 'Nothing to copy', 'ultimate-page-builder' ),
            'layoutAdded'        => esc_attr__( '%s Layout added', 'ultimate-page-builder' ),
            'layoutUse'          => esc_attr__( 'Use this layout', 'ultimate-page-builder' ),
            'pasteJSON'          => esc_attr__( 'Paste JSON Contents', 'ultimate-page-builder' ),
            'save'               => esc_attr__( 'Save', 'ultimate-page-builder' ),
            'copy'               => esc_attr__( 'Copy', 'ultimate-page-builder' ),
            'create'             => esc_attr__( 'Create', 'ultimate-page-builder' ),
            'delete'             => esc_attr__( 'Are you sure to delete %s?', 'ultimate-page-builder' ),
            'column_manual'      => esc_attr__( 'Manual', 'ultimate-page-builder' ),
            'column_layout_of'   => esc_attr__( 'Columns Layout of - %s', 'ultimate-page-builder' ),
            'column_order'       => esc_attr__( 'Column Order', 'ultimate-page-builder' ),
            'column_layout'      => esc_attr__( 'Column layout', 'ultimate-page-builder' ),
            'close'              => esc_attr__( 'Close', 'ultimate-page-builder' ),
            'clone'              => esc_attr__( 'Clone of %s', 'ultimate-page-builder' ),
            'help'               => esc_attr__( 'Help', 'ultimate-page-builder' ),
            'search'             => esc_attr__( 'Search', 'ultimate-page-builder' ),
            'back'               => esc_attr__( 'Back', 'ultimate-page-builder' ),
            'breadcrumbRoot'     => esc_attr__( 'You are on', 'ultimate-page-builder' ),
            'skeleton'           => esc_attr__( 'Skeleton preview', 'ultimate-page-builder' ),
            'collapse'           => esc_attr__( 'Collapse', 'ultimate-page-builder' ),
            'expand'             => esc_attr__( 'Expand', 'ultimate-page-builder' ),
            // 'closeUrl'         => esc_url( get_permalink() ),
            'closeUrl'           => esc_url( add_query_arg( 'preview', 'true', get_permalink() ) ),
            'ajaxUrl'            => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),


            // Templates
            'layoutPlaceholder'  => upb_assets_uri( 'images/layout-placeholder.png' ),
            'editorTemplate'     => upb_wp_editor_template(),
            'allowedTags'        => array_keys( wp_kses_allowed_html( 'post' ) ),
            'allowedAttributes'  => upb_allowed_attributes(),
            'allowedSchemes'     => wp_allowed_protocols(),
            'pageTitle'          => get_the_title(),
        ) ) );
    } );

    add_action( 'upb_boilerplate_print_footer_scripts', function () {
        //$tabs = upb_tabs()->getAll();
        print( "<script>
var LogicalPanel = {
  template: '<span> Logical Panel Template </span>',
  props:[]
}
</script>" );
    } );
