<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!function_exists('dfd_get_select_options_multi')) {
	function dfd_get_select_options_multi( $what = '') {
		$args = array(
			'type' => 'post',
			'hide_empty' => 0
		);

		$args['taxonomy'] = $what;
		$categories = get_categories( $args);

		$str = array();

		if(!empty($categories) && is_array($categories)) {
			foreach( $categories as $category ) {
				if(is_object($category)) {
					$str[$category->name] = $category->slug;
				}
			}
		}

		return $str;
	}
}

if(!function_exists('dfd_custom_taxonomy_item_select')) {
	function dfd_custom_taxonomy_item_select($what) {
		$args = array(
			'post_status' => 'publish',
			'post_type' => $what,
			'posts_per_page' => -1,
		);
		$query = new WP_Query($args);
		$items = array();
		if(!empty($query)) {
			foreach($query->posts as $post) {
				if (has_post_thumbnail($post->ID)) {
					$thumb_id = get_post_thumbnail_id($post->ID);
					$img_url = wp_get_attachment_url($thumb_id);
					$img = dfd_aq_resize($img_url, 120, 120, true, true, true);
					if(!$img) {
						$img = $img_url;
					}
				} else {
					$img = get_template_directory_uri() . '/assets/images/no_image_resized_120-120.jpg';
				}
				$items[$post->ID] = $img;
			}
		}

		return $items;
	}
}

