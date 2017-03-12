<?php
 /*
 Template Name: Template Home Tnd
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$content_class = 'post-content';
		$active_class = 'active'; ?>
<div id="position" class="blank-parallax">
	<div class="container"></div>
</div><!-- End Position -->
<div class="container margin_top_30">
	<div class="main_title">
		<h1> – <span style="color: #e04f67;">Hanoi</span> Discovery – </h1>
		<p>LET DISCOVER HANOI AND VIETNAM WITH US!</p>
	</div>
	
	<div class="row">
	    <div class="col-md-8" id="">
	        <div class="row" style="padding: 20px;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;background:#fff;">
				<div class="col-md-4 text-center">
					<img class="img-circle wp-post-image" style="margin: auto; display: block;" src="https://hanoidiscovery.com/wp-content/uploads/2016/08/Hanoi-Disocvery.jpg" alt="Hanoi Discovery" width="120" height="120" data-pin-nopin="true">
					<h2 style="font-size: 18px;"><span>Hanoi</span> Discovery</h2>
					<small>Find your way to The Heart of Vietnam</small>
					<div class"row"><center><div class="fb-like" style="margin-right: 4px;" data-href="https://hanoidiscovery.com" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div></div>
				</div>
				<div class="col-md-8 nopadding">
					<blockquote class="styled">
						<span>
						"Hanoi is the capital city of Vietnam, and you'll experience a very different side of the country here in this northern and cosmopolitan city than what you get in Saigon (Ho Chi Minh City)." - <strong>George K</strong>
						</span>
					</blockquote>
					<blockquote class="styled">
						<span>
							"Hanoi is an absolute must for those interested in the hustle and bustle that only comes in large asian cities. All day can be spent roaming the Old Quarter and Hoan Kiem Lake areas."	- <strong>nickandkerry</strong>					
							</span>
					</blockquote>
					<blockquote class="styled">
						<span>
							"Vietnam was the clear favourite of a nine month round world trip, and Hanoi has left the clearest memories. Having spoken to other experienced travellers, this is not a unique response. To quote a friend: Hanoi is the best of all kinds of crazy.  - <strong>Mik W</strong>
						</span>
					</blockquote>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6" style="border-right: 1px solid #ddd;">
					<center>
						<img style="border-bottom: 1px solid #ddd;" class="img-responsive" src="https://hanoidiscovery.com/wp-content/uploads/2016/08/staticmap.png" alt="">
					</center>
				</div>
				<div class="col-md-6">
					<div class="text-center">
					<h3 style="font-size: 16px;margin:10px 0px 0px 15px;" class="pull-left"><span class="price_tnd">Hanoi</span> Sightseeings</h3>
					<span class="pull-right" style="margin-top:10px;"><a href="/hanoi_sight/" alt="Hanoi Top Sightseeings" target="blank"><u> – View All – </u></a></span>
					</div>
					<?php echo do_shortcode('[list_sight post_ids="4685,4840,4734"]'); ?>
					
				</div>
			</div>
			<hr>
			<div class="row ">
				<div class="col-md-6" style="border-right: 1px solid #ddd;">
					<div class="text-center">
					<h3 style="font-size: 16px;margin:0px 0px 0px 15px;" class="pull-left"><span class="price_tnd">Vietnam</span> Package Tours</h3>
					<span class="pull-right" style="margin-top:0px;"><a href="https://hanoidiscovery.com/tour-type/vietnam-classic-family-tours/" alt="Vietnam Package Tours" target="blank"><u> – View All – </u></a></span>
					</div>
					<?php echo do_shortcode('[list_tour type="selected" post_ids="665,3639,3677,4277"]') ?>
				</div>
				<div class="col-md-6">
					<div class="text-center">
					<h3 style="font-size: 16px;margin:0px 0px 0px 15px;" class="pull-left"><span class="price_tnd">Halong</span> Bay Cruises</h3>
					<span class="pull-right" style="margin-top:0px;"><a href="/cruise/" alt="Halong Bay Cruises" target="blank"><u> – View All – </u></a></span>
					</div>
					<?php echo do_shortcode('[list_cruise type="selected" post_ids="1980,3650,658,2074"]') ?>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6" style="border-right: 1px solid #ddd;">
					<div class="text-center">
					<h3 style="font-size: 16px;margin:0px 0px 0px 15px;" class="pull-left"><span class="price_tnd">Hanoi</span> Hotels</h3>
					<span class="pull-right" style="margin-top:0px;"><a href="/hotel/" alt="Hanoi Hotels" target="blank"><u> – View All – </u></a></span>
					</div>
					<?php echo do_shortcode('[list_hotel type="selected" post_ids="3114,1292,1739,1924"]') ?>
					<hr>
				</div>
				<div class="col-md-6">
					<div class="text-center">
					<h3 style="font-size: 16px;margin:0px 0px 0px 15px;" class="pull-left"><span class="price_tnd">Hanoi</span> Day Trips</h3>
					<span class="pull-right" style="margin-top:0px;"><a href="https://hanoidiscovery.com/tour-type/hanoi-day-trips/" alt="Hanoi Day Trips" target="blank"><u> – View All – </u></a></span>
					</div>
					<?php echo do_shortcode('[list_tour type="selected" post_ids="2935,2960,3013,4020"]') ?>
					<hr>
				</div>
			</div>
			
			
    	</div>
    	<aside class="col-md-4">
    		<?php if ( ! wp_is_mobile() ) : ?>
    		<style>.carousel-inner img {
			    -webkit-filter: grayscale(10%);
			    filter: grayscale(10%); /* make all photos black and white */ 
			    width: 100%; /* Set width to 100% */
			    margin: auto;
			}
			
			.carousel-caption h3 {
			    color: #fff !important;
			}
			
			.carousel-indicators .active {
			    width: 12px;
			    height: 12px;
			    margin: 0;
			    background-color: #e04f67;
			}
			.carousel-indicators li {
		    	border: 1px solid #e04f67;
			}
			@media (max-width: 600px) {
			    .carousel-caption {
			        display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
			    }
			}</style>
    		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			    <li data-target="#myCarousel" data-slide-to="1"></li>
			    <li data-target="#myCarousel" data-slide-to="2"></li>
			  </ol>
			
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			    <div class="item active">
			      <img src="https://hanoidiscovery.com/wp-content/uploads/2016/01/hanoi-discovery-400x267.jpg" alt="New York">
			      <div class="carousel-caption">
			        <h3></h3>
			        <p></p>
			      </div> 
			    </div>
			
			    <div class="item">
			      <img src="https://hanoidiscovery.com/wp-content/uploads/2016/03/West-Lake-hanoi-400x267.jpg" alt="Chicago">
			      <div class="carousel-caption">
			        <h3></h3>
			        <p></p>
			      </div> 
			    </div>
			
			    <div class="item">
			      <img src="https://hanoidiscovery.com/wp-content/uploads/2016/02/hanoi-Tran_Quoc_Pagoda-1112x630-400x267.jpg" alt="Los Angeles">
			      <div class="carousel-caption">
			        <h3></h3>
			        <p></p>
			      </div> 
			    </div>
			  </div>
			
			  <!-- Left and right controls -->
			  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
    		<hr>
    		
	        <div id="tabs" class="tabs tabsnd" style="margin-bottom: 20px; ">
    			<nav style="margin-top:0px;">
    			<ul>
    				<li class="tab-current"><a class="icon-tours" href="#section-1"></a></li>
    				<li class=""><a class="icon-hotels" href="#section-2"></a></li>
    				<li class=""><a class="icon-cruises" href="#section-3"></a></li>
    			</ul>
    			</nav>
    		<div class="content">
    			<section id="section-1" class="content-current" style="padding: 10px 30px 30px 30px;">
    				<center><h5> - Search Tours - </h5></center>
					<form role="search" method="get" id="search-tour-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="hidden" name="post_type" value="tour">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Search terms', 'citytours' ) ?></label>
								<input type="text" class="form-control" name="s" placeholder="<?php esc_html_e( 'Type your search terms', 'citytours' ) ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Things to do', 'citytours' ) ?></label>
								<?php
								$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
								if ( ! empty( $all_tour_types ) ) : ?>
									<select class="form-control" name="tour_types">
										<option value="" selected><?php esc_html_e( 'All tours', 'citytours' ) ?></option>
										<?php foreach ( $all_tour_types as $each_tour_type ) {
											$term_id = $each_tour_type->term_id;
											$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
										?>
										<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $each_tour_type->name ) ?></option>
										<?php } ?>
									</select>
								<?php endif; ?>
							</div>
						</div>
					</div><!-- End row -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Date', 'citytours' ) ?></label>
								<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="1" class="qty2 form-control" name="adults">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="0" class="qty2 form-control" name="kids">
								</div>
							</div>
						</div>

					</div><!-- End row -->
					<hr>
					<button class="btn_full book-now"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ) ?></button>
					</form>
    			</section>
    			<section id="section-2" class="" style="padding: 10px 30px 30px 30px;">
    			    <center><h5> - Search Hotels - </h5></center>
					<form role="search" method="get" id="search-hotel-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="hidden" name="post_type" value="hotel">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check in', 'citytours' ) ?></label>
								<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check out', 'citytours' ) ?></label>
								<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_to">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="1" class="qty2 form-control" name="adults">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="0" class="qty2 form-control" name="kids">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-xs-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Rooms', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="1" id="rooms" class="qty2 form-control" name="rooms">
								</div>
							</div>
						</div>
					</div><!-- End row -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Hotel name', 'citytours' ) ?></label>
								<input type="text" class="form-control" id="hotel_name" name="s" placeholder="<?php esc_attr_e( 'Optionally type hotel name', 'citytours' ) ?>">
							</div>
						</div>

						<?php
						$all_districts = get_terms( 'district', array('hide_empty' => 0) );
						if ( ! empty( $all_districts ) ) : ?>
							<div class="col-md-12">
								<div class="form-group">
								<label><?php esc_html_e( 'Preferred city area', 'citytours' ) ?></label>
									<select class="form-control" name="districts">
										<option value="" selected><?php esc_html_e( 'All', 'citytours' ) ?></option>
										<?php foreach ( $all_districts as $district ) {
											$term_id = $district->term_id; ?>
											<option value="<?php echo esc_attr( $term_id ) ?>"><?php echo esc_html( $district->name ) ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php endif;?>
					</div> <!-- End row -->
					<hr>
					<button class="btn_full book-now"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ); ?></button>
					</form>
    			</section>
    			<section id="section-3" class="" style="padding: 10px 30px 30px 30px;">
    			    <center><h5> - Search Halong Bay Cruies - </h5></center>
					<form role="search" method="get" id="search-cruise-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="hidden" name="post_type" value="cruise">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Check in', 'citytours' ) ?></label>
								<input class="date-pick form-control" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" name="date_from">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php esc_html_e( 'Itinerary', 'citytours' ) ?></label>
								<select class="form-control" name="itinerary">
										<option value="2" selected><?php esc_html_e( '2 days 1 night', 'citytours' ) ?></option>
										<option value="3" ><?php esc_html_e( '3 days 2 nights', 'citytours' ) ?></option>

								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Adults', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="1" class="qty2 form-control" name="adults">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?php esc_html_e( 'Children', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="0" class="qty2 form-control" name="kids">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Cabins', 'citytours' ) ?></label>
								<div class="numbers-row">
									<input type="text" value="1" id="rooms" class="qty2 form-control" name="cabins">
								</div>
							</div>
						</div>
					</div><!-- End row -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><?php esc_html_e( 'Cruise name', 'citytours' ) ?></label>
								<input type="text" class="form-control" id="cruise_name" name="s" placeholder="<?php esc_attr_e( 'Optionally type cruise name', 'citytours' ) ?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							<label><?php esc_html_e( 'Cruise star', 'citytours' ) ?></label>
								<select class="form-control" name="star_filter[]">
									<option value="" selected>All</option>
									<option value="3"><?php esc_html_e( 'Superior - 3 ***', 'citytours' ) ?></option>
									<option value="4" ><?php esc_html_e( 'Deluxe - 4 ****', 'citytours' ) ?></option>
									<option value="5" ><?php esc_html_e( 'Luxury - 5 *****', 'citytours' ) ?></option>
								</select>
							</div>
						</div>

					</div> <!-- End row -->
					<hr>
					<button class="btn_full book-now"><i class="icon-search"></i><?php esc_html_e( 'Search now', 'citytours' ); ?></button>
					</form>
    			</section>
				
    		</div>
    		<!-- /content -->
    		<script type="text/javascript" src="https://hanoidiscovery.com/wp-content/themes/citytours%20thaond/js/tabs.js"></script>
    		<script>
    		new CBPFWTabs( document.getElementById( 'tabs' ) );
    		</script>
    		</div>
    		<hr>
			<?php endif; ?>
    		<div class="box_style_cat">
				<ul id="cat_nav">
					<li><a href="https://hanoidiscovery.com/transfer/" target="blank"><i class="icon_set_1_icon-26"></i>Car Transfer Service</a></li>
					<li><a href="#"><i class="icon_set_1_icon-93"></i>Visa Service</a></li>
					<li><a href="#"><i class="icon_set_1_icon-37"></i>Flight Ticket Service</a></li>
					<li><a href="#"><i class="icon_set_1_icon-5"></i>Train Ticket Service</a></li>
				</ul>
			</div>
    		<?php if ( ! wp_is_mobile() ) : ?>
	    		<hr>
	    		<center>
	    			<div class="fb-page" data-href="https://www.facebook.com/thelighttravel/" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/thelighttravel/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/thelighttravel/">The Light Travel</a></blockquote></div>
	    		</center>	
		        <hr>
	        <?php endif; ?>
	    </aside>
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
	$('input.date-pick').datepicker({
		startDate: "today"
	});
	$('input[name="date_from"]').datepicker( 'setDate', 'today' );
	$('input[name="date_to"]').datepicker( 'setDate', '+1d' );
	$('input[name="date"]').datepicker( 'setDate', 'today' );
	});
</script>

<?php endwhile;
}
get_footer();