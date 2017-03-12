<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();

		//init variables
		$post_id = get_the_ID();
		$terms = get_the_terms( $post_id, 'tour_type' );
		if ( $terms && ! is_wp_error( $terms ) )  {
				    foreach ( $terms as $term ) {
				        $tour_type = $term->name;
				        $tour_type_id = $term->term_id;
				    }
				}
		$similar_tours = ct_tour_get_special_tours('latest', '12', array($post_id), array($tour_type_id) );
		
		$loai_tour = get_post_meta( $post_id, '_tour_loai', true );
		$person_price = get_post_meta( $post_id, '_tour_price', true );
		if ( empty( $person_price ) ) $person_price = 0;
		//$charge_child = get_post_meta( $post_id, '_tour_charge_child', true );
		$child_price = get_post_meta( $post_id, '_tour_price_child', true );
		$price_adult_superior = get_post_meta( $post_id, '_tour_price_adult_superior', true );
		$price_child_superior = get_post_meta( $post_id, '_tour_price_child_superior', true );
		$price_adult_superior_plus = get_post_meta( $post_id, '_tour_price_adult_superior_plus', true );
		$price_child_superior_plus = get_post_meta( $post_id, '_tour_price_child_superior_plus', true );
		$price_adult_deluxe = get_post_meta( $post_id, '_tour_price_adult_deluxe', true );
		$price_child_deluxe = get_post_meta( $post_id, '_tour_price_child_deluxe', true );
		$price_rates = get_post_meta( $post_id, '_tour_price_rates', true );
		
		$tour_brief = get_post_meta( $post_id, '_tour_brief', true );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
		$tour_popular = get_post_meta( $post_id, '_tour_popular', true );
		$tour_duration = get_post_meta( $post_id, '_tour_duration', true );
		$tour_departure = get_post_meta( $post_id, '_tour_departure', true );
		$address = get_post_meta( $post_id, '_tour_address', true );
		
		$review = get_post_meta( $post_id, '_review', true );
		$review = ( ! empty( $review ) )?round( $review, 1 ):0;
		//$hotel_in_tour = get_post_meta( $post_id, '_tour_hotel_in_tour', true);
		
		//$itinerary = get_post_meta( $post_id, '_tour_itinerary', true );
		$price_note = get_post_meta( $post_id, '_tour_price_note', true );
		$accomodation_3 = get_post_meta( $post_id, '_tour_accommodation_3_hotel' );
		
		$review_fields = ! empty( $ct_options['hotel_review_fields'] ) ? explode( ",", $ct_options['hotel_review_fields'] ) : array("Position", "Comfort", "Price", "Quality");
			$review = get_post_meta( ct_hotel_org_id( $post_id ), '_review', true );
			// $review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
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
		?>
		<div id="position" class="blank-parallax">
			<div class="container"><?php ct_breadcrumbs(); ?></div>
		</div><!-- End Position -->

