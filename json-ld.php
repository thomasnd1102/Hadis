<?php // JSON-LD for Wordpress Home Articles and Author Pages written by Pete Wailes and Richard Baxter 
function get_post_data() { global $post; return $post; } 
// stuff for any page 
$payload["@context"] = "http://schema.org/"; 
// this has all the data of the post/page etc 
$post_data = get_post_data(); 
// stuff for any page, if it exists 
$category = get_the_category(); 
// stuff for specific pages 
/*if (is_single()) { 
    // this gets the data for the user who wrote that particular item 
    $author_data = get_userdata($post_data->post_author); 
    $post_url = get_permalink(); 
    $post_thumb = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 
    $payload["@type"] = "Article";
    $payload["url"] = $post_url; 
    $payload["author"] = array( "@type" => "Person", "name" => $author_data->display_name, ); 
    $payload["headline"] = $post_data->post_title; 
    $payload["datePublished"] = $post_data->post_date; 
    $payload["image"] = $post_thumb; 
    $payload["ArticleSection"] = $category[0]->cat_name; 
    $payload["Publisher"] = "Builtvisible";
} */
// we do all this separately so we keep the right things for organization together
if (is_front_page()) {
    $payload["@type"] = "Organization"; 
    $payload["name"] = "Hanoi Discovery | The Green Light Travel Ltd | Hanoi Local Travel Agency"; 
    $payload["logo"] = "https://hanoidiscovery.com/wp-content/uploads/2016/04/logo4.png";
    $payload["url"] = "https://hanoidiscovery.com/"; 
    $payload["sameAs"] = array( "https://twitter.com/DiscoveryHanoi", "https://www.facebook.com/TheLightTravel/", "https://www.pinterest.com/hanoidiscovery/", "https://www.youtube.com/channel/UChDtKgHk3ysDdci7zuyL85A" ); 
    $payload["contactPoint"] = array( array( "@type" => "ContactPoint", "telephone" => "+84 96 4684 698", "email" => "info@hanoidiscovery.com", "contactType" => "sales" ) );
    $payload["address"] = array( "@type" => "PostalAddress", "streetAddress" => "73 Ly Nam De Street, Hoan Kiem District, Hanoi, Vietnam" ); 
}
if ( is_singular( 'tour' ) ) {
    $payload["@type"] = "Product"; 
    $payload["name"] = get_the_title();
    $payload["description"] = get_post_meta( $post->ID, '_tour_brief', true );
    $payload["offers"] = array( "@type" => "AggregateOffer", "url" => get_permalink(), "lowPrice" => get_post_meta( $post->ID, '_tour_price', true ), "priceCurrency" => "USD" );
    $payload["image"] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    $payload["aggregateRating"] = array( "@type" => "AggregateRating", "bestRating" => "10", "ratingValue" => 2*get_post_meta( $post->ID, '_review', true ), "reviewCount" => ct_get_review_count( $post->ID ));
    $payload["brand"] = array("@type" => "Organization", "url" => "https://hanoidiscovery.com/", "name" => "Hanoi Discovery | The Green Light Travel Ltd | Hanoi Local Travel Agency", "logo" => "https://hanoidiscovery.com/wp-content/uploads/2016/04/logo4.png", "contactPoint" => array( "@type" => "ContactPoint", "telephone" => "+84 96 4684 698", "email" => "info@hanoidiscovery.com", "contactType" => "sales" ));
}
if ( is_singular( 'cruise' ) ) {
    $payload["@type"] = "Product"; 
    $payload["name"] = get_the_title();
    $payload["description"] = get_post_meta( $post->ID, '_cruise_brief', true );
    $payload["offers"] = array( "@type" => "AggregateOffer", "url" => get_permalink(), "lowPrice" => get_post_meta( $post->ID, '_cruise_price', true ), "priceCurrency" => "USD" );
    $payload["image"] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    $payload["aggregateRating"] = array( "@type" => "AggregateRating", "bestRating" => "10", "ratingValue" => 2*get_post_meta( $post->ID, '_review', true ), "reviewCount" => ct_get_review_count( $post->ID ));
    $payload["brand"] = array("@type" => "Organization", "url" => "https://hanoidiscovery.com/", "name" => "Hanoi Discovery | The Green Light Travel Ltd | Hanoi Local Travel Agency", "logo" => "https://hanoidiscovery.com/wp-content/uploads/2016/04/logo4.png", "contactPoint" => array( "@type" => "ContactPoint", "telephone" => "+84 96 4684 698", "email" => "info@hanoidiscovery.com", "contactType" => "sales" ));
}
if ( is_singular( 'hotel' ) ) {
    $payload["@type"] = "Product"; 
    $payload["name"] = get_the_title();
    $payload["description"] = get_post_meta( $post->ID, '_hotel_brief', true );
    $payload["offers"] = array( "@type" => "AggregateOffer", "url" => get_permalink(), "lowPrice" => get_post_meta( $post->ID, '_hotel_price', true ), "priceCurrency" => "USD" );
    $payload["image"] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    $payload["aggregateRating"] = array( "@type" => "AggregateRating", "bestRating" => "10", "ratingValue" => 2*get_post_meta( $post->ID, '_review', true ), "reviewCount" => ct_get_review_count( $post->ID ));
    $payload["brand"] = array("@type" => "Organization", "url" => "https://hanoidiscovery.com/", "name" => "Hanoi Discovery | The Green Light Travel Ltd | Hanoi Local Travel Agency", "logo" => "https://hanoidiscovery.com/wp-content/uploads/2016/04/logo4.png", "contactPoint" => array( "@type" => "ContactPoint", "telephone" => "+84 96 4684 698", "email" => "info@hanoidiscovery.com", "contactType" => "sales" ));
}
if ( is_singular( 'transfer' ) ) {
    $payload["@type"] = "Product"; 
    $payload["name"] = get_the_title();
    $payload["description"] = get_post_meta( $post->ID, '_transfer_brief', true );
    $payload["offers"] = array( "@type" => "AggregateOffer", "url" => get_permalink(), "lowPrice" => get_post_meta( $post->ID, '_transfer_price', true ), "priceCurrency" => "USD" );
    $payload["image"] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    $payload["aggregateRating"] = array( "@type" => "AggregateRating", "bestRating" => "10", "ratingValue" => 2*get_post_meta( $post->ID, '_review', true ), "reviewCount" => ct_get_review_count( $post->ID ));
    $payload["brand"] = array("@type" => "Organization", "url" => "https://hanoidiscovery.com/", "name" => "Hanoi Discovery | The Green Light Travel Ltd | Hanoi Local Travel Agency", "logo" => "https://hanoidiscovery.com/wp-content/uploads/2016/04/logo4.png", "contactPoint" => array( "@type" => "ContactPoint", "telephone" => "+84 96 4684 698", "email" => "info@hanoidiscovery.com", "contactType" => "sales" ));
}
?>