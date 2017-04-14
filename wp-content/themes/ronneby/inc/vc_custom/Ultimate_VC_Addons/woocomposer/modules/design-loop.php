<?php
function Dfd_Woocommerce_Loop_module($atts){
	global $woocommerce, $dfd_ronneby;
	$products_style = '';
	extract(shortcode_atts(array(
		'products_style' => 'style-1',
		'category' => '',
		'shortcode' => '',
		'ids' => ''
	),$atts));
	$output = '';
	$image_size = apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );
	
	if($products_style == '') {
		$products_style = 'style-1';
	}
	
	$post_count = '12';
	/* $output .= do_shortcode($content); */
	if($shortcode !== ''){
		$new_shortcode = rawurldecode( base64_decode( strip_tags( $shortcode ) ) );
	}
	
	$pattern = get_shortcode_regex();
	$shortcode_str = $short_atts = '';
	preg_match_all("/".$pattern."/", $new_shortcode, $matches);
	$shortcode_str = str_replace('"','',str_replace(" ","&",trim($matches[3][0])));
	$short_atts = parse_str($shortcode_str);//explode("&",$shortcode_str);
	if(isset($matches[2][0])): $display_type = $matches[2][0]; else: $display_type = ''; endif;
	if(!isset($columns)): $columns = '4'; endif;
	if(isset($per_page)): $post_count = $per_page; endif;
	if(isset($number)): $post_count = $number; endif;
	if(!isset($order)): $order = 'asc'; endif;
	if(!isset($orderby)): $orderby = 'date'; endif;
	if(!isset($category)): $category = ''; endif;
	if(!isset($ids)): $ids = ''; endif;
	if($ids){
		$ids = explode( ',', $ids );
		$ids = array_map( 'trim', $ids );
	}
	$col = $columns;
	if($columns == "2") $columns = 6;
	elseif($columns == "3") $columns = 4;
	elseif($columns == "4") $columns = 3;
	$meta_query = '';
	if($display_type == "recent_products"){
		$meta_query = WC()->query->get_meta_query();
	}
	if($display_type == "featured_products"){
		$meta_query = array(
			array(
				'key' 		=> '_visibility',
				'value' 	  => array('catalog', 'visible'),
				'compare'	=> 'IN'
			),
			array(
				'key' 		=> '_featured',
				'value' 	  => 'yes'
			)
		);
	}
	if($display_type == "top_rated_products"){
		add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		$meta_query = WC()->query->get_meta_query();
	}
	$args = array(
		'post_type'			=> 'product',
		'post_status'		  => 'publish',
		'ignore_sticky_posts'  => 1,
		'posts_per_page' 	   => $post_count,
		'orderby' 			  => $orderby,
		'order' 				=> $order,
		'meta_query' 		   => $meta_query
	);
	if($display_type == "sale_products"){
		$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
		$meta_query = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
	    $meta_query[] = $woocommerce->query->stock_status_meta_query();
		$args['meta_query'] = $meta_query;
		$args['post__in'] = $product_ids_on_sale;
	}
	if($display_type == "best_selling_products"){
		$args['meta_key'] = 'total_sales';
		$args['orderby'] = 'meta_value_num';
		$args['meta_query'] = array(
				array(
					'key' 		=> '_visibility',
					'value' 	=> array( 'catalog', 'visible' ),
					'compare' 	=> 'IN'
				)
			);
	}
	if($display_type == "product_category"){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	 => 'product_cat',
				'terms' 		=> array( esc_attr($category)),
				'field' 		=> 'name',
				'operator' 	 => 'IN'
			)
		);
	}
	if($display_type == "product_categories"){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	 => 'product_cat',
				'terms' 		=> $ids,
				'field' 		=> 'term_id',
				'operator' 	 => 'IN'
			)
		);
	}
	$test = '';
	
	if(vc_is_inline()){
		$test = "wcmp_vc_inline";
	}
	
	$catalogue_mode = (isset($dfd_ronneby['woocommerce_catalogue_mode']) && $dfd_ronneby['woocommerce_catalogue_mode']);
	
	$column_class = 'columns mobile-two dfd-loop-shop-responsive ';
	$column_class .= dfd_num_to_string($col);
	$column_class .= ' '.$products_style;
	
	$output .= '<div class="woocommerce columns-'.esc_attr($columns).'">';
	$output .= '<div class="products row">';
	$query = new WP_Query( $args );
	ob_start();
	if($query->have_posts()):
		while ( $query->have_posts() ) : $query->the_post();
		$subtitle = get_post_meta(get_the_ID(), 'dfd_product_product_subtitle', true);
	?>
			<div <?php post_class($column_class); ?>>
				<div class="prod-wrap">

					<?php do_action('woocommerce_before_shop_loop_item'); ?>
					<div class="woo-cover">
						<div class="prod-image-wrap woo-entry-thumb">

							<?php
								do_action('woocommerce_before_shop_loop_item_title');
							?>
							<a href="<?php the_permalink(); ?>" class="link"></a>
						</div>
					</div>
					<?php if(!$catalogue_mode): ?>
						<div class="woo-title-wrap">
							<div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<div class="woo-price-cart-wrap">
								<div class="price-wrap">
									<?php do_action('woocommerce_after_shop_loop_item_title'); ?>
								</div>
							</div>
							<?php if(!empty($subtitle)) : ?>
								<div class="subtitle"><?php echo $subtitle; ?></div>
							<?php endif; ?>
							<div class="rating-section">
								<?php woocommerce_get_template_part('loop/rating'); ?>
							</div>
							<?php if(strcmp($products_style , 'style-1') !== 0) : ?>
								<div class="description">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if(strcmp($products_style , 'style-2') === 0) : ?>
							<div class="additional-price">
								<?php do_action('woocommerce_after_shop_loop_item_title') ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endwhile;
	endif;
	$output .= ob_get_clean();
	
	$output .= '</div>';
	$output .= '</div>';
	if($display_type == "top_rated_products"){
		remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
	}
	wp_reset_postdata();
	return $output;
}