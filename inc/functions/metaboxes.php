<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'admin_enqueue_scripts', 'ct_admin_enqueue_scripts', 10, 1 );

add_filter( 'rwmb_meta_boxes', 'ct_plugin_register_meta_boxes' );
add_filter( 'rwmb_meta_boxes', 'ct_theme_register_meta_boxes' );
// add_action( "add_meta_boxes", "ct_tour_schedule_meta_box" );
add_action( "add_meta_boxes", "ct_hotel_rooms_meta_box" );
add_action( "add_meta_boxes", "ct_cruise_cabins_meta_box" );
add_action( "add_meta_boxes", "ct_add_services_meta_box" );
add_action( 'save_post', 'ct_save_schedule_data' );
add_action( 'save_post', 'ct_save_add_service_data' );
add_action( 'admin_enqueue_scripts', 'ct_metabox_admin_enqueue_scripts' );
/*
 * tour metabox enqueue script
 */
if ( ! function_exists( 'ct_admin_enqueue_scripts' ) ) {
	function ct_admin_enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( 'post' == $screen->base ) {
			wp_enqueue_script( 'ct_admin_hotel_admin_js', CT_TEMPLATE_DIRECTORY_URI . '/inc/admin/js/admin.js', array('jquery'), '', true );
		}
	}
}

/*
 * post metabox registration
 */
if ( ! function_exists( 'ct_post_register_meta_boxes' ) ) { 
	function ct_post_register_meta_boxes() {
		$meta_boxes = array();
		if ( class_exists( 'RevSlider' ) ) {
			$meta_boxes[] = array(
				'id'          => 'slider_setting',
				'title'       => esc_html__( 'Slider Setting', 'citytours' ),
				'description' => esc_html__( 'Select your options to display a slider above the masthead.', 'citytours' ),
				'pages'        => array('page'),
				'context'     => 'normal',
				'priority'    => 'high',
				'fields'      => array( 
					array(
						'name' => esc_html__( 'Revolution Slider', 'citytours' ),
						'desc' => esc_html__( 'To activate your slider, select an option from the dropdown. To deactivate your slider, set the dropdown back to "Deactivated."', 'citytours' ),
						'id'   => "_rev_slider",
						'type' => 'rev_slider',
						'std'  => 'Deactivated',
						'placeholder' => 'Deactivated'
					)
				)
			);
		}

		$meta_boxes[] = array(
			'id' => 'header_image_setting',
			'title' => esc_html__( 'Header Image Setting', 'citytours' ),
			'pages' => array( 'post', 'page' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'   => esc_html__( 'Header Image', 'citytours' ),
					'id'    => "_header_image",
					'type'   => 'image_advanced',
					'desc' => wp_kses_post( sprintf( __( 'If you do not set this field, default image src that you set in <a href="%s" target="_blank">theme options panel</a> will work.', 'citytours' ), admin_url( 'themes.php?page=CityTours' ) ) ) ,
					'max_file_uploads' => 1,
				),
				array(
					'name'  => esc_html__( 'Height (px)', 'citytours' ),
					'id'      => "_header_image_height",
					'desc' => wp_kses_post( sprintf( __( 'If you do not set this field, default image height that you set in <a href="%s" target="_blank">theme options panel</a> will work.', 'citytours' ), admin_url( 'themes.php?page=CityTours' ) ) ) ,
					'type'  => 'text',
				),
				array(
					'name' => esc_html__( 'Header Content', 'citytours' ),
					'id'   => "_header_content",
					'type' => 'wysiwyg',
					'raw'  => true,
					'options' => array(
						'textarea_rows' => 4,
					),
				),
			)
		);

		$meta_boxes[] = array(
			'id' => 'custom_css',
			'title' => esc_html__( 'Custom CSS', 'citytours' ),
			'pages' => array( 'post', 'page' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Custom CSS', 'citytours' ),
					'id'      => "_custom_css",
					'desc'  => esc_html__( 'Enter custom css code here.', 'citytours' ),
					'type'  => 'textarea',
				)
			)
		);

		global $wp_registered_sidebars;

		foreach($wp_registered_sidebars as $sidebar) {
			$sidebars[$sidebar['id']] = $sidebar['name'];
		}
		$sidebars['default'] = esc_html__('default', 'citytours');

		$meta_boxes[] = array(
			'id' => 'ct-metabox-page-sidebar',
			'title' => esc_html__( 'Page layout', 'citytours' ),
			'pages' => array( 'post', 'page' ),
			'context' => 'side',
			'priority' => 'low',
			'fields' => array(
				// Sidebar option
				array(
					'name' => esc_html__( 'Sidebar position:', 'citytours' ),
					'id' => '_ct_sidebar_position',
					'type' => 'radio',
					'std' => 'default',
					'desc' => esc_html__( 'If you set this setting as default, the default setting that you set on theme-options panel will work.', 'citytours' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'citytours' ),
						'no' => esc_html__( 'No Sidebar', 'citytours' ),
						'left' => esc_html__( 'Left', 'citytours' ),
						'right' => esc_html__( 'Right', 'citytours' ),
					)
				),

				// Sidebar widget area
				array(
					'name' => esc_html__( 'Select Sidebar:', 'citytours' ),
					'id' => '_ct_sidebar_widget_area',
					'type' => 'select',
					'options' => $sidebars,
					'std' => 'default'
				),
			),

		);

		return $meta_boxes;
	}
}

/*
 * rwmb metabox registration
 */
if ( ! function_exists( 'ct_theme_register_meta_boxes' ) ) {
	function ct_theme_register_meta_boxes( $meta_boxes ) {
		$meta_boxes = array_merge( $meta_boxes, ct_post_register_meta_boxes() );
		return $meta_boxes;
	}
}

/*
 * tour metabox enqueue script
 */
