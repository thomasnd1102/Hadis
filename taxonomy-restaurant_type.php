<?php
get_header();
$page = ( isset( $_REQUEST['page'] ) && ( is_numeric( $_REQUEST['page'] ) ) && ( $_REQUEST['page'] >= 1 ) ) ? sanitize_text_field( $_REQUEST['page'] ):1;
$per_page = 10;
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$args = array( 'post_type' => 'restaurant', 'restaurant_type' => $term->name, 'posts_per_page' => $per_page, 'paged'=>$page );
$loop = new WP_Query( $args );
?>

<div id="position" class="blank-parallax">
    <div class="container"><ul><li><a href="/" title="Home">Home</a></li><li><a href="/restaurant" title="All Hanoi Restaurants">All Hanoi Restaurants</a></li><li><?php echo $term->name; ?></li></ul></div>
</div><!-- End Position -->

<div class="container margin_30">
    <div class="main_title">
        <h1><b>Hanoi <?php echo $term->name; ?> Restaurants</b></h1>
        <p><?php echo $term->description; ?></p>
    </div>
    <div class="row">
        <aside class="col-lg-3 col-md-3">
        	<div class="box_style_cat">
	            <ul id="cat_nav">
	                <?php
	                    echo '<li class="all-types"><a href="https://hanoidiscovery.com/restaurant/"><i class="icon_set_1_icon-51"></i>' . esc_html__( 'All Restaurants', 'citytours' ) . '<small></small></a></li>';
	                    $all_tour_types = get_terms( 'restaurant_type', array('hide_empty' => 0) );
	                    if ( ! empty( $all_tour_types ) ) :
	                    foreach ( $all_tour_types as $each_tour_type ) {
	                        $term_id = $each_tour_type->term_id;
	                        $icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
	                        echo '<li data-term-id="' . esc_attr( $term_id ) . '"><a href="' . esc_url( get_term_link( $each_tour_type ) ) . '">';
	                        if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
	                        echo esc_html( $each_tour_type->name ) . '<small></small></a></li>';
	                    }
	                    endif;
	                ?>
	            </ul>
	        </div>

            <?php if ( is_active_sidebar( 'sidebar-restaurant' ) ) : ?>
                <?php dynamic_sidebar( 'sidebar-restaurant' ); ?>
            <?php endif; ?>
        </aside><!--End aside -->

        <div class="col-lg-9 col-md-8">
            <div class="hotel-list">
                <?php while ( $loop->have_posts() ) : $loop->the_post(); 
                    $post_id = get_the_ID();
                    $review = get_post_meta( $post_id , '_review', true );
                    $price = get_post_meta( $post_id, '_restaurant_price', true );
                    $brief = get_post_meta( $post_id, '_restaurant_brief', true );
                    $terms = get_the_terms( $post_id, 'restaurant_type' );
                ?>
                     <div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="img_list">
                                    <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                                        <!-- <div class="ribbon popular" ></div> -->
                                        <?php echo get_the_post_thumbnail( $post_id, 'ct-list-thumb' ); ?>
                                    </a>
                                    <div class="short_info"><?php foreach ( $terms as $term ) { $icon_class = get_tax_meta( $term->term_id, 'ct_tax_icon_class' ); if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>'; echo $term->name; } ?> </div>
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
                
                <hr>

				<div class="text-center">
					<?php
						//$count = 4;
						unset( $_GET['page'] );
						$pagenum_link = strtok( $_SERVER["REQUEST_URI"], '?' ) . '%_%';
						//$total = ceil( $count / $per_page );
						$args = array(
							'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
							'total' => $loop->max_num_pages,
							'format' => '?page=%#%',
							'current' => max( 1, get_query_var('page') ),
							'show_all' => false,
							'prev_next' => true,
							'prev_text' => esc_html__('Previous', 'citytours'),
							'next_text' => esc_html__('Next', 'citytours'),
							'end_size' => 1,
							'mid_size' => 2,
							'type' => 'list',
							'add_args' => $_GET,
						);
						echo paginate_links( $args );
					?>
				</div><!-- end pagination-->
				<div class="text-center">
			</div>
            </div><!-- hotel-list -->

        </div><!-- End col lg 9 -->
    </div><!-- End row -->
</div><!-- End container -->
<?php get_footer(); ?>
