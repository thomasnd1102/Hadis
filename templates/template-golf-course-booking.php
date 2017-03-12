<?php
 /*
 Template Name: Full Golf Booking
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		if ( ! isset( $_REQUEST['booking_no'] ) || ! isset( $_REQUEST['pin_code'] ) ) {
			do_action('ct_tour_thankyou_wrong_data');
			exit;
		}
		global $wpdb, $ct_options;
		
		$order = new CT_Hotel_Order( $_REQUEST['booking_no'], $_REQUEST['pin_code'] );
		if ( ! $order_data = $order->get_order_info() ) {
			do_action('ct_tour_thankyou_wrong_data');
			exit;
		}
		
		
		if ( empty( $order_data['mail_sent'] ) ) {
			do_action('ct_order_conf_mail_not_sent', $order_data); // mail is not sent
		}
		
		$order_golf_booking = $order->get_golf_booking();
		$order_add_hotel_booking = $order->get_add_hotel_rooms();
		
		$header_img_scr = ct_get_header_image_src( $post_id );
		if ( ! empty( $header_img_scr ) ) {
				$header_img_height = ct_get_header_image_height( $post_id );
				$header_content = get_post_meta( $post_id, '_header_content', true );
		 ?>
		 <section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
			<div class="parallax-content-1">
				<div class="animated fadeInDown">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php echo balancetags( $header_content ); ?>
				</div>
			</div>
		</section><!-- End section -->
		<div id="position" <?php if ( empty( $header_img_scr ) ) echo 'class="blank-parallax"' ?>>
			<div class="container"><?php ct_breadcrumbs(); ?></div>
		</div><!-- End Position -->
		<?php } ?>
		<div class="container margin_60">
			<div class="row">
				<div class="col-md-8">
			
					<div class="form_title">
						<h3><strong><i class="icon-ok"></i></strong><?php echo esc_html__( 'Thank you!', 'citytours' ) ?></h3>
						<p><?php echo esc_html__( 'Your Booking Order is Confirmed Now.', 'citytours' ) ?></p>
					</div>
					<div class="step">
						<?php if ( ! empty( $ct_options['tour_thankyou_text_1'] ) ) : ?>
						<p><?php echo esc_html__( $ct_options['tour_thankyou_text_1'], 'citytours' ) ?></p>
						<?php endif; ?>
					</div><!--End step -->
			
					<div class="form_title">
						<h3><strong><i class="icon-tag-1"></i></strong><?php echo esc_html__( 'Booking summary', 'citytours' ) ?></h3>
						<p><?php echo esc_html__( 'Your Booking Details.', 'citytours' ) ?></p>
					</div>
					<div class="step">
						<table class="table confirm">
							<tbody>
								<tr>
									<td><strong><?php echo esc_html__( 'Name', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_data['first_name'] . ' ' . $order_data['last_name'] ) ?></td>
								</tr>
								<tr>
									<td><strong><?php echo esc_html__( 'Golf Course', 'citytours' ) ?></strong></td>
									<td><?php echo get_the_title( $order_data['post_id'] ) ?></td>
								</tr>
								<?php if ( ! empty( $order_data['date_from'] ) && '0000-00-00' != $order_data['date_from'] ) : ?>
								<tr>
									<td><strong><?php echo esc_html__( 'Date', 'citytours' ) ?></strong></td>
									<td><?php echo date( 'j F Y', strtotime( $order_data['date_from'] ) ) ?></td>
								</tr>
								<tr>
									<td><strong><?php echo esc_html__( 'Time', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_golf_booking['time'] ) ?></td>
								</tr>
								<?php endif; ?>
								<?php if ( ! empty( $order_golf_booking['add_service'] )  ) : ?>
								<tr>
									<td><strong><?php echo esc_html__( 'Add Service', 'citytours' ) ?></strong></td>
									<td><?php echo $order_golf_booking['add_service']; ?></td>
								</tr>
								<?php endif; ?>
								<tr>
									<td><strong><?php echo esc_html__( 'Players', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_golf_booking['players'] ) ?></td>
								</tr>
							</tbody>
						</table>
						<?php if ( ! empty( $order_add_hotel_booking ) ) : ?>
							<table class="table confirm">
								<tbody>
								<tr>
									<th><?php echo esc_html__( 'Hotel', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Room Type', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Rooms', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Check In', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Check Out', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Adults', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Childs', 'citytours' ) ?></th>
									<th><?php echo esc_html__( 'Price', 'citytours' ) ?></th>
									<th>&nbsp;</th>
								</tr>
									<?php foreach ( $order_add_hotel_booking as $key=>$room ) : ?>
										<tr class="clone-field">
											<td>
												<?php echo esc_attr( get_the_title( $room['hotel_id'] ) ) ?> 
											</td>
											<td><?php echo esc_attr( get_the_title( $room['room_type_id'] ) ) ?></td>
											<td><?php echo esc_attr( $room['rooms'] ) ?></td>
											<td><?php echo esc_attr( $room['date_from'] ) ?></td>
											<td><?php echo esc_attr( $room['date_to'] ) ?></td>
											<td><?php echo esc_attr( $room['adults'] ) ?></td>
											<td><?php echo esc_attr( $room['kids'] ) ?></td>
											<td><?php echo ct_price( $room['total_price'] ) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
						</table>		
						<?php endif; ?>
						<table class="table confirm">
							<tbody>
								<tr>
									<td><strong><?php echo esc_html__( 'TOTAL COST', 'citytours' ) ?></strong></td>
									<td ><?php echo ct_price( $order_data['total_price'] ) ?></td>
								</tr>
							</tbody>
						</table>
					</div><!--End step -->
				</div><!--End col-md-8 -->
			
				<aside class="col-md-4">
				
				<?php if ( is_active_sidebar( 'sidebar-confirmation' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-confirmation' ); ?>
				<?php endif; ?>
				
				</aside>
			</div><!--End row -->
		</div><!--End container -->
<?php endwhile;
}
get_footer();