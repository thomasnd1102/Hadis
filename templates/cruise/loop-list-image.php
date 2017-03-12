<?php global $post_id, $before_list;

$wishlist = array();
if ( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$wishlist = get_user_meta( $user_id, 'wishlist', false );
}
if ( ! is_array( $wishlist ) ) $wishlist = array();

$price = get_post_meta( $post_id, '_cruise_price', true );
if ( empty( $price ) ) $price = 0;
$brief = get_post_meta( $post_id, '_hotel_brief', true );
if ( empty( $brief ) ) {
	$brief = apply_filters('the_content', get_post_field('post_content', $post_id));
	$brief = wp_trim_words( $brief, 20, '' );
}
$star = get_post_meta( $post_id, '_cruise_star', true );
$star = ( ! empty( $star ) )?round( $star, 1 ):0;
$review = get_post_meta( $post_id, '_review', true );
$review = ( ! empty( $review ) )?round( $review, 1 ):0;
$doubled_review = number_format( round( $review * 2, 1 ), 1 );
$review_content = '';
$star_content = '';
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
if ( $star = 5 ) {
	$star_content = esc_html__( 'Luxury Cruise', 'citytours' );
} elseif ( $star = 4 ) {
	$star_content = esc_html__( 'Deluxe Cruise', 'citytours' );
} elseif ( $star = 3 ) {
	$star_content = esc_html__( 'Superior Cruise', 'citytours' );
} else {
	$star_content = esc_html__( 'Cruise', 'citytours' );
}
$wishlist_link = ct_wishlist_page_url();
?>
<?php if ( ! empty( $before_list ) ) {
	echo ( $before_list );
} else { ?>
	<div >
<?php } ?>
	<div class="hotel_container">
		
		<div class="">
			<table>
				<tbody>
					<td style="width:25%;">
						<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
						<?php echo get_the_post_thumbnail( $post_id, $size='thumbnail'); ?>
						</a>
					</td>
					<td style="width:70%; padding:8px;">
						<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
						<h4 style="margin:0;"><?php echo esc_html( get_the_title( $post_id ) );?></h4>
						</a>
						<div class="rating" style="font-size: 12px;">
							<?php ct_rating_smiles( $star, 'icon-star-empty', 'icon-star voted' );?>
							<span style="float: right">	<?php echo $star_content ?> </span>
						</div>
						<?php if ( ! empty( $review ) ) : ?>
								<div style="font-size: 10px"><?php echo esc_html__( 'Review Score: ', 'citytours' ) ?><span style="float: right;"><?php echo esc_html( $doubled_review . ' - ' . $review_content) ?></span></div>
							<?php endif; ?>
						<div class="short_info_cruise cruise">
							<?php echo esc_html__( 'From/Per Person', 'citytours' ) ?>
							<span class="price"><?php echo ct_price( $price, 'special' ) ?></span>
						</div>
						<?php if ( ! empty( $wishlist_link ) ) : ?>
						
					</td>
				</tbody>	
			</table>
			<?php endif; ?>
		</div>
	</div><!-- End box tour -->
</div><!-- End col-md-6 -->