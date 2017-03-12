<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();

		//init variables
		$post_id = get_the_ID();
		$address = get_post_meta( $post_id, '_golf_address', true );
		$loc = get_post_meta( $post_id, '_golf_loc', true );
		//$booking_link = get_post_meta( $post_id, '_golf_booking_link', true );
		$weekday_price = get_post_meta( $post_id, '_golf_weekday_price', true );
		$weekend_price = get_post_meta( $post_id, '_golf_weekend_price', true );

		$brief = get_post_meta( $post_id, '_golf_brief', true );
        $designer = get_post_meta( $post_id, '_golf_designer', true );
        $hole = get_post_meta( $post_id, '_golf_hole', true );
        $established = get_post_meta( $post_id, '_golf_established', true );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
        
		$review = get_post_meta( ct_hotel_org_id( $post_id ), '_review', true );
		$review = ( ! empty( $review ) )?round( $review, 1 ):0;
		$doubled_review = number_format( round( $review * 2, 1 ), 1 );
		$review_content = '';
		if ( $doubled_review >= 9 ) {
			$review_content = esc_html__( 'Superb', 'citytours' );
		} elseif ( $doubled_review >= 8 ) {
			$review_content = esc_html__( 'Very good', 'citytours' );
		} elseif ( $doubled_review >= 7 ) {
			$review_content = esc_html__( 'Good', 'citytours' );
		} elseif ( $doubled_review >= 6 ) {
			$review_content = esc_html__( 'Pleasant', 'citytours' );
		} else {
			$review_content = esc_html__( 'Review Rating', 'citytours' );
		}
		$tour_pos = get_post_meta( $post_id, '_golf_loc', true );
		if ( ! empty( $tour_pos ) ) {
			$tour_pos = explode( ',', $tour_pos );
		}

		$related_hotel = get_post_meta( $post_id, '_golf_related_3_hotel' );
		
		$related_tour = get_post_meta( $post_id, '_golf_related_tour' );

		$add_services = ct_get_add_services_by_postid( $post_id );
		?>
		<div id="position" class="blank-parallax">
			<div class="container"><?php ct_breadcrumbs(); ?></div>
		</div><!-- End Position -->

		<div class="collapse" id="collapseMap">
			<div id="map" class="map"></div>
		</div>