if ( ! function_exists( 'ct_metabox_admin_enqueue_scripts' ) ) {
	function ct_metabox_admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'post' != $screen->base || ! in_array( $screen->post_type, array('tour', 'hotel', 'cruise', 'transfer', 'restaurant', 'golf_course') ) ) return;
		wp_enqueue_script( 'ct-meta-custom-js', RWMB_JS_URL . 'custom.js', array( 'jquery' ), RWMB_VER, true );
		wp_enqueue_script( 'rwmb-clone', RWMB_JS_URL . 'clone.js', array( 'jquery' ), RWMB_VER, true );
		wp_enqueue_style( 'ct-meta-custom-css', RWMB_CSS_URL . 'custom.css');
		RWMB_Date_Field::admin_enqueue_scripts();
	}
}

/*
 * tour metabox registration
 */
if ( ! function_exists( 'ct_tour_register_meta_boxes' ) ) {
	function ct_tour_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_tour_';
		//tour_details
		$meta_boxes[] = array(
			'id' => 'tour_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'tour' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Tour Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is tour brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'  => esc_html__( 'Type', 'citytours' ),
					'id'      => "{$prefix}type",
					'desc'  => esc_html__( 'Select an tour type', 'citytours' ),
					'placeholder'  => esc_html__( 'Select an tour type', 'citytours' ),
					'type'  => 'taxonomy',
					'options' => array(
						'taxonomy' => 'tour_type',
						'type' => 'select_advanced',
					),
				),
				array(
					'name' => esc_html__( 'Is Popular ?', 'citytours' ),
					'id'    => "{$prefix}popular",
					'type' => 'checkbox',
					'std' => array(),
				),
				array(
					'name'  => esc_html__( 'Loai Tour', 'citytours' ),
					'id'      => "{$prefix}loai",
					'placeholder'  => esc_html__( 'Please select…', 'citytours' ),
					'type'  => 'radio',
					'std'  => '1',
					'options' => array(
						'0' => 'Excrursion Tour',
						'1' => 'Tour Package',
					),
				),
				array(
					'name'           => esc_html__( 'Price Rates', 'citytours' ),
					'id'                => "{$prefix}price_rates",
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'  => esc_html__( 'Duration', 'citytours' ),
					'id'      => "{$prefix}duration",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Departure', 'citytours' ),
					'id'      => "{$prefix}departure",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price Per Person', 'citytours' ),
					'id'      => "{$prefix}price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price Per Child', 'citytours' ),
					'id'      => "{$prefix}price_child",
					'type'  => 'text',
					//'hidden' => array( '_tour_charge_child', '=', 1 )
				),
				array(
					'name'  => esc_html__( 'Price per adult - superior package', 'citytours' ),
					'id'      => "{$prefix}price_adult_superior",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price per child - superior package', 'citytours' ),
					'id'      => "{$prefix}price_child_superior",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price per adult - superior plus package', 'citytours' ),
					'id'      => "{$prefix}price_adult_superior_plus",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price per child - superior plus package', 'citytours' ),
					'id'      => "{$prefix}price_child_superior_plus",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price per adult - deluxe package', 'citytours' ),
					'id'      => "{$prefix}price_adult_deluxe",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price per child - deluxe package', 'citytours' ),
					'id'      => "{$prefix}price_child_deluxe",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Accomodation 3 * ', 'citytours' ),
					'id'      => "{$prefix}accommodation_3_hotel",
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel', 'cruise' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Accomodation 3 * plus ', 'citytours' ),
					'id'      => "{$prefix}accommodation_3plus_hotel",
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel', 'cruise' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Accomodation 4 * ', 'citytours' ),
					'id'      => "{$prefix}accommodation_4_hotel",
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel', 'cruise' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Itinerary', 'citytours' ),
					'id'      => "{$prefix}itinerary",
					'desc'  => esc_html__( 'Please write itinerary info here.', 'citytours' ),
					'type'  => 'wysiwyg',
				),
				array(
					'name'  => esc_html__( 'Price Note', 'citytours' ),
					'id'      => "{$prefix}price_note",
					
					'type'  => 'wysiwyg',
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
				array(
					'name'  => esc_html__( 'Related Tours', 'citytours' ),
					'id'      => "{$prefix}related_tour",
					'desc'  => esc_html__( 'Select Related Tours', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Tours', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'tour' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
			)
		);

		$meta_boxes = apply_filters( 'ct_tour_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

/*
 * hotel metabox registration
 */
if ( ! function_exists( 'ct_hotel_register_meta_boxes' ) ) {
	function ct_hotel_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_hotel_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'hotel_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'hotel' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'District', 'citytours' ),
					'id'      => "{$prefix}type",
					'desc'  => esc_html__( 'Select district', 'citytours' ),
					'placeholder'  => esc_html__( 'Select district', 'citytours' ),
					'type'  => 'taxonomy',
					'options' => array(
						'taxonomy' => 'district',
						'type' => 'select_advanced',
					),
				),
				array(
					'name'  => esc_html__( 'City', 'citytours' ),
					'id'      => "{$prefix}city",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Star rating', 'citytours' ),
					'id'      => "{$prefix}star",
					'type' => 'slider',
					'suffix' => esc_html__( ' star', 'citytours' ),
					'std'  => 0,
					'js_options' => array(
						'min'   => 0,
						'max'   => 5,
						'step'  => 1,
					),
				),
				array(
					'name' => esc_html__( 'Is This Hotel Popular ?', 'citytours' ),
					'id'    => "{$prefix}popular",
					'desc' => esc_html__( 'Is This Hotel Popular ?', 'citytours' ),
					'type' => 'checkbox',
					'std' => array(),
				),
				array(
					'name'  => esc_html__( 'Check In Time', 'citytours' ),
					'id'      => "{$prefix}checkin",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Check Out Time', 'citytours' ),
					'id'      => "{$prefix}checkout",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Minimum Stay Info', 'citytours' ),
					'id'      => "{$prefix}minimum_stay",
					'desc'  => esc_html__( 'Leave it blank if this hotel does not have minimum stay', 'citytours' ),
					'type'  => 'number',
					'suffix'=> 'Nights'
				),
				array(
					'name'  => esc_html__( 'AVG/NIGHT Price', 'citytours' ),
					'id'      => "{$prefix}price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Security Deposit Amount(%)', 'citytours' ),
					'id'      => "{$prefix}security_deposit",
					'desc'  => esc_html__( 'Leave it blank if security deposit is not needed. And can insert value 100 if you want customers to pay whole amount of money while booking.', 'citytours' ),
					'type'  => 'text',
					'std'  => '100',
				),
				
				array(
					'name'  => esc_html__( 'Hotel Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is hotel brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'           => esc_html__( 'Price Rates', 'citytours' ),
					'id'                => "{$prefix}price_rates",
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'  => esc_html__( 'Facilities', 'citytours' ),
					'id'      => "{$prefix}facilities",
					'desc'  => esc_html__( 'Select Facilities', 'citytours' ),
					'type'  => 'taxonomy',
					'placeholder' => esc_html__( 'Select Facilities', 'citytours' ),
					'options' => array(
						'taxonomy' => 'hotel_facility',
						'type' => 'checkbox_list',
					),
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Email', 'citytours' ),
					'id'      => "{$prefix}email",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Phone', 'citytours' ),
					'id'      => "{$prefix}phone",
					'type'  => 'text',
				),
				array(
					'name' => esc_html__( 'Feature This Hotel', 'citytours' ),
					'id'    => "{$prefix}featured",
					'desc' => esc_html__( 'Add this hotel to featured list.', 'citytours' ),
					'type' => 'checkbox',
					'std' => array(),
				),
				array(
					'name'  => esc_html__( 'Slider Content', 'citytours' ),
					'id'      => "{$prefix}slider",
					'desc'  => esc_html__( 'Please write slider shortcode here.', 'citytours' ),
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Related Hotels and Tours', 'citytours' ),
					'id'      => "{$prefix}related",
					'desc'  => esc_html__( 'Select Hotels or Tours, Restaurant related to this Hotel', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Hotel or Tours', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel', 'tour', 'restaurant' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Nearby Sightseeing', 'citytours' ),
					'id'      => "{$prefix}near_sight",
					'desc'  => esc_html__( 'Select sight near to this Hotel', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Sights', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hanoi_sight' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
			)
		);

		$prefix = '_room_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'room_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'room_type' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'hotel', 'citytours' ),
					'id'      => "{$prefix}hotel_id",
					'type'  => 'post',
					'std' => isset($_GET['hotel_id']) ? sanitize_text_field( $_GET['hotel_id'] ) : '',
					'post_type' => 'hotel',
				),
				array(
					'name'  => esc_html__( 'Max Adults', 'citytours' ),
					'id'    => "{$prefix}max_adults",
					'desc'  => esc_html__( 'How many adults are allowed in the room?', 'citytours' ),
					'type' => 'number',
					'std' => 1
				),
				array(
					'name'  => esc_html__( 'Max Children', 'citytours' ),
					'id'    => "{$prefix}max_kids",
					'desc'  => esc_html__( 'How many children are allowed in the room?', 'citytours' ),
					'type' => 'number',
					'std' => 0
				),
				array(
					'name'  => esc_html__( 'Bed', 'citytours' ),
					'id'      => "{$prefix}bed",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Cabin Size', 'citytours' ),
					'id'      => "{$prefix}size",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price From', 'citytours' ),
					'id'    => "{$prefix}price",
					'type' => 'number',
					'std' => 0
				),
				array(
					'name'  => esc_html__( 'Facilities', 'citytours' ),
					'id'      => "{$prefix}facilities",
					'desc'  => esc_html__( 'Select Facilities', 'citytours' ),
					'type'  => 'taxonomy',
					'placeholder' => esc_html__( 'Select Facilities', 'citytours' ),
					'options' => array(
						'taxonomy' => 'hotel_facility',
						'type' => 'checkbox_list',
					),
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 50,
				),
			)
		);

		$meta_boxes = apply_filters( 'ct_tour_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

/*
 * cruise metabox registration
 */
if ( ! function_exists( 'ct_cruise_register_meta_boxes' ) ) {
	function ct_cruise_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_cruise_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'cruise_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'cruise' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				
				array(
					'name'  => esc_html__( 'Star rating', 'citytours' ),
					'id'      => "{$prefix}star",
					'type' => 'slider',
					'suffix' => esc_html__( ' star', 'citytours' ),
					'std'  => 0,
					'js_options' => array(
						'min'   => 0,
						'max'   => 5,
						'step'  => 1,
					),
				),
				array(
					'name'  => esc_html__( 'Minimum Stay Info', 'citytours' ),
					'id'      => "{$prefix}minimum_stay",
					'desc'  => esc_html__( 'Leave it blank if this hotel does not have minimum stay', 'citytours' ),
					'type'  => 'number',
					'suffix'=> 'Nights'
				),
				array(
					'name' => esc_html__( 'Is This Cruise Popular ?', 'citytours' ),
					'id'    => "{$prefix}popular",
					'desc' => esc_html__( 'Is This Cruise Popular ?', 'citytours' ),
					'type' => 'checkbox',
					'std' => array(),
				),
				array(
					'name'  => esc_html__( 'AVG/NIGHT Price', 'citytours' ),
					'id'      => "{$prefix}price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Security Deposit Amount(%)', 'citytours' ),
					'id'      => "{$prefix}security_deposit",
					'desc'  => esc_html__( 'Leave it blank if security deposit is not needed. And can insert value 100 if you want customers to pay whole amount of money while booking.', 'citytours' ),
					'type'  => 'text',
					'std'  => '100',
				),
				array(
					'name'  => esc_html__( 'Cruise Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is cruise brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'           => esc_html__( 'Price Rates', 'citytours' ),
					'id'                => "{$prefix}price_rates",
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'  => esc_html__( 'Facilities', 'citytours' ),
					'id'      => "{$prefix}facilities",
					'desc'  => esc_html__( 'Select Facilities', 'citytours' ),
					'type'  => 'taxonomy',
					'placeholder' => esc_html__( 'Select Facilities', 'citytours' ),
					'options' => array(
						'taxonomy' => 'cruise_facility',
						'type' => 'checkbox_list',
					),
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Email', 'citytours' ),
					'id'      => "{$prefix}email",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Phone', 'citytours' ),
					'id'      => "{$prefix}phone",
					'type'  => 'text',
				),
				array(
					'name' => esc_html__( 'Feature This Cruise', 'citytours' ),
					'id'    => "{$prefix}featured",
					'desc' => esc_html__( 'Add this cruise to featured list.', 'citytours' ),
					'type' => 'checkbox',
					'std' => array(),
				),
				array(
					'name'  => esc_html__( 'Slider Content', 'citytours' ),
					'id'      => "{$prefix}slider",
					'desc'  => esc_html__( 'Please write slider shortcode here.', 'citytours' ),
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Itinerary 2D1N', 'citytours' ),
					'id'      => "{$prefix}itinerary_2d1",
					'desc'  => esc_html__( 'Please write itinerary for 2d1n here', 'citytours' ),
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'  => esc_html__( 'Itinerary 3D2N', 'citytours' ),
					'id'      => "{$prefix}itinerary_3d2",
					'desc'  => esc_html__( 'Please write itinerary for 3d2n here', 'citytours' ),
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				/*array(
					'name'  => esc_html__( 'Price Include', 'citytours' ),
					'id'      => "{$prefix}included",
					'desc'  => esc_html__( 'Please write price include here', 'citytours' ),
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'  => esc_html__( 'Price Exclude', 'citytours' ),
					'id'      => "{$prefix}excluded",
					'desc'  => esc_html__( 'Please write price exclude here', 'citytours' ),
					'type' => 'wysiwyg',
					'raw'  => true,
				),*/
				array(
					'name'  => esc_html__( 'Important Notes', 'citytours' ),
					'id'      => "{$prefix}notes",
					'type' => 'wysiwyg',
					'raw'  => true,
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
			)
		);

		$prefix = '_cabin_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'cabin_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'cabin_type' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Cruise', 'citytours' ),
					'id'      => "{$prefix}cruise_id",
					'type'  => 'post',
					'std' => isset($_GET['cruise_id']) ? sanitize_text_field( $_GET['cruise_id'] ) : '',
					'post_type' => 'cruise',
				),
				array(
					'name'  => esc_html__( 'Max Adults', 'citytours' ),
					'id'    => "{$prefix}max_adults",
					'desc'  => esc_html__( 'How many adults are allowed in the cabin?', 'citytours' ),
					'type' => 'number',
					'std' => 1
				),
				array(
					'name'  => esc_html__( 'Max Children', 'citytours' ),
					'id'    => "{$prefix}max_kids",
					'desc'  => esc_html__( 'How many children are allowed in the cabin?', 'citytours' ),
					'type' => 'number',
					'std' => 0
				),
				array(
					'name'  => esc_html__( 'Bed', 'citytours' ),
					'id'      => "{$prefix}bed",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Cabin Size', 'citytours' ),
					'id'      => "{$prefix}size",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price 2D1N From', 'citytours' ),
					'id'    => "{$prefix}price2d1n",
					'type' => 'number',
					'std' => 0
				),
				array(
					'name'  => esc_html__( 'Price 3D2N From', 'citytours' ),
					'id'    => "{$prefix}price3d2n",
					'type' => 'number',
					'std' => 0
				),
				array(
					'name'  => esc_html__( 'Facilities', 'citytours' ),
					'id'      => "{$prefix}facilities",
					'desc'  => esc_html__( 'Select Facilities', 'citytours' ),
					'type'  => 'taxonomy',
					'placeholder' => esc_html__( 'Select Facilities', 'citytours' ),
					'options' => array(
						'taxonomy' => 'cruise_facility',
						'type' => 'checkbox_list',
					),
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 50,
				),
			)
		);

		$meta_boxes = apply_filters( 'ct_tour_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}
/*
 * transfer metabox registration
 */
if ( ! function_exists( 'ct_transfer_register_meta_boxes' ) ) {
	function ct_transfer_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_transfer_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'transfer_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'transfer' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Pick up', 'citytours' ),
					'id'      => "{$prefix}pick_up",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Price From', 'citytours' ),
					'id'      => "{$prefix}price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Transfer Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is transfer brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'  => esc_html__( 'Booking Link', 'citytours' ),
					'id'      => "{$prefix}booking_link",
					'type'  => 'text',
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
			)
		);
		$meta_boxes = apply_filters( 'ct_transfer_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

/*
 * transfer metabox registration
 */
if ( ! function_exists( 'ct_restaurant_register_meta_boxes' ) ) {
	function ct_restaurant_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_restaurant_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'restaurant_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'restaurant' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Restaurant Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is restaurant brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'  => esc_html__( 'Restaurant Type', 'citytours' ),
					'id'      => "{$prefix}type",
					'desc'  => esc_html__( 'Select an restaurant type', 'citytours' ),
					'placeholder'  => esc_html__( 'Select an restaurant type', 'citytours' ),
					'type'  => 'taxonomy',
					'options' => array(
						'taxonomy' => 'restaurant_type',
						'type' => 'select_advanced',
					),
				),
				array(
					'name'  => esc_html__( 'Price From', 'citytours' ),
					'id'      => "{$prefix}price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Telephone', 'citytours' ),
					'id'      => "{$prefix}telephone",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Website', 'citytours' ),
					'id'      => "{$prefix}website",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Opening hours', 'citytours' ),
					'id'      => "{$prefix}opening_hours",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Slider Content', 'citytours' ),
					'id'      => "{$prefix}slider",
					'desc'  => esc_html__( 'Please write slider shortcode here. For example [sliderpro id="1"] or [rev_slider concept]', 'citytours' ),
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Foursquare Id', 'citytours' ),
					'id'      => "{$prefix}foursquare_id",
					'type'  => 'text',
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
			)
		);
		$meta_boxes = apply_filters( 'ct_restaurant_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

/*
 * transfer metabox registration
 */
if ( ! function_exists( 'ct_hanoi_sight_register_meta_boxes' ) ) {
	function ct_hanoi_sight_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_hanoi_sight_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'hanoi_sight_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'hanoi_sight' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Hanoi Sight Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is restaurant brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'  => esc_html__( 'Hanoi Sight Type', 'citytours' ),
					'id'      => "{$prefix}type",
					'desc'  => esc_html__( 'Select an Hanoi Sight type', 'citytours' ),
					'placeholder'  => esc_html__( 'Select an Hanoi Sight type', 'citytours' ),
					'type'  => 'taxonomy',
					'options' => array(
						'taxonomy' => 'hanoi_sight_type',
						'type' => 'select_advanced',
					),
				),
				array(
					'name'  => esc_html__( 'Telephone', 'citytours' ),
					'id'      => "{$prefix}telephone",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Website', 'citytours' ),
					'id'      => "{$prefix}website",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Opening hours', 'citytours' ),
					'id'      => "{$prefix}opening_hours",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Foursquare Id', 'citytours' ),
					'id'      => "{$prefix}foursquare_id",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Related Hotels', 'citytours' ),
					'id'      => "{$prefix}related",
					'desc'  => esc_html__( 'Select Hotels related to this Sight', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
			)
		);
		$meta_boxes = apply_filters( 'ct_hanoi_sight_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

// resgister golf course metaboxes
if ( ! function_exists( 'ct_golf_course_register_meta_boxes' ) ) {
	function ct_golf_course_register_meta_boxes() {
		$meta_boxes = array();

		$prefix = '_golf_';
		//hotel_details
		$meta_boxes[] = array(
			'id' => 'golf_details',
			'title' => esc_html__( 'Details', 'citytours' ),
			'pages' => array( 'golf_course' ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => esc_html__( 'Golf Course Location', 'citytours' ),
					'id'      => "{$prefix}location",
					'desc'  => esc_html__( 'Select Location', 'citytours' ),
					'placeholder'  => esc_html__( 'Select Location', 'citytours' ),
					'type'  => 'taxonomy',
					'options' => array(
						'taxonomy' => 'golf_course_location',
						'type' => 'select_advanced',
					),
				),
				array(
					'name'  => esc_html__( 'Weekday Price', 'citytours' ),
					'id'      => "{$prefix}weekday_price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Weekend Price', 'citytours' ),
					'id'      => "{$prefix}weekend_price",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Golf Course Brief', 'citytours' ),
					'id'      => "{$prefix}brief",
					'desc'  => esc_html__( 'This is golf course brief field and the value is shown on search result page and detail page .', 'citytours' ),
					'type'  => 'textarea',
				),
				array(
					'name'  => esc_html__( 'Address', 'citytours' ),
					'id'      => "{$prefix}address",
					'type'  => 'text',
				),
				array(
					'name'        => esc_html__( 'Location', 'citytours' ),
					'id'            => "{$prefix}loc",
					'type'        => 'map',
					'style'      => 'width: 500px; height: 300px',
					'address_field' => "{$prefix}address",                   // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				),
				array(
					'name'  => esc_html__( 'Designer', 'citytours' ),
					'id'      => "{$prefix}designer",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Holes / Par / Yardage', 'citytours' ),
					'id'      => "{$prefix}hole",
					'type'  => 'text',
				),
				array(
					'name'  => esc_html__( 'Established', 'citytours' ),
					'id'      => "{$prefix}established",
					'type'  => 'text',
				),
				array(
					'name'           => esc_html__( 'Gallery Images', 'citytours' ),
					'id'                => "_gallery_imgs",
					'type'           => 'image_advanced',
					'max_file_uploads' => 10,
				),
				array(
					'name'  => esc_html__( 'Related Hotels 3 * hotel', 'citytours' ),
					'id'      => "{$prefix}related_3_hotel",
					'desc'  => esc_html__( 'Select Hotels related to this Golf Course', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Related 4 * Hotels', 'citytours' ),
					'id'      => "{$prefix}related_4_hotel",
					'desc'  => esc_html__( 'Select 4 * Hotels related to this Golf Course', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Related 5 * Hotels', 'citytours' ),
					'id'      => "{$prefix}related_5_hotel",
					'desc'  => esc_html__( 'Select 5 * Hotels related to this Golf Course', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Hotel', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'hotel' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Related Tours', 'citytours' ),
					'id'      => "{$prefix}related_tour",
					'desc'  => esc_html__( 'Select Tours related to this Golf Course', 'citytours' ),
					'placeholder'  => esc_html__( 'Please type a name of Tours', 'citytours' ),
					'type'  => 'post',
					'post_type' => array( 'tour' ),
					'field_type' => 'select_advanced',
					'multiple' => true,
				),
				array(
					'name'  => esc_html__( 'Booking Link', 'citytours' ),
					'id'      => "{$prefix}booking_link",
					'type'  => 'text',
				),
			)
		);

		$meta_boxes = apply_filters( 'ct_golf_course_register_meta_boxes', $meta_boxes );

		return $meta_boxes;
	}
}

/*
 * rwmb metabox registration
 */
if ( ! function_exists( 'ct_plugin_register_meta_boxes' ) ) {
	function ct_plugin_register_meta_boxes( $meta_boxes ) {
		global $ct_options;

		//tour custom post type
		if ( ct_is_tour_enabled() ) :
			$tour_meta_boxes = ct_tour_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $tour_meta_boxes );
		endif;

		if ( ct_is_hotel_enabled() ) :
			$hotel_meta_boxes = ct_hotel_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $hotel_meta_boxes );
		endif;
			$cruise_meta_boxes = ct_cruise_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $cruise_meta_boxes );
			$transfer_meta_boxes = ct_transfer_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $transfer_meta_boxes );
			$restaurant_meta_boxes = ct_restaurant_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $restaurant_meta_boxes );
			$hanoi_sight_meta_boxes = ct_hanoi_sight_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $hanoi_sight_meta_boxes );
			$golf_course_meta_boxes = ct_golf_course_register_meta_boxes();
			$meta_boxes = array_merge( $meta_boxes, $golf_course_meta_boxes );
		return $meta_boxes;
	}
}

