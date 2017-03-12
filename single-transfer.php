<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$price = get_post_meta( $post_id, '_transfer_price', true );
		if ( empty( $price ) ) $price = 0;
		$pick_up = get_post_meta( $post_id, '_transfer_pick_up', true );
		//$header_img_scr = ct_get_header_image_src( $post_id );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
		$brief = get_post_meta( $post_id, '_transfer_brief', true );
		$booking_link = get_post_meta( $post_id, '_transfer_booking_link', true );
		$transfer_type = ct_get_add_services_by_postid( $post_id );
		$review_fields = array("Service", "Driver", "Vehicle", "Price");
				$review = get_post_meta( $post_id , '_review', true );
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
				$review_detail = get_post_meta( ct_hotel_org_id( $post_id ), '_review_detail', true );
				if ( ! empty( $review_detail ) ) {
					$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
				} else {
					$review_detail = array_fill( 0, count( $review_fields ), 0 );
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
									<?php ct_rating_smiles( $review ); ?>
								</span>
								<p><i>from </i><span style="font-size: 19px; color: #E04F67;"><?php echo ct_price( $price, "special" ) ?></span> /person </p>
								
							</div>
							<div class="col-md-8">
								<ul class="list_info" >
								<li><i class="icon_set_1_icon-26"></i><span class="info_label">Transportation:</span> <span><?php the_title() ?></span></li>
								<li><i class="icon_set_1_icon-52"></i><span class="info_label">Pick Up:</span><?php echo $pick_up; ?></li>
								<li><i class="icon_set_1_icon-18"></i><span class="info_label">Review:</span> <b class="text-danger"><?php echo esc_html( $doubled_review ) ?></b> /10 - <span class="text-success"><?php echo esc_html( $review_content ) ?></span> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></li>
								</ul>
								<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
							</div>
							<div class="hidden-xs" style="font-style: italic;">
								<?php echo $brief; ?>
							</div>
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
			<?php the_content(); ?>
			<?php if ( ! wp_is_mobile() ) : ?>
				<div class="row">
					<div class="col-md-2">
						<h3><?php echo esc_html__( 'Transfer Reviews', 'citytours') ?></h3>
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
								$per_page = 2;
								$review_count = ct_get_review_html($post_id, 0, $per_page);
							?>
						</div>
						<div class="margin_bottom_30">
							<?php if ( $review_count >= $per_page ) { ?>
								<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>"><?php echo esc_html__( 'LOAD MORE REVIEWS', 'citytours' ) ?></a> - Or -
							<?php } ?>
							 <a href="#" class="btn_1" data-toggle="modal" data-target="#myReview"><?php echo esc_html__( 'Leave a review', 'citytours') ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div><!--End  single_tour_desc-->
		<aside class="col-md-4">
		<?php	global $ct_options;
				if ( ! empty( $ct_options['transfer_thankyou_page'] ) ) :
		?>
		<div class="box_style_1 expose">
			<h3 class="inner">- Booking -</h3>
			<form method="get" id="booking-form" action="<?php echo ct_get_permalink_clang( $ct_options['transfer_thankyou_page'] ); ?>">
				<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<input type="hidden" name="action" value="tnd_transfer_submit_booking">
				<div class="form-group">
	            	<label><i class="icon_set_1_icon-26"></i>Vehicle</label>
	                <select id="transfer-type" class="form-control" name="transfer-type">
	                <?php foreach ( $transfer_type as $key=>$tmp ) : ?>
	                  <option data-value="<?php echo $key ?>" value="<?php echo esc_attr( $tmp->title ); ?>"><?php echo esc_attr( $tmp->title ); ?> </option>
	                 <?php endforeach ?> 
	                </select>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon_set_1_icon-53"></i> Select a date</label>
							<input class="date-pick form-control valid" data-date-format="mm/dd/yyyy" type="text" name="date_pick" id="date_pick">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon_set_1_icon-52"></i> Time</label>
							<input class="time-pick form-control" value="08:00 AM" type="text" name="time_pick">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Adults</label>
							<div class="numbers-row">
								<input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
							<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Children</label>
							<div class="numbers-row">
								<input type="text" value="0" id="children" class="qty2 form-control" name="children">
							<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
						</div>
					</div>
				</div>
				<table class="table table_summary">
					<tbody>
						<tr>
							<td>
								Adults
							</td>
							<td class="text-right adults-number">
								1
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
						
						<tr class="total">
							<td>
								Total cost
							</td>
							<td class="text-right total-cost">
								<span class="price-transfer">$<?php echo $transfer_type[0]->price; ?></span>
								<input type="hidden" name="total_price" class="total_price" value="<?php echo $transfer_type[0]->price; ?>">
							</td>
						</tr>
					</tbody>
				</table>
				<a class="btn_full_outline" href="#" data-toggle="modal" data-target="#inquiry">Book now</a>
				<div class="modal fade" id="inquiry" tabindex="-1" role="dialog" aria-labelledby="inquiryLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
								<h4 class="modal-title" id="myReviewLabel">Booking Transfer</h4>
							</div>
							<div class="modal-body">
								<?php tnd_tour_form_booking(); ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php endif; ?>
		<?php if ( ! wp_is_mobile() ) : ?>
			<?php if ( is_active_sidebar( 'sidebar-transfer' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-transfer' ); ?>
			<?php endif; ?>
		<?php endif; ?>
		</aside>
	</div><!--End row -->
	<?php if ( wp_is_mobile() ) : ?>
		<?php //tnd_render_mobile_end_page_menu(); ?>
	<?php endif; ?>
</div><!--End container -->
<?php if ( ! wp_is_mobile() ) : ?>
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title" id="myReviewLabel"><?php echo esc_html__( 'Write your review', 'citytours' ) ?></h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>" name="review" id="review-form">
					<?php wp_nonce_field( 'post-' . $post_id, '_wpnonce', false ); ?>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<input type="hidden" name="action" value="submit_review">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="booking_no" id="booking_no" type="text" placeholder="<?php echo esc_html__( 'Booking No', 'citytours' ) ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input name="pin_code" id="pin_code" type="text" placeholder="<?php echo esc_html__( 'Pin Code', 'citytours' ) ?>" class="form-control">
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
var array = [];
var i = 0;
<?php foreach ( $transfer_type as $key=>$tmp ) : ?>
array[<?php echo $key; ?>] = {transfer_name:"<?php echo esc_attr( $tmp->title ); ?>", price:"<?php echo esc_attr( $tmp->price );?>"};
<?php endforeach ?> 
$ = jQuery.noConflict();
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
	
	$('input.date-pick').datepicker({
		startDate: "today",
	});
	$('input.date-pick').datepicker( 'setDate', 'today' );
	$('input.time-pick').timepicker({
	    minuteStep: 15,
	    showInpunts: false
	})
	$('input#adults').on('change', function(){
		$('.adults-number').html( $(this).val());
	});
	$('input#children').on('change', function(){
		$('.children-number').html( $(this).val() );
	});
	$('#vehicle').val( $('#transfer-type').find('option:selected').attr('data-value') );
	$('select#transfer-type').on('change', function(){
		$('#vehicle').val( $('#transfer-type').find('option:selected').attr('data-value') );
		update_transfer_price();
	});
	
	function update_transfer_price() {
			var type = $('#transfer-type').find(':selected').data('value');
			var price_per_person = array[type].price;
			$('.price-transfer').html( "$" + price_per_person );
			$('.total_price').val( price_per_person );
		}
});	
</script>

<?php endwhile;
}
get_footer();