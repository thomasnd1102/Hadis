<?php
/**
 * Plugin Name: CTBooking
 * Plugin URI: http://www.soaptheme.net/ctbooking/
 * Description: A booking system
 * Version: 1.0
 * Author: Soaptheme
 * Author URI: http://www.soaptheme.net
 */
if ( ! function_exists( 'ct_register_hotel_post_type' ) ) {
	function ct_register_hotel_post_type() {
		$labels = array(
			'name'                => _x( 'Hotels', 'Post Type General Name', 'ct' ),
			'singular_name'       => _x( 'Hotel', 'Post Type Singular Name', 'ct' ),
			'menu_name'           => __( 'Hotels', 'ct' ),
			'all_items'           => __( 'All Hotels', 'ct' ),
			'view_item'           => __( 'View Hotel', 'ct' ),
			'add_new_item'        => __( 'Add New Hotel', 'ct' ),
			'add_new'             => __( 'New Hotel', 'ct' ),
			'edit_item'           => __( 'Edit Hotels', 'ct' ),
			'update_item'         => __( 'Update Hotels', 'ct' ),
			'search_items'        => __( 'Search Hotels', 'ct' ),
			'not_found'           => __( 'No Hotels found', 'ct' ),
			'not_found_in_trash'  => __( 'No Hotels found in Trash', 'ct' ),
		);
		$args = array(
			'label'               => __( 'hotel', 'ct' ),
			'description'         => __( 'Hotel information pages', 'ct' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);
		register_post_type( 'hotel', $args );
	}
}

/*
 * register room post type
 */
if ( ! function_exists( 'ct_register_room_type_post_type' ) ) {
	function ct_register_room_type_post_type() {
		$labels = array(
			'name'                => _x( 'Room Types', 'Post Type Name', 'ct' ),
			'singular_name'       => _x( 'Room Type', 'Post Type Singular Name', 'ct' ),
			'menu_name'           => __( 'Room Types', 'ct' ),
			'all_items'           => __( 'All Room Types', 'ct' ),
			'view_item'           => __( 'View Room Type', 'ct' ),
			'add_new_item'        => __( 'Add New Room', 'ct' ),
			'add_new'             => __( 'New Room Types', 'ct' ),
			'edit_item'           => __( 'Edit Room Types', 'ct' ),
			'update_item'         => __( 'Update Room Types', 'ct' ),
			'search_items'        => __( 'Search Room Types', 'ct' ),
			'not_found'           => __( 'No Room Types found', 'ct' ),
			'not_found_in_trash'  => __( 'No Room Types found in Trash', 'ct' ),
		);
		$args = array(
			'label'               => __( 'room types', 'ct' ),
			'description'         => __( 'Room Type information pages', 'ct' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			//'show_in_menu'        => 'edit.php?post_type=hotel',
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite' => array('slug' => 'room-type', 'with_front' => true)
		);
		if ( current_user_can( 'manage_options' ) ) {
			$args['show_in_menu'] = 'edit.php?post_type=hotel';
		}
		register_post_type( 'room_type', $args );
	}
}

/*
 * register District taxonomy
 */
if ( ! function_exists( 'ct_register_hotel_district_taxonomy' ) ) {
	function ct_register_hotel_district_taxonomy(){
		$labels = array(
				'name'              => _x( 'Districts', 'taxonomy general name', 'ct' ),
				'singular_name'     => _x( 'District', 'taxonomy singular name', 'ct' ),
				'menu_name'         => __( 'Districts', 'ct' ),
				'all_items'         => __( 'All Districts', 'ct' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New District', 'ct' ),
				'add_new_item'      => __( 'Add New District', 'ct' ),
				'edit_item'         => __( 'Edit District', 'ct' ),
				'update_item'       => __( 'Update District', 'ct' ),
				'separate_items_with_commas' => __( 'Separate Districts with commas', 'ct' ),
				'search_items'      => __( 'Search Districts', 'ct' ),
				'add_or_remove_items'        => __( 'Add or remove Districts', 'ct' ),
				'choose_from_most_used'      => __( 'Choose from the most used Districts', 'ct' ),
				'not_found'                  => __( 'No Districts found.', 'ct' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'district', array( 'hotel' ), $args );
	}
}

/*
 * register hotel facility taxonomy
 */
if ( ! function_exists( 'ct_register_hotel_facility_taxonomy' ) ) {
	function ct_register_hotel_facility_taxonomy(){
		$labels = array(
				'name'              => _x( 'Hotel Facilities', 'taxonomy general name', 'ct' ),
				'singular_name'     => _x( 'Hotel Facility', 'taxonomy singular name', 'ct' ),
				'menu_name'         => __( 'Hotel Facilities', 'ct' ),
				'all_items'         => __( 'All Hotel Facilities', 'ct' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Hotel Facility', 'ct' ),
				'add_new_item'      => __( 'Add New Hotel Facility', 'ct' ),
				'edit_item'         => __( 'Edit Hotel Facility', 'ct' ),
				'update_item'       => __( 'Update Hotel Facility', 'ct' ),
				'separate_items_with_commas' => __( 'Separate hotel facilities with commas', 'ct' ),
				'search_items'      => __( 'Search Hotel Facilities', 'ct' ),
				'add_or_remove_items'        => __( 'Add or remove hotel facilities', 'ct' ),
				'choose_from_most_used'      => __( 'Choose from the most used hotel facilities', 'ct' ),
				'not_found'                  => __( 'No hotel facilities found.', 'ct' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'hotel_facility', array( 'room_type', 'hotel' ), $args );
	}
}

// Post Types for Tour
/*
 * register tour post type
 */
if ( ! function_exists( 'ct_register_tour_post_type' ) ) {
	function ct_register_tour_post_type() {
		$labels = array(
			'name'                => _x( 'Tours', 'Post Type General Name', 'ct' ),
			'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'ct' ),
			'menu_name'           => __( 'Tours', 'ct' ),
			'all_items'           => __( 'All Tours', 'ct' ),
			'view_item'           => __( 'View Tour', 'ct' ),
			'add_new_item'        => __( 'Add New Tour', 'ct' ),
			'add_new'             => __( 'New Tour', 'ct' ),
			'edit_item'           => __( 'Edit Tours', 'ct' ),
			'update_item'         => __( 'Update Tours', 'ct' ),
			'search_items'        => __( 'Search Tours', 'ct' ),
			'not_found'           => __( 'No Tours found', 'ct' ),
			'not_found_in_trash'  => __( 'No Tours found in Trash', 'ct' ),
		);
		$args = array(
			'label'               => __( 'tour', 'ct' ),
			'description'         => __( 'Tour information pages', 'ct' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);
		register_post_type( 'tour', $args );
	}
}

/*
 * register tour type taxonomy
 */
if ( ! function_exists( 'ct_register_tour_type_taxonomy' ) ) {
	function ct_register_tour_type_taxonomy(){
		$labels = array(
				'name'              => _x( 'Tour Types', 'taxonomy general name', 'ct' ),
				'singular_name'     => _x( 'Tour Type', 'taxonomy singular name', 'ct' ),
				'menu_name'         => __( 'Tour Types', 'ct' ),
				'all_items'         => __( 'All Tour Types', 'ct' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Tour Type', 'ct' ),
				'add_new_item'      => __( 'Add New Tour Type', 'ct' ),
				'edit_item'         => __( 'Edit Tour Type', 'ct' ),
				'update_item'       => __( 'Update Tour Type', 'ct' ),
				'separate_items_with_commas' => __( 'Separate tour types with commas', 'ct' ),
				'search_items'      => __( 'Search Tour Types', 'ct' ),
				'add_or_remove_items'        => __( 'Add or remove tour types', 'ct' ),
				'choose_from_most_used'      => __( 'Choose from the most used tour types', 'ct' ),
				'not_found'                  => __( 'No tour types found.', 'ct' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false,
				'rewrite' => array('slug' => 'tour-type', 'with_front' => true)
			);
		register_taxonomy( 'tour_type', array( 'tour' ), $args );
	}
}

/*
 * register tour facility taxonomy
 */
if ( ! function_exists( 'ct_register_tour_facility_taxonomy' ) ) {
	function ct_register_tour_facility_taxonomy(){
		$labels = array(
				'name'              => _x( 'Tour Facilities', 'taxonomy general name', 'ct' ),
				'singular_name'     => _x( 'Tour Facility', 'taxonomy singular name', 'ct' ),
				'menu_name'         => __( 'Tour Facilities', 'ct' ),
				'all_items'         => __( 'All Tour Facilities', 'ct' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Tour Facility', 'ct' ),
				'add_new_item'      => __( 'Add New Tour Facility', 'ct' ),
				'edit_item'         => __( 'Edit Tour Facility', 'ct' ),
				'update_item'       => __( 'Update Tour Facility', 'ct' ),
				'separate_items_with_commas' => __( 'Separate tour facilities with commas', 'ct' ),
				'search_items'      => __( 'Search Tour Facilities', 'ct' ),
				'add_or_remove_items'        => __( 'Add or remove tour facilities', 'ct' ),
				'choose_from_most_used'      => __( 'Choose from the most used tour facilities', 'ct' ),
				'not_found'                  => __( 'No tour facilities found.', 'ct' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'tour_facility', array( 'tour' ), $args );
	}
}

/*
 * register cruise post_types
 */
if ( ! function_exists( 'ct_register_cruise_post_type' ) ) {
	function ct_register_cruise_post_type() {
		$labels = array(
			'name'                => _x( 'Cruise', 'Post Type General Name', 'ct' ),
			'singular_name'       => _x( 'Cruise', 'Post Type Singular Name', 'ct' ),
			'menu_name'           => __( 'Cruises', 'ct' ),
			'all_items'           => __( 'All Cruises', 'ct' ),
			'view_item'           => __( 'View Cruise', 'ct' ),
			'add_new_item'        => __( 'Add New Cruise', 'ct' ),
			'add_new'             => __( 'New Cruise', 'ct' ),
			'edit_item'           => __( 'Edit Cruise', 'ct' ),
			'update_item'         => __( 'Update Cruises', 'ct' ),
			'search_items'        => __( 'Search Cruises', 'ct' ),
			'not_found'           => __( 'No Cruises found', 'ct' ),
			'not_found_in_trash'  => __( 'No Cruises found in Trash', 'ct' ),
		);
		$args = array(
			'label'               => __( 'cruise', 'ct' ),
			'description'         => __( 'Cruise information pages', 'ct' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);
		register_post_type( 'cruise', $args );
	}
} 
/*
 * register cabin post type
 */
if ( ! function_exists( 'ct_register_cabin_type_post_type' ) ) {
	function ct_register_cabin_type_post_type() {
		$labels = array(
			'name'                => _x( 'Cabin Types', 'Post Type Name', 'ct' ),
			'singular_name'       => _x( 'Cabin Type', 'Post Type Singular Name', 'ct' ),
			'menu_name'           => __( 'Cabin Types', 'ct' ),
			'all_items'           => __( 'All Cabin Types', 'ct' ),
			'view_item'           => __( 'View Cabin Type', 'ct' ),
			'add_new_item'        => __( 'Add New Cabin', 'ct' ),
			'add_new'             => __( 'New Cabin Types', 'ct' ),
			'edit_item'           => __( 'Edit Cabin Types', 'ct' ),
			'update_item'         => __( 'Update Cabin Types', 'ct' ),
			'search_items'        => __( 'Search Cabin Types', 'ct' ),
			'not_found'           => __( 'No Cabin Types found', 'ct' ),
			'not_found_in_trash'  => __( 'No Cabin Types found in Trash', 'ct' ),
		);
		$args = array(
			'label'               => __( 'cabin types', 'ct' ),
			'description'         => __( 'Cabin Type information pages', 'ct' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			//'show_in_menu'        => 'edit.php?post_type=hotel',
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite' => array('slug' => 'room-type', 'with_front' => true)
		);
		if ( current_user_can( 'manage_options' ) ) {
			$args['show_in_menu'] = 'edit.php?post_type=cabin';
		}
		register_post_type( 'cabin_type', $args );
	}
}
/*
 * register cruise facility taxonomy
 */
if ( ! function_exists( 'ct_register_cruise_facility_taxonomy' ) ) {
	function ct_register_cruise_facility_taxonomy(){
		$labels = array(
				'name'              => _x( 'Cruise Facilities', 'taxonomy general name', 'ct' ),
				'singular_name'     => _x( 'Cruise Facility', 'taxonomy singular name', 'ct' ),
				'menu_name'         => __( 'Cruise Facilities', 'ct' ),
				'all_items'         => __( 'All Cruise Facilities', 'ct' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Cruise Facility', 'ct' ),
				'add_new_item'      => __( 'Add New Cruise Facility', 'ct' ),
				'edit_item'         => __( 'Edit Cruise Facility', 'ct' ),
				'update_item'       => __( 'Update Cruise Facility', 'ct' ),
				'separate_items_with_commas' => __( 'Separate cruise facilities with commas', 'ct' ),
				'search_items'      => __( 'Search Cruise Facilities', 'ct' ),
				'add_or_remove_items'        => __( 'Add or remove cruise facilities', 'ct' ),
				'choose_from_most_used'      => __( 'Choose from the most used cruise facilities', 'ct' ),
				'not_found'                  => __( 'No cruise facilities found.', 'ct' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'cruise_facility', array( 'cabin_type', 'cruise' ), $args );
	}
}
 /*
 * init custom post_types
 */
if ( ! function_exists( 'ct_init_custom_post_types' ) ) {
	function ct_init_custom_post_types(){
		global $ct_options;
		if ( empty( $ct_options['disable_hotel'] ) ) {
			ct_register_hotel_post_type();
			ct_register_room_type_post_type();
			ct_register_hotel_district_taxonomy();
			ct_register_hotel_facility_taxonomy();
		}

		if ( empty( $ct_options['disable_tour'] ) ) {
			ct_register_tour_post_type();
			ct_register_tour_type_taxonomy();
			ct_register_tour_facility_taxonomy();
		}
	}
}

/*
 * hide Add Hotel Submenu on sidebar
 */
if ( ! function_exists( 'ct_hd_add_hotel_box' ) ) {
	function ct_hd_add_hotel_box() {
		if ( current_user_can( 'manage_options' ) ) {
			global $submenu;
			unset($submenu['edit.php?post_type=hotel'][10]);
		}
	}
}

add_action( 'init', 'ct_init_custom_post_types', 0 );
add_action('admin_menu', 'ct_hd_add_hotel_box');