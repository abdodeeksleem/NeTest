<?php
/*
@Module: Category Grid Layout
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_Single_Cat')){
	class WooComposer_Single_Cat
	{
		function __construct(){
			add_action('admin_init',array($this,'woocomposer_init_single_cat'));
			add_shortcode('woocomposer_single_cat',array($this,'woocomposer_single_cat_shortcode'));
		} /* end constructor */
		function woocomposer_init_single_cat(){
			if(function_exists('vc_map')){
				$orderby_arr = array(
					"Date" => "date",
					"Title" => "title",
					"Product ID" => "ID",
					"Name" => "name",
					"Price" => "price",
					"Sales" => "sales",
					"Random" => "rand",
				);
				vc_map(
					array(
						'name'		=> __('Single Product Category', 'dfd'),
						'base'		=> 'woocomposer_single_cat',
						'icon'		=> 'woo_grid',
						'class'	   => 'woo_grid',
						'category'  => __('WooComposer', 'dfd'),
						'description' => 'Display categories in grid view',
						'controls' => 'full',
						'wrapper_class' => 'clearfix',
						'show_settings_on_create' => true,
						'params' => array(
							array(
								'type' => 'radio_image_box',
								'heading' => __('Select products category to display','dfd'),
								'param_name' => 'single_category_item',
								'value' => '',
								'options' => dfd_product_categories_select(true),
								'css' => array(
									'width' => '120px',
									'height' => '120px',
									'background-repeat' => 'repeat',
									'background-size' => 'cover' 
								),
								'show_default' => false,
								//'description' => __('Select portfolio item to display', 'dfd'),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Title Color', 'dfd'),
								'param_name' => 'color_heading',
								'value' => '',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Title size', 'dfd'),
								'param_name' => 'size_title',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Subtitle Color', 'dfd'),
								'param_name' => 'color_subtitle',
								'value' => '',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Subtitle size', 'dfd'),
								'param_name' => 'size_subtitle',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Image width', 'dfd'),
								'param_name' => 'image_width',
								'value' => 500,
								'min' => 50,
								'max' => 1920,
								'suffix' => '',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Image height', 'dfd'),
								'param_name' => 'image_height',
								'value' => 500,
								'min' => 50,
								'max' => 1920,
								'suffix' => '',
								'description' => __('', 'dfd'),
							),
							array(
								'type' => 'textfield',
								'heading' => __('Extra class name', 'js_composer'),
								'param_name' => 'el_class',
								'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Animation", 'dfd' ),
								"param_name"  => "module_animation",
								"value"       => dfd_module_animation_styles(),
								"description" => __( "", 'dfd' ),
								"group"       => "Animation Settings",
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_single_cat */
		function woocomposer_single_cat_shortcode($atts){
			$color_heading = $size_title = $color_subtitle = $size_subtitle = $single_category_item = $image_width = $image_height = $output = $module_animation = $el_class = '';
			extract( shortcode_atts( array(
				'color_heading'     => '',
				'size_title'     => '',
				'color_subtitle'     => '',
				'size_subtitle'     => '',
				'single_category_item'     => '',
				'image_width' => '',
				'image_height' => '',
				'el_class' => '',
				'module_animation' => '',
			), $atts ) );
			
			$title_css = $subtitle_css = '';
			
			$animate = $animation_data = '';

			if ( ! ( $module_animation == '' ) ) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "' . esc_attr($module_animation) . '" ';
			}
			
			if(!empty($size_title)) {
				$title_css .= 'font-size: '.esc_attr($size_title).'px;';
			}
			
			if(!empty($color_heading)) {
				$title_css .= 'color: '.esc_attr($color_heading).';';
			}
			
			if(!empty($size_subtitle)) {
				$subtitle_css .= 'font-size: '.esc_attr($size_subtitle).'px;';
			}
			
			if(!empty($color_subtitle)) {
				$subtitle_css .= 'color: '.esc_attr($color_subtitle).';';
			}
			
			if($image_width == '') {
				$image_width = 500;
			}
			
			if($image_height == '') {
				$image_height = 500;
			}
	
			if(!empty($single_category_item)) :
				$categories_meta = dfd_product_categories_select();
				$image_url = dfd_aq_resize($categories_meta[$single_category_item]['url'], $image_width, $image_height, true, true, true);
				if(!$image_url) {
					$image_url = $categories_meta[$single_category_item]['url'];
				}
				
				ob_start();
				?>
				<div class="dfd-woo-single-category clearfix <?php echo esc_attr($el_class); ?> <?php echo esc_attr($animate); ?>" <?php echo $animation_data; ?>>
					<div class="left">
						<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($categories_meta[$single_category_item]['name']); ?>" />
						<div class="dfd-heading">
							<div class="inline-block">
								<div class="box-name" <?php echo !empty($title_css) ? 'style="'.$title_css.'"' : ''; ?>><a href="<?php echo esc_url($categories_meta[$single_category_item]['cat_src']); ?>" title=""><?php echo $categories_meta[$single_category_item]['name']; ?></a></div>
								<div class="subtitle mobile-hide" <?php echo !empty($subtitle_css) ? 'style="'.$subtitle_css.'"' : ''; ?>><?php echo $categories_meta[$single_category_item]['desc']; ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php
				$output .= ob_get_clean();
			endif;
			
			return $output;
		}/* end woocomposer_single_cat_shortcode */
	} /* end class WooComposer_Single_Cat */
	new WooComposer_Single_Cat;
}