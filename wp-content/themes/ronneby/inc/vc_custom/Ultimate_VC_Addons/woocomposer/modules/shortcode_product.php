<?php
/*
@Module: Single Product view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_ViewProduct')){
	class WooComposer_ViewProduct
	{
		function __construct(){
			add_action('admin_init',array($this,'WooComposer_Init_Product'));
			add_shortcode('woocomposer_product',array($this,'WooComposer_Product'));
		} 
		function WooComposer_Init_Product(){
			if(function_exists('vc_map')){
				$params =
					array(
						'name'		=> __('Single Product', 'dfd'),
						'base'		=> 'woocomposer_product',
						'icon'		=> 'woo_product',
						'class'	   => 'woo_product',
						'category'  => __('WooComposer', 'dfd'),
						'description' => 'Display single product from list',
						'controls' => 'full',
						'show_settings_on_create' => true,
						'params' => array(
							array(
								'type' => 'product_search',
								'class' => '',
								'heading' => __('Select Product', 'dfd'),
								'param_name' => 'product_id',
								'admin_label' => true,
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'dropdown',
								'class' => '',
								'heading' => __('Select Product Style', 'dfd'),
								'param_name' => 'product_style',
								'admin_label' => true,
								'value' => array(
										__('Simple product','dfd') => 'style-1',
										__('Full width image hover description','dfd') => 'style-2',
									),
								'description' => __('', 'dfd'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'dropdown',
								'heading' => __('Enable product image', 'dfd'),
								'param_name' => 'enable_product_image',
								'value' => array(
									__('No', 'dfd') => '',
									__('Yes', 'dfd') => 'yes',
								),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'dropdown',
								'class' => '',
								'heading' => __('Select Product Style', 'dfd'),
								'param_name' => 'image_selector',
								'admin_label' => true,
								'value' => array(
										__('Product thumbnail','dfd') => 'thumb',
										__('Custom uploaded image','dfd') => 'custom_image',
									),
								'description' => __('', 'dfd'),
								'dependency' => Array('element' => 'enable_product_image', 'value' => array('yes')),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'attach_image',
								'class' => '',
								'heading' => __('Custom product image','dfd'),
								'param_name' => 'custom_image',
								'value' => '',
								'description' => __('Upload the custom product image','dfd'),
								'dependency' => Array('element' => 'image_selector', 'value' => array('custom_image')),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Image width', 'dfd'),
								'param_name' => 'image_width',
								'value' => '',
								'min' => 0,
								'max' => 1920,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'dependency' => Array('element' => 'enable_product_image', 'value' => array('yes')),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Image height', 'dfd'),
								'param_name' => 'image_height',
								'value' => '',
								'min' => 0,
								'max' => 1920,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'dependency' => Array('element' => 'enable_product_image', 'value' => array('yes')),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Description limit', 'dfd'),
								'param_name' => 'desc_limit',
								'value' => '',
								'min' => 0,
								'max' => 55,
								'description' => __('Please specify the number of words of product description you would like to be displayed on the page', 'dfd'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Product Title','dfd'),
								'param_name' => 'enable_title',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Subtitle','dfd'),
								'param_name' => 'enable_cat_tag',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Rating','dfd'),
								'param_name' => 'enable_rating',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Price','dfd'),
								'param_name' => 'enable_price',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Description','dfd'),
								'param_name' => 'enable_description',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Add to Cart','dfd'),
								'param_name' => 'enable_add_to_cart',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Wishlist','dfd'),
								'param_name' => 'enable_wishlist',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable Quick-View','dfd'),
								'param_name' => 'enable_quick_view',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Show Add to cart button by default','dfd'),
								'param_name' => 'enable_button_default',
								'value' => array('Yes, please' => 'yes'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'dropdown',
								'heading' => __('Information Alignment', 'dfd'),
								'param_name' => 'info_alignment',
								'value' => array(
									__('Left', 'dfd') => 'text-left',
									__('Center', 'dfd') => 'text-center',
									__('Right', 'dfd') => 'text-right'
								),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Background', 'dfd'),
								'param_name' => 'background_color',
								'value' => '',
								'description' => __('', 'dfd'),
								'dependency' => Array('element' => 'product_style', 'value' => array('style-1')),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'textfield',
								'heading' => __('Extra class name', 'js_composer'),
								'param_name' => 'el_class',
								'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'dropdown',
								'class' => '',
								'heading' => __('Enable Custom Styling Settings', 'dfd'),
								'param_name' => 'enable_custom_settings',
								'admin_label' => true,
								'value' => array(
										__('No','dfd') => 'no',
										__('Yes','dfd') => 'yes',
									),
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Product Title', 'dfd'),
								'param_name' => 'size_title',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								"type" => "dropdown",
								"heading" 		=>	__("Font Style", 'dfd'),
								"param_name"	=>	"main_heading_default_style",
								'value' => array(
									__('Normal', 'dfd')	=>	'normal',
									__('Italic','dfd')		=>	'italic',
									__('Inherit','dfd')		=>	'inherit',
									__('Initial','dfd')		=>	'initial',
								),
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
								'group' => 'Style Settings',
							),
							array(
								"type" => "dropdown",
								"heading" 		=>	__("Font Style", 'dfd'),
								"param_name"	=>	"main_heading_text_transform",
								'value' => array(
									__('None','dfd')		=>	'none',
									__('Capitalize', 'dfd')	=>	'capitalize',
									__('Lowercase','dfd')		=>	'lowercase',
									__('Uppercase','dfd')		=>	'uppercase',
									__('Ihnerit','dfd')		=>	'inherit',
								),
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
								'group' => 'Style Settings',
							),
							array(
								"type" => "dropdown",
								"heading" 		=>	__("Font Weight", 'dfd'),
								"param_name"	=>	"main_heading_default_weight",
								'value' => array(
									__('Default', 'dfd')	=>	'',
									'100'	=>	'100',
									'200'	=>	'200',
									'300'	=>	'300',
									'500'	=>	'500',
									'600'	=>	'600',
									'700'	=>	'700',
									'800'	=>	'800',
									'900'	=>	'900',
								),
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
								'group' => 'Style Settings',
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Title Line Height", 'dfd'),
								"param_name" => "main_heading_line_height",
								"value" => "",
								"suffix" => "px",
								//"description" => __("Main heading color", 'dfd'),	
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
								'group' => 'Style Settings',
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Title Letter spacing", 'dfd'),
								"param_name" => "main_heading_letter_spacing",
								"value" => "",
								"suffix" => "px",
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
								'group' => 'Style Settings',
								//"description" => __("Main heading color", 'dfd'),	
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Product Title Color', 'dfd'),
								'param_name' => 'color_heading',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Subtitle font-size', 'dfd'),
								'param_name' => 'size_cat',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Subtitle Color', 'dfd'),
								'param_name' => 'color_categories',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Price', 'dfd'),
								'param_name' => 'size_price',
								'value' => '',
								'min' => 10,
								'max' => 72,
								'suffix' => 'px',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Price Color', 'dfd'),
								'param_name' => 'color_price',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Product Description Text Color', 'dfd'),
								'param_name' => 'color_product_desc',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Initial Settings',
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Star Ratings Color', 'dfd'),
								'param_name' => 'color_rating',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Star Rating Background Color', 'dfd'),
								'param_name' => 'color_rating_bg',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Sale Notification Text Color', 'dfd'),
								'param_name' => 'color_on_sale',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
							),
							array(
								'type' => 'colorpicker',
								'class' => '',
								'heading' => __('Sale Notification Background Color', 'dfd'),
								'param_name' => 'color_on_sale_bg',
								'value' => '',
								'description' => __('', 'dfd'),
								'group' => 'Style Settings',
								'dependency' => Array('element' => 'enable_custom_settings', 'value' => array('yes')),
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
						)
					);
				vc_map($params);
			}
		} 
		function WooComposer_Product($atts){
			extract($atts);
			
			$output = '';
			
			/*ob_start();
			$output .= '<div class="woocommerce woo-msg">';
			wc_print_notices();
			$output .= ob_get_clean();
			$output .= '</div>';*/
			
			require_once('design-single.php');
			$output .= Dfd_WooComposer_Single($atts);
			
			return $output;
						
		} 
	}
	new WooComposer_ViewProduct;
}