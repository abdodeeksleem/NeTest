<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.10
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add_to_cart_button product_type_%s">%s</a>', esc_url( $product->add_to_cart_url() ), 
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			esc_attr( $product->product_type ),
			'<span class="cover"><span class="front"><i class="dfd-icon-trolley_input"></i><span>'.__('Add to cart', 'dfd').'</span></span><span class="back"><i class="dfd-icon-trolley_input"></i><span>'.__('Add to cart', 'dfd').'</span></span></span>'
	),
$product );
