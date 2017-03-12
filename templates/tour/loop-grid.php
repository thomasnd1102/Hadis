<?php global $post_id, $before_list;


$price = get_post_meta( $post_id, '_tour_price', true );
if ( empty( $price ) ) $price = 0;
$tour_type = wp_get_post_terms( $post_id, 'tour_type' );
$tour_popular = get_post_meta( $post_id, '_tour_popular', true );
$review = get_post_meta( $post_id, '_review', true );
$review = ( ! empty( $review ) )?round( $review, 1 ):0;
$wishlist_link = ct_wishlist_page_url();
?>
<?php if ( ! empty( $before_list ) ) {
	echo ( $before_list );
} else { ?>
	<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
<?php } ?>
	<div class="tour_container">
		<div class="img_container">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php echo get_the_post_thumbnail( $post_id, 'ct-list-thumb' ); ?>
			<!-- <div class="ribbon top_rated"></div> -->
			<div class="short_info">
				<?php
					if ( ! empty( $tour_type ) ) {
						$icon_class = get_tax_meta($tour_type[0]->term_id, 'ct_tax_icon_class', true);
						if ( ! empty( $icon_class ) ) echo '<i class="' . $icon_class . '"></i>' . $tour_type[0]->name;
					}
				?>
				<span class="price"><?php echo ct_price( $price, 'special' ) ?></span>
			</div>
			<div class="<?php if (! empty( $tour_popular )) : echo "ribbon popular"; endif; ?>"></div>
			</a>
		</div>
		<div class="tour_title">
			<h3><?php echo esc_html( get_the_title( $post_id ) );?></h3>
			<div class="rating">
				<?php ct_rating_smiles( $review )?><small>(<?php echo esc_html( ct_get_review_count( $post_id ) ) ?>)</small>
			</div><!-- end rating -->
			
		</div>
	</div><!-- End box tour -->
</div><!-- End col-md-6 -->