/*
 * Register schedule meta box on tour page
 */
if ( ! function_exists( 'ct_tour_schedule_meta_box' ) ) {
	function ct_tour_schedule_meta_box( $post )
	{
		add_meta_box( 
			'ct_tour_schedule_meta_box',
			'Schedules', 
			'ct_tour_schedule_meta_box_html',
			'tour'
		);
	}
}

/*
 * Register schedule meta box on tour page
 */
if ( ! function_exists( 'ct_add_services_meta_box' ) ) {
	function ct_add_services_meta_box( $post )
	{
		$screens = array( 'tour', 'hotel', 'cruise', 'transfer', 'golf_course' );

		foreach ( $screens as $screen ) {
			add_meta_box( 
				'ct_add_services_meta_box',
				'Additional Services', 
				'ct_add_services_meta_box_html',
				$screen
			);
		}
	}
}

/*
 * Add schedule meta box on tour page
 */
if ( ! function_exists( 'ct_add_services_meta_box_html' ) ) {
	function ct_add_services_meta_box_html( $post )
	{
		global $wpdb;
		$post_id = $post->ID;
		$services = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE post_id=%d', $post_id ) );
		wp_nonce_field( 'ct_services', 'ct_services_nonce' );
		echo '<div class="services-wrapper">';
		echo '<table class="services-table"><tbody class="rwmb-input">';
			echo '<tr class="rwmb-field">
						<th>Title</th>
						<th>Price</th>
						<th>Per Person?</th>
						<th>Include Child?</th>
						<th>Icon Class</th>
						<th>&nbsp;</th>
					</tr>';

		if ( empty( $services ) ) {
			echo '<tr class="rwmb-clone">
						<td><input type="text" class="rwmb-text" name="service_title[0]"></td>
						<td><input type="text" class="rwmb-text" name="service_price[0]"></td>
						<td><input type="checkbox" class="rwmb-checkbox" name="service_per_person[0]" value="0"></td>
						<td><input type="checkbox" class="rwmb-checkbox" name="service_inc_child[0]" value="0"></td>
						<td><input type="text" class="rwmb-text" name="service_icon_class[0]"></td>
						<td><a href="#" class="rwmb-button button remove-clone" style="display: none;">-</a></td>
					</tr>';
		} else {
			foreach ( $services as $key=>$service ) {
				echo '<tr class="rwmb-clone">
						<td><input type="hidden" class="rwmb-text" name="service_id[' . $key . ']" value="' . esc_html( $service->id ) . '"><input type="text" class="rwmb-text" name="service_title[' . $key . ']" value="' . esc_html( $service->title ) . '"></td>
						<td><input type="text" class="rwmb-text" name="service_price[' . $key . ']" value="' . esc_html( $service->price ) . '"></td>
						<td><input type="checkbox" class="rwmb-checkbox" name="service_per_person[' . $key . ']" value="1" ' . ( !empty($service->per_person) ? 'checked' : '' ) . '></td>
						<td><input type="checkbox" class="rwmb-checkbox" name="service_inc_child[' . $key . ']" value="1" ' . ( !empty($service->inc_child) ? 'checked' : '' ) . '></td>
						<td><input type="text" class="rwmb-text" name="service_icon_class[' . $key . ']" value="' . esc_html( $service->icon_class ) . '"></td>
						<td><a href="#" class="rwmb-button button remove-clone">-</a></td>
					</tr>';
			}
		}
		echo '<tr><td colspan="5"><a href="#" class="rwmb-button button-primary add-clone">+</a></td></tr>
		</tbody></table></div>';
	}
}