if(!function_exists('dfd_vc_columns_to_string')) {
	function dfd_vc_columns_to_string ($str = 1) {
		$arr = array(1 => 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve');

		if( isset($arr[$str]) )	{
			return $arr[$str];
		} else {
			return 'six';
		}
	}
}

if(!function_exists('dfd_product_categories_select')) {
	function dfd_product_categories_select($backend = false) {
		$args = array(
			'taxonomy' => 'product_cat',
			'hide_empty' => true,
		);
		$categories = get_categories($args);
		$items = array();
		if(!empty($categories)) {
			foreach($categories as $category) {
				$item_meta = array();
				$category_image = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
				$category_image_url = wp_get_attachment_url($category_image);
				if($backend) {
					$category_image_url = dfd_aq_resize($category_image_url, 120, 120, true);
				}
				if(!$category_image_url) {
					$category_image_url = get_stylesheet_directory_uri().'/assets/images/no_image_resized_120-120.jpg';
				}
				$item_meta['name'] = $category->name;
				$item_meta['desc'] = $category->category_description;
				$item_meta['url'] = $category_image_url;
				$item_meta['cat_src'] = get_term_link(intval($category->term_id), 'product_cat');
				if($backend) {
					$items[$category->term_id] = $category_image_url;
				} else {
					$items[$category->term_id] = $item_meta;
				}
			}
		}

		return $items;
	}
}

if(!function_exists('dfd_soc_icons_hover_composer')) {
	function dfd_soc_icons_hover_composer() {
		$composer_styles = array();
		$defauls_styles = dfd_soc_icons_hover_style();
		if(!empty($defauls_styles) && is_array($defauls_styles)) {
			foreach($defauls_styles as $key => $val) {
				$composer_styles[$val] = $key;
			}
		}
		return $composer_styles;
	}
}

if(!function_exists('dfd_module_animation_styles')) {
	function dfd_module_animation_styles() {
		return array(
		   __( 'No Animation', 'dfd' )       => '',
		   __( 'FadeIn', 'dfd' )             => 'transition.fadeIn',
		   __( 'FlipXIn', 'dfd' )            => 'transition.flipXIn',
		   __( 'FlipYIn', 'dfd' )            => 'transition.flipYIn',
		   __( 'FlipBounceXIn', 'dfd' )      => 'transition.flipBounceXIn',
		   __( 'FlipBounceYIn', 'dfd' )      => 'transition.flipBounceYIn',
		   __( 'SwoopIn', 'dfd' )            => 'transition.swoopIn',
		   __( 'WhirlIn', 'dfd' )            => 'transition.whirlIn',
		   __( 'ShrinkIn', 'dfd' )           => 'transition.shrinkIn',
		   __( 'ExpandIn', 'dfd' )           => 'transition.expandIn',
		   __( 'BounceIn', 'dfd' )           => 'transition.bounceIn',
		   __( 'BounceUpIn', 'dfd' )         => 'transition.bounceUpIn',
		   __( 'BounceDownIn', 'dfd' )       => 'transition.bounceDownIn',
		   __( 'BounceLeftIn', 'dfd' )       => 'transition.bounceLeftIn',
		   __( 'BounceRightIn', 'dfd' )      => 'transition.bounceRightIn',
		   __( 'SlideUpIn', 'dfd' )          => 'transition.slideUpIn',
		   __( 'SlideDownIn', 'dfd' )        => 'transition.slideDownIn',
		   __( 'SlideLeftIn', 'dfd' )        => 'transition.slideLeftIn',
		   __( 'SlideRightIn', 'dfd' )       => 'transition.slideRightIn',
		   __( 'SlideUpBigIn', 'dfd' )       => 'transition.slideUpBigIn',
		   __( 'SlideDownBigIn', 'dfd' )     => 'transition.slideDownBigIn',
		   __( 'SlideLeftBigIn', 'dfd' )     => 'transition.slideLeftBigIn',
		   __( 'SlideRightBigIn', 'dfd' )    => 'transition.slideRightBigIn',
		   __( 'PerspectiveUpIn', 'dfd' )    => 'transition.perspectiveUpIn',
		   __( 'PerspectiveDownIn', 'dfd' )  => 'transition.perspectiveDownIn',
		   __( 'PerspectiveLeftIn', 'dfd' )  => 'transition.perspectiveLeftIn',
		   __( 'PerspectiveRightIn', 'dfd' ) => 'transition.perspectiveRightIn',
	   );
	}
}

// Removing shortcodes
if ( function_exists( 'vc_remove_element' ) ) {
	if(!isset($dfd_ronneby['enable_default_modules']) || strcmp($dfd_ronneby['enable_default_modules'], '1') !== 0) {
		/* Default modules */
		vc_remove_element('vc_wp_search');
		vc_remove_element('vc_wp_meta');
		vc_remove_element('vc_wp_recentcomments');
		vc_remove_element('vc_wp_calendar');
		vc_remove_element('vc_wp_pages');
		vc_remove_element('vc_wp_tagcloud');
		vc_remove_element('vc_wp_custommenu');
		vc_remove_element('vc_wp_text');
		vc_remove_element('vc_wp_posts');
		vc_remove_element('vc_wp_links');
		vc_remove_element('vc_wp_categories');
		vc_remove_element('vc_wp_archives');
		vc_remove_element('vc_wp_rss');
		vc_remove_element('vc_gallery');
		vc_remove_element('vc_teaser_grid');
		vc_remove_element('vc_button');
		vc_remove_element('vc_cta_button');
		vc_remove_element('vc_posts_grid');
		vc_remove_element('vc_images_carousel');
		vc_remove_element('vc_separator');
		vc_remove_element('vc_text_separator');
		vc_remove_element('vc_message');
		vc_remove_element('vc_facebook');
		vc_remove_element('vc_tweetmeme');
		vc_remove_element('vc_googleplus');
		vc_remove_element('vc_pinterest');
		vc_remove_element('vc_toggle');
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_button2');
		vc_remove_element('vc_cta_button2');
		vc_remove_element('vc_gmaps');
		vc_remove_element('vc_flickr');
		vc_remove_element('vc_progress_bar');
		vc_remove_element('vc_pie');
		vc_remove_element('vc_empty_space');
		vc_remove_element('vc_custom_heading');
		vc_remove_element('vc_basic_grid');
		vc_remove_element('vc_media_grid');
		vc_remove_element('vc_masonry_grid');
		vc_remove_element('vc_masonry_media_grid');
		vc_remove_element('vc_icon');
		vc_remove_element('vc_btn');
		vc_remove_element('vc_cta');
		vc_remove_element('vc_line_chart');
		vc_remove_element('vc_round_chart');
	}
	
	/* Woocommerce modules */
	if(!function_exists('dfd_vc_remove_woocommerce')) {
		function dfd_vc_remove_woocommerce() {
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				vc_remove_element( 'woocommerce_cart' );
				vc_remove_element( 'woocommerce_checkout' );
				vc_remove_element( 'woocommerce_order_tracking' );
				vc_remove_element( 'woocommerce_my_account' );
				vc_remove_element( 'product' );
				vc_remove_element( 'products' );
				vc_remove_element( 'add_to_cart' );
				vc_remove_element( 'add_to_cart_url' );
				vc_remove_element( 'product_page' );
//				vc_remove_element( 'product_category' );
				vc_remove_element( 'product_categories' );
//				vc_remove_element( 'recent_products' );
//				vc_remove_element( 'featured_products' );
//				vc_remove_element( 'sale_products' );
//				vc_remove_element( 'best_selling_products' );
//				vc_remove_element( 'top_rated_products' );
				vc_remove_element( 'product_attribute' );
			}
		}
	}
	
	add_action( 'vc_build_admin_page', 'dfd_vc_remove_woocommerce', 11 );
	
	add_action( 'vc_load_shortcode', 'dfd_vc_remove_woocommerce', 11 );
}