<div class="container margin_60">
	<div class="row">
		<div class="col-md-8" id="single_tour_desc">
			<div class="row">
				<div class="col-md-12">
					<div class="box_style_1 expose">
						<div class="row">
							<div class="col-md-4" style="text-align: center;">
								<?php echo get_the_post_thumbnail( $post_id, array(150,150), array( 'class' => 'img-circle', 'style' => 'margin: auto; display: block;' )); ?>
								<h1 style="font-size: 18px;"><?php the_title() ?></h1>
								<span class="rating" style="text-align: center; margin: auto; display: block; font-size: 14px;">
									<?php ct_rating_smiles( $review ); ?>
								</span>
								<i>from </i><span style="font-size: 19px; color: #E04F67;"><?php echo ct_price( $weekday_price, "special" ) ?></span> /player
							</div>
							<div class="col-md-8">
								<ul class="list_info" >
								<li><i class="icon_set_1_icon-61"></i><span class="info_label">Golf Course:</span> <span><?php the_title() ?></span></li>
								<li><i class="icon_set_1_icon-70"></i><span class="info_label">Designer:</span> <?php echo esc_html( $designer, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-39"></i><span class="info_label">Holes / Par / Yardage:</span> <?php echo esc_html( $hole, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-41"></i><span class="info_label">Location:</span> <?php echo esc_html( $address, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-53"></i><span class="info_label">Established:</span> <?php echo esc_html( $established, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-18"></i><span class="info_label">Review:</span> <b class="text-danger"><?php echo esc_html( $doubled_review ) ?></b> /10 - <span class="text-success"><?php echo esc_html( $review_content ) ?></span> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></li>
								</ul>
								<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
							</div>
							<div class="hidden-xs" style="font-style: italic;">
								<?php echo $brief; ?>
							</div>
						</div>
						
						
						<div class="<?php if (! empty( $hotel_po )) : echo "ribbon popular"; endif; ?>"></div>
					</div>
				</div>	
			</div>
			<div class="row">
				<?php //if ( ! wp_is_mobile() ) : ?>
        			<?php if ( ! empty( $gallery_imgs ) ) : ?>
						<div class="carousel magnific-gallery" id="galery-post">
							<center>
							<?php foreach ( $gallery_imgs as $gallery_img ) {
								echo '<div class="col-md-2 col-sm-2 col-xs-4 gallery-image-nd"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'tnd-post-galery', '', array( "class" => "img-responsive" ) ) . '</a></div>';
							} ?>
							</center>
						</div>
					<?php endif; ?>
				<?php //endif; ?>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
						<?php the_content(); ?>
				</div>
			</div>
			<hr>
			<?php if ( ! empty( $related_hotel ) ) : ?>
			<div class="row">
				<div class="col-md-2">
					<h3><?php echo esc_html__( 'Hotel Booking', 'citytours') ?></h3>
				</div>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-4">
							<a href="#hotel-tab-1" class="btn_1 outline btn_full hotel_class_btn active" data-hotel_class="_golf_related_3_hotel" ><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a>
						</div>
						<div class="col-md-4">
							<a href="#hotel-tab-2" class="btn_1 outline btn_full hotel_class_btn" data-hotel_class="_golf_related_4_hotel" ><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a>
						</div>
						<div class="col-md-4">
							<a href="#hotel-tab-3" class="btn_1 outline btn_full hotel_class_btn" data-hotel_class="_golf_related_5_hotel" ><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a>
						</div>
					</div>
					<br>
					<div id="hotel-tab-1" class="hotel_list_div" e="1">
						<?php tnd_render_list_hotel($related_hotel); ?>
					</div>
					<div id="hotel-tab-2" class="hotel_list_div" e="0">		
					</div>
					<div id="hotel-tab-3" class="hotel_list_div" e="0">		
					</div>
				</div>
			</div>
			<hr>
			<?php endif; ?>

			<?php
				$review_fields = array("Position", "Comfort", "Price", "Quality");
				$review = get_post_meta( ct_hotel_org_id( $post_id ) , '_review', true );
				//$review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
				$doubled_review = number_format( round( $review * 2, 1 ), 1 );
				$review_content = '';
				if ( $doubled_review >= 9 ) {
					$review_content = esc_html__( 'Superb', 'citytours' );
				} elseif ( $doubled_review >= 8 ) {
					$review_content = esc_html__( 'Very good', 'citytours' );
				} elseif ( $doubled_review >= 7 ) {
					$review_content = esc_html__( 'Good', 'citytours' );
				} elseif ( $doubled_review >= 6 ) {
					$review_content = esc_html__( 'Pleasant', 'citytours' );
				} else {
					$review_content = esc_html__( 'Review Rating', 'citytours' );
				}
				$review_detail = get_post_meta( ct_tour_org_id( $post_id ), '_review_detail', true );
				if ( ! empty( $review_detail ) ) {
					$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
				} else {
					$review_detail = array_fill( 0, count( $review_fields ), 0 );
				}
				?>
				<div class="row">
					<div class="col-md-2">
						<h3><?php echo esc_html__( 'Reviews', 'citytours') ?></h3>
					</div>
					<div class="col-md-10">
						<div id="score_detail"><span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></div>
						<hr>
						<div class="guest-reviews">
							<?php
								$per_page = 2;
								$review_count = ct_get_review_html($post_id, 0, $per_page);
							?>
						</div>
						<div class="margin_bottom_30">
							<?php if ( $review_count >= $per_page ) : ?>
								<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>">LOAD MORE REVIEWS</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">
			
		<div class="box_style_1 expose">
			<h3 class="inner">- <?php echo esc_html__( 'Booking', 'citytours' ) ?> -</h3>
			<form method="post" id="booking-form" action="<?php echo esc_url( $booking_link ); ?>">
				<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Select a date', 'citytours' ) ?></label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class=" icon-clock"></i> <?php echo esc_html__( 'T/O Times', 'citytours' ) ?></label>
							<input class="time-pick form-control" value="6:00 AM" type="text" name="time">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon_set_1_icon-29"></i> <?php echo esc_html__( 'Players', 'citytours' ) ?></label>
							<div class="numbers-row" data-min="1">
								<input type="text" value="1" id="players" class="qty2 form-control valid" name="players" aria-invalid="false">
								<div class="inc button_inc">+</div><div class="dec button_inc">-</div>
							</div>
						</div>
					</div>
				</div>
				<table class="table table_summary">
				<thead>
				<tr>
					<th colspan="2">
						<?php the_title()  ?>
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<?php echo esc_html__( 'Players', 'citytours' ) ?>
					</td>
					<td class="text-right adults-number">
						1
					</td>
				</tr>
				<tr>
					<td>
						<?php echo esc_html__( 'Fee per Player at weekday', 'citytours' ) ?>
					</td>
					<td class="text-right weekday_price">
						<?php echo ct_price( $weekday_price ) ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo esc_html__( 'Fee per Player at weekend', 'citytours' ) ?>
					</td>
					<td class="text-right weekend_price">
						<?php echo ct_price( $weekend_price ) ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo esc_html__( 'Selected date', 'citytours' ) ?>
					</td>
					<td class="text-right selected_date">

					</td>
				</tr>
				<tr>
					<td>
						<?php echo esc_html__( 'Total Golf Course Fee', 'citytours' ) ?>
					</td>
					<td class="text-right">
						<span class="adults-number">1</span>x $<span class="fee-per-player"></span>
						<?php if ( ! empty( $child_price ) ) : ?>
							<span class="child-amount hide"> + <span class="children-number">0</span>x <?php echo ct_price( $child_price ) ?></span>
						<?php endif; ?>
					</td>
				</tr>

				</tbody>
				</table>
				<?php if ( ! empty( $add_services ) ) : ?>
				<table class="table table-striped options_booking">
				<thead>
				<tr>
					<th colspan="3">
						<?php echo esc_html__( 'Add Services', 'citytours' ) ?>
					</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ( $add_services as $service ) : ?>
						<?php $field_name = 'add_service_' . esc_attr( $service->id ); ?>
						<tr>
							<td width="6%">
								<i class="<?php echo esc_attr( $service->icon_class ); ?>"></i>
							</td>
							<td width="59%">
								<?php echo esc_attr( $service->title ); ?> <strong>+<?php echo ct_price( $service->price ) ?></strong>
							</td>
							<td width="35%">
								<label class="switch-light switch-ios pull-right">
								<input type="checkbox" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>" value="<?php echo $service->price ?>" name_service="<?php echo esc_attr( $service->title ); ?>">
								<span>
								<span><?php echo esc_html__( 'No', 'citytours' ) ?></span>
								<span><?php echo esc_html__( 'Yes', 'citytours' ) ?></span>
								</span>
								<a></a>
								</label>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
				</table>
				<input type="hidden" name="add_service" value="">
				<?php endif; ?>
				<div id="add-hotel">
				</div>
				<table class="table table_summary">
				<tbody>
				<tr class="total">
					<td>
						<?php echo esc_html__( 'Total Fee', 'citytours' ) ?>
					</td>
					<td class="text-right total-cost">
						$0
					</td>
				</tr>
				</tbody>
				</table>
				<input type="hidden" name="total_price" value="0">
				<input type="hidden" name="action" value="tnd_golf_course_submit_booking">
				<a class="btn_full_outline" href="#" data-toggle="modal" data-target="#inquiry">Book now</a>
				<div class="modal fade" id="inquiry" tabindex="-1" role="dialog" aria-labelledby="inquiryLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
								<h4 class="modal-title" id="myReviewLabel">Booking Golf Course</h4>
							</div>
							<div class="modal-body">
								<?php tnd_tour_form_booking(); ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div><!--/box_style_1 -->
		<?php if ( is_active_sidebar( 'golf_course_sidebar' ) ) : ?>
			<?php dynamic_sidebar( 'golf_course_sidebar' ); ?>
		<?php endif; ?>
		</aside>
	</div><!--End row -->
</div><!--End container -->
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=287004874991108";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
$ = jQuery.noConflict();
var price_per_person = 0;
var exchange_rate = 1;
var weekday_price = 0;
var weekend_price = 0;
var total_hotel_booking_price = 0;
<?php if ( ! empty( $weekday_price ) ) : ?>
	weekday_price = <?php echo esc_js( $weekday_price ); ?>;
	weekend_price = <?php echo esc_js( $weekend_price ); ?>;
<?php endif; ?>
<?php if ( ! empty( $_SESSION['exchange_rate'] ) ) : ?>
	exchange_rate = <?php echo esc_js( $_SESSION['exchange_rate'] ); ?>;
<?php endif; ?>
var cart_hotel;
$(document).ready(function(){
	var validation_rules = {
			first_name: { required: true},
			last_name: { required: true},
			email: { required: true, email: true},
			email2: { required: true, equalTo: 'input[name="email"]'},
			phone: { required: true},
			address1: { required: false},
			city: { required: false},
			zip: { required: false},
		};
	//validation form
	$('#booking-form').validate({
		rules: validation_rules,
		submitHandler: function (form) {
			if ( $('input[name="agree"]').length ) {
				if ( $('input[name="agree"]:checked').length == 0 ) {
					alert("<?php echo esc_html__( 'Agree to terms&conditions is required' ,'citytours' ); ?>");
					return false;
				}
			}
			var booking_data = $('#booking-form').serialize();
			$('#overlay').fadeIn();
			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: booking_data,
				success: function ( response ) {
					if ( response.success == 1 ) {
						var confirm_url = $('#booking-form').attr('action');
							if ( confirm_url.indexOf('?') > -1 ) {
								confirm_url = confirm_url + '&';
							} else {
								confirm_url = confirm_url + '?';
							}
							confirm_url = confirm_url + 'booking_no=' + response.result.booking_no + '&pin_code=' + response.result.pin_code;
							window.location.href = confirm_url;
					} else if ( response.success == -1 ) {
						alert( response.result );
						window.location.href = '';
					} else {
						alert(response.result);
					}
				}
			});
			return false;
		}
	});
	$(document).on('change', '.numbers-row input', function(){
		if ( $(this).parent().attr("data-max") && $(this).val() > $(this).parent().data('max') ) {
		$(this).val( $(this).parent().data('max') );
		}
		if ( $(this).parent().attr("data-min") && $(this).val() < $(this).parent().data('min') ) {
			$(this).val( $(this).parent().data('min') );
		}
	});
	$(document).on('click', '.button_inc_tnd', function(){
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();

		if ($button.text() == "+") {
			var max_val = 9999;
			if ( $(this).parent().attr("data-max") ) {
				max_val = $(this).parent().data("max");
			}
			if (oldValue < max_val) {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				newVal = max_val;
			}
		} else {
			// Don't allow decrementing below zero
			var min_val = 0;
			if ( $(this).parent().attr("data-min") ) {
				min_val = $(this).parent().data("min");
			}
			if (oldValue > min_val) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				if ( $(this).parent() )
				newVal = min_val;
			}
		}
		$button.parent().find("input").val(newVal).change();
	});
	$(document).on('change', '.room-adults', function(){
		$('.check_price_btn').removeClass("hidden");
		$('#hotel-price').html("");
		var $quantity = $(this).closest('tr').find('.room-quantity');
		var adults = parseInt($(this).val(),10);
		var max_adults = 0;
		if ( $(this).parent('.numbers-row').attr('data-per-room') ) {
			max_adults = $(this).parent('.numbers-row').data('per-room');
			if ( ( max_adults * $quantity.val() < adults ) ) $quantity.val( Math.ceil(adults / max_adults) );
		}
	});
	$(document).on('change', '.room-kids', function(){
		$('.check_price_btn').removeClass("hidden");
		$('#hotel-price').html("");
		var $quantity = $(this).closest('tr').find('.room-quantity');
		var kids = parseInt($(this).val(),10);
		var max_kids = 0;
		if ( $(this).parent('.numbers-row').attr('data-per-room') ) {
			max_kids = $(this).parent('.numbers-row').data('per-room');
			if ( ( max_kids * $quantity.val() < kids ) ) $quantity.val( Math.ceil(kids / max_kids) );
		}
	});
	$(document).on('change', '.room-quantity', function(){
		$('.check_price_btn').removeClass("hidden");
		$('#hotel-price').html("");
		var $adults = $(this).closest('tr').find('.room-adults');
		var $kids = $(this).closest('tr').find('.room-kids');
		var max_adults = 0, max_kids = 0;
		if ( $adults.parent('.numbers-row').attr('data-per-room') ) max_adults = $adults.parent('.numbers-row').data('per-room');
		if ( $kids.parent('.numbers-row').attr('data-per-room') ) max_kids = $kids.parent('.numbers-row').data('per-room');
		var rooms = parseInt($(this).val(),10);
		if ( max_adults > 0 && ( max_adults * rooms < parseInt($adults.val(),10) ) ) $adults.val( max_adults * rooms );
		if ( max_kids > 0 && ( max_kids * rooms < parseInt($kids.val(),10) ) ) $kids.val( max_kids * rooms );
	});
	$(document).on('click', '.view_room_btn', function(e){
		e.preventDefault();
		$('#overlay').fadeIn();
		$('#hotel-check').remove();
		$('#hotel-price').remove();
		$(this).closest('.hotel_box').append('<div id="hotel-check"></div><div id="hotel-price"></div>');
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: $(this).parent().serialize(),
			success: function(response){
				if (response == '') {
					location.reload();
				} else {
					console.log(response);
					$('#hotel-check').html(response);
					$('#overlay').fadeOut();
				}
			}
		});
		return false;
	});
	$(document).on('click', '.check_price_btn', function(e){
		e.preventDefault();
		$('#overlay').fadeIn();
		$(this).addClass("hidden");
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: $(this).parent().serialize(),
			success: function(response){
				if (response == '') {
					location.reload();
				} else {
					console.log(response);
					cart_hotel = JSON.parse( response );
					var html = '<div><div><h5 class="text-center"><strong>' + 'Check In: ' + cart_hotel.date_from + ' - Check Out: ' + cart_hotel.date_to +'</strong></h3></div><div><div class="table-responsive"><table class="table table-condensed"><thead><tr><td><strong>Room</strong></td><td class="text-center"><strong>Quantity</strong></td><td class="text-center"><strong>Adult</strong></td><td class="text-center"><strong>Child</strong></td><td class="text-right"><strong>Price</strong></td></tr></thead><tbody>';
					if (typeof cart_hotel.room != "undefined") {
						$.each(cart_hotel.room, function(key,value) {
							html += '<tr><td>' + value.room_name + '</td><td class="text-center">' + value.rooms + '</td><td class="text-center">' + value.adults + '</td><td class="text-center">' + value.kids + '</td><td class="text-right">$' + value.total + '</td></tr>';
						});
					}	
					html += '<tr><td class="no-line"></td><td class="no-line"></td><td class="no-line"></td><td class="no-line text-center"><strong>Total</strong></td><td class="no-line text-right">$' + cart_hotel.total_price +'</td></tr></tbody></table></div><a href="#" class="btn_full add_hotel_cart_btn"><i class="icon-cart"></i> Add Cart</a></div></div>';
					$('#hotel-price').html(html);
					$('#overlay').fadeOut();
				}
			}
		});
		return false;
	});
	var tmp = 0;
	$(document).on('click', '.add_hotel_cart_btn', function(e){
		e.preventDefault();
		$('#overlay').fadeIn();
		$('#hotel-check').remove();
		$('#hotel-price').remove();
		
		var rooms_html = "";
		var html = '<table class="table table_summary add_hotel_cart_summary"><thead><tr><th>' + cart_hotel.hotel_name + '</th><th class="text-right"><a class="remove_hotel_cart_btn" ><i class="icon-minus-circled"></i>Remove</a></th></tr></thead><tbody><tr><td>Check in</td><td class="text-right">' + cart_hotel.date_from + '</td></tr><tr><td>Check out</td><td class="text-right">' + cart_hotel.date_to + '</td></tr><tr><td>Rooms</td><td class="text-right">';
		$.each(cart_hotel.room, function(key,value) {
			rooms_html += value.rooms + ' ' + value.room_name + '<br>';
		});
		html += rooms_html + '</td></tr><tr><td>Adults</td><td class="text-right">' + cart_hotel.total_adults + '</td></tr><tr><td>Children</td><td class="text-right">' + cart_hotel.total_kids + '</td></tr><tr><td>Hotel Cost</td><td class="text-right">$<span class="hotel_booking_price">' + cart_hotel.total_price + '</span></td></tr></tbody></table>';
		$('#add-hotel').append(html);
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {
				action: "tnd_ajax_add_hotel_cart",
				cart_hotel
			},
			success: function(response){
				if (response == '') {
					location.reload();
				} else {
					console.log(response);
					var html = '<input type="hidden" name="add_hotels[' + tmp + ']" value="' + response +'">';
					$('#add-hotel').append(html);
					tmp += 1;
				}
			}
		});
		total_hotel_booking_price += parseInt( cart_hotel.total_price );
		update_tour_price();
		$('body,html').animate({scrollTop: ( $('#add-hotel').offset().top - 100) },1000);
		$('#overlay').fadeOut();
		return false;
	});
	$(document).on('click', '.remove_hotel_cart_btn', function(e){
		e.preventDefault();
		total_hotel_booking_price = total_hotel_booking_price - parseInt( $(this).closest('.add_hotel_cart_summary').find('.hotel_booking_price').html(), 10 );
		update_tour_price();
		$(this).closest('.add_hotel_cart_summary').next().remove();//remove input hidden uid 
		$(this).closest('.add_hotel_cart_summary').remove();// remove hotel table
	});
	$('input[type="checkbox"]').click(function(){
            update_tour_price();
        });
	if ( $('input.date-pick').length ) {
				$('input.date-pick').datepicker({
					startDate: "today"
				});
				$('input[name="date"]').datepicker( 'setDate', 'today' );
				$('input[name="date_from"]').datepicker( 'setDate', '+1d' );
				$('input[name="date_to"]').datepicker( 'setDate', '+2d' );
			}
	$('.selected_date').text( $('input[name="date"]').datepicker('getDate').toDateString() );
	var daytmp = $('input[name="date"]').datepicker('getDate').getDay();
	if ( (daytmp == 6) || (daytmp == 0) ) {
		$('.fee-per-player').text(weekend_price);
		$('.total-cost').text('$' + weekend_price);
		$('input[name="total_price"]').val(weekend_price);
	} else {
		$('.fee-per-player').text(weekday_price);
		$('.total-cost').text('$' + weekday_price);
		$('input[name="total_price"]').val(weekday_price);
	}
	if ( $('input.time-pick').length ) {
		$('input.time-pick').timepicker({
			minuteStep: 15,
			showInpunts: false
		});
	}
	$('input#players').on('change', function(){
		$('.adults-number').html( $(this).val() );
		$('input#players_form_2').val( $(this).val() );
		update_tour_price();
	});
	
	$(document).on('click', '.hotel_class_btn', function(e){
		e.preventDefault();
		var hc = $(this).attr('data-hotel_class');
		var div = $(this).attr('href');
		var postid = '<?php echo $post_id; ?>';
		var e = $(div).attr('e');
		$('.hotel_class_btn').removeClass('active');
		$(this).addClass('active');
		$('.hotel_list_div').fadeOut();
		if ( e == '0') {
			$('#overlay').fadeIn();
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					action: "tnd_hotel_class_tab_ajax",
					hc,
					postid
				},
				success: function(response){
					$( div ).html(response);
					$('input[name="date_from"]').datepicker( 'setDate', 'today' );
					$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
					$('#overlay').fadeOut();
				}
			});
			$(div).attr('e', "1");
		}
		$( div ).fadeIn();
	});
});

function update_tour_price() { 
	var addservice = 0;
	var addservicesum = '';
	$('input[type=checkbox]').each(function () {
		if($(this).prop("checked") == true){
			addservice += parseInt( $(this).val() );
			addservicesum += ' + ' + $(this).attr("name_service") + ' $' + $(this).val() + '<br>';
		}
		$('input[name="add_service"]').val(addservicesum);
	});
	var day = $('input[name="date"]').datepicker('getDate').getDay();
	var adults = $('input#players').val();
	if ( (day == 6) || (day == 0) ) {
		var price = +( (adults * weekend_price ) * exchange_rate + addservice + total_hotel_booking_price).toFixed(2);
		$('.fee-per-player').html(weekend_price);
	} else {
		var price = +( (adults * weekday_price ) * exchange_rate + addservice + total_hotel_booking_price).toFixed(2);
		$('.fee-per-player').html(weekday_price);
	}

	var total_price = $('.total-cost').text().replace(/[\d\.\,]+/g, price);
	$('.total-cost').text( total_price );
	$('input[name="total_price"]').val(price);
}
</script>
<?php endwhile;
}
get_footer();
