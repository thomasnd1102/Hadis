<?php
get_header();
$page = ( isset( $_REQUEST['page'] ) && ( is_numeric( $_REQUEST['page'] ) ) && ( $_REQUEST['page'] >= 1 ) ) ? sanitize_text_field( $_REQUEST['page'] ):1;
$per_page = 10;
$args = array( 'post_type' => 'hanoi_sight', 'posts_per_page' => $per_page, 'paged'=>$page );
$loop = new WP_Query( $args );
$arrayPostId = array();
?>

<div id="position" class="blank-parallax">
    <div class="container"><ul><li><a href="/" title="Home">Home</a></li><li>Hanoi Sights</li></ul></div>
</div><!-- End Position -->

<div class="collapse" id="collapseMap">
	<div id="map" class="map"></div>
</div><!-- End Map -->

<div class="container margin_30">
    <div class="main_title">
        <h1><b>Hanoi Top Sights And Attractions</b></h1>
    </div>
    <div class="row">
        <aside class="col-lg-3 col-md-3">
            <?php if ( ! wp_is_mobile() ) : ?>
                <p><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a></p>
    		<?php endif; ?>
            <?php if ( is_active_sidebar( 'sidebar-hanoi-sight' ) ) : ?>
                <?php dynamic_sidebar( 'sidebar-hanoi-sight' ); ?>
            <?php endif; ?>
        </aside><!--End aside -->

        <div class="col-lg-9 col-md-8">
            <div class="hotel-list">
                <?php while ( $loop->have_posts() ) : $loop->the_post(); 
                    $post_id = get_the_ID();
                    array_push($arrayPostId, $post_id);
                    $brief = get_post_meta( $post_id, '_hanoi_sight_brief', true );
                    $terms = get_the_terms( $post_id, 'hanoi_sight_type' );
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
                                    </div>
                                    <h3><?php the_title(); ?></h3>
                                    <?php echo wp_kses_post( $brief ); ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="price_list">
                                    <div>
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
<?php if ( ! wp_is_mobile() ) : ?>
<script type="text/javascript">
	jQuery('#collapseMap').on('shown.bs.collapse', function(e){
		var zoom = 14;
		var markersData = {
		    <?php foreach ( $arrayPostId as $each_id ) {
    					$sight_pos = get_post_meta( $each_id, '_hanoi_sight_loc', true );

				if ( ! empty( $sight_pos ) ) { 
					$sight_pos = explode( ',', $sight_pos );
					$description = wp_trim_words( strip_shortcodes(get_post_field("post_content", $sight_pos)), 20, '...' );
					$image_map = wp_get_attachment_image_src(get_post_thumbnail_id( $each_id ), 'ct-list-thumb' );
				 ?>
					'<?php echo $each_id ?>' :  [{
						name: '<?php echo get_the_title( $each_id ) ?>',
						type: 'Sightseeing',
						location_latitude: <?php echo $sight_pos[0] ?>,
						location_longitude: <?php echo $sight_pos[1] ?>,
						map_image_url: '<?php echo $image_map[0] ?>',
						name_point: '<?php echo get_the_title(  $each_id ) ?>',
						description_point: '<?php echo $description ?>',
						url_point: '<?php echo get_permalink(  $each_id ) ?>'
					}],
				<?php
				}
			} ?>
		};
		 <?php 
		$centre_pos = get_post_meta( $arrayPostId[0], '_hanoi_sight_loc', true );
		if ( ! empty( $centre_pos ) ) { 
				$centre_pos = explode( ',', $centre_pos );
			}
		if ( ! empty( $centre_pos ) ) {
		 ?>
		var lati = <?php echo $centre_pos[0] ?>;
		var long = <?php echo $centre_pos[1] ?>;
		var _center = [lati, long];
		renderMap( _center, markersData, zoom, google.maps.MapTypeId.ROADMAP, false );
		<?php } ?>
	});
</script>
<?php endif; ?>
<?php get_footer(); ?>