/*
 * rwmb metabox save action
 */
if ( ! function_exists( 'ct_save_add_service_data' ) ) {
	function ct_save_add_service_data( $post_id ) {
		if ( ! isset( $_POST['ct_services_nonce'] ) ) return $post_id;
		$nonce = $_POST['ct_services_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ct_services' ) ) return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		$ids = $_POST['service_id'];
		$titles = $_POST['service_title'];
		$prices = $_POST['service_price'];
		$per_persons = ! empty( $_POST['service_per_person'] ) ? $_POST['service_per_person'] : array();
		$inc_childs = ! empty( $_POST['service_inc_child'] ) ? $_POST['service_inc_child'] : array();
		$icon_classes = $_POST['service_icon_class'];

		// Check the user's permissions.
		if ( current_user_can( 'edit_post', $post_id ) ) {
			global $wpdb;

			// delete original data
			$sql = 'DELETE FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE post_id=%d';
			$wpdb->query( $wpdb->prepare( $sql, $post_id ) );

			for ( $index = 0; $index < count( $titles ); $index++ ) {
				if ( empty( $titles[$index] ) && empty( $prices[$index] ) ) continue;
				$add_services_data = array( 'post_id' => $post_id, 'title' => $titles[$index], 'price' => $prices[$index], 'per_person' => isset( $per_persons[$index] ) ? 1 : 0, 'inc_child' => isset( $inc_childs[$index] ) ? 1 : 0, 'icon_class' => $icon_classes[$index] );
				$format = array( '%d', '%s', '%d', '%d', '%d', '%s' );
				// if the service is not new one update it.
				if ( ! empty( $ids[$index] ) ) {
					// validation if the add_service id is correct
					$add_services_data['id'] = $ids[$index];
					$format[] = '%d';
				}
				$wpdb->insert( CT_ADD_SERVICES_TABLE, $add_services_data, $format ); // add additional services
			}
		}
	}
}