if ( function_exists( 'vc_set_template_dir' ) ) {
	$templates_path = get_template_directory() . '/inc/vc_custom/vc_templates/';
	vc_set_shortcodes_templates_dir( $templates_path );
}

if(function_exists('vc_remove_param')) {
	//vc_remove_param('vc_row','bg_image');
	//vc_remove_param('vc_row','bg_image');
	//vc_remove_param('vc_row','el_class');
	vc_remove_param('vc_row','bg_image_repeat');
	vc_remove_param('vc_row','font_color');
	vc_remove_param('vc_row','full_width');
	vc_remove_param('vc_row','el_id');
	vc_remove_param('vc_row','parallax');
	vc_remove_param('vc_row','parallax_image');
	//vc_remove_param('vc_row','full_height');
	//vc_remove_param('vc_row','content_placement');
	vc_remove_param('vc_row','video_bg');
	vc_remove_param('vc_row','video_bg_url');
	vc_remove_param('vc_row','video_bg_parallax');
	vc_remove_param('vc_video','title');
	vc_remove_param('vc_video','link');
	vc_remove_param('vc_tour','title');
	vc_remove_param('vc_single_image','onclick');
}

if(function_exists('vc_map')){
	class WPBakeryShortCode_Dfd_Side_By_Side_Slider  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Side by Side slider', 'dfd' ),
		'base' => 'dfd_side_by_side_slider',
		'as_parent' => array('only' => 'dfd_side_by_side_left,dfd_side_by_side_right'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => false,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));
	
	class WPBakeryShortCode_Dfd_Side_By_Side_Left  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Side by Side Left Container', 'dfd' ),
		'base' => 'dfd_side_by_side_left',
		'as_parent' => array('only' => 'dfd_side_by_side_slide'),
		'as_child' => array('only' => 'dfd_side_by_side_slider'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => false,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));

	class WPBakeryShortCode_Dfd_Side_By_Side_Right  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Side by Side Right Container', 'dfd' ),
		'base' => 'dfd_side_by_side_right',
		'as_parent' => array('only' => 'dfd_side_by_side_slide'),
		'as_child' => array('only' => 'dfd_side_by_side_slider'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => false,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));

	class WPBakeryShortCode_Dfd_Side_By_Side_Slide  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Side by Side Slider Item', 'dfd' ),
		'base' => 'dfd_side_by_side_slide',
		'admin_enqueue_css' => get_template_directory_uri() .'/inc/vc_custom/Ultimate_VC_Addons/admin/css/no-margin-css.css',
		'as_parent' => array('except' => 'dfd_side_by_side_slider, dfd_side_by_side_left, dfd_side_by_side_right, dfd_side_by_side_slide, vc_accordion, vc_tabs, vc_tour, dfd_scrolling_content, dfd_scrolling_content2 , dfd_equal_height_content, dfd_scrolling_effect'),
		'as_child' => array('only' => 'dfd_side_by_side_left, dfd_side_by_side_right'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => true,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'css_editor',
				'edit_field_class' => 'dfd_side_by_side_item_custom_class',
				'heading' => __( 'CSS box', 'js_composer' ),
				'param_name' => 'css',
				// 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
				'group' => __( 'Design Options', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'class' => '',
				'heading' => __('Select Slide Background Style', 'dfd'),
				'param_name' => 'slide_bg_check',
				'value' => array(
					__('Light background', 'dfd') => '',
					__('Dark background', 'dfd') => 'column-background-dark'
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));
	class WPBakeryShortCode_Dfd_Masonry_Container  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Masonry/Grid container', 'dfd' ),
		'base' => 'dfd_masonry_container',
		'as_parent' => array('only' => 'dfd_masonry_item'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => true,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'dropdown',
				'class' => '',
				'heading' => __('Select Layout mode', 'dfd'),
				'param_name' => 'layout_style',
				'value' => array(
					__('Masonry', 'dfd') => 'masonry',
					__('Grid', 'dfd') => 'fitRows'
				),
			),
			array(
				'type' => 'dropdown',
				'class' => '',
				'heading' => __('Enable sort panel', 'dfd'),
				'param_name' => 'enable_sort_panel',
				'value' => array(
					__('No', 'dfd') => 'disabled',
					__('Yes', 'dfd') => 'enabled',
				),
			),
			array(
				'type' => 'dropdown',
				'class' => '',
				'heading' => __('Sort panel alignment ', 'dfd'),
				'param_name' => 'sort_panel_alignment',
				'value' => array(
					__('Left', 'dfd') => 'text-left',
					__('Right', 'dfd') => 'text-right',
					__('Center', 'dfd') => 'text-center'
				),
				'dependency' => Array('element' => 'enable_sort_panel','value' => array('enabled')),
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Categories list', 'ultimate_vc' ),
				'param_name' => 'categories_strings',
				'description' => __('Enter each string on a new line','dfd'),
				'dependency' => Array('element' => 'enable_sort_panel','value' => array('enabled')),
				'admin_label' => true
			),
			array(
				'type' => 'number',
				'class' => '',
				'heading' => __('Number of columns for wide container', 'dfd'),
				'param_name' => 'columns_number_wide',
				'value' =>'5',
				'min'=>'1',
				'max'=>'8',
				'description' => __("Number of columns if container width more then 1280. Enter value between 1 to 8", 'dfd'),
			),
			array(
				'type' => 'number',
				'class' => '',
				'heading' => __('Number of columns for normal container', 'dfd'),
				'param_name' => 'columns_number_normal',
				'value' =>'4',
				'min'=>'1',
				'max'=>'8',
				'description' => __("Number of columns if container width more then 1024 and less then 1280. Enter value between 1 to 8", 'dfd'),
			),
			array(
				'type' => 'number',
				'class' => '',
				'heading' => __('Number of columns for medium container', 'dfd'),
				'param_name' => 'columns_number_medium',
				'value' =>'3',
				'min'=>'1',
				'max'=>'8',
				'description' => __("Number of columns if container width more then 800 and less then 1024. Enter value between 1 to 8", 'dfd'),
			),
			array(
				'type' => 'number',
				'class' => '',
				'heading' => __('Number of columns for small container', 'dfd'),
				'param_name' => 'columns_number_small',
				'value' =>'2',
				'min'=>'1',
				'max'=>'8',
				'description' => __("Number of columns if container width more then 460 and less then 800. Enter value between 1 to 8", 'dfd'),
			),
			array(
				'type' => 'number',
				'class' => '',
				'heading' => __('Number of columns for smartphones', 'dfd'),
				'param_name' => 'columns_number_mobile',
				'value' =>'1',
				'min'=>'1',
				'max'=>'8',
				'description' => __("Number of columns if container width less then 460. Enter value between 1 to 8", 'dfd'),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));
	
	class WPBakeryShortCode_Dfd_Masonry_Item  extends WPBakeryShortCodesContainer {}
	vc_map(array(
		'name' =>  __( 'Masonry/Grid item', 'dfd' ),
		'base' => 'dfd_masonry_item',
		'as_parent' => array('except' => 'dfd_masonry_container, dfd_masonry_item, dfd_side_by_side_slider, dfd_side_by_side_left, dfd_side_by_side_right, dfd_side_by_side_slide, vc_accordion, vc_tabs, vc_tour, dfd_scrolling_content, dfd_scrolling_content2 , dfd_equal_height_content, dfd_scrolling_effect'),
		'as_child' => array('only' => 'dfd_masonry_container'),
		'content_element' => true,
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'show_settings_on_create' => true,
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Category title', 'dfd'),
				'param_name' => 'data_category',
				'description' => __('Please enter the title of the category in sort panel for this item', 'dfd')
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));
        require_once locate_template('/inc/user_form/user_form_manager.php');
        class WPBakeryShortCode_Dfd_User_Form  extends WPBakeryShortCode {}
	vc_map(array(
		'name' =>  __( 'User Form', 'dfd' ),
		'base' => 'dfd_user_form',
		'category' => 'DFD VC Addons',
		'icon' => 'ultimate_carousel',
		'params' => Dfd_User_Form_Manager::instance()->getParams()
	));
}

