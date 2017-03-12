<?php
get_header();
global $ct_options, $post_list, $current_view;
$order_array = array( 'ASC', 'DESC' );
$order_by_array = array(
		'' => '',
		'price' => 'price',
		'rating' => 'rating'
	);
$order_defaults = array(
		'price' => 'ASC',
		'rating' => 'DESC'
	);
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$order_by = ( isset( $_REQUEST['order_by'] ) && array_key_exists( $_REQUEST['order_by'], $order_by_array ) ) ? sanitize_text_field( $_REQUEST['order_by'] ) : '';
$order = ( isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], $order_array ) ) ? sanitize_text_field( $_REQUEST['order'] ) : 'ASC';
$current_view = isset( $_REQUEST['view'] ) ? sanitize_text_field( $_REQUEST['view'] ) : 'list';
$page = ( isset( $_REQUEST['page'] ) && ( is_numeric( $_REQUEST['page'] ) ) && ( $_REQUEST['page'] >= 1 ) ) ? sanitize_text_field( $_REQUEST['page'] ):1;
$per_page = ( isset( $ct_options['tour_posts'] ) && is_numeric($ct_options['tour_posts']) )?$ct_options['tour_posts']:6;
$search_result = ct_tour_get_search_result( array( 'tour_type'=>array($term->term_id), 'order_by'=>$order_by_array[$order_by], 'order'=>$order, 'last_no'=>( $page - 1 ) * $per_page, 'per_page'=>$per_page ) );
$post_list = $search_result['ids'];

 ?>
 
<div id="position" class="blank-parallax">
	<div class="container"><ul><li><a href="/" title="Home">Home</a></li><li><a href="/tour" title="All Hanoi Tours">All Tours</a></li><li><?php echo $term->name; ?></li></ul></div>
</div><!-- End Position -->

<div class="container margin_30">
	<div class="main_title">
		<h1><b><?php echo $term->name; ?></b></h1>
		<p><?php echo $term->description; ?> </p>
	</div>
	<div class="row">
		<aside class="col-lg-3 col-md-3">

		<div class="box_style_cat">
			<ul id="cat_nav">
				<?php
					$counts_by_tour_type = ct_tour_get_search_result_count( array( 'by' => 'tour_type' ) );
					echo '<li class="all-types"><a href="https://hanoidiscovery.com/tour/"><i class="icon_set_1_icon-51"></i>' . esc_html__( 'All tours', 'citytours' ) . '<small>(' . esc_html( array_sum( $counts_by_tour_type ) ) . ')</small></a></li>';
					$all_tour_types = get_terms( 'tour_type', array('hide_empty' => 0) );
					if ( ! empty( $all_tour_types ) ) :
					foreach ( $all_tour_types as $each_tour_type ) {
						$term_id = $each_tour_type->term_id;
						$icon_class = get_tax_meta( $term_id, 'ct_tax_icon_class' );
						echo '<li data-term-id="' . esc_attr( $term_id ) . '"><a href="' . esc_url( get_term_link( $each_tour_type ) ) . '">';
						if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
						echo esc_html( $each_tour_type->name ) . '<small>(' . esc_html( ( empty( $counts_by_tour_type[ $term_id ] ) ? 0 : $counts_by_tour_type[ $term_id ] ) ) . ')</small></a></li>';
					}
					endif;
				?>
			</ul>
		</div>
        
			<?php if ( is_active_sidebar( 'sidebar-tour_type' ) ) : ?>
    			<?php dynamic_sidebar( 'sidebar-tour_type' ); ?>
    		<?php endif; ?>
    		
		</aside><!--End aside -->

		<div class="col-lg-9 col-md-8">
			<div id="tools">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="styled-select-filters">
							<select name="sort_price" id="sort_price" data-base-url="<?php echo esc_url( remove_query_arg( array( 'order', 'order_by', 'page' ) ) ); ?>">
								<option value="" <?php if ( $order_by != 'price' ) echo 'selected' ?>><?php echo esc_html__( 'Sort by price', 'citytours' ) ?></option>
								<option value="lower" <?php if ( $order_by == 'price' && $order == 'ASC' ) echo 'selected' ?>><?php echo esc_html__( 'Lowest price', 'citytours' ) ?></option>
								<option value="higher" <?php if ( $order_by == 'price' && $order == 'DESC' ) echo 'selected' ?>><?php echo esc_html__( 'Highest price', 'citytours' ) ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="styled-select-filters">
							<select name="sort_rating" id="sort_rating" data-base-url="<?php echo esc_url( remove_query_arg( array( 'order', 'order_by', 'page' ) ) ); ?>">
								<option value="" <?php if ( $order_by != 'rating' ) echo 'selected' ?>><?php echo esc_html__( 'Sort by rating', 'citytours' ) ?></option>
								<option value="lower" <?php if ( $order_by == 'rating' && $order == 'ASC' ) echo 'selected' ?>><?php echo esc_html__( 'Lowest rating', 'citytours' ) ?></option>
								<option value="higher" <?php if ( $order_by == 'rating' && $order == 'DESC' ) echo 'selected' ?>><?php echo esc_html__( 'Highest rating', 'citytours' ) ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 hidden-xs text-right">
						<a href="<?php echo esc_url( add_query_arg( array( 'view' => 'grid' ) ) ) ?>" class="bt_filters" title="<?php esc_html_e(  'Grid View', 'citytours' ) ?>"><i class="icon-th"></i></a>
						<a href="<?php echo esc_url( add_query_arg( array( 'view' => 'list' ) ) ) ?>" class="bt_filters" title="<?php esc_html_e(  'List View', 'citytours' ) ?>"><i class="icon-list"></i></a>
					</div>
				</div>
			</div><!--End tools -->

			<div class="tour-list <?php if ( $current_view == 'grid' ) echo 'row' ?>">
				<?php ct_get_template( 'tour-list.php', '/templates/tour/'); ?>
			</div><!-- End row -->

			<hr>

				<div class="text-center">
					<?php
						unset( $_GET['page'] );
						$pagenum_link = strtok( $_SERVER["REQUEST_URI"], '?' ) . '%_%';
						$total = ceil( $count / $per_page );
						$args = array(
							'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
							'total' => $total,
							'format' => '?page=%#%',
							'current' => $page,
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
				
		</div><!-- End col lg 9 -->
	</div><!-- End row -->
</div><!-- End container -->
<script>
jQuery(document).ready(function(){
	jQuery('input').iCheck({
		checkboxClass: 'icheckbox_square-grey',
		radioClass: 'iradio_square-grey'
	});
	jQuery('#cat_nav').mobileMenu();
	if ( jQuery('input.date-pick').length ) {
		jQuery('input.date-pick').datepicker({
			startDate: "today"
		});
	}
});
 </script>
<?php get_footer(); ?>