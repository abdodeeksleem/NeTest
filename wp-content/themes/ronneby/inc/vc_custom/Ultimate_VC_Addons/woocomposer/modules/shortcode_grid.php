<?php
/*
@Module: Grid Layout view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_GridView')){
	class WooComposer_GridView
	{
		function __construct(){
			add_action('admin_init',array($this,'woocomposer_init_grid'));
			add_shortcode('woocomposer_grid',array($this,'woocomposer_grid_shortcode'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				vc_map(
					array(
						'name'		=> __('Products Grid', 'woocomposer'),
						'base'		=> 'woocomposer_grid',
						'icon'		=> 'woo_grid',
						'class'	   => 'woo_grid',
						'category'  => __('WooComposer', 'woocomposer'),
						'description' => 'Display products in grid view',
						'controls' => 'full',
						'wrapper_class' => 'clearfix',
						'show_settings_on_create' => true,
						'params' => array(
							array(
								'type' => 'woocomposer',
								'class' => '',
								'heading' => __('Query Builder', 'woocomposer'),
								'param_name' => 'shortcode',
								'value' => '',
								'module' => 'grid',
								'labels' => array(
										'products_from'   => __('Display:','woocomposer'),
										'per_page'		=> __('How Many:','woocomposer'),
										'columns'		 => __('Columns:','woocomposer'),
										'order_by'		=> __('Order By:','woocomposer'),
										'order'		   => __('Loop Order:','woocomposer'),
										'category' 		=> __('Category:','woocomposer'),
								),
								'description' => __('', 'woocomposer'),
							),
							array(
								'type' => 'dropdown',
								'class' => '',
								'heading' => __('Select Products Style', 'dfd'),
								'param_name' => 'products_style',
								'admin_label' => true,
								'value' => array(
										__('Simple','dfd') => 'style-1',
										__('Advanced','dfd') => 'style-2',
										__('Full','dfd') => 'style-3',
									),
								'description' => __('', 'dfd'),
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_grid_shortcode($atts){
			extract(shortcode_atts(array(
				'product_style' => '',
			),$atts));
			$output = '';
			$uid = uniqid();
			$output = '<div id="woo-grid-'.esc_attr($uid).'" class="woocomposer_grid">';
			
			require_once('design-loop.php');
			$output .= Dfd_Woocommerce_Loop_module($atts);
			$output .= '</div>';
			return $output;
		}/* end woocomposer_grid_shortcode */
	} /* end class GridView */
	new WooComposer_GridView;
}