/* VC settings */
if(function_exists('vc_add_param')){
	vc_add_param(
		'vc_row', array(
			'type' => 'textfield',
			'class' => '',
			'heading' => __('Extra CSS Styles', 'dfd'),
			'param_name' => 'extra_css_styles',
			'value' => '',
		)
	);
	vc_add_param(
		'vc_row', array(
			'type' => 'textfield',
			'class' => '',
			'heading' => __('Title for one page scroll layout navigation', 'dfd'),
			'param_name' => 'one_page_title',
			'value' => '',
		)
	);
	vc_add_param(
		'vc_row', array(
			'type' => 'textfield',
			'class' => '',
			'heading' => __('Anchor', 'dfd'),
			'param_name' => 'anchor',
			'value' => '',
		)
	);
	vc_add_param("vc_row", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Select Row Delimiter Style",
			"param_name" => "row_delimiter",
			"value" => dfd_vc_delimiter_styles(),
		));
	vc_add_param('vc_row',array(
			'type' => 'colorpicker',
			'class' => '',
			'heading' => __('Delimiter Background Color', 'dfd'),						
			'param_name' => 'delimiter_bg_color_value',
			//"description" => __('At least two color points should be selected. <a href="https://www.youtube.com/watch?v=yE1M4AKwS44" target="_blank">Video Tutorial</a>', 'dfd'),
			'dependency' => array('element' => 'row_delimiter','value' => array('12')),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Delimiter height', 'dfd'),
			'param_name' => 'delimiter_height',
			'value' =>'150',
			'min'=>'1',
			'max'=>'500',
			'description' => __('Control speed of parallax. Enter value between 1 to 500', 'dfd'),
			'dependency' => array('element' => 'row_delimiter','value' => array('12')),
		)
	);
	vc_add_param("vc_row", array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Row effect', 'dfd'),
			'param_name' => 'row_effect',
			'value' => array(
				__('None', 'dfd') => '',
				__('Fade on scroll', 'dfd') => 'dfd-fade-on-scroll'
			),
		)
	);
	vc_add_param("vc_row", array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Select Row Background Style', 'dfd'),
			'param_name' => 'bg_check',
			'value' => array(
				__('Light background', 'dfd') => '',
				__('Dark background', 'dfd') => 'row-background-dark'
			),
		)
	);
	vc_add_param("vc_row", array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Force equal height columns', 'dfd'),
			'param_name' => 'force_equal_height_columns',
			'value' => array(
				__('No', 'dfd') => 'no',
				__('Yes', 'dfd') => 'main_row',
				//__('Yes, for child row', 'dfd') => 'child_row',
			),
		)
	);
	vc_add_param("vc_row", array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Align content vertically', 'dfd'),
			'param_name' => 'align_content_vertically',
			'value' => array(__('Yes, please', 'dfd') => 'yes'),
			"dependency" => array("element" => "force_equal_height_columns","value" => array('main_row', 'child_row')),
		)
	);
	vc_add_param("vc_row", array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Destroy equal heights on mobile devices', 'dfd'),
			'param_name' => 'mobile_destroy_equal_heights',
			'value' => array(__('Yes, please', 'dfd') => 'yes'),
			"dependency" => array("element" => "force_equal_height_columns","value" => array('main_row', 'child_row')),
		)
	);
	vc_add_param('vc_row', array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Select Content Width', 'dfd'),
			'param_name' => 'dfd_row_config',
			'value' => array(
				__('Default', 'dfd') => '',
				__('3px column paddings grid', 'dfd') => 'default_row_small_paddings',
				__('No paddings grid', 'dfd') => 'default_row_no_paddings',
				__('Full Width Content', 'dfd') => 'full_width_content',
				__('Full Width Content With 3px Column Paddings', 'dfd') => 'full_width_small_paddings',
				__('Full Width Content With paddings', 'dfd') => 'full_width_content_paddings',
			),
		)
	);
	vc_add_param('vc_row', array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Row content parallax effect', 'dfd'),
			'param_name' => 'dfd_row_parallax',
			'value' => array(
				__('Disable', 'dfd') => '',
				__('Enable', 'dfd') => 'dfd-row-parallax',
			),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Parallax Speed', 'dfd'),
			'param_name' => 'row_parallax_sense',
			'value' =>'30',
			'min'=>'1',
			'max'=>'100',
			'description' => __("Control speed of parallax. Enter value between 1 to 100", 'dfd'),
			'dependency' => Array("element" => "dfd_row_parallax","value" => array('dfd-row-parallax')),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Parallax limit', 'dfd'),
			'param_name' => 'row_parallax_limit',
			'value' =>'',
			'min'=>'50',
			'max'=>'400',
			'description' => __("Module shift limit. Enter value between 50 to 400. Units - px.", 'dfd'),
			'dependency' => Array("element" => "dfd_row_parallax","value" => array('dfd-row-parallax')),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Pre-built responsive settings', 'dfd'),
			'param_name' => 'row_prebuilt_classes',
			'edit_field_class' => 'dfd_vc_hide',
			'value' => array(
					__('None', 'dfd') => '',
					__('Remove left border on mobiles', 'dfd') => 'dfd-mobile-remove-left-border',
					__('Remove right border on mobiles', 'dfd') => 'dfd-mobile-remove-right-border',
					__('Remove top border on mobiles', 'dfd') => 'dfd-mobile-remove-top-border',
					__('Remove bottom border on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-border',
					__('Remove all borders on mobiles', 'dfd') => 'dfd-mobile-remove-all-borders',
					__('Remove left padding on mobiles', 'dfd') => 'dfd-mobile-remove-left-padding',
					__('Remove right padding on mobiles', 'dfd') => 'dfd-mobile-remove-right-padding',
					__('Remove top padding on mobiles', 'dfd') => 'dfd-mobile-remove-top-padding',
					__('Remove bottom padding on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-padding',
					__('Remove all paddings on mobiles', 'dfd') => 'dfd-mobile-remove-all-paddings',
					__('Remove left margin on mobiles', 'dfd') => 'dfd-mobile-remove-left-margin',
					__('Remove right margin on mobiles', 'dfd') => 'dfd-mobile-remove-right-margin',
					__('Remove top margin on mobiles', 'dfd') => 'dfd-mobile-remove-top-margin',
					__('Remove bottom margin on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-margin',
					__('Remove all margins on mobiles', 'dfd') => 'dfd-mobile-remove-all-margins',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Remove css rule on mobiles', 'dfd'),
			'param_name' => 'row_responsive_mobile_classes',
			'edit_field_class' => 'dfd_vc_responsive',
			'value' => array(
					__('Left border', 'dfd') => 'dfd-remove-left-border',
					__('Right border', 'dfd') => 'dfd-remove-right-border',
					__('Top border', 'dfd') => 'dfd-remove-top-border',
					__('Bottom border', 'dfd') => 'dfd-remove-bottom-border',
					//__('Remove all borders on mobiles', 'dfd') => 'dfd-remove-all-borders',
					__('Left padding', 'dfd') => 'dfd-remove-left-padding',
					__('Right padding', 'dfd') => 'dfd-remove-right-padding',
					__('Top padding', 'dfd') => 'dfd-remove-top-padding',
					__('Bottom padding', 'dfd') => 'dfd-remove-bottom-padding',
					//__('Remove all paddings on mobiles', 'dfd') => 'dfd-remove-all-paddings',
					__('Left margin', 'dfd') => 'dfd-remove-left-margin',
					__('Right margin', 'dfd') => 'dfd-remove-right-margin',
					__('Top margin', 'dfd') => 'dfd-remove-top-margin',
					__('Bottom margin', 'dfd') => 'dfd-remove-bottom-margin',
					//__('Remove all margins on mobiles', 'dfd') => 'dfd-mobile-remove-all-margins',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param('vc_row',array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Apply those rules for devices', 'dfd'),
			'param_name' => 'row_responsive_mobile_resolutions',
			'edit_field_class' => 'dfd_vc_responsive',
			'value' => array(
					__('Semi-wide desktops', 'dfd') => 'dfd-apply-desktop',
					__('Laptops', 'dfd') => 'dfd-apply-laptop',
					__('Tablets', 'dfd') => 'dfd-apply-tablet',
					__('Mobiles', 'dfd') => 'dfd-apply-mobile',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param("vc_column", array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Select Column Background Style', 'dfd'),
			'param_name' => 'column_bg_check',
			'value' => array(
				__('Light background', 'dfd') => '',
				__('Dark background', 'dfd') => 'column-background-dark'
			),
		));
	vc_add_param('vc_column', array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Column content parallax effect', 'dfd'),
			'param_name' => 'column_parallax',
			'value' => array(
				__('Disable', 'dfd') => '',
				__('Enable', 'dfd') => 'dfd-column-parallax',
			),
		));
	vc_add_param('vc_column',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Parallax Speed', 'upb_parallax'),
			'param_name' => 'column_parallax_sense',
			'value' =>'30',
			'min'=>'-200',
			'max'=>'200',
			'description' => __("Control speed of parallax. Enter value between -200 to 200", 'dfd'),
			'dependency' => Array("element" => "column_parallax","value" => array('dfd-column-parallax')),
		)
	);
	vc_add_param('vc_column',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Parallax limit', 'dfd'),
			'param_name' => 'column_parallax_limit',
			'value' =>'',
			'min'=>'50',
			'max'=>'400',
			'description' => __("Module shift limit. Enter value between 50 to 400. Units - px.", 'dfd'),
			'dependency' => Array("element" => "column_parallax","value" => array('dfd-column-parallax')),
		)
	);
	vc_add_param('vc_column',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Pre-built responsive settings', 'dfd'),
			'param_name' => 'column_prebuilt_classes',
			'edit_field_class' => 'dfd_vc_hide',
			'value' => array(
					__('None', 'dfd') => '',
					__('Remove left border on mobiles', 'dfd') => 'dfd-mobile-remove-left-border',
					__('Remove right border on mobiles', 'dfd') => 'dfd-mobile-remove-right-border',
					__('Remove top border on mobiles', 'dfd') => 'dfd-mobile-remove-top-border',
					__('Remove bottom border on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-border',
					__('Remove all borders on mobiles', 'dfd') => 'dfd-mobile-remove-all-borders',
					__('Remove left padding on mobiles', 'dfd') => 'dfd-mobile-remove-left-padding',
					__('Remove right padding on mobiles', 'dfd') => 'dfd-mobile-remove-right-padding',
					__('Remove top padding on mobiles', 'dfd') => 'dfd-mobile-remove-top-padding',
					__('Remove bottom padding on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-padding',
					__('Remove all paddings on mobiles', 'dfd') => 'dfd-mobile-remove-all-paddings',
					__('Remove left margin on mobiles', 'dfd') => 'dfd-mobile-remove-left-margin',
					__('Remove right margin on mobiles', 'dfd') => 'dfd-mobile-remove-right-margin',
					__('Remove top margin on mobiles', 'dfd') => 'dfd-mobile-remove-top-margin',
					__('Remove bottom margin on mobiles', 'dfd') => 'dfd-mobile-remove-bottom-margin',
					__('Remove all margins on mobiles', 'dfd') => 'dfd-mobile-remove-all-margins',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param('vc_column',array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Remove css rule on mobiles', 'dfd'),
			'param_name' => 'column_responsive_mobile_classes',
			'edit_field_class' => 'dfd_vc_responsive',
			'value' => array(
					__('Left border', 'dfd') => 'dfd-remove-left-border',
					__('Right border', 'dfd') => 'dfd-remove-right-border',
					__('Top border', 'dfd') => 'dfd-remove-top-border',
					__('Bottom border', 'dfd') => 'dfd-remove-bottom-border',
					//__('Remove all borders on mobiles', 'dfd') => 'dfd-remove-all-borders',
					__('Left padding', 'dfd') => 'dfd-remove-left-padding',
					__('Right padding', 'dfd') => 'dfd-remove-right-padding',
					__('Top padding', 'dfd') => 'dfd-remove-top-padding',
					__('Bottom padding', 'dfd') => 'dfd-remove-bottom-padding',
					//__('Remove all paddings on mobiles', 'dfd') => 'dfd-remove-all-paddings',
					__('Left margin', 'dfd') => 'dfd-remove-left-margin',
					__('Right margin', 'dfd') => 'dfd-remove-right-margin',
					__('Top margin', 'dfd') => 'dfd-remove-top-margin',
					__('Bottom margin', 'dfd') => 'dfd-remove-bottom-margin',
					//__('Remove all margins on mobiles', 'dfd') => 'dfd-remove-all-margins',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param('vc_column',array(
			'type' => 'checkbox',
			'class' => '',
			'heading' => __('Apply those rules for devices', 'dfd'),
			'param_name' => 'column_responsive_mobile_resolutions',
			'edit_field_class' => 'dfd_vc_responsive',
			'value' => array(
					__('Laptops', 'dfd') => 'dfd-apply-laptop',
					__('Tablets', 'dfd') => 'dfd-apply-tablet',
					__('Mobiles', 'dfd') => 'dfd-apply-mobile',
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'group' => __( 'Responsive Options', 'js_composer' ),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Video mode', 'dfd'),
			'param_name' => 'video_module_mode',
			'value' => array(
					__('Simple video', 'dfd') => 'simple',
					__('Full screen video', 'dfd') => 'full_screen'
				),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'textfield',
			'heading' => __( 'Video link', 'js_composer' ),
			'param_name' => 'link',
			'admin_label' => true,
			'description' => sprintf( __( 'Link to the video. More about supported formats at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>' ),
			'dependency' => array('element' => 'video_module_mode','value' => array('simple')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'attach_image',
			'class' => '',
			'heading' => __('Thumbnail Image', 'dfd'),
			'param_name' => 'video_thumb_image',
			'value' => '',
			'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'dependency' => array('element' => 'video_module_mode','value' => array('simple')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Video source', 'dfd'),
			'param_name' => 'video_source',
			'value' => array(
					__('Youtube', 'dfd') => 'youtube',
					__('Vimeo', 'dfd') => 'vimeo'
				),
			//'description' => __('Upload or select video thumbnail image from media gallery.', 'dfd'),
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'textfield',
			'heading' => __( 'Video ID', 'dfd' ),
			'param_name' => 'video_id',
			'admin_label' => true,
			//'description' => __( '', 'dfd' ),
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Label Alignment','dfd'),
			'param_name' => 'module_alignment',
			"value" => array(
				__('Left','dfd') => "text-left",
				__('Center','dfd') => "text-center",
				__('Right','dfd') => "text-right"
			),
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'colorpicker',
			'class' => '',
			'heading' => __('Icon color', 'dfd'),
			'param_name' => 'icon_color',
			'value' => '#ffffff',
			'description' => __('', 'dfd'),	
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'colorpicker',
			'class' => '',
			'heading' => __('Label background', 'dfd'),
			'param_name' => 'label_background',
			'value' => '#323232',
			'description' => __('', 'dfd'),	
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'dfd' ),
			'param_name' => 'video_title',
			'admin_label' => true,
			'description' => __( 'Short description', 'dfd' ),
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_video',array(
			'type' => 'textfield',
			'heading' => __( 'Description', 'dfd' ),
			'param_name' => 'description',
			'admin_label' => true,
			'description' => __( 'Short description', 'dfd' ),
			'dependency' => array('element' => 'video_module_mode','value' => array('full_screen')),
		)
	);
	vc_add_param('vc_tour',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Tabs alignment','dfd'),
			'param_name' => 'tabs_alignment',
			"value" => array(
				__('Left','dfd') => 'dfd-left-tabs',
				__('Right','dfd') => 'dfd-right-tabs'
			),
		)
	);
	vc_add_param('vc_accordion',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Alignment','dfd'),
			'param_name' => 'titles_alignment',
			"value" => array(
				__('Left','dfd') => "text-left",
				__('Center','dfd') => "text-center",
				__('Right','dfd') => "text-right"
			),
		)
	);
	vc_add_param('vc_accordion',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Item Animation','dfd'),
			'param_name' => 'item_animation',
			'value'       => dfd_module_animation_styles(),
			'description' => __('', 'dfd'),
			'group'=> 'Animation',
		)
	);
	vc_add_param('vc_column_text',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Item Animation','dfd'),
			'param_name' => 'item_animation',
			'value'       => dfd_module_animation_styles(),
			'description' => __('', 'dfd'),
			'group'=> 'Animation',
		)
	);
	vc_add_param('vc_single_image',array(
			'type' => 'number',
			'class' => '',
			'heading' => __('Image opacity', 'dfd'),
			'param_name' => 'image_opacity',
			'value' =>'',
			'min'=>'0',
			'max'=>'100',
			'description' => __('Image opacity. Units - %.', 'dfd'),
		)
	);
	vc_add_param('vc_single_image',array(
			'type' => 'dropdown',
			'heading' => __( 'On click action', 'js_composer' ),
			'param_name' => 'onclick',
			'value' => array(
				__( 'None', 'js_composer' ) => '',
				__( 'Use as navigation for One Page Scroll Page template', 'js_composer' ) => 'link_one_page',
				__( 'Link to large image', 'js_composer' ) => 'img_link_large',
				__( 'Open prettyPhoto', 'js_composer' ) => 'link_image',
				__( 'Open custom link', 'js_composer' ) => 'custom_link',
				__( 'Zoom', 'js_composer' ) => 'zoom',
			),
			'description' => __( 'Select action for click action.', 'js_composer' ),
			'std' => '',
		)
	);
	vc_add_param('vc_single_image',array(
			'type' => 'dropdown',
			'heading' => __( 'Go to:', 'dfd' ),
			'param_name' => 'link_one_page_value',
			'description' => __( 'Specifies the direction of one-page template on click', 'dfd' ),
			'value' => array(
				__( 'None', 'dfd' ) => '',
				__( 'Previous page', 'dfd' ) => 'slickPrev',
				__( 'Next page', 'dfd' ) => 'slickNext'
			),
			'dependency' => Array('element' => 'onclick','value' => array('link_one_page')),
		)
	);
	vc_add_param('vc_single_image',array(
			'type' => 'dropdown',
			'class' => '',
			'heading' => __('Item Animation','dfd'),
			'param_name' => 'item_animation',
			'value'       => dfd_module_animation_styles(),
			'description' => __('', 'dfd'),
			'group'=> 'Animation',
		)
	);
}