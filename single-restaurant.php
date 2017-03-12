<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$price = get_post_meta( $post_id, '_restaurant_price', true );
		if ( empty( $price ) ) $price = 0;
		$header_img_scr = ct_get_header_image_src( $post_id );
		$brief = get_post_meta( $post_id, '_restaurant_brief', true );
		$telephone = get_post_meta( $post_id, '_restaurant_telephone', true );
		$website = get_post_meta( $post_id, '_restaurant_website', true );
		$opening_hours = get_post_meta( $post_id, '_restaurant_opening_hours', true );
		//$slider = get_post_meta( $post_id, '_restaurant_slider', true );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
		$address = get_post_meta( $post_id, '_restaurant_address', true );
		$foursquare_id = get_post_meta( $post_id, '_restaurant_foursquare_id', true );
		$review_fields = array("Service", "Quality", "Position", "Price");
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
								<li><i class="icon_set_1_icon-58"></i><span class="info_label">Restaurant:</span> <span><?php the_title(); ?></span></li>
								<li><i class="icon_set_1_icon-41"></i><span class="info_label">Location:</span>Hanoi - Vietnam</li>
								<li><i class="icon_set_1_icon-48"></i><span class="info_label">Address:</span> <span><?php echo $address; ?></span></li>
								<?php if ( ! empty( $telephone ) ) : ?><li><i class="icon_set_1_icon-91"></i><span class="info_label">Telephone:</span> <span><?php echo $telephone; ?></span></li> <?php endif; ?>
								<?php if ( ! empty( $website ) ) : ?> <li><i class="icon_set_1_icon-54"></i><span class="info_label">More information:</span> <span><a href="<?php echo $website; ?>" rel="no_follow"><?php echo $website; ?></a></span></li> <?php endif; ?>
								<li><i class="icon_set_1_icon-52"></i><span class="info_label">Opening hours:</span> <span><?php echo $opening_hours ; ?></span></li>
								<li><i class="icon_set_1_icon-18"></i><span class="info_label">Review:</span> <b class="text-danger"><?php echo esc_html( $doubled_review ) ?></b> /10 - <span class="text-success"><?php echo esc_html( $review_content ) ?></span> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></li>
								<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
								</ul>
							</div>
							<div class="hidden-xs" style="font-style: italic;">
								<?php echo $brief; ?>
							</div>
						</div>
					</div>
				</div>	
			</div> <!-- end of row-->	
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
		<div class="row">
					<div class="col-md-2">
						<h3><?php echo esc_html__( 'Tips And Reviews', 'citytours') ?></h3>
					</div>
					<div class="col-md-10">
						<div class="guest-reviews">
							<?php
								echo do_shortcode( '[venue_tips id="' . $foursquare_id . '"]' );
							?>
						</div>
						<div style="margin-top: 25px;">
								<a href="#" class="btn_1 more-tips" data-post_id="<?php echo esc_attr( $foursquare_id ) ?>"><?php echo esc_html__( 'LOAD MORE TIPS', 'citytours' ) ?></a>
						</div>
						<script>
						
						</script>
					</div>
		</div>
		<hr>
		<div class="row">
            	<div class="col-md-2">
            		<h3 style="font-size: 19px;"><?php echo esc_html__( 'Comments', 'citytours') ?></h3>
            	</div>
            	<div class="col-md-10">
            		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-width="100%"></div>
            	</div>
        </div>
		</div><!--End  single_tour_desc-->
		<aside class="col-md-4">

		<?php if ( is_active_sidebar( 'sidebar-restaurant' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-restaurant' ); ?>
		<?php endif; ?>

		</aside>
	</div><!--End row -->
</div><!--End container -->

<?php //if ( ! empty( $ct_options['transfer_end_section'] ) ) : ?>
	<?php //echo do_shortcode( $ct_options['transfer_end_section'] ); ?>
<?php //endif; ?>
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
	$('.more-tips').click(function() {
	    $.getJSON('https://api.foursquare.com/v2/venues/<?php echo $foursquare_id; ?>/tips?limit=10&client_id=5ERQJM2QHMEPHRQYYZZUSSW2LZBAAXK5OEHPXN2KKPMHH4W5&client_secret=WKC5UFZUXA0U2XXEX4GJH2JLZ1IANHJ4FQK1X1RDZ5NNGV1E&v=20160722',
	    					{offset: $('.guest-review').length},
						    function(data) {
						        $.each(data.response.tips.items, function(i,items){
						        	var content = '';
						        	var date = new Date(items.createdAt * 1000);
						        	var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
						        	content += '<div class="review_strip_single_nd guest-review">';
						        	content += '<img width="32" height="32" src="' + items.user.photo.prefix + '32x32' + items.user.photo.suffix + '" class="img-rounded wp-post-image" "="" data-pin-nopin="true">';
						        	content += '<small>- ' + months[date.getMonth()] + ', ' + date.getDate() + ', ' + date.getFullYear() + ' -</small>';
						        	content += '<h4>' + items.user.firstName;
						        	if ( typeof items.user.lastName != "undefined") { content += ' ' + items.user.lastName;}
						        	content += '</h4>';
						            content += '<p>' + items.text + '</p>';
						            if ( typeof items.photo != "undefined") { content += '<center><img class="img-responsive" src="' + items.photo.prefix + '558x200' + items.photo.suffix + '"></center>'; }
						            content += '</div>';
						            $(content).appendTo(".guest-reviews");
						       });
						});
	    return false;
	});
});	
</script>
<?php endwhile;
}
get_footer();