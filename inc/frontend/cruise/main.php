<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once( CT_INC_DIR . '/frontend/cruise/functions.php');
require_once( CT_INC_DIR . '/frontend/cruise/templates.php');
require_once( CT_INC_DIR . '/frontend/cruise/ajax.php');
//require_once( CT_INC_DIR . '/frontend/cruise/class.order.php');
require_once( CT_INC_DIR . '/frontend/cruise/class.cart.php');

add_action( 'ct_hotel_booking_wrong_data', 'ct_redirect_home' );
add_action( 'ct_hotel_thankyou_wrong_data', 'ct_redirect_home' );
add_action( 'wp_ajax_ct_cruise_update_cart', 'ct_cruise_update_cart' );
add_action( 'wp_ajax_nopriv_ct_cruise_update_cart', 'ct_cruise_update_cart' );
add_action( 'wp_ajax_ct_cruise_submit_booking', 'ct_cruise_submit_booking' );
add_action( 'wp_ajax_nopriv_ct_cruise_submit_booking', 'ct_cruise_submit_booking' );