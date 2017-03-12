<?php

// validation
$required_params = array( 'uid' );
foreach ( $required_params as $param ) {
	if ( ! isset( $_REQUEST[ $param ] ) ) {
		do_action( 'ct_tour_booking_wrong_data' ); // ct_redirect_home() - if data is not valid return to home
		exit;
	}
}

// init variables
$uid = $_REQUEST['uid'];
if ( ! CT_Hotel_Cart::get( $uid ) ) {
	do_action( 'ct_tour_booking_wrong_data' ); // ct_redirect_home() - if data is not valid return to home
	exit;
}

$cart = new CT_Hotel_Cart();
$tour_id = $cart->get_field( $uid, 'tour_id' );
$loai_tour = get_post_meta( $tour_id, '_tour_loai', true );
$date = $cart->get_field( $uid, 'date' );
$cart_tour = $cart->get_field( $uid, 'tour' );
$adults = $cart_tour['adults'];
$kids = $cart_tour['kids'];
$infants = $cart_tour['infants'];
$type = $cart->get_field( $uid, 'tour_type' );
$hotels = $cart_tour['hotels'];
$hotels_array = explode(",", $hotels);
$cart_service = $cart->get_field( $uid, 'add_service' );
$user_info = ct_get_current_user_info();
$_countries = ct_get_all_countries();
$deposit_rate = get_post_meta( $tour_id, '_tour_security_deposit', true );
$deposit_rate = empty( $deposit_rate ) ? 0 : $deposit_rate;
$duration = get_post_meta( $tour_id, '_tour_duration', true );
$link = get_the_permalink($tour_id);
// function
if ( ! ct_get_tour_thankyou_page() ) { ?>
	<h5 class="alert alert-warning"><?php echo esc_html__( 'Please set booking confirmation page in theme options panel.', 'citytours' ) ?></h5>
<?php } else { ?>

	<form id="booking-form" action="<?php echo esc_url( ct_get_tour_thankyou_page() ); ?>">
		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'tour_checkout_main_before' ); ?>
				<div class="form_title">
					<h3><strong>1</strong><?php echo esc_html__( 'Your Details', 'citytours' ) ?></h3>
					<p><?php echo esc_html__( 'Please fill your detail.', 'citytours' ) ?></p>
				</div>
				<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'First name', 'citytours' ) ?></label>
								<input type="text" class="form-control" name="first_name" value="<?php echo esc_attr( $user_info['first_name'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Last name', 'citytours' ) ?></label>
								<input type="text" class="form-control" name="last_name" value="<?php echo esc_attr( $user_info['last_name'] ) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Email', 'citytours' ) ?></label>
								<input type="email" name="email" class="form-control" value="<?php echo esc_attr( $user_info['email'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Confirm email', 'citytours' ) ?></label>
								<input type="email" name="email2" class="form-control">
							</div>
						</div>
					</div>
					 <div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Telephone', 'citytours' ) ?></label>
								<input type="text" name="phone" class="form-control" value="<?php echo esc_attr( $user_info['phone'] ) ?>">
							</div>
						</div>
					</div>
				</div><!--End step -->

				<div class="form_title">
					<h3><strong>2</strong><?php echo esc_html__( 'Your Address', 'citytours' ) ?></h3>
					<p><?php echo esc_html__( 'Please write your address detail', 'citytours' ) ?></p>
				</div>
				<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Country', 'citytours' ) ?></label>
								<select class="form-control" name="country" id="country">
									<option value="" selected><?php echo esc_html__( 'Select your country', 'citytours' ) ?></option>
									<?php foreach ( $_countries as $_country ) { ?>
										<option value="<?php echo esc_attr( $_country['code'] ) ?>" <?php selected( $user_info['country_code'], $_country['code'] ); ?>><?php echo esc_html( $_country['name'] ) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Street line 1', 'citytours' ) ?></label>
								<input type="text" name="address1" class="form-control" value="<?php echo esc_attr( $user_info['address1'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Street line 2', 'citytours' ) ?></label>
								<input type="text" name="address2" class="form-control" value="<?php echo esc_attr( $user_info['address2'] ) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'City', 'citytours' ) ?></label>
								<input type="text" name="city" class="form-control" value="<?php echo esc_attr( $user_info['city'] ) ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo esc_html__( 'State', 'citytours' ) ?></label>
								<input type="text" name="state" class="form-control" value="<?php echo esc_attr( $user_info['state'] ) ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo esc_html__( 'Postal code', 'citytours' ) ?></label>
								<input type="text" name="zip" class="form-control" value="<?php echo esc_attr( $user_info['zip'] ) ?>">
							</div>
						</div>
					</div><!--End row -->
				</div><!--End step -->
				<div id="policy">

					<?php global $ct_options;
					if ( ! empty( $ct_options['tour_terms_page'] ) ) : ?>
						<h4><?php echo esc_html__( 'Cancellation policy', 'citytours' ) ?></h4>
						<div class="form-group">
							<label><input name="agree" value="agree" type="checkbox" checked><?php printf( __('By continuing, you agree to the <a href="%s" target="_blank"><span class="skin-color">Terms and Conditions</span></a>.', 'citytours' ), ct_get_permalink_clang( $ct_options['tour_terms_page'] ) ) ?></label>
						</div>
					<?php endif; ?>
					<button type="submit" class="btn_1 green medium book-now-btn book-now-btn1"><?php echo esc_html__( 'Book now', 'citytours' ) ?></button>
				</div>
				<?php do_action( 'tour_checkout_main_after' ); ?>
			</div>
			<aside class="col-md-4">
				<?php do_action( 'tour_checkout_sidebar_before' ); ?>
				<div class="box_style_1">
					<h3 class="inner"><?php echo esc_html__( '- Summary -', 'citytours' ) ?></h3>
					<table class="table table_summary">
					<tbody>
						<tr>
							<td><?php echo esc_html__( 'Tour', 'citytours' ) ?></td>
							<td class="text-right"><a href="<?php echo $link; ?>" target="_blank"><?php echo esc_html( get_the_title( $tour_id ) ); ?></a></td>
						</tr>
						<?php if ( ! empty( $type ) ) : ?>
						<tr>
							<td><?php echo esc_html__( 'Tour Type', 'citytours' ) ?></td>
							<td class="text-right"><?php if ($type == 1)  echo esc_html( 'Group Tour' ); elseif ($type == 2) echo esc_html( 'Private Tour' ); ?></td>
						</tr>
						<?php endif; ?>
						<?php if ( ! empty( $date ) ) : ?>
						<tr>
							<td><?php echo esc_html__( 'Date', 'citytours' ) ?></td>
							<td class="text-right"><?php echo date( 'j F Y', ct_strtotime( $date ) ); ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<td><?php echo esc_html__( 'Duration', 'citytours' ) ?></td>
							<td class="text-right"><?php echo esc_html( $duration ); ?></td>
						</tr>
						<?php if (! empty($hotels) ) :?>
						<tr>
							<td><?php echo esc_html__( 'Hotels In Tour', 'citytours' ) ?></td>
							<td class="text-right">
								<?php 
									foreach ($hotels_array as $value) {
									echo '<span class="show">';
									echo '<a href="' . get_the_permalink($value) . '" target="_blank" >';
									echo get_the_title($value);
									echo '</a></span>';
								}
								?>
							</td>
						</tr>
						<?php endif;?>
						<tr>
							<td><?php echo esc_html__( 'Adults', 'citytours' ) ?></td>
							<td class="text-right"><?php echo esc_html( $adults ) ?></td>
						</tr>
						<tr>
							<td><?php echo esc_html__( 'Children', 'citytours' ) ?></td>
							<td class="text-right"><?php echo esc_html( $kids ) ?></td>
						</tr>
						<tr>
							<td><?php echo esc_html__( 'Infants', 'citytours' ); echo '<small> (Free)</small>'; ?></td>
							<td class="text-right"><?php echo esc_html( $infants ) ?></td>
						</tr>
						<?php if ( ! empty( $cart_service ) ) {
							foreach ( $cart_service as $key => $service ) { ?>
								<tr>
									<td><?php echo esc_html( $service['title'] ) ?></td>
									<td class="text-right"><?php echo ct_price( $service['total'] ); ?></td>
								</tr>
						<?php }} ?>
						<tr class="total">
							<td><?php echo esc_html__( 'Total cost', 'citytours' ) ?></td>
							<td class="text-right"><?php $total_price = $cart->get_field( $uid, 'total_price' ); if ( ! empty( $total_price ) ) echo ct_price( $total_price ) ?></td>
						</tr>
						<?php if ( ! empty( $deposit_rate ) && $deposit_rate < 100 ) : ?>
							<tr>
								<td><?php echo sprintf( esc_html__( 'Security Deposit (%d%%)', 'citytours' ), $deposit_rate ) ?></td>
								<td class="text-right"><?php if ( ! empty( $total_price ) ) echo ct_price( $total_price * $deposit_rate / 100 ) ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
					</table>
					<button type="submit" class="btn_full book-now-btn"><?php echo esc_html__( 'Book now', 'citytours' ) ?></button>
					<a class="btn_full_outline" href="<?php echo esc_url( get_permalink( $tour_id ) ) ?>"><i class="icon-right"></i> <?php echo esc_html__( 'Modify your search', 'citytours' ) ?></a>
					<input type="hidden" name="action" value="ct_tour_submit_booking">
					<input type="hidden" name="uid" value="<?php echo esc_attr( $uid ) ?>">
					<?php wp_nonce_field( 'checkout' ); ?>
				</div>
				<?php do_action( 'tour_checkout_sidebar_after' ); ?>
			</aside>
		</div><!--End row -->
	</form>

	<script>
		$ = jQuery.noConflict();
		var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';

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
							console.log( response );
							if ( response.success == 1 ) {
								if ( response.result.payment == 'woocommerce' ) {
									<?php if ( function_exists( 'ct_woo_get_cart_page_url' ) && ct_woo_get_cart_page_url() ) { ?>
										window.location.href = '<?php echo esc_js( ct_woo_get_cart_page_url() ); ?>';
									<?php } else { ?>
										alert("<?php echo esc_js( esc_html__( 'Please set woocommerce cart page', 'citytours' ) ); ?>");
									<?php } ?>
								} else {
									if ( response.result.payment == 'paypal' ) {
										$('.book-now-btn1').before('<div class="alert alert-success"><?php echo esc_js( esc_html__( 'You will be redirected to paypal.', 'citytours' ) ) ?><span class="close"></span></div>');
									}
									var confirm_url = $('#booking-form').attr('action');
									if ( confirm_url.indexOf('?') > -1 ) {
										confirm_url = confirm_url + '&';
									} else {
										confirm_url = confirm_url + '?';
									}
									confirm_url = confirm_url + 'booking_no=' + response.result.booking_no + '&pin_code=' + response.result.pin_code;
									$('.book-now-btn').hide();
									window.location.href = confirm_url;
								}
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

<?php } ?>