<div class="container margin_top_30">
	<div class="row">
		<div class="col-md-8" id="single_tour_desc">
			<div class="row">
				<div class="col-md-12">
					<div class="box_style_1 expose" >
					<div class="row">
						<div class="col-md-4" style="text-align: center;">
							<?php echo get_the_post_thumbnail( $post_id, array(150,150), array( 'class' => 'img-circle', 'style' => 'margin: auto; display: block;' )); ?>
							<h1 style="font-size: 18px;"><?php the_title() ?></h1>
							<span class="rating" style="text-align: center; margin: auto; display: block; font-size: 14px;">
								<?php ct_rating_smiles( $review ); ?>
							</span>
							<p><i>from </i><span style="font-size: 19px; color: #E04F67;"><?php echo ct_price( $person_price, "special" ) ?></span> /person </p>
						</div>
						<div class="col-md-8">
							<ul class="list_info" >
							<li><i class="icon_set_1_icon-30"></i><span class="info_label">Tour Name:</span> <span><?php the_title() ?></span></li>
							<li><i class="icon_set_1_icon-81"></i><span class="info_label">Type:</span> <?php echo $tour_type; ?></li>
							<li><i class="icon_set_1_icon-37"></i><span class="info_label">Locations:</span> <?php echo esc_html( $address, 'citytours' ); ?></li>
							<li><i class="icon_set_1_icon-52"></i><span class="info_label">Duration:</span> <?php echo esc_html( $tour_duration, 'citytours' ); ?></li>
							<li><i class="icon_set_1_icon-53"></i><span class="info_label">Departure:</span> <?php echo esc_html( $tour_departure, 'citytours' ); ?></li>
							<li><i class="icon_set_1_icon-18"></i><span class="info_label">Review:</span> <b class="text-danger"><?php echo esc_html( $doubled_review ) ?></b> /10 - <span class="text-success"><?php echo esc_html( $review_content ) ?></span> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></li>
							</ul>
							<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
							<div style="font-style: italic;">
							<?php echo $tour_brief; ?>
						</div>
						</div>
						<div class="<?php if (! empty( $tour_popular )) : echo "ribbon popular"; endif; ?>"></div>
						
					</div>
				</div>
				</div>
			</div>
			<div class="row">
				<?php if ( ! wp_is_mobile() ) : ?>
        			<?php if ( ! empty( $gallery_imgs ) ) : ?>
						<div class="carousel magnific-gallery" id="galery-post">
							<center>
							<?php foreach ( $gallery_imgs as $gallery_img ) {
								echo '<div class="col-md-2 col-sm-2 col-xs-4 gallery-image-nd"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'tnd-post-galery', '', array( "class" => "img-responsive" ) ) . '</a></div>';
							} ?>
							</center>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12"  id="tour_overview">
					<?php if ( $loai_tour == 1 ) : ?>
						<?php if ( ! wp_is_mobile() ) : ?>
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-md-4"><a href="#itinerary_overview" class="btn_1 outline btn_full active btn_itinerary">Tour Overview</a></div>
								<div class="col-md-4"><a href="#itinerary_detail" class="btn_1 outline btn_full btn_itinerary">Itinerary in Details</a></div>
								<div class="col-md-4"><a href="#" class="btn_1 outline btn_full">Download Itinerary</a></div>
							</div>
							<div id="itinerary_overview" class="itinerary" e="1">
								<?php the_content(); ?>
							</div>
							<div id="itinerary_detail" class="itinerary" e="0">
								
							</div>
						<?php else : ?>
							<?php echo get_post_meta( $post_id, '_tour_itinerary', true ); ?>
						<?php endif; ?>
						<hr>
					<?php elseif ( $loai_tour == 0 ) : ?>
						<?php echo get_post_meta( $post_id, '_tour_itinerary', true ); ?>
					<?php endif; ?>
					
					<?php if (! empty($price_rates)) : ?>
						<div class="row">
							<div class="col-md-2">
								<h3>Price Rates </h3>
							</div>
							<div class="col-md-10">
								<?php echo $price_rates ?>
							</div>
						</div>
					<?php endif; ?>
					
					<hr>
					<?php if (  ! empty( $price_note ) ) : ?>
							<div class="">
								<?php echo do_shortcode( $price_note ); ?>
							</div>	
					<?php endif; ?>
				</div>
			</div>
			
			<hr>
			
			<?php if (! empty($accomodation_3)) : ?>
			<div class="row">
				<div class="col-md-2">
					<h3>Hotels in Tour </h3>
				</div>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-4">
							<a href="#hotel-tab-1" class="btn_1 outline btn_full hotel_class_btn active" data-hotel_class="_tour_accommodation_3_hotel" >Superior</i></a>
						</div>
						<div class="col-md-4">
							<a href="#hotel-tab-2" class="btn_1 outline btn_full hotel_class_btn" data-hotel_class="_tour_accommodation_3plus_hotel" >Superior +</a>
						</div>
						<div class="col-md-4">
							<a href="#hotel-tab-3" class="btn_1 outline btn_full hotel_class_btn" data-hotel_class="_tour_accommodation_4_hotel" >Deluxe</a>
						</div>
					</div>
					<br>
					<div class="row">	
						<div id="hotel-tab-1" class="hotel_list_div" e="1">
						<?php tnd_render_accomodation_tour($accomodation_3); ?>
						</div>
						<div id="hotel-tab-2" class="hotel_list_div" e="0">		
						</div>
						<div id="hotel-tab-3" class="hotel_list_div" e="0">		
						</div>
					</div>
					<br>
				</div>
					
			</div>

			<hr>
			<?php endif; ?>
			
			<?php if ( ! wp_is_mobile() ) : ?>
				<?php
				global $ct_options;
				if ( ! empty( $ct_options['tour_review'] ) ) :
					$review_fields = ! empty( $ct_options['tour_review_fields'] ) ? explode( ",", $ct_options['tour_review_fields'] ) : array("Position", "Comfort", "Price", "Quality");
					$review = get_post_meta( ct_tour_org_id( $post_id ), '_review', true );
					$review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
					$review_detail = get_post_meta( ct_tour_org_id( $post_id ), '_review_detail', true );
					if ( ! empty( $review_detail ) ) {
						$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
					} else {
						$review_detail = array_fill( 0, count( $review_fields ), 0 );
					}
					?>
					<div class="row">
						<div class="col-md-2">
							<h3>Tour Reviews </h3>
						</div>
						<div class="col-md-10">
							<div id="score_detail">
								<span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small>
	
							</div>
							<div class="row" id="rating_summary">
								<div class="col-md-6">
									<ul>
										<?php for ( $i = 0; $i < ( count( $review_fields ) / 2 ); $i++ ) { ?>
										<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
											<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="col-md-6">
									<ul>
										<?php for ( $i = $i; $i < count( $review_fields ); $i++ ) { ?>
										<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
											<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div><!-- End row -->
							<hr>
							<div class="guest-reviews">
								<?php
									$per_page = 1;
									$review_count = ct_get_review_html($post_id, 0, $per_page);
								?>
							</div>
							<div class="margin_bottom_30">
								<?php if ( $review_count >= $per_page ) { ?>
									<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>"> LOAD MORE REVIEWS </a> - Or -
								<?php } ?>
								 <a href="#" class="btn_1" data-toggle="modal" data-target="#myReview">Leave a review </a>
							</div>
						</div>
					</div>
				
				<?php  endif; ?>
				<hr>
				<div class="row">
					<div class="col-md-2">
						<h3>Similar Tours </h3>
					</div>
					<div class="col-md-10">
						<?php
							echo '<div class="list_tours_tabs"><ul>';
							foreach ( $similar_tours as $similar_tour ) {
								$similar_tour_id = $similar_tour->ID;
								$price = get_post_meta( $similar_tour_id, '_tour_price', true );
								echo '<li><div><a href="' . esc_url( get_permalink( $similar_tour_id ) ) . '"><figure>' . get_the_post_thumbnail( $similar_tour_id, 'tnd-list-thumb', array( 'class' => 'img-rounded')) . '</figure><h5>' . get_the_title( $similar_tour_id ) . '</h5>';
								echo '</span>';
								echo '<a href="' . get_term_link($term) .'" target="_blank"><small>' . $tour_type . '</small></a>';
								echo '<small class="pull-right">- From <b>$' . $price . '</b>/person</small>';	
								echo '</a></div></li>';
							}
							echo '</ul></div>';
						?>
					</div>
						
				</div>
			<?php endif; ?>
		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">

		<div class="box_style_1 expose">
			<h3 class="inner">-  Booking  -</h3>
			<form method="get" id="booking-form" action="<?php echo esc_url( ct_get_tour_thankyou_page() ); ?>">
				<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ) ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> Select a date </label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
						</div>
					</div>
				<?php if ( $loai_tour == 1 ) : ?>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-list-3"></i> Tour Package </label>
							<select class="form-control" name="type" id="type">
								<option value="Superior">Superior</option>
								<option value="Superior Plus">Superior +</option>
								<option value="Deluxe">Deluxe</option>
							</select>
						</div>
					</div>
				<?php endif; ?>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-adult"></i> Adults </label>
							<div class="numbers-row" data-min="2" >
								<input type="text" value="2" id="adults" class="qty2 form-control" name="adults">
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-child"></i> Children</label>
							<div class="numbers-row" data-min="0">
								<input type="text" value="0" id="children" class="qty2 form-control" name="kids">
							</div>
						</div>
					</div>
				</div>
				<br>
				<table class="table table_summary">
				<tbody>
				<tr>
					<td>
						 Tour Name 
					</td>
					<td class="text-right">
						<?php echo get_the_title(); ?>
					</td>
				</tr>	
				<?php if ( $loai_tour == 1 ) : ?>
					<tr>
						<td>
							 Tour Package 
						</td>
						<td class="text-right tour-package">
							Superior
						</td>
					</tr>
				<?php endif; ?>	
				<tr>
					<td>
						 Adults 
					</td>
					<td class="text-right adults-number">
						2
					</td>
				</tr>
				<tr>
					<td>	
						 Children
					</td>
					<td class="text-right children-number">
						0
					</td>
				</tr>
				
				<tr>
					<td>
						 Price Per Adult 
					</td>
					<td class="text-right">
						<span class="price-per-person">
							<?php if ( $loai_tour == 0) : ?>
								<?php echo ct_price( $person_price ) ?>
							<?php elseif ( $loai_tour == 1 ) : ?>	
								<?php echo ct_price( $price_adult_superior ) ; ?>
							<?php endif; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						 Price Per Child 
					</td>
					<td class="text-right">
						<span class="price-per-child">
							<?php if ( $loai_tour == 0) : ?>
									<?php echo ct_price( $child_price ) ?>
								<?php elseif ( $loai_tour == 1 ) : ?>	
									<?php echo ct_price( $price_child_superior ) ?>
							<?php endif; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						 Total amount 
					</td>
					<td class="text-right">
						<span class="adults-number">2</span> x 
						<span class="price-per-person">
							<?php if ( $loai_tour == 0) : ?>
								<?php echo ct_price( $person_price ) ?>
							<?php elseif ( $loai_tour == 1 ) : ?>	
								<?php echo ct_price( $price_adult_superior ) ; ?>
							<?php endif; ?>
						</span>
						<?php if ( $loai_tour == 0) : ?>
							<span class="child-amount hide"> + <span class="children-number">0</span> x <?php echo ct_price( $child_price ) ?></span>
						<?php elseif ( $loai_tour == 1) : ?>	
							<span class="child-amount hide"> + <span class="children-number">0</span> x <span class="price-per-child"><?php echo ct_price( $price_child_superior ) ?></span></span>
						<?php endif; ?>
					</td>
				</tr>
				<tr class="total">
					<td>
						 Total cost 
					</td>
					<td class="text-right total-cost">
						<?php if ( $loai_tour == 0) : ?>
								<?php echo ct_price( 2*$person_price ) ?>
							<?php elseif ( $loai_tour == 1 ) : ?>	
								<?php echo ct_price( 2*$price_adult_superior ) ; ?>
						<?php endif; ?>
					</td>
					<input type="hidden" name="total_price" value="<?php if ( $loai_tour == 0) {echo 2*$person_price ;} elseif ( $loai_tour == 1 ) {echo 2*$price_adult_superior ;}?>">
					<input type="hidden" name="action" value="tnd_tour_submit_booking">
				</tr>
				</tbody>
				</table>
				<a class="btn_full_outline" href="#" data-toggle="modal" data-target="#inquiry">Book now</a>
				<div class="modal fade" id="inquiry" tabindex="-1" role="dialog" aria-labelledby="inquiryLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
								<h4 class="modal-title" id="myReviewLabel">Booking Tour</h4>
							</div>
							<div class="modal-body">
								<?php tnd_tour_form_booking(); ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div><!--/box_style_1 -->
		<?php if ( ! wp_is_mobile() ) : ?>
			<?php if ( is_active_sidebar( 'sidebar-tour' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-tour' ); ?>
			<?php endif; ?>
		<?php endif; ?>
		</aside>
	</div><!--End row -->
</div><!--End container -->
<?php if ( ! empty( $ct_options['tour_review'] ) ) : ?>
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title" id="myReviewLabel"> Write your review </h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>" name="review" id="review-form">
					<?php wp_nonce_field( 'post-' . $post_id, '_wpnonce', false ); ?>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<input type="hidden" name="action" value="submit_review">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="booking_no" id="booking_no" type="text" placeholder=" Booking No " class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input name="pin_code" id="pin_code" type="text" placeholder=" Pin Code " class="form-control">
							</div>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<div class="row">
						<?php for ( $i = 0; $i < ( count( $review_fields ) ); $i++ ) { ?>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?></label>
									<select class="form-control" name="review_rating_detail[<?php echo esc_attr( $i ) ?>]">
										<option value="0"><?php esc_html_e( "Please review", 'citytours' ); ?></option>
										<option value="1"><?php esc_html_e( "Low", 'citytours' ); ?></option>
										<option value="2"><?php esc_html_e( "Sufficient", 'citytours' ); ?></option>
										<option value="3"><?php esc_html_e( "Good", 'citytours' ); ?></option>
										<option value="4"><?php esc_html_e( "Excellent", 'citytours' ); ?></option>
										<option value="5"><?php esc_html_e( "Super", 'citytours' ); ?></option>
									</select>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- End row -->
					<div class="form-group">
						<textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="<?php esc_html_e( "Write your review", 'citytours' ); ?>"></textarea>
					</div>
					<input type="submit" value="Submit" class="btn_1" id="submit-review">
				</form>
				<div id="message-review" class="alert alert-warning">
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=287004874991108";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
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
	});
</script>
<?php if ( $loai_tour == 0) : ?>
	<script>
		$ = jQuery.noConflict();
		var price_per_person = 0;
		var price_per_child = 0;
		var exchange_rate = 1;
		
		<?php if ( ! empty( $person_price ) ) : ?>
			price_per_person = <?php echo esc_js( $person_price ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $child_price ) ) : ?>
			price_per_child = <?php echo esc_js( $child_price ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $_SESSION['exchange_rate'] ) ) : ?>
			exchange_rate = <?php echo esc_js( $_SESSION['exchange_rate'] ); ?>;
		<?php endif; ?>
		
		$(document).ready(function(){
			$('#btn_notes').click(function(){
				$('#notes').toggleClass('hidden');
			});
			if ( $('input.date-pick').length ) {
				$('input.date-pick').datepicker({
					startDate: "today"
				});
				$('input[name="date"]').datepicker( 'setDate', 'today' );
			}
			if ( $('input.time-pick').length ) {
				$('input.time-pick').timepicker({
					minuteStep: 15,
					showInpunts: false
				});
			}
			$('input#adults').on('change', function(){
				$('.adults-number').html( $(this).val() );
				update_tour_price();
			});
			$('input#children').on('change', function(){
				$('.children-number').html( $(this).val() );
				update_tour_price();
			});
			
			$('.iti-detail').hide();
			$('.btn-iti').on('click', function() {
			    $(this).parent().next("div").toggle();
			})
			var validation_rules = {};
			if ( $('input.date-pick').length ) {
				validation_rules.date = { required: true};
			}
			//validation form
			$('#booking-form').validate({
				rules: validation_rules
			});
		});
		
		function update_tour_price() {
			var adults = $('input#adults').val();
			var children = 0;
			if ( $('input#children').length ) {
				children = $('input#children').val();
			}
			var price = +( (adults * price_per_person + children * price_per_child) * exchange_rate ).toFixed(2);
			$('.child-amount').toggleClass( 'hide', children < 1 );
			var total_price = $('.total-cost').text().replace(/[\d\.\,]+/g, price);
			$('.total-cost').text( total_price );
			$('input[name$="total_price"]').val(price);
		}
	</script>