/*
 * schedule meta box html
 */
if ( ! function_exists( 'ct_tour_schedule_meta_box_html' ) ) {
	function ct_tour_schedule_meta_box_html( $post )
	{
		global $wpdb;
		$days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
		$post_id = $post->ID;
		$has_multi_schedules = get_post_meta( $post_id, '_has_multi_schedules', true );
		$schedules = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . CT_TOUR_SCHEDULES_TABLE . ' WHERE tour_id=%d', $post_id ) );

		wp_nonce_field( 'ct_schedule', 'ct_schedule_nonce' );
		echo '<div class="schedule-wrapper rwmb-input">';
			echo '<div><label><input type="checkbox" name="has_multi_schedules" class="has_multi_schedules" ' . ( !empty($has_multi_schedules) ? 'checked' : '' ) . '> Has multiple schedules?</label></div>';
			if ( empty( $schedules ) ) {
				echo '<div class="rwmb-clone">
					<div class="rwmb-field schedule-header">
						<label>From</label> <input type="text" class="rwmb-text schedule-from-date ct_datepicker" name="schedule_from_date[]" value=""><br />
						<label>To</label> <input type="text" class="rwmb-text schedule-to-date ct_datepicker" name="schedule_to_date[]" value="">
					</div>
					<a href="#" class="rwmb-button button remove-clone" style="display: none;">-</a>
					<table class="schedule-table">
						<tr class="rwmb-field">
							<th>Day</th>
							<th>Is Closed?</th>
							<th>Open Time</th> 
							<th>Close Time</th>
						</tr>
						<tr class="rwmb-field">
							<td>Monday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="0"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Tuesday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="1"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Wednesday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="2"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Thursday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="3"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Friday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="4"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Saturday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="5"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
						<tr class="rwmb-field">
							<td>Sunday</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[0][]" value="6"></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[0][]"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[0][]"></td>
						</tr>
					</table>
				</div>';
			} else {
				foreach ( $schedules as $key => $schedule ) {
					$schedule_id = $schedule->id;
					$from_date = $schedule->from;
					$to_date = $schedule->to;
					echo '<div class="rwmb-clone">
						<div class="rwmb-field schedule-header">
							<label>From</label> <input type="text" class="rwmb-text schedule-from-date ct_datepicker" name="schedule_from_date[]" value="' . ( $from_date != '0000-00-00' ? $from_date : '' ) . '"><br />
							<label>To</label> <input type="text" class="rwmb-text schedule-to-date ct_datepicker" name="schedule_to_date[]" value="' . ( $to_date != '0000-00-00' ? $to_date : '' ) . '">
						</div>
						<a href="#" class="rwmb-button button remove-clone" style="display: none;">-</a>
						<table class="schedule-table">
							<tr class="rwmb-field">
								<th>Day</th>
								<th>Is Closed?</th>
								<th>Open Time</th> 
								<th>Close Time</th>
							</tr>';
					$schedule_meta_data = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . CT_TOUR_SCHEDULE_META_TABLE . ' WHERE schedule_id=%d ORDER BY day ASC', $schedule_id ) );
					foreach( $schedule_meta_data as $schedule_meta ) {
						echo '<tr class="rwmb-field">
							<td>' . $days[ $schedule_meta->day ] . '</td>
							<td><input type="checkbox" class="rwmb-checkbox" name="schedule_closed[' . $key . '][]" value="' . $schedule_meta->day . '" ' . ( !empty($schedule_meta->is_closed) ? 'checked' : '' ) . '></td>
							<td><input type="text" class="rwmb-text" name="schedule_open_time[' . $key . '][]" value="' . $schedule_meta->open_time . '"></td>
							<td><input type="text" class="rwmb-text" name="schedule_close_time[' . $key . '][]" value="' . $schedule_meta->close_time . '"></td>
						</tr>';
					}
					echo '</table></div>';
				}
			}
			echo '<a href="#" class="rwmb-button button-primary add-clone">+</a></div>';
	}
}

