<?php
function Dfd_WooComposer_Single($atts){
	$enable_product_image = $image_width = $image_height = $image_selector = $custom_image = $product_id = $product_style = $outside_offset_width = $inside_offset_width = $enable_custom_settings = $desc_limit = $info_alignment = '';
	$size_title = $size_cat = $size_price = $sale_price = $color_heading = $color_categories = $color_price = $color_rating = $color_rating_bg = '';
	$color_on_sale = $color_on_sale_bg = $color_product_desc = $module_animation = $el_class = '';
	$main_heading_default_style = $main_heading_default_weight = $main_heading_line_height = $main_heading_letter_spacing = $main_heading_text_transform = '';
	
	extract(shortcode_atts(array(
		'info_alignment' => 'text-left',
		'enable_product_image' => '',
		'image_width' => '',
		'image_height' => '',
		'image_selector' => 'thumb',
		'custom_image' => '',
		'product_id' => '',
		'product_style' => 'style-1',
		'desc_limit' => '',
		'enable_rating' => '',
		'enable_title' => '',
		'enable_price' => '',
		'enable_description' => '',
		'enable_add_to_cart' => '',
		'enable_wishlist' => '',
		'enable_quick_view' => '',
		'enable_cat_tag' => '',
		'enable_button_default' => '',
		'background_color' => '',
		'enable_custom_settings' => 'no',
		'size_title' => '',
		'main_heading_default_style' => 'normal',
		'main_heading_default_weight' => '',
		'main_heading_line_height' => '',
		'main_heading_letter_spacing' => '',
		'main_heading_text_transform' => 'none',
		'size_cat' => '',
		'size_price' => '',
		'sale_price' => '',
		'color_heading' => '',
		'color_categories' => '',
		'color_price' => '',
		'color_rating' => '',
		'color_rating_bg' => '',
		'color_on_sale' => '',
		'color_on_sale_bg' => '',
		'color_product_desc' => '',
		'el_class' => '',
		'module_animation' => '',
	),$atts));

	$output = $heading_style = $cat_style = $price_style = $rating_style = $rating_bg_style = '';
	$module_css = $label_style = $desc_color = $css_js = '';
	$animate = $animation_data = '';
	
	$uniq_id = uniqid('dfd-single-product-module-');

	if ( ! ( $module_animation == '' ) ) {
		$animate        = ' cr-animate-gen';
		$animation_data = 'data-animate-type = "' . esc_attr($module_animation) . '" ';
	}
	
	if(!isset($enable_rating) || empty($enable_rating)) {
		$enable_rating = false;
	}
	
	if(!isset($enable_title) || empty($enable_title)) {
		$enable_title = false;
	}
	
	if(!isset($enable_price) || empty($enable_price)) {
		$enable_price = false;
	}
	
	if(!isset($enable_description) || empty($enable_description)) {
		$enable_description = false;
	}
	
	if(!isset($enable_add_to_cart) || empty($enable_add_to_cart)) {
		$enable_add_to_cart = false;
	}
	
	if(!isset($enable_wishlist) || empty($enable_wishlist)) {
		$enable_wishlist = false;
	}
	
	if(!isset($enable_quick_view) || empty($enable_quick_view)) {
		$enable_quick_view = false;
	}
	
	if(!isset($enable_cat_tag) || empty($enable_cat_tag)) {
		$enable_cat_tag = false;
	}
	
	if(isset($enable_button_default) && !empty($enable_button_default)) {
		$el_class .= ' with-active-button';
	}
		
	if($color_product_desc !== '') {
		$desc_color .= 'color:'.esc_attr($color_product_desc).';';
	}
		
	if($background_color !== '') {
		$module_css .= 'background:'.esc_attr($background_color).';';
	}
		
	if(strcmp($enable_custom_settings, 'yes') === 0) {
		if($size_title !== ""){
			$heading_style .= 'font-size:'.esc_attr($size_title).'px;';
		}
		if($main_heading_default_style != '') {
			$heading_style .= 'font-style: '.esc_attr($main_heading_default_style).';';
		}
		if($main_heading_default_weight != '') {
			$heading_style .= 'font-weight: '.esc_attr($main_heading_default_weight).';';
		}
		if($main_heading_line_height != '') {
			$heading_style .= 'line-height: '.esc_attr($main_heading_line_height).'px;';
		}
		if($main_heading_letter_spacing != '') {
			$heading_style .= 'letter-spacing: '.esc_attr($main_heading_letter_spacing).'px;';
		}
		if($main_heading_text_transform != '') {
			$heading_style .= 'text-transform: '.esc_attr($main_heading_text_transform).';';
		}
		if($color_heading !== ""){
			$heading_style .= 'color:'.esc_attr($color_heading).';';
		}
		if($size_cat !== ""){
			$cat_style .= 'font-size:'.esc_attr($size_cat).'px;';
		}
		if($color_categories !== ""){
			$cat_style .= 'color:'.esc_attr($color_categories).';';
		}
		if($size_price !== ""){
			$price_style .= 'font-size:'.esc_attr($size_price).'px;';
		}
		if($color_price !== ""){
			$price_style .= 'color:'.esc_attr($color_price).';';
		}
		if($color_rating !== ""){
			$rating_style .= 'color:'.esc_attr($color_rating).';';
		}
		if($color_rating_bg !== ""){
			$rating_bg_style .= 'color:'.esc_attr($color_rating_bg).';';
		}
		if($color_on_sale_bg !== ""){
			$label_style .= 'background:'.esc_attr($color_on_sale_bg).';';
		}
		if($color_on_sale !== ""){
			$label_style .= 'color:'.esc_attr($color_on_sale).';';
		}
	}
	
	if(!empty($price_style) || !empty($rating_style)) {
		$css_js .= '<style type="text/css">';
		if(!empty($price_style)) {
			$css_js .= '#'.esc_attr($uniq_id).'.dfd-single-product-module .dfd-price ins .amount, #'.esc_attr($uniq_id).'.dfd-single-product-module .dfd-price .amount {'.$price_style.'}';
		}
		if(!empty($rating_style)) {
			$css_js .= '#'.esc_attr($uniq_id).'.dfd-single-product-module .star-rating:before {'.esc_attr($rating_bg_style).'}';
			$css_js .= '#'.esc_attr($uniq_id).'.dfd-single-product-module .star-rating span:before {'.esc_attr($rating_style).'}';
		}
		$css_js .= '</style>';
	}
	if(!empty($color_cart_bg_hover) && strcmp($product_style, 'style-2') !== 0) {
		
	}
	
	$post = get_post($product_id);
	$product_desc = $post->post_excerpt;
	
	if(!empty($desc_limit) && is_numeric($desc_limit)) {
		$product_desc = wp_trim_words($product_desc, $desc_limit, '');
	}
	if($enable_product_image != '') {
		if(strcmp($image_selector, 'thumb') !== 0 && !empty($custom_image)) {
			$product_img_option = $custom_image;
		} else {
			$product_img_option = get_post_thumbnail_id($product_id);
		}
		$product_img = wp_get_attachment_image_src($product_img_option, 'full');
		$img_src = $product_img[0];
		$src = $img_src;
		if(!empty($image_width) && !empty($image_height)) {
			$src = dfd_aq_resize($img_src, $image_width, $image_height, true, true, true);
			if(!$src) {
				$src = $img_src;
			}
		}
	}
		
	ob_start();
	?>
	<div id="<?php echo esc_attr($uniq_id); ?>" class="dfd-single-product-module woocommerce dfd-<?php echo esc_attr($product_style); ?> <?php echo esc_attr($el_class); ?> <?php echo esc_attr($animate); ?>" style="<?php echo $module_css;?>" <?php echo $module_animation; ?>>
		<?php
		$query = new WP_Query( array( 'post_type' => 'product', 'post__in' => array( $product_id ) ) );
		if($query->have_posts()):
			while ( $query->have_posts() ) : $query->the_post();
				global $product;
				$title = get_the_title();
				$price = $product->get_price_html();
				$rating = $product->get_rating_html();
				$stock = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
				if ( $product->is_on_sale() ) :
					$on_sale = apply_filters( 'woocommerce_sale_flash', __('Sale', 'dfd') , $post, $product );
				else:
					$on_sale = '';
				endif;
				$subtitle = get_post_meta($product_id, 'dfd_product_product_subtitle', true);
			?>
				<div class="dfd-product-wrap">
					<?php if($on_sale !== '') : ?>
						<div class="onsale" style="<?php echo $label_style; ?>">
							<?php echo $on_sale; ?>
						</div>
					<?php endif; ?>

					<div class="dfd-product-top">
						<?php if($stock == 'OutOfStock') : ?>
							<span class="dfd-out-stock"><?php _e('Out Of Stock!','dfd'); ?></span>
						<?php endif; ?>

						<?php if($enable_title) : ?>
							<div class="block-title" style="<?php echo $heading_style; ?>">
								<a href="<?php the_permalink(); ?>"><?php echo $title; ?></a>
							</div>
						<?php endif; ?>

						<?php if($enable_cat_tag && !empty($subtitle)) : ?>
							<div class="subtitle" style="<?php echo $cat_style; ?>">
								<?php echo $subtitle; ?>
							</div>
						<?php endif; ?>

						<?php if($enable_rating) : ?>
							<div class="dfd-star-ratings clearfix">
								<?php echo $rating; ?>
							</div>
						<?php endif; ?>

						<?php if($enable_price) : ?>
							<div class="dfd-price">
								<?php echo $price; ?>
							</div>
						<?php endif; ?>
					</div>
						
					<div class="dfd-product-image">
						<a href="<?php the_permalink(); ?>">
							<img class="dfd-woo-img" src="<?php echo esc_url($src); ?>" data-src="<?php echo esc_url($src); ?>" alt="" />
						</a>
					</div>

					<?php if($enable_description) : ?>
						<div class="dfd-woo-description <?php echo esc_attr($info_alignment) ?>" style="<?php echo $desc_color; ?>">
							<?php echo get_the_content(); ?>
						</div>
					<?php endif; ?>

					<div class="buttons-wrap">
						<?php if($enable_add_to_cart) : ?>
							<a title="Add to Cart" href="?add-to-cart=<?php echo esc_attr($product_id); ?>" rel="nofollow" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="" class="add_to_cart_button">
								<span class="cover">
									<span class="front">
										<i class="dfd-icon-trolley_input"></i>
										<span><?php _e('Add to cart', 'dfd'); ?></span>
									</span>
									<span class="back">
										<i class="dfd-icon-trolley_input"></i>
										<span><?php _e('Add to cart', 'dfd'); ?></span>
									</span>
								</span>
							</a>
						<?php endif; ?>
						<?php if($enable_wishlist) : ?>
							<?php wc_get_template_part('add-to-wishlist-button'); ?>
						<?php endif; ?>
						<?php if($enable_quick_view) : ?>
							<a class="dfd-prod-lightbox quick-view-single" title="" href="<?php echo get_permalink($product_id); ?>">
								<span class="cover">
									<i class="dfd-icon-zoom_in front"></i>
									<i class="dfd-icon-zoom_in back"></i>
								</span>
							</a>
						<?php endif; ?>
					</div>
					<?php if(strcmp($product_style, 'style-2') === 0) : ?>
					<div class="dfd-bottom-heading">
						<div class="box-name"><?php echo $title; ?></div>
						<div class="dfd-price"><?php echo $price; ?></div>
					</div>
					<?php endif; ?>
				</div>
				<?php if($enable_quick_view) { ?>
					<div class="wcmp-quick-view-wrapper">
						<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="wcmp-quick-view-wrapper woocommerce">
								<div class="single-product row">
									<div class="wcmp-close-single">
										<i class="wooicon-cross2"></i>
									</div>
									<div class="wcmp-product-content-single">
									<?php
										do_action( 'woocommerce_before_single_product_summary' );
										do_action( 'woocommerce_single_product_summary' );
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
			endwhile; wp_reset_postdata();
		endif;
		?>
	</div>
	<?php if(!empty($css_js)) : ?>
	<script type="text/javascript">
		(function($) {
			"use strict";
			$('head').append('<?php echo $css_js; ?>');
		})(jQuery);
	</script>
	<?php endif; ?>
<?php
	$output .= ob_get_clean();
	return $output;
}