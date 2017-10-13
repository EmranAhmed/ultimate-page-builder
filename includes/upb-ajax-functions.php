<?php
	
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	
	// Core Ajax Functions
	require_once upb_include_path( 'upb-ajax-core-functions.php' );
	
	// Posts
	add_action( 'wp_ajax__upb_search_posts', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$result = array();
		
		$args = array(
			'posts_per_page' => 10,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			's'              => esc_sql( $_GET[ 'query' ] ),
			'orderby'        => 'title',
			'order'          => 'ASC'
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$result[] = array(
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'text'  => get_the_title(),
				);
			}
		}
		
		wp_reset_postdata();
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_load_posts', function () {
		
		upb_check_ajax_access();
		
		$ids = array_map( 'esc_attr', $_GET[ 'id' ] );
		
		if ( empty( $ids ) ) {
			wp_send_json_success( array() );
		} else {
			
			$ids = array_unique( $ids );
			
			$posts = get_posts( array(
				                    'posts_per_page' => - 1,
				                    'orderby'        => 'ID',
				                    'sort_order'     => 'desc',
				                    'post__in'       => $ids,
				                    'post_type'      => 'post',
			                    ) );
			
			$data = array();
			foreach ( $posts as $post ) :
				$data[] = array(
					'id'    => $post->ID,
					'title' => esc_html( $post->post_title ),
					'text'  => esc_html( $post->post_title )
				);
			endforeach;
			
			wp_send_json_success( $data );
		}
	} );
	
	add_action( 'wp_ajax__upb_load_post', function () {
		
		upb_check_ajax_access();
		
		$id = absint( $_GET[ 'id' ] );
		
		if ( empty( $id ) ) {
			wp_send_json_success( array() );
		} else {
			$post   = get_post( $id );
			$result = array(
				'id'    => $post->ID,
				'title' => esc_html( $post->post_title ),
				'text'  => esc_html( $post->post_title )
			);
			wp_send_json_success( $result );
		}
	} );
	
	// Pages
	add_action( 'wp_ajax__upb_search_pages', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$result = array();
		
		$args = array(
			'posts_per_page' => 10,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			's'              => esc_sql( $_GET[ 'query' ] ),
			'orderby'        => 'title',
			'order'          => 'ASC'
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$result[] = array(
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'text'  => get_the_title(),
				);
			}
		}
		
		wp_reset_postdata();
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_load_pages', function () {
		
		upb_check_ajax_access();
		
		$ids = array_map( 'esc_attr', $_GET[ 'id' ] );
		
		
		if ( empty( $ids ) ) {
			wp_send_json_success( array() );
		} else {
			
			$ids = array_unique( $ids );
			
			$posts = get_posts( array(
				                    'posts_per_page' => - 1,
				                    'orderby'        => 'ID',
				                    'sort_order'     => 'desc',
				                    'post__in'       => $ids,
				                    'post_type'      => 'page',
			                    ) );
			
			$data = array();
			foreach ( $posts as $post ) :
				$data[] = array(
					'id'    => $post->ID,
					'title' => esc_html( $post->post_title ),
					'text'  => esc_html( $post->post_title )
				);
			endforeach;
			
			wp_send_json_success( $data );
		}
	} );
	
	add_action( 'wp_ajax__upb_load_page', function () {
		
		upb_check_ajax_access();
		
		$id = absint( $_GET[ 'id' ] );
		
		if ( empty( $id ) ) {
			wp_send_json_success( array() );
		} else {
			$post   = get_post( $id );
			$result = array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
			wp_send_json_success( $result );
		}
	} );
	
	
	// Material Design Icon Ajax
	add_action( 'wp_ajax__upb_material_icon_search', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$query = esc_html( $_GET[ 'query' ] );
		
		$icons = upb_material_design_icons();
		
		$finds = array_filter( $icons, function ( $icon ) use ( $query ) {
			$p = strpos( strtolower( $icon ), $query );
			
			if ( $p === FALSE ) {
				return FALSE;
			} else {
				return TRUE;
			}
		} );
		
		$result = array_values( array_map( function ( $icon, $key ) {
			
			return array( 'id' => $key, 'title' => $icon, 'text' => $icon );
			
		}, $finds, array_keys( $finds ) ) );
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_material_icon_load', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'id' ] ) ) {
			wp_send_json_success( array() );
		}
		
		$query = esc_html( $_GET[ 'id' ] );
		
		$icons = upb_material_design_icons();
		
		$result = array( 'id' => $query, 'title' => esc_html( $icons[ $query ] ), 'text' => esc_html( $icons[ $query ] ) );
		
		wp_send_json_success( $result );
	} );
	
	// FontAwesome Icon Ajax
	add_action( 'wp_ajax__upb_font_awesome_icon_search', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$query = esc_html( $_GET[ 'query' ] );
		
		$icons = upb_font_awesome_icons();
		
		$finds = array_filter( $icons, function ( $icon ) use ( $query ) {
			$p = strpos( strtolower( $icon ), $query );
			
			if ( $p === FALSE ) {
				return FALSE;
			} else {
				return TRUE;
			}
		} );
		
		$result = array_values( array_map( function ( $icon, $key ) {
			
			return array( 'id' => $key, 'title' => $icon, 'text' => $icon );
			
		}, $finds, array_keys( $finds ) ) );
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_font_awesome_icon_load', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'id' ] ) ) {
			wp_send_json_success( array() );
		}
		
		$query = esc_html( $_GET[ 'id' ] );
		
		$icons = upb_font_awesome_icons();
		
		$result = array( 'id' => $query, 'title' => esc_html( $icons[ $query ] ), 'text' => esc_html( $icons[ $query ] ) );
		
		wp_send_json_success( $result );
	} );
	
	// DashIcons Icon Ajax
	add_action( 'wp_ajax__upb_dashicons_icon_search', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$query = esc_html( $_GET[ 'query' ] );
		
		$icons = upb_dash_icon_icons();
		
		$finds = array_filter( $icons, function ( $icon ) use ( $query ) {
			$p = strpos( strtolower( $icon ), $query );
			
			if ( $p === FALSE ) {
				return FALSE;
			} else {
				return TRUE;
			}
		} );
		
		$result = array_values( array_map( function ( $icon, $key ) {
			
			return array( 'id' => $key, 'title' => $icon, 'text' => $icon );
			
		}, $finds, array_keys( $finds ) ) );
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_dashicons_icon_load', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'id' ] ) ) {
			wp_send_json_success( array() );
		}
		
		$query = esc_html( $_GET[ 'id' ] );
		
		$icons = upb_dash_icon_icons();
		
		$result = array( 'id' => $query, 'title' => esc_html( $icons[ $query ] ), 'text' => esc_html( $icons[ $query ] ) );
		
		wp_send_json_success( $result );
	} );
	
	// Contact form 7 Ajax
	add_action( 'wp_ajax__upb_upb-contact-form-7_preview_contents', function () {
		
		upb_check_ajax_access();
		
		if ( ! empty( $_POST[ 'id' ] ) ) {
			$short_code = do_shortcode( sprintf( '[contact-form-7 id="%d" title="%s"]', absint( $_POST[ 'id' ] ), esc_html( $_POST[ 'title' ] ) ) );
			wp_send_json_success( $short_code );
		} else {
			wp_send_json_success();
		}
	} );
	
	add_action( 'wp_ajax__upb_element_upb-contact-form-7_id_search', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$result = array();
		
		$args = array(
			'posts_per_page' => 10,
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'all',
			's'              => esc_sql( $_GET[ 'query' ] ),
			'orderby'        => 'title',
			'order'          => 'ASC'
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$result[] = array(
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'text'  => get_the_title(),
				);
			}
		}
		
		wp_reset_postdata();
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_element_upb-contact-form-7_id_load', function () {
		
		upb_check_ajax_access();
		
		$id = absint( $_GET[ 'id' ] );
		
		if ( empty( $id ) ) {
			wp_send_json_success( array() );
		} else {
			$post   = get_post( $id );
			$result = array( 'id' => $post->ID, 'title' => esc_html( $post->post_title ), 'text' => esc_html( $post->post_title ) );
			wp_send_json_success( $result );
		}
	} );
	
	// Contact form 7 multiple demo Ajax example
	add_action( 'wp_ajax__upb_element_upb-contact-form-7_idx_search', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'query' ] ) ) {
			wp_send_json_error( 'no_search_term', 400 );
		}
		
		$result = array();
		
		$args = array(
			'posts_per_page' => 10,
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'all',
			's'              => esc_sql( $_GET[ 'query' ] ),
			'orderby'        => 'title',
			'order'          => 'ASC'
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$result[] = array(
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'text'  => get_the_title(),
				);
			}
		}
		
		wp_reset_postdata();
		
		wp_send_json_success( $result );
	} );
	
	add_action( 'wp_ajax__upb_element_upb-contact-form-7_idx_load', function () {
		
		upb_check_ajax_access();
		
		$ids = array_map( 'esc_attr', $_GET[ 'id' ] );
		
		
		if ( empty( $ids ) ) {
			wp_send_json_success( array() );
		} else {
			
			$ids = array_unique( $ids );
			
			$posts = get_posts( array(
				                    'posts_per_page' => - 1,
				                    'orderby'        => 'ID',
				                    'sort_order'     => 'desc',
				                    'post__in'       => $ids,
				                    'post_type'      => 'wpcf7_contact_form',
			                    ) );
			
			$data = array();
			foreach ( $posts as $post ) :
				$data[] = array(
					'id'    => $post->ID,
					'title' => esc_html( $post->post_title ),
					'text'  => esc_html( $post->post_title )
				);
			endforeach;
			
			wp_send_json_success( $data );
		}
	} );
	
	// MailChimp
	add_action( 'wp_ajax__upb_upb-mc4wp_form_preview_contents', function () {
		
		upb_check_ajax_access();
		
		ob_start();
		
		if ( function_exists( 'mc4wp_show_form' ) ) {
			mc4wp_show_form();
		}
		
		$data = ob_get_clean();
		wp_send_json_success( $data );
	} );
	
	// WP_Widget_Archives
	add_action( 'wp_ajax__upb_upb-wp_widget_archives_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-widget-archives.php line#135
		$instance = wp_parse_args( array(
			                           'title'    => sanitize_text_field( $_POST[ 'title' ] ),
			                           'dropdown' => upb_return_boolean( $_POST[ 'dropdown' ] ),
			                           'count'    => upb_return_boolean( $_POST[ 'count' ] )
		                           ), array(
			                           'title'    => '',
			                           'count'    => 0,
			                           'dropdown' => ''
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Archives', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Archives', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( str_ireplace( 'onchange=', 'data-onchange=', $contents ) );
	} );
	
	// WP_Nav_Menu_Widget
	add_action( 'wp_ajax__upb_upb-wp_nav_menu_widget_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-nav-menu-widget.php line#95
		$instance = wp_parse_args( array(
			                           'title'    => sanitize_text_field( $_POST[ 'title' ] ),
			                           'nav_menu' => absint( $_POST[ 'nav_menu' ] ),
		                           ), array(
			                           'title'    => '',
			                           'nav_menu' => 0
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Nav_Menu_Widget', $instance );
		
		ob_start();
		the_widget( 'WP_Nav_Menu_Widget', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Calendar
	add_action( 'wp_ajax__upb_upb-wp_widget_calendar_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-widget-calendar.php line#54
		$instance = wp_parse_args( array(
			                           'title' => sanitize_text_field( $_POST[ 'title' ] )
		                           ), array(
			                           'title' => ''
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Calendar', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Calendar', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Categories
	add_action( 'wp_ajax__upb_upb-wp_widget_categories_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-widget-categories.php line#44
		$instance = wp_parse_args( array(
			                           'title'        => sanitize_text_field( $_POST[ 'title' ] ),
			                           'dropdown'     => upb_return_boolean( $_POST[ 'dropdown' ] ),
			                           'count'        => upb_return_boolean( $_POST[ 'count' ] ),
			                           'hierarchical' => upb_return_boolean( $_POST[ 'hierarchical' ] ),
		                           ), array(
			                           'title'        => esc_html__( 'Categories', 'ultimate-page-builder' ),
			                           'dropdown'     => FALSE,
			                           'count'        => FALSE,
			                           'hierarchical' => FALSE,
		                           ) );
		
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Categories', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Categories', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Categories
	add_action( 'wp_ajax__upb_upb-wp_widget_links_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-widget-categories.php line#44
		$instance = wp_parse_args( array(
			                           'title'       => sanitize_text_field( $_POST[ 'title' ] ),
			                           'category'    => absint( $_POST[ 'category' ] ),
			                           'orderby'     => sanitize_text_field( $_POST[ 'orderby' ] ),
			                           'images'      => upb_return_boolean( $_POST[ 'images' ] ),
			                           'name'        => upb_return_boolean( $_POST[ 'name' ] ),
			                           'description' => upb_return_boolean( $_POST[ 'description' ] ),
			                           'rating'      => upb_return_boolean( $_POST[ 'rating' ] ),
			                           'limit'       => sanitize_text_field( $_POST[ 'limit' ] ),
		                           ), array(
			                           'title'       => esc_html__( 'Links', 'ultimate-page-builder' ),
			                           'category'    => '',
			                           'orderby'     => 'name',
			                           'images'      => 0,
			                           'name'        => 0,
			                           'description' => 0,
			                           'rating'      => 0,
			                           'limit'       => '-1',
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Categories', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Links', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Meta
	add_action( 'wp_ajax__upb_upb-wp_widget_meta_preview_contents', function () {
		
		upb_check_ajax_access();
		
		// Check /wp-includes/widgets/class-wp-widget-calendar.php line#54
		$instance = wp_parse_args( array( 'title' => sanitize_text_field( $_POST[ 'title' ] ) ), array( 'title' => '' ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Meta', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Meta', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Pages
	add_action( 'wp_ajax__upb_upb-wp_widget_pages_preview_contents', function () {
		
		upb_check_ajax_access();
		
		$instance = wp_parse_args( array(
			                           'title'   => sanitize_text_field( $_POST[ 'title' ] ),
			                           'sortby'  => sanitize_text_field( $_POST[ 'sortby' ] ),
			                           'exclude' => implode( ',', array_map( 'absint', $_POST[ 'exclude' ] ) ),
		                           ), array(
			                           'title'   => '',
			                           'sortby'  => 'menu_order',
			                           'exclude' => '',
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Pages', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Pages', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Recent_Comments
	add_action( 'wp_ajax__upb_upb-wp_widget_recent_comments_preview_contents', function () {
		
		upb_check_ajax_access();
		
		$instance = wp_parse_args( array(
			                           'title'     => sanitize_text_field( $_POST[ 'title' ] ),
			                           'number'    => absint( $_POST[ 'number' ] ),
			                           'show_date' => upb_return_boolean( $_POST[ 'show_date' ] ),
		                           ), array(
			                           'title'     => '',
			                           'number'    => 5,
			                           'show_date' => FALSE
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Recent_Comments', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Recent_Comments', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Recent_Posts
	add_action( 'wp_ajax__upb_upb-wp_widget_recent_posts_preview_contents', function () {
		
		upb_check_ajax_access();
		
		$instance = wp_parse_args( array(
			                           'title'     => sanitize_text_field( $_POST[ 'title' ] ),
			                           'number'    => absint( $_POST[ 'number' ] ),
			                           'show_date' => upb_return_boolean( $_POST[ 'show_date' ] ),
		                           ), array(
			                           'title'     => '',
			                           'number'    => 5,
			                           'show_date' => FALSE
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Recent_Posts', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Recent_Posts', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Search
	add_action( 'wp_ajax__upb_upb-wp_widget_search_preview_contents', function () {
		
		upb_check_ajax_access();
		
		$instance = wp_parse_args( array(
			                           'title' => sanitize_text_field( $_POST[ 'title' ] ),
		                           ), array(
			                           'title' => '',
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Search', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Search', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// WP_Widget_Text
	add_action( 'wp_ajax__upb_upb-wp_widget_text_preview_contents', function () {
		
		upb_check_ajax_access();
		
		$instance = wp_parse_args( array(
			                           'title'  => sanitize_text_field( $_POST[ 'title' ] ),
			                           'text'   => upb_return_boolean( $_POST[ 'filter' ] ) ? wp_kses_post( $_POST[ 'text' ] ) : esc_textarea( $_POST[ 'text' ] ),
			                           'filter' => upb_return_boolean( $_POST[ 'filter' ] ),
		                           ), array(
			                           'title'  => '',
			                           'text'   => '',
			                           'filter' => FALSE
		                           ) );
		
		$args = apply_filters( 'upb-element-wp-widget-args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle widget-title">',
			'after_title'   => '</h2>'
		), 'WP_Widget_Search', $instance );
		
		ob_start();
		the_widget( 'WP_Widget_Text', $instance, $args );
		$contents = ob_get_clean();
		wp_send_json_success( $contents );
	} );
	
	// Ajax Shortcode Preview: $_upb_options => preview => shortcode => true
	add_action( 'wp_ajax__upb_shortcode_preview_contents', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_POST[ 'shortcode' ] ) ) {
			wp_send_json_error( 'no_shortcode', 204 );
		}
		
		$contents = do_shortcode( wp_kses_post( stripslashes( $_POST[ 'shortcode' ] ) ) );
		wp_send_json_success( $contents );
	} );
	
	add_action( 'wp_ajax__upb_icon_popup_load', function () {
		
		upb_check_ajax_access();
		
		if ( empty( $_GET[ 'provider' ] ) ) {
			wp_send_json_error( 'no_provider', 204 );
		}
		
		if ( empty( $_GET[ 'start' ] ) ) {
			$start = 0;
		} else {
			$start = absint( $_GET[ 'start' ] );
		}
		
		if ( empty( $_GET[ 'limit' ] ) ) {
			$limit = 160;
		} else {
			$limit = absint( $_GET[ 'limit' ] );
		}
		
		if ( isset( $_GET[ 'search' ] ) && ! empty( $_GET[ 'search' ] ) ) {
			$search = strtolower( trim( $_GET[ 'search' ] ) );
		} else {
			$search = FALSE;
		}
		
		$all_icons = apply_filters( 'upb_icon_popup_icons', array(), strtolower( $_GET[ 'provider' ] ) );
		
		if ( $search ) {
			// Search Icon
			$all_icons = array_filter( $all_icons, function ( $icon ) use ( $search ) {
				$p = strpos( strtolower( $icon ), $search );
				
				if ( $p === FALSE ) {
					return FALSE;
				} else {
					return TRUE;
				}
			} );
		}
		
		// Icon Object
		$icons = array_values( array_map( function ( $icon, $key ) {
			return array( 'id' => $key, 'name' => $icon );
		}, $all_icons, array_keys( $all_icons ) ) );
		
		$icons = array(
			'total' => count( $icons ),
			'start' => $start,
			'limit' => $limit,
			'icons' => array_slice( $icons, $start, $limit ),
		);
		
		wp_send_json_success( $icons );
		
	} );
	
	//  Example: Section title generatedAttributes
	/*    add_action( 'wp_ajax__upb_generate_attribute_upb-section_title', function () {
			upb_check_ajax_access();
	
			if ( empty( $_GET[ 'attribute_value' ] ) ) {
				wp_send_json_success( '#' );
			}
			wp_send_json_success( esc_html( "%% {$_POST[ 'attribute_value' ]} %%" ) );
	
		} );*/