<?php
session_start();
//constants
define( 'CT_VERSION', '1.0.5' );
define( 'CT_DB_VERSION', '1.1' );
define( 'CT_TEMPLATE_DIRECTORY_URI', get_template_directory_uri() );
define( 'CT_IMAGE_URL', CT_TEMPLATE_DIRECTORY_URI . '/img' );
define( 'CT_INC_DIR', get_template_directory() . '/inc' );
define( 'RWMB_URL', CT_TEMPLATE_DIRECTORY_URI . '/inc/lib/meta-box/' );
define( 'CT_TAX_META_DIR_URL', CT_TEMPLATE_DIRECTORY_URI . '/inc/lib/tax-meta-class/' );
global $wpdb;
define( 'CT_HOTEL_VACANCIES_TABLE', $wpdb->prefix . 'ct_hotel_vacancies' );
define( 'CT_HOTEL_BOOKINGS_TABLE', $wpdb->prefix . 'ct_hotel_bookings' );
define( 'CT_CRUISE_VACANCIES_TABLE', $wpdb->prefix . 'ct_cruise_vacancies' );
define( 'CT_CRUISE_BOOKINGS_TABLE', $wpdb->prefix . 'ct_cruise_bookings' );
define( 'CT_TRANSFER_BOOKINGS_TABLE', $wpdb->prefix . 'ct_transfer_bookings' );
define( 'CT_GOLF_BOOKINGS_TABLE', $wpdb->prefix . 'ct_golf_bookings' );
define( 'CT_ADD_HOTEL_BOOKINGS_TABLE', $wpdb->prefix . 'ct_add_hotel_bookings' );
define( 'CT_REVIEWS_TABLE', $wpdb->prefix . 'ct_reviews' );
// define( 'CT_MODE', 'product' );
define( 'CT_ADD_SERVICES_TABLE', $wpdb->prefix . 'ct_add_services' );
define( 'CT_ADD_SERVICES_BOOKINGS_TABLE', $wpdb->prefix . 'ct_add_service_bookings' );
define( 'CT_TOUR_SCHEDULES_TABLE', $wpdb->prefix . 'ct_tour_schedules' );
define( 'CT_TOUR_SCHEDULE_META_TABLE', $wpdb->prefix . 'ct_tour_schedule_meta' );
define( 'CT_TOUR_BOOKINGS_TABLE', $wpdb->prefix . 'ct_tour_bookings' );
define( 'CT_CURRENCIES_TABLE', $wpdb->prefix . 'ct_currencies' );
define( 'CT_ORDER_TABLE', $wpdb->prefix . 'ct_order' );
define( 'CT_MODE', 'dev' );


if ( ! class_exists( 'ReduxFramework' ) ) {
    require_once( CT_INC_DIR . '/lib/redux-framework/ReduxCore/framework.php' );
}
if ( ! isset( $redux_demo ) ) {
    require_once( CT_INC_DIR . '/lib/redux-framework/config.php' );
}

//require files
require_once( CT_INC_DIR . '/lib/meta-box/meta-box.php' );
require_once( CT_INC_DIR . '/lib/multiple_sidebars.php' );
require_once( CT_INC_DIR . '/functions/main.php' );
require_once( CT_INC_DIR . '/shortcode/init.php' );
require_once( CT_INC_DIR . '/js_composer/init.php' );
require_once( CT_INC_DIR . '/admin/main.php');
require_once( CT_INC_DIR . '/frontend/main.php');

// Translation
load_theme_textdomain('citytours', get_template_directory() . '/languages');

//theme supports
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );

global $wp_version;
if ( version_compare( $wp_version, '4.1', '>=' ) ) {
	add_theme_support( 'title-tag' );
	add_filter( 'wp_title', 'ct_wp_title', 10, 2 );
} else {
	add_filter( 'wp_title', 'ct_wp_title_old', 10, 2 );
}
if ( ! isset( $content_width ) ) $content_width = 900;

add_image_size( 'ct-list-thumb', 400, 267, true );
add_image_size( 'tnd-list-thumb', 45, 45, true );
add_image_size( 'tnd-post-galery', 130, 130, true );
//actions
add_action( 'init', 'ct_init' );
add_action( 'wp_enqueue_scripts', 'ct_enqueue_scripts' );
add_action( 'wp_footer', 'ct_inline_script' );
add_action( 'tgmpa_register', 'ct_register_required_plugins' );
add_action( 'admin_menu', 'ct_remove_redux_menu',12 );
add_action( 'widgets_init', 'ct_register_sidebar' );
// add_action( 'user_register', 'ct_user_register' );
add_action( 'wp_login_failed', 'ct_login_failed' );
add_action( 'lost_password', 'ct_lost_password' );
add_action( 'comment_form_before', 'ct_enqueue_comment_reply' );

add_filter( '404_template', 'ct_show404' );
add_filter( 'authenticate', 'ct_authenticate', 1, 3);
add_filter( 'get_default_comment_status', 'ct_open_comments_for_myposttype', 10, 3 );

remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );
/*
 * Calculate tour price if tour = tour package
 */
//add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_filter('widget_text', 'do_shortcode');
add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );
function wsds_defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = array( 
		'ct_script_common',
		'ct_script_functions',
		'ct_script_jquery_validate',
		'ct_script_datepicker',
		'ct_script_google_map',
		'ct_script_map',
		'ct_script_infobox',
		'ct_script_icheck',
		//'jquery-core',
		//'jquery-migrate', 
	);

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
}

//Making jQuery Google API
function modify_jquery() {
if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery-core');
		//wp_deregister_script('jquery-migrate');
		wp_register_script('jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', false, '3.6', false);
	   	//wp_register_script('jquery-core', 'https://city-tour2-cat7777.c9users.io/wp-includes/js/jquery/jquery.js', false, '1.11.3', true);
		wp_enqueue_script('jquery-core');
	}
}
add_action('init', 'modify_jquery');

