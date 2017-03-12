<?php global $post_id, $before_list;
$price = get_post_meta( $post_id, '_hotel_price', true );
if ( empty( $price ) ) $price = 0;
$hotel_popular = get_post_meta( $post_id, '_hotel_popular', true );
$star = get_post_meta( $post_id, '_hotel_star', true );
$star = ( ! empty( $star ) )?round( $star, 1 ):0;
$review = get_post_meta( $post_id, '_review', true );
$review = ( ! empty( $review ) )?round( $review, 1 ):0;
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
$wishlist_link = ct_wishlist_page_url();
?>
<?php if ( ! empty( $before_list ) ) {
	echo ( $before_list );
} else { ?>
	<div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
<?php } ?>
	<div class="hotel_container">
		<div class="img_container">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php echo get_the_post_thumbnail( $post_id, 'ct-list-thumb' ); ?>
			<!-- <div class="ribbon top_rated"></div> -->
			<?php if ( ! empty( $review ) ) : ?>
				<div class="score"><span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?></div>
			<?php endif; ?>
			<div class="short_info hotel">
				<?php echo esc_html__( 'From/Per night', 'citytours' ) ?>
				<span class="price"><?php echo ct_price( $price, 'special' ) ?></span>
			</div>
			</a>
			<div class="<?php if (! empty( $hotel_popular )) : echo "ribbon popular"; endif; ?>"></div>
		</div>
		<div class="hotel_title">
			<h3><?php echo esc_html( get_the_title( $post_id ) );?></h3>
			<div class="rating">
				<?php ct_rating_smiles( $star, 'icon-star-empty', 'icon-star voted' )?>
			</div><!-- end rating -->
			
		</div>
	</div><!-- End box tour -->
</div><!-- End col-md-6 -->