<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$address = get_post_meta( $post_id, '_hotel_address', true );
		$person_price = get_post_meta( $post_id, '_hotel_price', true );
		if ( empty( $person_price ) ) $person_price = 0;
		//$slider = get_post_meta( $post_id, '_hotel_slider', true );
		$star_rating = get_post_meta( $post_id, '_hotel_star', true );
		//$minimum_stay = get_post_meta( $post_id, '_hotel_minimum_stay', true );
		$checkin = get_post_meta( $post_id, '_hotel_checkin', true );
		$checkout = get_post_meta( $post_id, '_hotel_checkout', true );
		$hotel_popular = get_post_meta( $post_id, '_hotel_popular', true );
		$hotel_city = get_post_meta( $post_id, '_hotel_city', true );
		$hotel_brief = get_post_meta( $post_id, '_hotel_brief', true );
		$price_rates = get_post_meta( $post_id, '_hotel_price_rates', true );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
		if ($star_rating == 3) { 
			$hotel_type = "Superior Hotel";
		} elseif ( $star_rating == 4) {
			$hotel_type = "Deluxe Hotel";
		} elseif ( $star_rating == 5) {
			$hotel_type = "Luxury Hotel";
		}
		$related_ht = get_post_meta( $post_id, '_hotel_related' );
		$near_sight = get_post_meta( $post_id, '_hotel_near_sight' );
		$hotel_pos = get_post_meta( $post_id, '_hotel_loc', true );
		if ( ! empty( $hotel_pos ) ) { 
			$hotel_pos = explode( ',', $hotel_pos );
		}
		$args = array(
			'post_type' => 'room_type',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_room_hotel_id',
					'value' => array( $post_id )
				)
			),
			'suppress_filters' => 0,
		);
		$room_types = get_posts( $args );
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
					<div class="box_style_1 expose">
						<div class="row">
							<div class="col-md-4" style="text-align: center;">
								<?php echo get_the_post_thumbnail( $post_id, array(150,150), array( 'class' => 'img-circle', 'style' => 'margin: auto; display: block;' )); ?>
								<h1 style="font-size: 18px;"><?php the_title() ?></h1>
								<span class="rating" style="text-align: center; margin: auto; display: block; font-size: 14px;">
									<?php ct_rating_smiles( $star_rating, 'icon-star-empty', 'icon-star voted' ); ?>
								</span>
								<span class="rating" style="text-align: center; margin: auto; display: block; font-size: 14px;">
									<?php ct_rating_smiles( $review ); ?>
								</span>
								<i>from </i><span style="font-size: 19px; color: #E04F67;"><?php echo ct_price( $person_price, "special" ) ?></span> /night
							</div>
							<div class="col-md-8">
								<ul class="list_info" >
								<li><i class="icon_set_1_icon-6"></i><span class="info_label">Hotel Name:</span> <span><?php the_title() ?></span></li>
								<li><i class="icon_set_1_icon-81"></i><span class="info_label">Type:</span> <?php echo esc_html( $hotel_type, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-41"></i><span class="info_label">Location:</span> <?php echo esc_html( $hotel_city, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-48"></i><span class="info_label">Address:</span> <?php echo esc_html( $address, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-52"></i><span class="info_label">Time To Check In:</span> <?php echo esc_html( $checkin, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-52"></i><span class="info_label">Time To Check Out:</span> <?php echo esc_html( $checkout, 'citytours' ); ?></li>
								<li><i class="icon_set_1_icon-18"></i><span class="info_label">Review:</span> <b class="text-danger"><?php echo esc_html( $doubled_review ) ?></b> /10 - <span class="text-success"><?php echo esc_html( $review_content ) ?></span> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></li>
								</ul>
								<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
							</div>
							<div class="<?php if (! empty( $hotel_popular )) : echo "ribbon popular"; endif; ?>"></div> 
							<div style="font-style: italic;">
								<?php echo $hotel_brief; ?>
							</div>
						</div>
						
						
						<div class="<?php if (! empty( $hotel_po )) : echo "ribbon popular"; endif; ?>"></div>
					</div>
				</div>	
			</div>
			<div class="row">
				<?php if ( ! wp_is_mobile() ) : ?>
        			<?php if ( ! empty( $gallery_imgs ) ) : ?>
						<div class="carousel magnific-gallery" id="galery-post">
							<center>
							<?php foreach ( $gallery_imgs as $gallery_img ) {
								echo '<div class="col-md-2 col-sm-2 col-xs-4 gallery-image-nd"><div class="class="img_wrapper"><div class="img_container"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'tnd-post-galery', '', array( "class" => "img-responsive" ) ) . '</a></div></div></div>';
							} ?>
							</center>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<?php the_content(); ?>
				</div>
			</div>
			<hr>
			<?php if (! empty($price_rates)) : ?>
				<div class="row">
					<div class="col-md-2">
						<h3>Price Rates</h3>
					</div>
					<div class="col-md-10">
						<?php echo $price_rates ?>
					</div>
				</div>
	
				<hr>
			<?php endif; ?>	
			<div class="row">
				<div class="col-md-2">
					<h3>Rooms Types</h3>
				</div>
				<div class="col-md-10">
					<?php if ( ! empty( $room_types ) ) : ?>
						<?php 
						$is_first = true;
						foreach( $room_types as $post ) : setup_postdata( $post ); ?>
							<?php if ( $is_first ) { $is_first = false; } else { echo '<hr>'; } ?>
							<div class="row">
								<div class="col-md-2 col-xs-4 nopadding magnific-gallery">
									
									<a title="<?php the_title() ?>" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>">
									<?php 
										$room_type_id = get_the_ID();
										if ( has_post_thumbnail( $cabin_type_id ) ) {
											 echo get_the_post_thumbnail( $_post->ID, 'thumbnail', array( 'class' => 'styled img-responsive', 'style' => 'margin-top: 0px;'));
    										}
										?>
									</a>	
								</div>
								<div class="col-md-7 col-xs-8">
									<?php 
										
										$max_adults = get_post_meta( $room_type_id, '_room_max_adults' );
										$max_childs = get_post_meta( $room_type_id, '_room_max_kids' );
										$bed = get_post_meta( $room_type_id, '_room_bed' );
										$room_size = get_post_meta( $room_type_id, '_room_size' );
										$price = get_post_meta( $room_type_id, '_room_price' );
										?>
									
									<div style="margin: 0 0 20px 0;">
										<b><?php the_title() ?></b>
  												<table class="table">
      												<tbody>
      													
      													<tr>
      														<td><i class="icon_set_1_icon-70"></i>Adults: <b><?php foreach ( $max_adults as $item) : echo $item; endforeach; ?></b> </td>
      														<td><i class="icon_set_1_icon-29"></i>Childs: <b><?php foreach ( $max_childs as $item) : echo $item; endforeach; ?></b></td>
      													</tr>
      													<tr>
      														<td><i class="icon_set_2_icon-104"></i>Bed: <b><?php foreach ( $bed as $item) : echo $item; endforeach; ?></b></td>
      														<td><i class="icon_set_1_icon-11"></i>Size: <b><?php foreach ( $room_size as $item) : echo $item; endforeach; ?></b></td>
      													</tr>
      												</tbody>
  												</table>
									</div>
								</div>	
								<div class="col-md-3 col-xs-12 text-center">
									<b>Price Room /Night </b>
									<table class="table">
										<?php if ( !empty($price)) :?>
										<tr>
											<td><i class="icon_set_1_icon-51">From: <b class="text-price">$<?php foreach ( $price as $item) : echo $item; endforeach; ?></b></td>
										</tr>
										<?php endif; ?>
										<tr>
											<td><a href="#" data-toggle="modal" data-target="#booking-part">Book Now</a></td>
										</tr>
										</table>
								</div>
							</div>
							
							<?php wp_reset_postdata(); ?>
						<?php endforeach ?>
					<?php endif; ?>
				
				</div><!-- End col-md-9  -->
				
			</div><!-- End row  -->
			
			<hr>
			
			<?php /*
			<div class="row hidden-xs">
				<div class="col-md-2">
					<h3 style="font-size: 19px;"><?php echo esc_html__( 'Facilities', 'citytours') ?></h3>
				</div>
				<div class="col-md-10 nopadding">
					<?php
							require_once(get_template_directory() . '/inc/lib/tax-meta-class/Tax-meta-class.php');
							$hotel_facilities = get_the_terms( $post_id, 'hotel_facility' );
							if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
							foreach ( $hotel_facilities as $hotel_term ) :
								$term_id = $hotel_term->term_id;
								$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
								echo '<div class="the-icons col-md-4">';
								if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
								echo esc_html( $hotel_term->name );
								echo '</div>';
							endforeach; ?>
				</div>
			</div>
			
			<hr>
			
			
			<div class="row">
				<div class="col-md-2">
					<h3 style="font-size: 19px;"><?php echo esc_html__( 'Map', 'citytours') ?></h3>
				</div>
				<div class="col-md-10 nopadding">
					<div id="map-hotel">
					</div>
				</div>
			</div>

			<hr>
			*/ ?>
			<?php
			global $ct_options;
			if ( ! empty( $ct_options['hotel_review'] ) ) :
				
				$review_detail = get_post_meta( ct_hotel_org_id( $post_id ), '_review_detail', true );
				if ( ! empty( $review_detail ) ) {
					$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
				} else {
					$review_detail = array_fill( 0, count( $review_fields ), 0 );
				}
				?>
				<div class="row">
					<div class="col-md-2">
						<h3>Hotel Reviews</h3>
					</div>
					<div class="col-md-10">
						<div id="score_detail"><span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></div>
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
								$per_page = 4;
								$review_count = ct_get_review_html($post_id, 0, $per_page);
							?>
						</div>
						<div class="margin_bottom_30">
							<?php if ( $review_count >= $per_page ) { ?>
								<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>">LOAD MORE REVIEWS</a> - Or -
							<?php } ?> <a href="#" class="btn_1" data-toggle="modal" data-target="#myReview">Leave a review</a>
						</div>
					</div>
				</div>

			<?php  endif; ?>
            
		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">
		
		<div class="box_style_1 expose nopadding">
			<center>
				<img style="border-bottom: 1px solid #ddd;" class="img-responsive" src="//maps.googleapis.com/maps/api/staticmap?center=<?php echo $hotel_pos[0] . ',' . $hotel_pos[1]; ?>&amp;zoom=14&amp;size=400x200&amp;maptype=roadmap&amp;markers=color:red%7Clabel:H%7C<?php echo $hotel_pos[0] . ',' . $hotel_pos[1]; ?><?php if ( ! empty( $near_sight ) ) { foreach ( $near_sight as $each_sight ) { $sight_pos = get_post_meta( $each_sight, '_hanoi_sight_loc', true ); $sight_pos = explode( ',', $sight_pos ); echo '&amp;markers=color:yellow%7Clabel:S%7C' . $sight_pos[0] . ',' . $sight_pos[1]; } } ?>" alt="">
			</center>
			<h5 class="text-center"><a class="" href="http://maps.google.com/maps?daddr=<?php echo $hotel_pos[0] . ',' . $hotel_pos[1]; ?>" rel="nofollow" target="_blank"> - <U>Get directions</U> - </a></h5>
			<div class="text-center"><?php echo $address ?></div>

			<div style="padding: 10px; border-top: 1px solid #ddd;">
				<?php if ( ! empty( $near_sight ) ) : ?>
					<center> - <u>Nearby Sightseeings</u> - </center>
					<div class="other_tours">
						<ul>
							<?php foreach ( $near_sight as $each_sight ) {
		            				echo '<li><div>';
									echo '<a href="' . get_permalink( $each_sight ) . '" target="_blank"">';
									//echo '<figure>' . get_the_post_thumbnail($each_sight, 'tnd-list-thumb', array('class' => 'img-responsive') ) . '</figure>';
									echo '<i class="icon_set_1_icon-61"></i>';
									echo get_the_title($each_sight);
									echo '</a>'; 
									echo '</div></li>'; 
		            				}		
							?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<hr>
		
		<div class="box_style_1 expose">
			<h3 class="inner">Check Availability</h3>
			<?php if ( ct_get_hotel_cart_page() ) : ?>
			<form method="get" id="booking-form-modal" action="<?php echo esc_url( ct_get_hotel_cart_page() ); ?>" target="_blank">
				<input type="hidden" name="hotel_id" value="<?php echo esc_attr( $post_id ) ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i>Check in</label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						 <div class="form-group">
							<label><i class="icon-calendar-7"></i>Check out</label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
						</div>
					</div>
				</div>	
				<br>
				<button type="submit" class="btn_full book-now">Check now</button>
			</form>
			<?php else : ?>
				<?php echo wp_kses_post( sprintf( __( 'Please set hotel booking page on <a href="%s">Theme Options</a>/Hotel Main Settings', 'citytours' ), esc_url( admin_url( 'themes.php?page=CityTours' ) ) ) ); ?>
			<?php endif; ?>
		</div><!--/box_style_1 -->
		<hr>
	
		<?php //if ( ! empty( $ct_options['hotel_end_section'] ) ) : ?>
			<?php //echo do_shortcode( $ct_options['hotel_end_section'] ); ?>
		<?php //endif; ?>
		
		<?php if ( is_active_sidebar( 'sidebar-hotel' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-hotel' ); ?>
		<?php endif; ?>

		</aside>
	</div><!--End row -->
	
</div><!--End container -->
<?php if ( ! empty( $ct_options['hotel_review'] ) ) : ?>
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title" id="myReviewLabel">Write your review</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>" name="review" id="review-form">
					<?php wp_nonce_field( 'post-' . $post_id, '_wpnonce', false ); ?>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<input type="hidden" name="action" value="submit_review">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="booking_no" id="booking_no" type="text" placeholder="Booking No" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input name="pin_code" id="pin_code" type="text" placeholder="Pin Code" class="form-control">
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
										<option value="0">Please review</option>
										<option value="1">Low</option>
										<option value="2">Sufficient</option>
										<option value="3">Good</option>
										<option value="4">Excellent</option>
										<option value="5">Super</option>
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
<div class="modal fade" id="booking-part" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title">Check Availability</h4>
			</div>
			<div class="modal-body">
				<form method="get" id="booking-form" action="<?php echo esc_url( ct_get_hotel_cart_page() ); ?>" target="_blank">
				<input type="hidden" name="hotel_id" value="<?php echo esc_attr( $post_id ) ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i>Check in</label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						 <div class="form-group">
							<label><i class="icon-calendar-7"></i>Check out</label>
							<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
						</div>
					</div>
				</div>
				<br>
				<button type="submit" class="btn_full book-now">Check now</button>
			</form>
			</div>
		</div>
	</div>
</div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=287004874991108";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>
$ = jQuery.noConflict();

$(document).ready(function(){
	
	var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';
	$('input.date-pick').datepicker({
		startDate: "today"
	});
	$('input[name="date_from"]').datepicker( 'setDate', 'today' );
	$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
	$('#booking-form').submit(function(){
		var minimum_stay = 0;
		<?php //if ( ! empty( $minimum_stay ) ) { echo 'minimum_stay=' . $minimum_stay .';'; } ?>
		var date_from = $('input[name="date_from"]').datepicker('getDate').getTime();
		var date_to = $('input[name="date_to"]').datepicker('getDate').getTime();
		var one_day = 1000*60*60*24;
		if ( date_from + one_day * minimum_stay > date_to ) {
			alert( "Minimum stay for this hotel is nights. Have another look at your dates and try again." );
			return false;
		}
	});
	
	
});
</script>
<?php endwhile;
}
get_footer();