/*
 * rwmb metabox save action
 */
if ( ! function_exists( 'ct_save_schedule_data' ) ) {
	function ct_save_schedule_data( $post_id ) {
		if ( ! isset( $_POST['ct_schedule_nonce'] ) ) return $post_id;
		$nonce = $_POST['ct_schedule_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ct_schedule' ) ) return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		// Check the user's permissions.
		if ( 'tour' == $_POST['post_type'] && current_user_can( 'edit_post', $post_id ) ) {
			global $wpdb;
			$has_multi_schedules = empty( $_POST['has_multi_schedules'] ) ? 0 : 1;
			$from_dates = $_POST['schedule_from_date'];
			$to_dates = $_POST['schedule_to_date'];
			$closed_data = $_POST['schedule_closed'];
			$open_time_data = $_POST['schedule_open_time'];
			$close_time_data = $_POST['schedule_close_time'];

			// update has multi schedule and count
			update_post_meta( $post_id, '_has_multi_schedules', $has_multi_schedules );

			// delete original data
			$sql = 'DELETE t1, t2 FROM ' . CT_TOUR_SCHEDULE_META_TABLE . ' AS t1 RIGHT JOIN ' . CT_TOUR_SCHEDULES_TABLE . ' AS t2 ON t1.schedule_id = t2.id WHERE t2.tour_id=%d';
			$wpdb->query( $wpdb->prepare( $sql, $post_id ) );

			for ( $index = 0; $index < count( $from_dates ); $index++ ) {
				$from_date = $from_dates[$index];
				$to_date = $to_dates[$index];
				$sc_new_data = array( 'tour_id' => $post_id, 'ts_id' => $index, 'from' => $from_date, 'to' => $to_date );
				$wpdb->insert( CT_TOUR_SCHEDULES_TABLE, $sc_new_data, array( '%d', '%d', '%s', '%s' ) ); // add schedule
				$schedule_id = $wpdb->insert_id;
				for ( $i = 0; $i < 7; $i++ ) {
					$sc_meta_new_data = array( 
						'schedule_id' => $schedule_id,
						'day' => $i,
						'is_closed' => !empty($closed_data[$index]) && in_array( $i, $closed_data[$index] ) ? 1 : 0,
						'open_time' => $open_time_data[$index][$i],
						'close_time' => $close_time_data[$index][$i]
						);

					$wpdb->insert( CT_TOUR_SCHEDULE_META_TABLE, $sc_meta_new_data, array( '%d', '%d', '%d', '%s', '%s' ) ); // add schedule meta
					$meta_id = $wpdb->insert_id;
				}
			}
		}
	}
}

