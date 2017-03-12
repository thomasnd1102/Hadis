<?php
/*
 * Shortcodes Class
 */
if ( ! class_exists( 'CTShortcodes') ) :
class CTShortcodes {

	public $shortcodes = array(
		"container",
		"row",
		"column",
		"one_half",
		"one_third",
		"one_fourth",
		"two_third",
		"three_fourth",
		"blockquote",
		"button",
		"banner",
		"checklist",
		"icon_box",
		"tabs",
		"tab",
		"tooltip",
		"toggles",
		"toggle",
		"review",
		"icon_list",
		"pricing_table",
		"parallax_block",
		"hotel_cart",
		"hotel_checkout",
		"hotel_booking_confirmation",
		"cruise_cart",
		"cruise_checkout",
		"cruise_booking_confirmation",
		"tour_cart",
		"tour_checkout",
		"tour_booking_confirmation",
		"hotels",
		"tours",
		"cruises",
		"cruises2",
		"timeline_container",
		"timeline",
		"blog",
		"tabs_travelo",
		"tab_travelo",
		"tour_hotel_default",
		"tour_hotel_list",
		"single_item",
		"single_tour",
		"list_hotel",
		"list_cruise",
		"list_tour",
		"search_fly",
		"search_pannel",
		"customize_tour",
		"transfer_checkout",
		"map",
		"list_tour_thumbnail",
		"list_cruise_thumbnail",
		"list_sight",
		"similar_tour"
	 );

	function __construct() {
		add_action( 'init', array( $this, 'add_shortcodes' ) );
		add_filter('the_content', array( $this, 'filter_eliminate_autop' ) );
		add_filter('widget_text', array( $this, 'filter_eliminate_autop' ) );
	}

	/* ***************************************************************
	* **************** Remove AutoP tags *****************************
	* **************************************************************** */
	function filter_eliminate_autop( $content ) {
		$block = join( "|", $this->shortcodes );

		// replace opening tag
		$content = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );

