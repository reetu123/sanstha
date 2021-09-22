<?php

add_action( 'init', 'slider_post');
	function slider_post() {
		register_post_type('Slider',
			array(
				'labels' => array(
					'name' => 'Slider',
					'singular_name' => 'Slider',
					'add_new' => 'Add New',
					'add_new_item' => 'Add New',
					'edit_item' => 'Edit',
					'new_item' => 'New',
					'all_items' => 'All items',
					'view_item' => 'View items',
					'search_items' => 'Search Items',
					'featured_image' => 'Featured Image',
					'set_featured_image' => __( 'Set Featured Image' ),
					'remove_featured_image' => __( 'Remove Featured Image' ),
					'not_found' => 'No Featured found',
					'not_found_in_trash' => 'No Featured found in the Trash',
					'menu_name' => 'Slider'
				),
					'menu_position' => 9,
					'supports' => array('title','editor','thumbnail','taxonomy'),
					'hierarchical' => true,
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => true,
					'menu_icon' => 'dashicons-admin-generic',
					'can_export' => true,
					'has_archive' => false,
					'show_in_rest' => true,
					'exclude_from_search' => false,
					'publicly_queryable' => true,
					'capability_type' => 'page'
			)
			
		);
	
	}

