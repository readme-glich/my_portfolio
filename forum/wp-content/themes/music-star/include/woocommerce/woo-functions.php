<?php // Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WooCommerce Functions
 */
 
 /* View Product Button */
add_action('woocommerce_after_shop_loop_item','music_star_replace_add_to_cart');

function music_star_replace_add_to_cart() {
	
		global $product;
		$link = $product->get_permalink();
		echo do_shortcode('<a href="'.$link.'" class="button viewbutton">'. __( "View Product", 'music-star' ) .'</a>');
	
} 

// Hide Header Image only on shop page and product pages
add_action('wp_head', 'music_star_hide_all_custom_meta_boxes', 99);
function music_star_hide_all_custom_meta_boxes () {
	if( class_exists( 'WooCommerce' ) ) {
		if (is_shop() or is_product()) { ?>
		<style> .site-header{ display: none !important; }</style>
		<?php
		}
	}
}
