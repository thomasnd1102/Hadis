<?php
get_header();
$args = array( 'post_type' => 'transfer', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
?>

<div id="position" class="blank-parallax">
	<div class="container"><ul><li><a href="/" title="Home">Home</a></li><li>Hanoi Transfer Services</li></ul></div>
</div><!-- End Position -->

<div class="container margin_30">
	<div class="main_title">
		<h1><b>Hanoi</b> Transfer Services</h1>
		<p>Book Now With Us To Get The Best Deal!</p>
	</div>
	<div class="row">
		<aside class="col-lg-3 col-md-3">
		    <?php if ( is_active_sidebar( 'sidebar-transfer' ) ) : ?>
    			<?php dynamic_sidebar( 'sidebar-transfer' ); ?>
    		<?php endif; ?>
		</aside><!--End aside -->

		<div class="col-lg-9 col-md-8">
			<div class="hotel-list">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); 
				    $post_id = get_the_ID();
				    $review = get_post_meta( $post_id , '_review', true );
				    $price = get_post_meta( $post_id, '_transfer_price', true );
				    $brief = get_post_meta( $post_id, '_transfer_brief', true );
				?>
				     <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                    	<div class="row">
                    		<div class="col-lg-4 col-md-4 col-sm-4">
                    			<div class="img_list">
                    				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                    					<!-- <div class="ribbon popular" ></div> -->
                    					<?php echo get_the_post_thumbnail( $post_id, 'ct-list-thumb' ); ?>
                    				</a>
                    			</div>
                    		</div>
                    		<div class="clearfix visible-xs-block"></div>
                    		<div class="col-lg-6 col-md-6 col-sm-6">
                    			<div class="tour_list_desc">
                    				<div class="rating">
                    				<?php ct_rating_smiles( $review ); ?><small>(<?php echo ct_get_review_count( $post_id ); ?>)</small>
                    				</div>
                    				<h3><?php the_title(); ?></h3>
                    				<?php echo wp_kses_post( $brief ); ?>
                    			</div>
                    		</div>
                    		<div class="col-lg-2 col-md-2 col-sm-2">
                    			<div class="price_list">
                    				<div>
                    					<?php echo ct_price( $price, 'special' ) ?>
                    					<p><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="btn_1"><?php echo esc_html__( 'Details', 'citytours' ) ?></a></p>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div><!--End strip -->   
				    
				<?php  endwhile; ?>
			</div><!-- hotel-list -->

			<hr>
				
		</div><!-- End col lg 9 -->
	</div><!-- End row -->
</div><!-- End container -->
<?php get_footer(); ?>