<?php elseif ( $loai_tour == 1 ) : ?> 
	<script>
		$ = jQuery.noConflict();
		var price_per_person = 0;
		var price_per_child = 0;
		var exchange_rate = 1;
		var pa1 = 0;
		var pc1 = 0;
		var pa2 = 0;
		var pc2 = 0;
		var pa3 = 0;
		var pc3 = 0;
		<?php if ( ! empty( $price_adult_superior ) ) : ?>
			pa1 = <?php echo esc_js( $price_adult_superior ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $price_child_superior ) ) : ?>
			pc1 = <?php echo esc_js( $price_child_superior ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $price_adult_superior_plus ) ) : ?>
			pa2 = <?php echo esc_js( $price_adult_superior_plus ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $price_child_superior_plus ) ) : ?>
			pc2 = <?php echo esc_js( $price_child_superior_plus ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $price_adult_deluxe ) ) : ?>
			pa3 = <?php echo esc_js( $price_adult_deluxe ); ?>;
		<?php endif; ?>
		<?php if ( ! empty( $price_child_deluxe ) ) : ?>
			pc3 = <?php echo esc_js( $price_child_deluxe ); ?>;
		<?php endif; ?>
		
		<?php if ( ! empty( $_SESSION['exchange_rate'] ) ) : ?>
			exchange_rate = <?php echo esc_js( $_SESSION['exchange_rate'] ); ?>;
		<?php endif; ?>
		
		$(document).ready(function(){
			if ( $('input.date-pick').length ) {
				$('input.date-pick').datepicker({
					startDate: "today"
				});
				$('input[name="date"]').datepicker( 'setDate', 'today' );
			}
			$('.btn-iti').parent().next("div").hide();
			$(document).on('click', '.btn-iti', function(e){
				$(this).parent().next("div").toggle();
			});
			$('input#adults').on('change', function(){
				$('.adults-number').html( $(this).val());
				update_tour_price();
			});
			$('input#children').on('change', function(){
				$('.children-number').html( $(this).val() );
				update_tour_price();
			});
			$('select#type').on('change', function(){
				$('.tour-package').html( $(this).val());
				update_tour_price();
			});
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
						action: "tnd_tour_accomodation_class_tab_ajax",
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
		
		$(document).on('click', '.btn_itinerary', function(e){
			e.preventDefault();
			var div = $(this).attr('href');
			var postid = '<?php echo $post_id; ?>';
			var e = $(div).attr('e');
			$('.btn_itinerary').removeClass('active');
			$(this).addClass('active');
			$('.itinerary').fadeOut();
			if ( e == '0') {
				$('#overlay').fadeIn();
				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						action: "tnd_get_tour_itinerary_detail_ajax",
						postid
					},
					success: function(response){
						$( div ).html(response);
						$('#overlay').fadeOut();
					}
				});
				$(div).attr('e', "1");
			}
			$( div ).fadeIn();
		});
		function update_tour_price() {
			var adults = $('input#adults').val();
			var children = 0;
			if ( $('input#children').length ) {
				children = $('input#children').val();
			}
			var t = $('select#type').val();
				if (t == 'Superior') {
					price_per_person = pa1;
					price_per_child = pc1;
				} else if (t == 'Superior Plus') {
					price_per_person = pa2;
					price_per_child = pc2;
				} else if (t == 'Deluxe') {
					price_per_person = pa3;
					price_per_child = pc3;
				}
				var price = +( (adults * price_per_person + children * price_per_child) * exchange_rate ).toFixed(2);
				$('.price-per-person').html( "$" + price_per_person );
				$('.price-per-child').html( "$" + price_per_child );
			$('.child-amount').toggleClass( 'hide', children < 1 );
			var total_price = $('.total-cost').text().replace(/[\d\.\,]+/g, price);
			$('.total-cost').text( total_price );
			$('input[name$="total_price"]').val(price);
		}
	</script>
<?php endif; ?>
<?php endwhile;
}
get_footer();