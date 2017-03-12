<?php
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$brief = get_post_meta( $post_id, '_hanoi_sight_brief', true );
		$telephone = get_post_meta( $post_id, '_hanoi_sight_telephone', true );
		$website = get_post_meta( $post_id, '_hanoi_sight_website', true );
		$opening_hours = get_post_meta( $post_id, '_hanoi_sight_opening_hours', true );
		$slider = get_post_meta( $post_id, '_hanoi_sight_slider', true );
		$address = get_post_meta( $post_id, '_hanoi_sight_address', true );
		$foursquare_id = get_post_meta( $post_id, '_hanoi_sight_foursquare_id', true );
		$sight_pos = get_post_meta( $post_id, '_hanoi_sight_loc', true );
		$related_ht = get_post_meta( $post_id, '_hanoi_sight_related' );
		$gallery_imgs = get_post_meta( $post_id, '_gallery_imgs' );
		$terms = get_the_terms( $post_id, 'hanoi_sight_type' );
		if ( ! empty( $sight_pos ) ) { 
			$sight_pos = explode( ',', $sight_pos );
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
							</div>
							<div class="col-md-8">
								<ul class="list_info" >
								<li><i class="icon_set_1_icon-1"></i><span class="info_label">Sight:</span> <span><?php the_title(); ?></span></li>
								<li><i class="icon_set_1_icon-81"></i><span class="info_label">Type:</span> <span><?php foreach ( $terms as $term ) { echo $term->name; }  ?></span></li>
								<li><i class="icon_set_1_icon-41"></i><span class="info_label">Location:</span>Hanoi - Vietnam</li>
								<li><i class="icon_set_1_icon-48"></i><span class="info_label">Address:</span> <span><?php echo $address; ?></span></li>
								<?php if ( ! empty( $telephone ) ) : ?><li><i class="icon_set_1_icon-91"></i><span class="info_label">Telephone:</span> <span><?php echo $telephone; ?></span></li><?php endif; ?>
								<?php if ( ! empty( $website ) ) : ?> <li><i class="icon_set_1_icon-54"></i><span class="info_label">More information:</span> <span><a href="<?php echo $website; ?>" rel="no_follow"><?php echo $website; ?></a></span></li> <?php endif; ?>
								<?php if ( ! empty( $opening_hours ) ) : ?> <li><i class="icon_set_1_icon-52"></i><span class="info_label">Opening hours:</span> <span><?php echo $opening_hours ; ?></span></li><?php endif; ?>
								<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div><div class="fb-save" data-uri="<?php the_permalink(); ?>" data-size="small"></div></center></div>
								</ul>
							</div>
							<div class="hidden-xs" style="font-style: italic;">
							<?php if ( ! wp_is_mobile() ) { echo $brief;} ?>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<div class="row">
    			<?php if ( ! empty( $gallery_imgs ) ) : ?>
					<div class="carousel magnific-gallery" id="galery-post">
						<center>
						<?php foreach ( $gallery_imgs as $gallery_img ) {
							echo '<div class="col-md-2 col-sm-2 col-xs-4 gallery-image-nd"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'tnd-post-galery', '', array( "class" => "img-responsive" ) ) . '</a></div>';
						} ?>
						</center>
					</div>
				<?php endif; ?>
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
    						<h3> Tips And Reviews </h3>
    					</div>
    					<div class="col-md-10">
    						<div class="guest-reviews">
    							<?php
    								if ( ! empty($foursquare_id) ) echo do_shortcode( '[venue_tips id="' . $foursquare_id . '"]' ) ;
    							?>
    						</div>
    						<div style="margin-top: 25px;">
    								<a href="#" class="btn_1 more-tips" data-post_id="<?php echo esc_attr( $foursquare_id ) ?>"> LOAD MORE TIPS </a>
    						</div>
    						<script>
    						
    						</script>
    					</div>
    		</div>
    		
    		<hr>
		</div><!--End  single_tour_desc-->
		<aside class="col-md-4">
			<div class="box_style_1 expose nopadding">
				<center>
					<img style="border-bottom: 1px solid #ddd;" class="img-responsive" src="//maps.googleapis.com/maps/api/staticmap?center=<?php echo $sight_pos[0] . ',' . $sight_pos[1]; ?>&amp;zoom=14&amp;size=400x200&amp;maptype=roadmap&amp;markers=color:yellow%7Clabel:S%7C<?php echo $sight_pos[0] . ',' . $sight_pos[1]; ?><?php if ( ! empty( $related_ht ) ) { foreach ( $related_ht as $each_ht ) { $hotel_pos = get_post_meta( $each_ht, '_hotel_loc', true ); $hotel_pos = explode( ',', $hotel_pos ); echo '&amp;markers=color:red%7Clabel:H%7C' . $hotel_pos[0] . ',' . $hotel_pos[1]; } } ?>" alt="">
				</center>
				<h5 class="text-center"><a class="" href="http://maps.google.com/maps?daddr=<?php echo $sight_pos[0] . ',' . $sight_pos[1]; ?>" rel="nofollow" target="_blank"> - <U>Get directions</U> - </a></h5>
				<div class="text-center"><?php echo $address ?></div>
	
				<div style="padding: 10px; border-top: 1px solid #ddd;">
					<?php if ( ! empty( $related_ht ) ) : ?>
						<center> - <u>Nearby Hotels</u> - </center>
						<div class="other_tours">
							<ul>
								<?php foreach ( $related_ht as $each_ht ) {
			            				echo '<li><div>';
										echo '<a href="' . get_permalink( $each_ht ) . '" target="_blank"">';
										//echo '<figure>' . get_the_post_thumbnail($each_sight, 'tnd-list-thumb', array('class' => 'img-responsive') ) . '</figure>';
										echo '<i class="icon_set_1_icon-6"></i>';
										echo get_the_title($each_ht);
										echo '<span class="other_tours_price">$' . get_post_meta( $each_ht, '_hotel_price', true ) . '</span>';
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
		<?php if ( is_active_sidebar( 'sidebar-hanoi-sight' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-hanoi-sight' ); ?>
		<?php endif; ?>

		</aside>
</div><!--End row -->
<div>
	<center><h3> - <u>Recommended Hanoi Day Trips</u> - </h3></center>
	<hr>
	<?php
		$content = '[tours count="3" type="selected" post_ids="2935,2960,4020"]';
		echo do_shortcode( $content ); 
	?>
</div>	
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
	$('.explore').click(function() {
	    $.getJSON('https://api.foursquare.com/v2/venues/explore?ll=<?php echo $sight_pos[0] . ',' . $sight_pos[1]; ?>&limit=10&client_id=5ERQJM2QHMEPHRQYYZZUSSW2LZBAAXK5OEHPXN2KKPMHH4W5&client_secret=WKC5UFZUXA0U2XXEX4GJH2JLZ1IANHJ4FQK1X1RDZ5NNGV1E&v=20160722',
	    					{section: "food"},
						    function(data) {
						        $.each(data.response.groups[0].items, function(i,items){
						        	var content = '';
						        	//var date = new Date(items.createdAt * 1000);
						        	//var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
						        	content += '<div class="review_strip_single_nd guest-review">';
						        	//content += '<img width="32" height="32" src="' + items.user.photo.prefix + '32x32' + items.user.photo.suffix + '" class="img-rounded wp-post-image" "="" data-pin-nopin="true">';
						        	//content += '<small>- ' + months[date.getMonth()] + ', ' + date.getDate() + ', ' + date.getFullYear() + ' -</small>';
						        	content += '<h4>' + items.venue.name + '</h4>';
						            //content += '<p>' + items.text + '</p>';
						            //if ( typeof items.photo != "undefined") { content += '<center><img src="' + items.photo.prefix + '558x200' + items.photo.suffix + '"></center>'; }
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