/*
 * room types meta box HTML on Hotel page
 */
if ( ! function_exists( 'ct_hotel_rooms_meta_box_html' ) ) {
	function ct_hotel_rooms_meta_box_html( $post )
	{
		if ( isset( $_GET['post'] ) ) {
			$hotel_id = $_GET['post'];
			$args = array(
				'post_type' => 'room_type',
				'meta_query' => array(
					array(
						'key' => '_room_hotel_id',
						'value' => array( sanitize_text_field( $_GET['post'] ) ),
					)
				),
				'suppress_filters' => 0,
			);
			$room_types = get_posts( $args );
			if ( ! empty( $room_types ) ) {
				echo '<ul>';
				foreach ($room_types as $room_type) {
					echo '<li>' . esc_html( get_the_title($room_type->ID) ) . '  <a href="' . esc_url( get_edit_post_link($room_type->ID) ) . '">edit</a></li>';
				}
				echo '</ul>';
			} else {
				echo 'No Room Types in This Hotel. <br />';
			}
			echo '<a href="' . esc_url( admin_url('post-new.php?post_type=room_type&hotel_id=' . $hotel_id) ) . '">Add New Room Type</a>';
			//wp_reset_postdata();
		} else { //in case of new
			echo 'No Room Types in This Hotel. <br />';
			echo '<a href="' . esc_url( admin_url('post-new.php?post_type=room_type') ) . '">Add New Room Type</a>';
		}
	}
}