		// replace closing tag
		$content = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $content );
		return $content;
	}

	/* ***************************************************************
	* **************** Add Shortcodes ********************************
	* **************************************************************** */
	function add_shortcodes() {
		foreach ( $this->shortcodes as $shortcode ) {
			$function_name = 'shortcode_' . $shortcode ;
			add_shortcode( $shortcode, array( $this, $function_name ) );
		}
	}

	/* ***************************************************************
	* *************** Grid System ************************************
	* **************************************************************** */
	//shortcode container
	function shortcode_container( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => ''
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		$result = '<div class="container' . esc_attr( $class ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}

	//shortcode row
	function shortcode_row( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => ''
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		$result = '<div class="row' . esc_attr( $class ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}


	//shortcode column
	function shortcode_column( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'lg'        => '',
			'md'        => '',
			'sms'        => '',
			'sm'        => '',
			'xs'        => '',
			'lgoff'        => '',
			'mdoff'        => '',
			'smsoff'        => '',
			'smoff'        => '',
			'xsoff'        => '',
			'lghide'    => '',
			'mdhide'    => '',
			'smshide'    => '',
			'smhide'    => '',
			'xshide'    => '',
			'lgclear'    => '',
			'mdclear'    => '',
			'smsclear'    => '',
			'smclear'    => '',
			'xsclear'    => '',
			'class'        => ''
		), $atts ) );

		$devices = array( 'lg', 'md', 'sm', 'sms', 'xs' );
		$classes = array();
		foreach ( $devices as $device ) {

			//grid column class
			if ( ${$device} != '' ) $classes[] = 'col-' . $device . '-' . ${$device};

			//grid offset class
			$device_off = $device . 'off';
			if ( ${$device_off} != '' ) $classes[] = 'col-' . $device . '-offset-' . ${$device_off};

			//grid hide class
			$device_hide = $device . 'hide';
			if ( ${$device_hide} == 'yes' ) $classes[] =  'hidden-' . $device;

			//grid clear class
			$device_clear = $device . 'clear';
			if ( ${$device_clear} == 'yes' ) $classes[] = 'clear-' . $device;

		}
		if ( ! empty( $class ) ) $classes[] = $class;

		$result = '<div class="' . esc_attr(  implode(' ', $classes) ) . '">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	//shortcode one_half
	function shortcode_one_half( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'offset' => 0,
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		if ( $offset != 0 ) $class .= ' col-sm-offset-' . $offset;
		
		$result = '<div class="col-sm-6' . esc_attr( $class ) . ' one-half">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	//shortcode one_third
	function shortcode_one_third( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'offset' => 0,
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		if ( $offset != 0 ) $class .= ' col-sm-offset-' . $offset;
		
		$result = '<div class="col-sm-4' . esc_attr( $class ) . ' one-third">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	//shortcode two_third
	function shortcode_two_third( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'offset' => 0,
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		if ( $offset != 0 ) $class .= ' col-sm-offset-' . $offset;
		
		$result = '<div class="col-sm-8' . esc_attr( $class ) . ' two-third">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	//shortcode one_fourth
	function shortcode_one_fourth( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'offset' => 0,
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		if ( $offset != 0 ) $class .= ' col-sm-offset-' . $offset;
		
		$result = '<div class="col-sm-3 ' . esc_attr( $class ) . ' one-fourth">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	//shortcode three_fourth
	function shortcode_three_fourth( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'offset' => 0,
		), $atts ) );

		$class = empty( $class )?'':( ' ' . $class );
		if ( $offset != 0 ) $class .= ' col-sm-offset-' . $offset;
		
		$result = '<div class="col-sm-9 ' . esc_attr( $class ) . ' three-fourth">';
		$result .= do_shortcode($content);
		$result .= '</div>';

		return $result;
	}

	/* ***************************************************************
	* **************** Blockquote Shortcode **************************
	* **************************************************************** */
	function shortcode_blockquote( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => ''
		), $atts) );

		$class = empty( $class )?'':( ' ' . $class );
		$result = '';
		$result .= '<blockquote class="' . esc_attr( 'styled' . $class ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</blockquote>';

		return $result;
	}

	/* ***************************************************************
	* **************** Button Shortcode **************************
	* **************************************************************** */
	function shortcode_button( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'style' => '',
			'size' => '',
			'target' => '_self', //available values 5 ( _blank|_self|_parent|_top|framename )
			'link' => '#',
		), $atts) );

		$class = empty( $class )?'':( ' ' . $class );
		$styles = array( 'outline', 'white', 'green' );
		$sizes = array( 'medium', 'full' );
		if ( ! in_array( $style, $styles ) ) $style = '';
		if ( ! in_array( $size, $sizes ) ) $size = '';
		if ( $size == 'full' ) $size = 'btn-full';
		$classes = array( 'btn_1' );
		if ( ! empty( $style ) ) $classes[] = $style;
		if ( ! empty( $size ) ) $classes[] = $size;
		if ( ! empty( $class ) ) $classes[] = $class;
		
		$result = '';
		$result .= '<a href="' . esc_url( $link ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '" target="' . esc_attr( $target ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</a>';

		return $result;
	}

	/* ***************************************************************
	* **************** Banner Shortcode **************************
	* **************************************************************** */
	function shortcode_banner( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'style' => '',
		), $atts) );

		$class = empty( $class )?'':( ' ' . $class );
		$styles = array( 'colored' );
		if ( ! in_array( $style, $styles ) ) $style = '';
		$result = '';
		$result .= '<div class="banner ' . esc_attr( $style . $class ) . ' ">';
		$result .= do_shortcode( $content );
		$result .= '</div>';

		return $result;
	}

	/* ***************************************************************
	* **************** Check List Shortcode *****************************
	* **************************************************************** */
	function shortcode_checklist($atts, $content = null) {

		extract( shortcode_atts( array(
			'class' => '',
		), $atts) );

		$class = empty( $class )?'':( ' ' . $class );
		$class = 'list_ok' . $class;
		$result = str_replace( '<ul>', '<ul class="' . esc_attr( $class ) . '">', $content);
		$result = str_replace( '<li>', '<li>', $result);
		$result = do_shortcode( $result );

		return $result;
	}

	/* ***************************************************************
	* **************** Icon Box Shortcode *****************************
	* **************************************************************** */
	function shortcode_icon_box($atts, $content = null) {

		extract( shortcode_atts( array(
			'class' => '',
			'icon_class' => '',
			'style' => '',
		), $atts) );

		$styles = array( 'style2', 'style3' );
		if ( ! in_array( $style, $styles ) ) $style = '';
		$class = empty( $class )?'':( ' ' . $class );
		$class = 'ct-icon-box ' . $style . $class;
		$result = '';
		$result .= '<div class="' . esc_attr( $class ) . '">';
		if ( ! empty( $icon_class ) ) :
			$result .= '<i class="' . esc_attr( $icon_class ) . '"></i>';
		endif;
		$result .= do_shortcode( $content );
		$result .= '</div>';

		return $result;
	}

	/* ***************************************************************
	* **************** Tabs Shortcode ********************************
	* **************************************************************** */
	function shortcode_tabs($atts, $content = null) {
		$variables = array( 'active_tab_index' => '1', 'class'=>'' );
		extract( shortcode_atts( $variables, $atts ) );

		$result = '';

		preg_match_all( '/\[tab(.*?)]/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();

		if ( isset( $matches[0] ) ) {
			$tab_titles = $matches[0];
		}
		if ( count( $tab_titles ) ) {

			$result .= sprintf( '<div class="%s"><ul class="nav nav-tabs">', esc_attr( $class ) );
			$uid = uniqid();
			foreach ( $tab_titles as $i => $tab ) {
				preg_match( '/title="([^\"]+)"/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
				if ( isset( $tab_matches[1][0] ) ) {
					$active_class = '';
					$active_attr = '';
					if ( $active_tab_index - 1 == $i ) {
						$active_class = ' class="active"';
						$active_attr = ' active="true"';
					}

					$result .= '<li '. $active_class . '><a href="' . esc_url( '#' . $uid . $i ) . '" data-toggle="tab">' . esc_html( $tab_matches[1][0] ) . '</a></li>';

					$before_content = substr($content, 0, $tab[1]);
					$current_content = substr($content, $tab[1]);
					$current_content = preg_replace('/\[tab/', '[tab id="' . $uid . $i . '"' . $active_attr, $current_content, 1);
					$content = $before_content . $current_content;
				}
			}
			$result .= '</ul>';
			$result .= '<div class="tab-content">';
			$result .= do_shortcode( $content );
			$result .= '</div>';
			$result .= '</div>';
		} else {
			$result .= do_shortcode( $content );
		}

		return $result;
	}

	/* ***************************************************************
	* **************** Tab Shortcode ********************************
	* **************************************************************** */
	function shortcode_tab($atts, $content = null) {
		extract( shortcode_atts( array(
			'title' => '',
			'id'	=> '',
			'active'=> '',
			'class' => ''
		), $atts) );

		$classes = array( 'tab-pane' );
		if ( $active == 'true' || $active == 'yes' ) {
			$classes[] = 'active';
		}
		if ( $class != '' )  {
			$classes[] = $class;
		}
		return sprintf( '<div id="%s" class="%s">%s</div>',
			esc_attr( $id ),
			esc_attr( implode(' ', $classes) ),
			do_shortcode( $content )
		);
	}

	/* ***************************************************************
	* **************** ToolTip Shortcode *****************************
	* **************************************************************** */
	function shortcode_tooltip($atts, $content = null) {
		extract( shortcode_atts( array(
			'title' => '',
			'style' => '',
			'effect' => 1,
			'position' => 'top',
			'class' => ''
		), $atts) );

		if ( $style == 'advanced' ) {
			$effects = array( 1, 2, 3, 4 );
			if ( ! in_array( $effect, $effects ) ) $effect = 1;
			$classes = array( 'tooltip_styled', 'tooltip-effect-' . esc_attr( $effect ) );
			if ( $class != '' ) { $classes[] = $class; }
			$result = sprintf( '<div class="%s"><span class="tooltip-item">%s</span><div class="tooltip-content">', esc_attr( implode(' ', $classes) ), do_shortcode( $content ) );
			$result .= esc_html( $title );
			$result .= '</div></div>';
		} else {
			$classes = array( 'tooltip-1' );
			if ( $class != '' ) { $classes[] = $class; }
			$positions = array( 'top', 'bottom', 'left', 'right' );
			if ( ! in_array( $position, $positions ) ) $position = 'top';
			$result = '';
			$result .= sprintf( '<a href="#" class="%s" data-placement="%s" title="%s">', esc_attr( implode(' ', $classes) ), esc_attr( $position ), esc_attr( $title ) );
			$result .= do_shortcode( $content );
			$result .= '</a>';
		}

		return $result;
	}

	// toggles
	public $toggles_index = 1; //to generate unique accordion id
	public $toggles_type = 'toggle'; //toggle type ( accordion|toggle )

	/* ***************************************************************
	* **************** toggles Shortcode *****************************
	* **************************************************************** */
	function shortcode_toggles( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'toggle_type'	=> 'accordion',
			'class' 		=> ''
		), $atts ) );

		$this->toggles_type = $toggle_type;
		$classes = array( 'panel-group' );
		if ( $class != '' ) { $classes[] = $class; }
		$result = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" id="toggles-' . $this->toggles_index . '">';
		$result .= do_shortcode( $content );
		$result .= "</div>";
		$this->toggles_index++;
		return $result;
	}

	/* ***************************************************************
	* **************** toggle Shortcode ******************************
	* **************************************************************** */
	function shortcode_toggle( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'		=> '',
			'active' => 'no',
			'class' 	=> ''
		), $atts ) );

		static $toggle_id = 1;

		$data_parent = '';
		if ( $this->toggles_type == "accordion" ) {
			$data_parent = ' data-parent="#toggles-' . $this->toggles_index . '"';
		}

		$result = '';
		$class = 'panel panel-default' . (empty( $class ) ? '': ( ' ' . $class ));
		$class_in = ( $active === 'yes') ? ' in':'';
		$class_collapsed = ( $active === 'yes') ? '' : ' collapsed';
		$class_icon = ( $active === 'yes') ? 'icon-minus' : 'icon-plus';

		$result .= '<div class="' . esc_attr( $class ) . '"><div class="panel-heading">';
		$result .= '<h4 class="panel-title"><a class="accordion-toggle' . $class_collapsed . '" href="#toggle-' . $toggle_id . '" data-toggle="collapse"' . $data_parent . '>';
		$result .= esc_html( $title ) . '<i class="indicator pull-right ' . $class_icon . '"></i></a></h4></div>';
		$result .= '<div class="panel-collapse collapse' . $class_in . '" id="toggle-' . $toggle_id . '"><div class="panel-body"><p>';
		$result .= do_shortcode( $content );
		$result .= '</p></div></div></div>';

		$toggle_id++;

		return $result;
	}

	/* ***************************************************************
	* **************** Review Shortcode *****************************
	* **************************************************************** */
	function shortcode_review($atts, $content = null) {
		extract( shortcode_atts( array(
			'name' => '',
			'rating' => 5,
			'img_url' => '',
			'class' => ''
		), $atts) );

		$classes = array( 'review_strip' );
		if ( $class != '' ) { $classes[] = $class; }

		$result = '';
		$result .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		if ( ! empty( $img_url ) ) $result .= '<img src="' . esc_url( $img_url ) . '" alt="" class="img-circle">';
		$result .= '<h4>' . esc_html( $name ) . '</h4>';
		$result .= do_shortcode( $content );
		if ( ! empty( $rating ) && is_numeric( $rating ) ) {
			$result .= '<div class="rating">';
			for ( $i = 1; $i <= 5 ; $i++ ) {
				if ( $rating >= $i ) {
					$icon_class = 'icon-star voted';
				} else {
					$icon_class = 'icon-star-empty';
				}
				$result .= '<i class="' . $icon_class . '"></i>';
			}
			$result .= '</div>';
		}
		$result .= '</div><!-- End review strip -->';
		return $result;
	}

	/* ***************************************************************
	* **************** Icon List Shortcode *****************************
	* **************************************************************** */
	function shortcode_icon_list($atts, $content = null) {
		extract( shortcode_atts( array(
			'class' => ''
		), $atts) );

		$classes = array( 'general_icons' );
		if ( $class != '' ) { $classes[] = $class; }
		$result = '';
		$result .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}

	/* ***************************************************************
	* ******************** Pricing Table Shortcode *******************
	* **************************************************************** */
	function shortcode_pricing_table( $atts, $content = null ) {
		$variables = array( 'class' => '',
						'style' => '',
						'price' => '',
						'title' => '',
						'btn_title' => 'Buy Now!',
						'btn_url' => '',
						'btn_target' => '_blank',
						'btn_color' => '',
						'btn_class' => '',
						'ribbon_img_url' => '',
						'is_featured' => '',
					);
		extract( shortcode_atts( $variables, $atts ) );
		$result = '';

		if ( empty( $style ) ) {

			$classes = array( 'plan' );
			if ( ! empty( $is_featured ) ) { $classes[] = 'plan-tall'; }
			if ( $class != '' ) { $classes[] = $class; }
			$result .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			if ( ! empty( $ribbon_img_url ) ) $result .= '<span class="ribbon_table" style="background:url(' . esc_url( $ribbon_img_url ) . ') no-repeat 0 0"></span>';
			$result .= '<h2 class="plan-title">' . esc_html( $title ) . '</h2>';
			$result .= '<p class="plan-price">' . balancetags( $price ) . '</p>';
			$content = preg_replace('/<ul>/', '<ul class="plan-features">' , $content, 1);
			$result .= do_shortcode( $content );
			$result .= '<a href="' . esc_url( $btn_url ) . '" class="btn_1 ' . esc_attr( $btn_color . ' ' . $btn_class ) . '" target="' . esc_html( $btn_target ) . '">' . esc_html( $btn_title ) . '</a>';
			$result .= '</div>';
		} else {
			$classes = array( 'pricing-table' );
			$classes[] = ( ! empty( $is_featured ) && ( $is_featured != 'no' ) ) ? 'green' : 'black';
			if ( $class != '' ) { $classes[] = $class; }
			$result .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			$result .= '<span class="ribbon_2" style="background:url(' . esc_url( $ribbon_img_url ) . ') no-repeat 0 0"></span>';
			$result .= '<div class="pricing-table-header">
							<span class="heading">' . esc_html( $title ) . '</span>
							<div class="price-value">' . balancetags( $price ) . '</div>
						</div>';
			$result .= '<div class="pricing-table-features">' . do_shortcode( $content ) . '</div>';
			$result .= '<div class="pricing-table-sign-up">';
			$result .= '<a href="' . esc_url( $btn_url ) . '" class="btn_1 ' . esc_attr( $btn_color . ' ' . $btn_class ) . '" target="' . esc_html( $btn_target ) . '">' . esc_html( $btn_title ) . '</a>';
			$result .= '</div></div><!-- End pricing-table-->';
		}
		return $result;
	}

	/* ***************************************************************
	* **************** Parallax Section Shortcode ********************
	* **************************************************************** */
	function shortcode_parallax_block( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'bg_image' => '',
			'width' => '1400',
			'height' => '470',
			'class' => '',
		), $atts) );

		$result = '';
		$result .= '<section class="parallax-window" data-parallax="scroll" data-image-src="' . esc_url( $bg_image ) . '" data-natural-width="' . esc_attr( $width ) . '" data-natural-height="' . esc_attr( $height ) . '">';
		$result .= '<div class="parallax-content-1 magnific">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		$result .= '</section>';
		return $result;
	}

	/* ***************************************************************
	* **************** Hotel Booking Page Shortcode **********
	* **************************************************************** */
	function shortcode_hotel_cart( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'cart.php', '/templates/hotel' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Hotel CheckOut Page Shortcode **********
	* **************************************************************** */
	function shortcode_hotel_checkout( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'checkout.php', '/templates/hotel' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Hotel Booking Confirm Page Shortcode **********
	* **************************************************************** */
	function shortcode_hotel_booking_confirmation( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'thankyou.php', '/templates/hotel' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/* ***************************************************************
	* **************** Cruise Booking Page Shortcode **********
	* **************************************************************** */
	function shortcode_cruise_cart( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'cart.php', '/templates/cruise' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Cruise CheckOut Page Shortcode **********
	* **************************************************************** */
	function shortcode_cruise_checkout( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'checkout.php', '/templates/cruise' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Cruise Booking Confirm Page Shortcode **********
	* **************************************************************** */
	function shortcode_cruise_booking_confirmation( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'thankyou.php', '/templates/cruise' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/* ***************************************************************
	* **************** Tour Booking Page Shortcode **********
	* **************************************************************** */
	function shortcode_tour_cart( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'cart.php', '/templates/tour' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Tour CheckOut Page Shortcode **********
	* **************************************************************** */
	function shortcode_tour_checkout( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'checkout.php', '/templates/tour' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/* ***************************************************************
	* **************** Tour Booking Confirm Page Shortcode **********
	* **************************************************************** */
	function shortcode_tour_booking_confirmation( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'thankyou.php', '/templates/tour' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}


	/* ***************************************************************
	* ****************** Hotels List Shortcode ****************
	* **************************************************************** */
	function shortcode_hotels( $atts ) {
		extract( shortcode_atts( array(
			'title' => '',
			'type' => 'latest',
			'style' => 'advanced',
			'count' => 6,
			'count_per_row' => 3,
			'district' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		if ( ! ct_is_hotel_enabled() ) return '';
		$styles = array( 'advanced', 'simple' );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $style, $styles ) ) $style = 'advanced';
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$district = ( ! empty( $district ) ) ? explode( ',', $district ) : array();
		$count = is_numeric( $count )?$count:6;
		$count_per_row = is_numeric( $count_per_row )?$count_per_row:3;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_hotel_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_hotel_get_special_hotels( $type, $count, array(), $district );
		}

		if ( $style == 'simple' ) {
			$output = '<div class="other_tours"><ul>';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_hotel_price', true );
				$output .= '<li><a href="' . esc_url( get_permalink( $post_id ) ) . '"><i class="icon-building"></i>' . get_the_title( $post_id ) . '<span class="other_tours_price">' . ct_price( $price ) . '</span></a></li>';
			}
			$output .= '</ul></div>';
		} else {
			ob_start();
			global $before_list, $post_id;
			$before_list = '';
			if ( ( 2 == $count_per_row ) ) {
				$before_list = '<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			} elseif ( 4 == $count_per_row ) {
				$before_list = '<div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			} else {
				$before_list = '<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			}

			if ( ! empty( $title ) ) { echo '<h2>' . esc_html( $title ) . '</h2>'; }
			echo '<div class="hotel-list row' . esc_attr( $class ) . '">';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				ct_get_template( 'loop-grid.php', '/templates/hotel/');
			}
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}
	
	/* ***************************************************************
	* ****************** Cruise List Shortcode ****************
	* **************************************************************** */
	function shortcode_cruises( $atts ) {
		extract( shortcode_atts( array(
			'title' => '',
			'type' => 'latest',
			'style' => 'advanced',
			'count' => 6,
			'count_per_row' => 3,
			'district' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		
		$styles = array( 'advanced', 'simple' );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $style, $styles ) ) $style = 'advanced';
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$district = ( ! empty( $district ) ) ? explode( ',', $district ) : array();
		$count = is_numeric( $count )?$count:6;
		$count_per_row = is_numeric( $count_per_row )?$count_per_row:3;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_cruise_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_cruise_get_special_hotels( $type, $count, array(), $district );
		}

		if ( $style == 'simple' ) {
			$output = '<div class="other_tours"><ul>';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_cruise_price', true );
				$output .= '<li><a href="' . esc_url( get_permalink( $post_id ) ) . '"><i class="icon-ferry"></i>' . get_the_title( $post_id ) . '<span class="other_tours_price">' . ct_price( $price ) . '</span></a></li>';
			}
			$output .= '</ul></div>';
		} else {
			ob_start();
			global $before_list, $post_id;
			$before_list = '';
			if ( ( 2 == $count_per_row ) ) {
				$before_list = '<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			} elseif ( 4 == $count_per_row ) {
				$before_list = '<div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			} else {
				$before_list = '<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			}

			if ( ! empty( $title ) ) { echo '<h2>' . esc_html( $title ) . '</h2>'; }
			echo '<div class="hotel-list row' . esc_attr( $class ) . '">';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				ct_get_template( 'loop-grid.php', '/templates/cruise/');
			}
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}
	
	/* ***************************************************************
	* ****************** Cruise List Shortcode ****************
	* **************************************************************** */
	function shortcode_cruises2( $atts ) {
		extract( shortcode_atts( array(
			'title' => '',
			'type' => 'latest',
			
			'count' => 6,
			'count_per_row' => 3,
			'district' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		
		$styles = array( 'advanced', 'simple' );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $style, $styles ) ) $style = 'advanced';
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$district = ( ! empty( $district ) ) ? explode( ',', $district ) : array();
		$count = is_numeric( $count )?$count:6;
		$count_per_row = is_numeric( $count_per_row )?$count_per_row:3;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_cruise_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_cruise_get_special_hotels( $type, $count, array(), $district );
		}

		if ( $style == 'simple' ) {
			$output = '<div class="other_tours"><ul>';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_cruise_price', true );
				$output .= '<li><a href="' . esc_url( get_permalink( $post_id ) ) . '">' . get_the_title( $post_id ) . '<span class="other_tours_price">' . ct_price( $price ) . '</span></a></li>';
			}
			$output .= '</ul></div>';
		} else {
			ob_start();
			global $before_list, $post_id;
			$before_list = '';
			if ( ( 3 == $count_per_row ) ) {
				$before_list = '<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
			} else {
				$before_list = '<div class="wow zoomIn" data-wow-delay="0.1s">';
			}

			if ( ! empty( $title ) ) { echo '<h2>' . esc_html( $title ) . '</h2>'; }
			echo '<div class="hotel-list' . esc_attr( $class ) . '">';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				ct_get_template( 'loop-list-image.php', '/templates/cruise/');
			}
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}
	
	/* ***************************************************************
	* ****************** Tour List Shortcode ****************
	* **************************************************************** */
	function shortcode_tours( $atts ) {
		extract( shortcode_atts( array(
			'title' => '',
			'type' => 'latest',
			'style' => 'advanced',
			'count' => 6,
			'count_per_row' => 3,
			'tour_type' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		if ( ! ct_is_tour_enabled() ) return '';
		$styles = array( 'advanced', 'simple', 'list' );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $style, $styles ) ) $style = 'advanced';
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$count = is_numeric( $count )?$count:6;
		$count_per_row = is_numeric( $count_per_row )?$count_per_row:3;
		$tour_type = ( ! empty( $tour_type ) ) ? explode( ',', $tour_type ) : array();

		global $before_list, $post_id;
		$before_list = '';
		if ( ( 2 == $count_per_row ) ) {
			$before_list = '<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
		} elseif ( 4 == $count_per_row ) {
			$before_list = '<div class="col-md-3 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
		} else {
			$before_list = '<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">';
		}

		$tours = array();
		if ( $type == 'selected' ) {
			$tours = ct_tour_get_tours_from_id( $post_ids );
		} else {
			$tours = ct_tour_get_special_tours( $type, $count, array(), $tour_type );
		}

		if ( $style == 'simple' ) {
			$output = '<div class="other_tours"><ul>';
			foreach ( $tours as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_tour_price', true );
				$tour_type = wp_get_post_terms( $post_id, 'tour_type' );
				$output .= '<li><a href="' . esc_url( get_permalink( $post_id ) ) . '">';
				if ( ! empty( $tour_type ) ) { $icon_class = get_tax_meta($tour_type[0]->term_id, 'ct_tax_icon_class', true); $output .= '<i class="' . esc_attr( $icon_class ) . '"></i>'; }
				$output .= get_the_title( $post_id ) . '<span class="other_tours_price">' . ct_price( $price ) . '</span></a></li>';
			}
			$output .= '</ul></div>';
		} elseif ( $style == 'list' ) {
			ob_start();
			if ( ! empty( $title ) ) { echo '<h2>' . esc_html( $title ) . '</h2>'; }
			echo '<div class="tour-list row' . esc_attr( $class ) . '">';
			foreach ( $tours as $post_obj ) {
				$post_id = $post_obj->ID;
				ct_get_template( 'loop-list.php', '/templates/tour/');
			}
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
		} else {
			ob_start();
			if ( ! empty( $title ) ) { echo '<h2>' . esc_html( $title ) . '</h2>'; }
			echo '<div class="tour-list row' . esc_attr( $class ) . '">';
			foreach ( $tours as $post_obj ) {
				$post_id = $post_obj->ID;
				ct_get_template( 'loop-grid.php', '/templates/tour/');
			}
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}


	/* ***************************************************************
	* **************** Timeline container Shortcode ******************
	* **************************************************************** */
	function shortcode_timeline_container( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
		), $atts) );

		$result = '';
		$result .= '<ul class="cbp_tmtimeline ' . esc_attr( $class ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</ul>';
		return $result;
	}

	/* ***************************************************************
	* ******************** Tiemline Shortcode ************************
	* **************************************************************** */
	function shortcode_timeline( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => '',
			'time' => '',
			'duration' => '',
			'icon_class' => '',
		), $atts) );

		$result = '';
		$result .= '<li class="' . esc_attr( $class ) . '">';
		$result .= '<time class="cbp_tmtime" datetime="' . esc_attr( $time ) . '"><span>' . esc_html( $duration ) . '</span> <span>' . esc_attr( $time ) . '</span></time>';
		$result .= '<div class="cbp_tmicon">' . '<i class="' . esc_attr( $icon_class ) . '"></i>' . '</div>';
		$result .= '<div class="cbp_tmlabel">';
		$result .= do_shortcode( $content );
		$result .= '</div></li>';
		return $result;
	}

	/* ***************************************************************
	* ************************* Blog Shortcode ***********************
	* **************************************************************** */
	function shortcode_blog( $atts, $content = null ) {
		global $cat;
		$variables = array( 'cat' => '' );
		extract( shortcode_atts( $variables, $atts ) );
		ob_start();
		ct_get_template( 'content-blog.php', '/templates' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	/* ***************************************************************
	* **************** Tabs Shortcode Travelo********************************
	* **************************************************************** */
	public $tabs_first_tab = true;
	function shortcode_tabs_travelo($atts, $content = null) {
		$variables = array( 'title'=>'', 'style'=>'', 'bg_color'=>'', 'class'=>'', 'img_src'=>'', 'img_height'=>'', 'img_width'=>'', 'img_alt'=>'tab-image' ); //available style values ( ''|style1|trans-style|full-width-style )
		extract( shortcode_atts( $variables, $atts ) );

		$this->tabs_first_tab = true;
		$result = '';
		if ( ! empty( $title ) ) { $result .= '<h2>' . esc_html( $title ) . '</h2>'; }

		if ( ( $style == 'trans-style' ) && ( ! empty( $img_src ) ) ) {
			$img_alt = ( $img_alt != '')?" alt='" . esc_attr( $img_alt ) . "'":'';
			$img_width = ( $img_width != '')?" width='" . esc_attr( $img_width ) . "'":'';
			$img_height = ( $img_height != '')?" height='" . esc_attr( $img_height ) . "'":'';
			$result .= '<img class="full-width" src="' . esc_url( $img_src ) . '"' . $img_alt . $img_width . $img_height . '/>';
		}

		$class = empty( $class )?'':( ' ' . $class );
		$bg_color = empty( $bg_color )?'':( ' ' . $bg_color );
		$result .= '<div class="tab-container ' . esc_attr( $style . $class . $bg_color ) . '">';
		$result .= '<ul class="tabs">';
		$active = ' class="active"';
		foreach ( $atts as $key => $tab ) {
			if ( ! array_key_exists( $key, $variables ) ) {
				$result .= '<li' . $active . '><a href="#' . esc_attr( $key ) . '" data-toggle="tab">' . balancetags( htmlspecialchars_decode( $tab ), true ) . '</a></li>';
				$active = '';
			}
		}
		$result .= '</ul>';
		$result .= '<div class="tab-content">';
		$result .= do_shortcode( $content );
		$result .= '</div></div>';

		return $result;
	}

	/* ***************************************************************
	* **************** Tab Shortcode Travelo********************************
	* **************************************************************** */
	function shortcode_tab_travelo($atts, $content = null) {

		extract( shortcode_atts( array(
			'id' => '',
			'class' => ''
		), $atts) );

		$active = '';
		if ( $this->tabs_first_tab ) {
			$this->tabs_first_tab = false;
			$active = ' active in';
		}

		$class = empty( $class )?'':( ' ' . $class );
		$result = '';
		$result .= '<div class="tab-pane fade' . esc_attr( $active . $class ) . '" id="' . esc_attr( $id ) . '">';
		$result .= do_shortcode( $content );
		$result .= '</div>';
		return $result;
	}
	/* ***************************************************************
	* **************** Tour Hotel Default Shortcode ********************************
	* **************************************************************** */
	function shortcode_tour_hotel_default($atts, $content = null) {
		extract( shortcode_atts( array(
			'hotel_id' => '',
			'hotel_type' => '',
			'hotel_selected_id'=> '',
		), $atts) );
		$star_hotel = get_post_meta( $hotel_id, '_hotel_star', true );
		$star_cruise = get_post_meta( $hotel_id, '_cruise_star', true );
		$review = get_post_meta( $hotel_id, '_review', true );
		$star = ( ! empty( $star_hotel ) )?$star_hotel:$star_cruise;
		$star = round($star);
		$review = round($review);
		$url = esc_url( get_permalink( $hotel_id ));
		$result = '';
		$result .= '<div class="row box-style-hotel hotel-default hotel_container" id="' . $hotel_selected_id . '">';
		$result .= '<div class="col-md-3 col-xs-6">';
		$result .= '<a href="' . $url . '" target="_blank">';
		$result .= get_the_post_thumbnail( $hotel_id, array(150,150), array( 'class' => 'img-responsive', 'style' => 'margin: auto; display: block; height: 120px;' ));
		$result .= '</a>';
		$result .= '</div>';
		$result .= '<div class="col-md-5 col-xs-6" style="border-right: 1px solid #ededed;">';
		$result .= '<a href="' . $url . '" target="_blank"><H5 class="hotel-name show">' . get_the_title( $hotel_id ) . '</h5></a>';
		$result .= '<span class="hotel-select-id hidden">' . $hotel_id . '</span>';
		$result .= '<span class="hotel-default-name">' . $hotel_type . '</span>';
		$result .= '<span class="rating show star" style="font-size: 11px;">'; 
		for ( $i = 1; $i <= 5; $i++ ) {
			$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star-empty';
			$result .= '<i class="' . $class . '"></i>';
		}
		$result .= '</span>';
		$result .= '<span class="rating show review" style="font-size: 11px;">';
		for ( $i = 1; $i <= 5; $i++ ) {
			$class = ( $i <= $review ) ? 'icon-smile voted' : 'icon-smile';
			$result .= '<i class="' . $class . '"></i>';
		}
		$result .= '</span>';
		$result .= '</div>'; 
		$result .= '<div class="col-md-4 col-xs-12 text-center block-center">';
		$result .= '<p></p>';
		$result .= '<a href="' . $url . '" target="_blank" class="btn_1 outline btn_full details" type="button"><small>Details</small></a>';
		
		$result .= '<a class="btn_1 outline btn_full btn_select" type="button"><small>Select Another</small></a>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
	/* ***************************************************************
	* **************** Tour Hotel List Shortcode ********************************
	* **************************************************************** */
	function shortcode_tour_hotel_list($atts, $content = null) {
		extract( shortcode_atts( array(
			'hotel_list' => '',
			'first_text' => '',
			'hotel_location'=> '',
		), $atts) );
		$hotel_arrary = array_map('intval', explode( ',', $hotel_list ) );
		$the_query = new WP_Query( array( 'post_type' => 'any', 'post__in' => $hotel_arrary ) );
		$result = '';
		$result .= '<div class="row hotel-list">';
		$result .= '<hr>';
		$result .= '<blockquote>';
		$result .= $first_text;
		$result .= '</blockquote>';
								if ( $the_query->have_posts() ) {
									 while ( $the_query->have_posts() ) { 
									 	$the_query->the_post();
									 	$hotel_id = get_the_ID();
									 	$star_hotel = get_post_meta( $hotel_id, '_hotel_star', true );
										$star_cruise = get_post_meta( $hotel_id, '_cruise_star', true );
										$star = ( ! empty( $star_hotel ) )?$star_hotel:$star_cruise;
										$star = round($star);
									 	$review = get_post_meta( $hotel_id, '_review', true );
									 	$review = round($review);
										$result .= '<div class="col-md-3 col-xs-6 text-center center-block">';
											$result .= '<div class="box-style-hotel hotel_container">';
												$result .= '<a href="'. esc_url( get_permalink( $hotel_id ) ) . '" target="_blank" style="color: #e04f67;">';
													$result .= get_the_post_thumbnail( $hotel_id, array(150,150), array( 'class' => 'img-responsive', 'style' => 'margin: auto; display: block; height: 100px;' )); 
													$result .= '<ins class="show">'; 
													$result .= get_the_title(); 
													$result .= '</ins>';
												$result .= '</a>';
												$result .= '<span class="hotel-id hidden">' . $hotel_id . '</span>';
												$result .= '<small>'. $hotel_location .'</small>';
												$result .= '<span class="rating show star" style="font-size: 11px;">';
												for ( $i = 1; $i <= 5; $i++ ) {
													$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star-empty';
													$result .= '<i class="' . $class . '"></i>';
												}
												$result .= '</span>';
												$result .= '<span class="rating show review" style="font-size: 11px;">';
											    for ( $i = 1; $i <= 5; $i++ ) {
													$class = ( $i <= $review ) ? 'icon-smile voted' : 'icon-smile';
													$result .= '<i class="' . $class . '"></i>';
												}
											    $result .= '</span>';
												$result .= '<hr style="margin-top: 10px; margin-bottom: 10px;">';
												$result .= '<a class="btn_1 outline active btn-choose" type="button" id="btn-choose">Select</a>';
											$result .= '</div>';
										$result .= '</div>';
									wp_reset_postdata(); 
									}
								} 
							$result .= '</div>';
							$result .= '<hr>';
		return $result;
	}
	/* ***************************************************************
	* ******************** Single Item Shortcode ************************
	* **************************************************************** */
	function shortcode_single_item( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'hotel_id' => '',
			'text' => '',
		), $atts) );
		$star_hotel = get_post_meta( $hotel_id, '_hotel_star', true );
		$star_cruise = get_post_meta( $hotel_id, '_cruise_star', true );
		$review = get_post_meta( $hotel_id, '_review', true );
		$hotel_price = get_post_meta( $hotel_id, '_hotel_price', true );
		$cruise_price = get_post_meta( $hotel_id, '_cruise_price', true );
		$price = ( ! empty( $hotel_price ) )?$hotel_price:$cruise_price;
		$star = ( ! empty( $star_hotel ) )?$star_hotel:$star_cruise;
		$review = round($review);
		$result = '';
		$result .= '<div class="hotel_container">';
			$result .= '<div class="img_container">';
					$result .= '<a href="'. esc_url( get_permalink( $hotel_id ) ) . '" target="_blank" style="color: #e04f67;">';
					$result .= get_the_post_thumbnail( $hotel_id, 'ct-list-thumb', array( 'class' => 'img-responsive', 'style' => 'margin: auto; display: block;' ));
					$result .= '<div class="ribbon popular"></div>';
					$result .= '<div class="short_info hotel">' . $text . '<span class="price"><span><sup>$</sup>'. $price .'</span></span></div>';
					$result .= '</a>';	
			$result .= '</div>';
			$result .= '<div class="hotel_title">';
			$result .= '<h5 style="margin-top: 0px; margin-bottom: 0px;">' . get_the_title($hotel_id). '</h5>';
			$result .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star-empty';
					$result .= '<i class="' . $class . '"></i>';
				}
			$result .= '</span>';
			
			$result .= '</div>';
			
		$result .= '</div>';
		return $result;
	}
	
	/* ***************************************************************
	* ******************** Single Tour Shortcode ************************
	* **************************************************************** */
	function shortcode_single_tour( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'tour_id' => '',
			'text' => '',
		), $atts) );
		$review = get_post_meta( $tour_id, '_review', true );
		$tour_price = get_post_meta( $tour_id, '_tour_price', true );
		$tour_duration = get_post_meta( $tour_id, '_tour_duration', true );
		$review = round($review);
		$result = '';
		$result .= '<div class="hotel_container">';
			$result .= '<div class="img_container">';
					$result .= '<a href="'. esc_url( get_permalink( $tour_id ) ) . '" target="_blank" style="color: #e04f67;">';
					$result .= get_the_post_thumbnail( $tour_id, 'ct-list-thumb', array( 'class' => 'img-responsive', 'style' => 'margin: auto; display: block;' ));
					$result .= '<div class="ribbon popular"></div>';
					$result .= '<div class="short_info hotel">' . $text . '<span class="price"><span><sup>$</sup>'. $tour_price .'</span></span></div>';
			$result .= '</a>';	
			$result .= '</div>';
			$result .= '<div class="hotel_title">';
			$result .= '<h5 style="margin-top: 0px; margin-bottom: 0px;">' . get_the_title($tour_id). '</h5>';
			$result .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $review ) ? 'icon-smile voted' : 'icon-smile';
					$result .= '<i class="' . $class . '"></i>';
				}
			$result .= '</span>';
			$result .= '<span class="pull-right">';
			$result .= $tour_duration;
			$result .= '</span>';
			$result .= '</div>';
			
		$result .= '</div>';
		return $result;
	}
	/* ***************************************************************
	* ******************** List Hotel Shortcode ************************
	* **************************************************************** */
	function shortcode_list_hotel( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'district' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$district = ( ! empty( $district ) ) ? explode( ',', $district ) : array();
		$count = is_numeric( $count )?$count:6;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_hotel_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_hotel_get_special_hotels( $type, $count, array(), $district );
		}
			$output = '<div class="list_tours_tabs"><ul>';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_hotel_price', true );
				$star = get_post_meta( $post_id, '_hotel_star', true );
				$output .= '<li><div><a href="' . esc_url( get_permalink( $post_id ) ) . '"><figure>' . get_the_post_thumbnail( $post_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $post_id ) . '</h5>';
				
				$output .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star';
					$output .= '<i class="' . $class . '"></i>';
				}
				$output .= '</span>';
				$output .= '<small class="pull-right"> - From <b>' . ct_price( $price ).'</b>/night</small>';
				$output .= '</a></div></li>';
			
			}
			$output .= '</ul></div>';
		return $output;
	}
	/* ***************************************************************
	* ******************** List Cruise Shortcode ************************
	* **************************************************************** */
	function shortcode_list_cruise( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		
		$count = is_numeric( $count )?$count:6;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_cruise_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_cruise_get_special_hotels( $type, $count, array() );
		}
			$output = '<div class="list_tours_tabs"><ul>';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_cruise_price', true );
				$star = get_post_meta( $post_id, '_cruise_star', true );
				$output .= '<li><div><a href="' . esc_url( get_permalink( $post_id ) ) . '"><figure>' . get_the_post_thumbnail( $post_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $post_id ) . '</h5>';
				
				$output .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star';
					$output .= '<i class="' . $class . '"></i>';
				}
				$output .= '</span>';
				$output .= '<small class="pull-right"> - From <b>' . ct_price( $price ).'</b>/person</small>';
				$output .= '</a></div></li>';
			
			}
			$output .= '</ul></div>';
		return $output;
	}
	/* ***************************************************************
	* ******************** List Tour Shortcode ************************
	* **************************************************************** */
	function shortcode_list_tour( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'tour_type' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$count = is_numeric( $count )?$count:6;
		$tour_type = ( ! empty( $tour_type ) ) ? explode( ',', $tour_type ) : array();
		$output = '';

		$tours = array();
		if ( $type == 'selected' ) {
			$tours = ct_tour_get_tours_from_id( $post_ids );
		} else {
			$tours = ct_tour_get_special_tours( $type, $count, array(), $tour_type );
		}
			$output = '<div class="list_tours_tabs"><ul>';
			foreach ( $tours as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_tour_price', true );
				$review = get_post_meta( $post_id, '_review', true );
				//$duration = get_post_meta( $post_id, '_tour_duration', true );
				$output .= '<li><div><a href="' . esc_url( get_permalink( $post_id ) ) . '"><figure>' . get_the_post_thumbnail( $post_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $post_id ) . '</h5>';
				
				$output .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $review ) ? 'icon-smile voted' : 'icon-smile';
					$output .= '<i class="' . $class . '"></i>';
				}
				$output .= '</span>';
				//$output .= '<small class="pull-right">'.$duration.' - From <b>' . ct_price( $price ).'</b>/person</small>';
				$output .= '<small class="pull-right">- From <b>' . ct_price( $price ).'</b>/person</small>';
				$output .= '</a></div></li>';
			
			}
			$output .= '</ul></div>';
		return $output;
	}
	
	/* ***************************************************************
	* ******************** Search Fly Shortcode ************************
	* **************************************************************** */
	function shortcode_search_fly( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		$data = array ( "request" => array(
                            "passengers" => array( 
                                adultCount => 1
                            ),
                            "slice" => array( 
                                array(
                                    origin => "HAN",
                                    destination => "SGN",
                                    date => "2016-09-09"),
                                array(
                                    origin => "HAN",
                                    destination => "SGN",
                                    date => "2016-09-10"),
                                ),
                                    solutions => "1"
                                ),                   
                );
        $result= '';
		$data_string = json_encode($data);
		$ch = curl_init('https://www.googleapis.com/qpxExpress/v1/trips/search?key=AIzaSyCvWvIGZPFU3NwC5JBSRkH2ujir0GUw0zQ');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                                                                                                                   
		
		$result = curl_exec($ch);
		curl_close($ch);
		

		return $result[kind];
	}
	/* ***************************************************************
	* ******************** Search Pannel Shortcode ************************
	* **************************************************************** */
	function shortcode_search_pannel( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
		), $atts) );
		$active_class = 'active';
        $result= '';
		
	}
	/* ***************************************************************
	* **************** Tour Customize Page Shortcode **********
	* **************************************************************** */
	function shortcode_customize_tour( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'customize-tour.php', '/templates/' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	/* ***************************************************************
	* **************** Transfer CheckOut Page Shortcode **********
	* **************************************************************** */
	function shortcode_transfer_checkout( $atts, $content = null ) {
		ob_start();
		ct_get_template( 'checkout.php', '/templates/transfer' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	/* ***************************************************************
	* ************************* Map Shortcode ************************
	* **************************************************************** */
	function shortcode_map( $atts, $content = null ) { 
		global $container_id, $center, $related, $zoom, $maptypecontrol, $maptype;

		$variables = array( 
			'class'=>'',
			'center' => '',
			'related' => '',
			'zoom' => '14',
			'maptype' => 'RoadMap',
			'maptypecontrol'=>'',
			'streetviewcontrol' => 'true',
			'scrollwheel' => 'true',
			'draggable' => 'true',
			'width' => '100%',
			'height' => '300px',
			'container_id' => ''
		);
		extract( shortcode_atts( $variables, $atts ) );

		if ( ! empty( $related ) ) { $related = explode( ',', $related ); } else { $related = array(); }

		if ( ( $maptypecontrol == 'yes' ) || ( $maptypecontrol == 'true' ) ) { $maptypecontrol = 'true'; } else { $maptypecontrol = 'false'; }
		// if ( ( $nav_control == 'yes' ) || ( $nav_control == 'true' ) ) { $nav_control = 'navigationControl: true,'; } else { $nav_control = 'navigationControl: false,'; }
		if ( ( $scrollwheel == 'yes' ) || ( $scrollwheel == 'true' ) ) { $scrollwheel = 'true'; } else { $scrollwheel = 'false'; }
		if ( ( $streetviewcontrol == 'yes' ) || ( $streetviewcontrol == 'true' ) ) { $streetviewcontrol = 'true'; } else { $streetviewcontrol = 'false'; }
		// if ( ( $draggable == 'yes' ) || ( $draggable == 'true' ) ) { $draggable = 'draggable: true,'; } else { $draggable = 'draggable: false,'; }

		$map_types = array( 'ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN' );
		$maptype = strtoupper( $maptype );
		if ( empty( $maptype) || ! in_array( $maptype, $map_types ) ) $maptype = 'ROADMAP';
		$maptype = 'google.maps.MapTypeId.' . $maptype;

		static $map_id = 1;
		$class = empty( $class )?'': ' ' . esc_attr( $class );

		$result = '';

		ob_start();
		ct_get_template( 'map.php', '/templates' );
		$result = ob_get_contents();
		ob_end_clean();

		$map_id++;
		return $result;
	}
	/* ***************************************************************
	* ******************** List Tour Thumbnail Shortcode ************************
	* **************************************************************** */
	function shortcode_list_tour_thumbnail( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'tour_type' => '',
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		$count = is_numeric( $count )?$count:6;
		$tour_type = ( ! empty( $tour_type ) ) ? explode( ',', $tour_type ) : array();
		$output = '';

		$tours = array();
		if ( $type == 'selected' ) {
			$tours = ct_tour_get_tours_from_id( $post_ids );
		} else {
			$tours = ct_tour_get_special_tours( $type, $count, array(), $tour_type );
		}
			$output = '<div class="list_tour_thumbnail">';
			foreach ( $tours as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_tour_price', true );
				$review = get_post_meta( $post_id, '_review', true );
				//$duration = get_post_meta( $post_id, '_tour_duration', true );
				$output .= '<div class="col-sm-4"><div class="thumbnail">';
				$output .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . get_the_post_thumbnail( $post_id, 'ct-list-thumb', array( 'class' => '')) . '<h5>' . get_the_title( $post_id ) . '</h5>';
				
				$output .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $review ) ? 'icon-smile voted' : 'icon-smile';
					$output .= '<i class="' . $class . '"></i>';
				}
				$output .= '</span>';
				$output .= '<p>From <b class="price_tnd">' . ct_price( $price ).'</b>/<small>person</small></p>';
				$output .= '</div></a></div>';
			
			}
			$output .= '</div>';
		return $output;
	}
	/* ***************************************************************
	* ******************** List Cruise Thumbnail Shortcode ************************
	* **************************************************************** */
	function shortcode_list_cruise_thumbnail( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$types = array( 'latest', 'featured', 'popular', 'hot', 'selected' );
		if ( ! in_array( $type, $types ) ) $type = 'latest';
		$post_ids = explode( ',', $post_ids );
		
		$count = is_numeric( $count )?$count:6;
		$output = '';

		$hotels = array();
		if ( $type == 'selected' ) {
			$hotels = ct_cruise_get_hotels_from_id( $post_ids );
		} else {
			$hotels = ct_cruise_get_special_hotels( $type, $count, array() );
		}
			$output = '<div class="list_tour_thumbnail">';
			foreach ( $hotels as $post_obj ) {
				$post_id = $post_obj->ID;
				$price = get_post_meta( $post_id, '_cruise_price', true );
				$star = get_post_meta( $post_id, '_cruise_star', true );
				$output .= '<div class="col-sm-4"><div class="thumbnail">';
				$output .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . get_the_post_thumbnail( $post_id, 'ct-list-thumb', array( 'class' => '')) . '<h5>' . get_the_title( $post_id ) . '</h5>';
				
				$output .= '<span class="rating star">'; 
				for ( $i = 1; $i <= 5; $i++ ) {
					$class = ( $i <= $star ) ? 'icon-star voted' : 'icon-star';
					$output .= '<i class="' . $class . '"></i>';
				}
				$output .= '</span>';
				$output .= '<p>From <b class="price_tnd">' . ct_price( $price ).'</b>/<small>person</small></p>';
				$output .= '</div></a></div>';
			
			}
			$output .= '</div>';
		return $output;
	}
		/* ***************************************************************
	* ******************** List Sights Shortcode ************************
	* **************************************************************** */
	function shortcode_list_sight( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'latest',
			'count' => 6,
			'post_ids' => '',
			'class' => '',
		), $atts) );
		$post_ids = explode( ',', $post_ids );
		
		$count = is_numeric( $count )?$count:6;
		$output = '';
		$output = '<div class="list_tours_tabs"><ul>';
		foreach ( $post_ids as $post_id ) {
			$terms = get_the_terms( $post_id, 'hanoi_sight_type' );
			$output .= '<li><div><a href="' . esc_url( get_permalink( $post_id ) ) . '"><figure>' . get_the_post_thumbnail( $post_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $post_id ) . '</h5>';
			$output .= '</span>';
			if ( $terms && ! is_wp_error( $terms ) )  {
				    foreach ( $terms as $term ) {
				        $output .='<small>' . $term->name . '</small>';
				    }
				}
			$output .= '</a></div></li>';
		
		}
		$output .= '</ul></div>';
		return $output;
	}
	/* ***************************************************************
	* ******************** Similar Tour Shortcode ************************
	* **************************************************************** */
	function shortcode_similar_tour( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'post_ids' => '',
		), $atts) );
		$post_ids = explode( ',', $post_ids );
		
		$output = '';
		$output = '<div class="list_tours_tabs"><ul>';
		foreach ( $post_ids as $post_id ) {
			$terms = get_the_terms( $post_id, 'tour_type' );
			$price = get_post_meta( $post_id, '_tour_price', true );
			$output .= '<li><div><a href="' . esc_url( get_permalink( $post_id ) ) . '"><figure>' . get_the_post_thumbnail( $post_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $post_id ) . '</h5>';
			$output .= '</span>';
			if ( $terms && ! is_wp_error( $terms ) )  {
				    foreach ( $terms as $term ) {
				        $output .='<a href="' . get_term_link($term) .'" target="_blank"><small>' . $term->name . '</small></a>';
				    }
				}
			$output .= '<small class="pull-right">- From <b>$' . $price . '</b>/person</small>';	
			$output .= '</a></div></li>';
		
		}
		$output .= '</ul></div>';
		return $output;
	}
}
endif;