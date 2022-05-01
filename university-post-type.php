<?php 

function University_post_type() {

		register_post_type( 'campus', array(
			'supports' => array( 'title', 'editor', 'excerpt' ),
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'campuses' ),
			'public' => true,
			'labels' => array(
				'name' => 'Campus',
				'all_items' => 'All Campuses',
				'add_new_item' => 'Add New Campus',
				'edit_item' => 'Edit Campus',
				'singular_name' => 'Campus',
			),

			'menu_icon' => 'dashicons-location-alt',
		) );
		register_post_type( 'event', array(
			'supports' => array( 'title', 'editor', 'excerpt' ),
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'events' ),
			'public' => true,
			'labels' => array(
				'name' => 'Events',
				'all_items' => 'All Events',
				'add_new_item' => 'Add New Event',
				'edit_item' => 'Edit Event',
				'singular_name' => 'Event',
			),

			'menu_icon' => 'dashicons-calendar',
		) );

		register_post_type( 'program', array(
			'supports' => array( 'title' ),
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'programs' ),
			'public' => true,
			'labels' => array(
				'name' => 'programs',
				'all_items' => 'All programs',
				'add_new_item' => 'Add New program',
				'edit_item' => 'Edit program',
				'singular_name' => 'Program',
			),

			'menu_icon' => 'dashicons-awards',
		) );

		register_post_type( 'professor', array(
			'show_in_rest' => true,
			'supports' => array( 'title', 'editor', 'thumbnail'),
			'public' => true,
			'labels' => array(
				'name' => 'Professors',
				'all_items' => 'All Professors',
				'add_new_item' => 'Add New Professor',
				'edit_item' => 'Edit Professor',
				'singular_name' => 'Professor',
			),

			'menu_icon' => 'dashicons-welcome-learn-more',
		) );
	}

add_action( 'init', 'University_post_type' );
