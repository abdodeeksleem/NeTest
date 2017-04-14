<?php
/*
@Module: List view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists("WooComposer_ViewList")){
	class WooComposer_ViewList
	{
		function __construct(){
			add_shortcode('woocomposer_list',array($this,'woocomposer_list_shortcode'));
			add_action('admin_init',array($this,'woocomposer_init_grid'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				vc_map(
					array(
						'name'		=> __('Product List', 'dfd'),
						'base'		=> 'woocomposer_list',
						'icon'		=> 'woo_list',
						'class'	   => 'woo_list',
						'category'  	=> __('WooComposer', 'dfd'),
						'description' => 'Display products in list view',
						'controls' => 'full',
						'show_settings_on_create' => true,
						'params' => array(
							array(
								'type' => 'woocomposer',
								'class' => '',
								'heading' => __('Query Builder', 'dfd'),
								'param_name' => 'shortcode',
								'value' => '',
								'module' => 'list',
								'labels' => array(
										'products_from'   => __('Display:', 'dfd'),
										'per_page'		=> __('How Many:', 'dfd'),
										'columns'		 => __('Columns:', 'dfd'),
										'order_by'		=> __('Order By:', 'dfd'),
										'order'		   => __('Display:', 'dfd'),
										'category' 		=> __('Category:', 'dfd'),
								),
								'description' => __('', 'dfd')
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => __( 'Display style', 'dfd' ),
								'param_name'  => 'display_style',
								'value'       => array(
									__( 'Simple', 'dfd' )       => '',
									__( 'Menu mode', 'dfd' )       => 'menu-mode',
								),
								'description' => __( '', 'dfd' ),
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => __( 'Subheading content', 'dfd' ),
								'param_name'  => 'subheading_content',
								'value'       => array(
									__( 'Tags', 'dfd' )       => '',
									__( 'Product subtitle', 'dfd' )       => 'subtitle',
								),
								'description' => __( '', 'dfd' ),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Product Title Font Size', 'dfd'),
								'param_name' => 'title_font',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Product Title Color', 'dfd'),
								'param_name' => 'title_color',
								'value' => '',
								'description' => __('', 'dfd'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Product Price Font Size', 'dfd'),
								'param_name' => 'price_font',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Product Price Color', 'dfd'),
								'param_name' => 'price_color',
								'value' => '',
								'description' => __('', 'woocommerce'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Subtitle/Category Font Size', 'dfd'),
								'param_name' => 'subtitle_font',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'woocommerce'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Subtitle/Category Color', 'dfd'),
								'param_name' => 'subtitle_color',
								'value' => '',
								'description' => __('', 'dfd'),
								'group'       => __('Typography','dfd'),
							),
							array(
								'type' => 'textfield',
								'heading' => __('Extra class name', 'js_composer'),
								'param_name' => 'el_class',
								'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
							),
							array(
								'type'        => 'dropdown',
								'class'       => '',
								'heading'     => __( 'Animation', 'dfd' ),
								'param_name'  => 'module_animation',
								'value'       => dfd_module_animation_styles(),
								'description' => __( '', 'dfd' ),
								'group'       => 'Animation Settings',
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_list_shortcode($atts){
			global $woocommerce;
			$img_position = $img_size = $img_border = $border_size = $border_radius = $border_color = $title_font = $price_font = $price_color = $shortcode = $subtitle_font = $subtitle_color = $module_animation = $display_style = $subheading_content = '';
			extract(shortcode_atts(array(
				'img_position' => '',
				'shortcode' => '',
				'img_size' => '',
				'img_border' => '',
				'border_size' => '',
				'border_radius' => '',
				'border_color' => '',
				'title_color' => '',
				'title_font' => '',
				'price_font' => '',
				'price_color' => '',
				'subtitle_font' => '',
				'subtitle_color' => '',
				'module_animation' => '',
				'el_class' => '',
				'display_style' => '',
				'subheading_content' => '',
			),$atts));
			$output = $on_sale = $style = $title_style = $pricing_style = $subtitle_style = $before_line = $after_line = '';
			if($display_style == 'menu-mode') {
				$before_line .= '<div class="clearfix dfd-list-menu-mode">';
				$after_line .= '</div>';
			}
			if($img_size !== ""){
				$style .= 'width:'.esc_attr($img_size).'px; height:'.esc_attr($img_size).'px;';
			}
			if($title_color !== ""){
				$title_style .= 'color:'.esc_attr($title_color).';';
			}
			if($title_font !== ""){
				$title_style .= 'font-size:'.esc_attr($title_font).'px;';
			}
			
			if($img_border !== ''){
				$style .= 'border-style:'.esc_attr($img_border).';';
				if($border_size !== ''){
					$style .= 'border-width:'.esc_attr($border_size).'px;';					
				}
				if($border_color !== ''){
					$style .= 'border-color:'.esc_attr($border_color).';';					
				}
				if($border_radius !== ''){
					$style .= 'border-radius:'.esc_attr($border_radius).'px;';					
				}
			}
			if($price_font !== ""){
				$pricing_style .= 'font-size:'.esc_attr($price_font).'px;';
			}
			if($price_color !== ""){
				$pricing_style .= 'color:'.esc_attr($price_color).';';
			}
			if($subtitle_font !== ""){
				$subtitle_style .= 'color:'.esc_attr($subtitle_font).';';
			}			
			if($subtitle_color !== ""){
				$subtitle_style .= 'font-size:'.esc_attr($subtitle_color).'px;';
			}
			
			$animate = $animation_data = '';

			if ( ! ( $module_animation == '' ) ) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "' . esc_attr($module_animation) . '" ';
			}
			
			$post_count = '12';
			$output .= '<div class="dfd-woocomposer_list woocommerce '.esc_attr($el_class).' '.esc_attr($animate).'" '.$animation_data.'>';
			/* $output .= do_shortcode($content); */
			$pattern = get_shortcode_regex();
			if($shortcode !== ''){
				$new_shortcode = rawurldecode( base64_decode( strip_tags( $shortcode ) ) );
			}
			preg_match_all("/".$pattern."/",$new_shortcode,$matches);
			$shortcode_str = str_replace('"','',str_replace(" ","&",trim($matches[3][0])));
			$short_atts = parse_str($shortcode_str);//explode("&",$shortcode_str);
			if(isset($matches[2][0])): $display_type = $matches[2][0]; else: $display_type = ''; endif;
			if(!isset($columns)): $columns = '4'; endif;
			if(isset($per_page)): $post_count = $per_page; endif;
			if(isset($number)): $post_count = $number; endif;
			if(!isset($order)): $order = 'ASC'; endif;
			if(!isset($orderby)): $orderby = 'date'; endif;
			if(!isset($category)): $category = ''; endif;
			if(!isset($ids)): $ids = ''; endif;
			if($ids){
				$ids = explode( ',', $ids );
				$ids = array_map( 'trim', $ids );
			}
			
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
						'terms' 		=> array( esc_attr( $category ) ),
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
			$query = new WP_Query( $args );
			$output .= '<ul class="dfd-woo-product-list '.$order.'">';
			if($query->have_posts()):
				while ( $query->have_posts() ) : $query->the_post();
					$product_id = get_the_ID();
					//$post = get_post($product_id);
					$product_title = get_the_title();
					
					$product = new WC_Product( $product_id );
					//$attachment_ids = $product->get_gallery_attachment_ids();
					$price = $product->get_price_html();
					$rating = $product->get_rating_html();
					//$product_var = new WC_Product_Variable( $product_id );
					//$available_variations = $product_var->get_available_variations();
					$cat_count = sizeof( get_the_terms( $product_id, 'product_cat' ) );
					if($subheading_content == 'subtitle') {
						$subtitle = DfdMetaBoxSettings::get('dfd_product_product_subtitle');
					} else {
						$subtitle = $product->get_categories(', ','<span class="posted_in">'._n('','',$cat_count,'woocommerce').' ','.</span>');
					}
				
						$output .= '<li>';
						
							$output .= $before_line;
							$output .= '<a href="'.get_permalink($product_id).'" class="box-name">';
							$output .= '<span style="'.$title_style.'">'.$product_title.'</span>';							
							$output .= '</a>';
							$output .= '<span class="woo-delim">-</span>';
							$output .= '<span class="amount" style="'.$pricing_style.'">'.$price.'</span>';
							$output .= $after_line;
							$output .= $before_line;
							$output .= '<span class="subtitle" style="'.$subtitle_style.'">'.$subtitle.'</span>';
							if($display_type == "top_rated_products"){						
								$output .= '<div>'.$rating.'</div>';
							}					
							$output .= $after_line;
					$output .= '</li>';
				endwhile;
			endif;
			$output .= "\n".'</ul>';
			$output .= "\n".'</div>';
			if($display_type == "top_rated_products"){
				remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			}
			wp_reset_postdata();
			return $output;
		}/* end woocomposer_list_shortcode */
	}
	new WooComposer_ViewList;
}
if(class_exists('WPBakeryShortCode'))
{
	class WPBakeryShortCode_woocomposer_list extends WPBakeryShortCode {
	}
}
