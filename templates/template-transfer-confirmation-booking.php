<?php
 /*
 Template Name: Transfer Confirmation Booking Template
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
			//do_action('ct_order_conf_mail_not_sent', $order_data); // mail is not sent
			//tnd_transfer_generate_conf_mail();
		}
		
		$order_transfer_booking = $order->get_transfer_booking();
		
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
									<td><strong><?php echo esc_html__( 'Transfer', 'citytours' ) ?></strong></td>
									<td><?php echo get_the_title( $order_data['post_id'] ) ?></td>
								</tr>
								<tr>
									<td><strong><?php echo esc_html__( 'Service', 'citytours' ) ?></strong></td>
									<td><?php echo $order_transfer_booking['vehicle']  ?></td>
								</tr>
								<?php if ( ! empty( $order_data['date_from'] ) && '0000-00-00' != $order_data['date_from'] ) : ?>
								<tr>
									<td><strong><?php echo esc_html__( 'Transfer Date', 'citytours' ) ?></strong></td>
									<td><?php echo date( 'j F Y', strtotime( $order_data['date_from'] ) ) ?></td>
								</tr>
								<tr>
									<td><strong><?php echo esc_html__( 'Time Pick', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_transfer_booking['transfer_time'] ) ?></td>
								</tr>
								<?php endif; ?>
								<tr>
									<td><strong><?php echo esc_html__( 'Adults', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_transfer_booking['adults'] ) ?></td>
								</tr>
								<tr>
									<td><strong><?php echo esc_html__( 'Kids', 'citytours' ) ?></strong></td>
									<td><?php echo esc_html( $order_transfer_booking['kids'] ) ?></td>
								</tr>
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