/*
 * Register room types meta box on hotel page
 */
if ( ! function_exists( 'ct_hotel_rooms_meta_box' ) ) {
	function ct_hotel_rooms_meta_box( $post )
	{
		add_meta_box( 
			'ct_hotel_rooms_meta_box', // this is HTML id
			'Room Types in This Hotel', 
			'ct_hotel_rooms_meta_box_html', // the callback function
			'hotel', // register on post type = page
			'side', // 
			'default'
		);
	}
}


/*
 * cabin types meta box HTML on Cruise page
 */
if ( ! function_exists( 'ct_cruise_cabins_meta_box_html' ) ) {
	function ct_cruise_cabins_meta_box_html( $post )
	{
		if ( isset( $_GET['post'] ) ) {
			$cruise_id = $_GET['post'];
			$args = array(
				'post_type' => 'cabin_type',
				'meta_query' => array(
					array(
						'key' => '_cabin_cruise_id',
						'value' => array( sanitize_text_field( $_GET['post'] ) ),
					)
				),
				'suppress_filters' => 0,
			);
			$cabin_types = get_posts( $args );
			if ( ! empty( $cabin_types ) ) {
				echo '<ul>';
				foreach ($cabin_types as $cabin_type) {
					echo '<li>' . esc_html( get_the_title($cabin_type->ID) ) . '  <a href="' . esc_url( get_edit_post_link($cabin_type->ID) ) . '">edit</a></li>';
				}
				echo '</ul>';
			} else {
				echo 'No Cabin Types in This Cruise. <br />';
			}
			echo '<a href="' . esc_url( admin_url('post-new.php?post_type=cabin_type&cruise_id=' . $cruise_id) ) . '">Add New Cabin Type</a>';
			//wp_reset_postdata();
		} else { //in case of new
			echo 'No Cabin Types in This Cruise. <br />';
			echo '<a href="' . esc_url( admin_url('post-new.php?post_type=cabin_type') ) . '">Add New Cabin Type</a>';
		}
	}
}

/*
 * Register cabin types meta box on cruise page
 */
if ( ! function_exists( 'ct_cruise_cabins_meta_box' ) ) {
	function ct_cruise_cabins_meta_box( $post )
	{
		add_meta_box( 
			'ct_cruise_cabins_meta_box', // this is HTML id
			'Cabin Types in This Cruise', 
			'ct_cruise_cabins_meta_box_html', // the callback function
			'cruise', // register on post type = page
			'side', // 
			'default'
		);
	}
}