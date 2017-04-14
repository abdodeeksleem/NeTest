<?php
/**
 * Eight themes functions
 */

define('DFD_THEME_SETTINGS_NAME', 'ronneby');

if (!isset($content_width)) $content_width = 1200;

# Including theme components
require_once locate_template('/inc/includes.php');

add_action('after_setup_theme', 'dfd_eight_setup_theme');

if (!function_exists('dfd_eight_setup_theme')) {
	function dfd_eight_setup_theme() {

		// Enqueue theme scripts and styles
		add_action('wp_enqueue_scripts', 'dfd_kadabra_enq_fonts');
		add_action('wp_enqueue_scripts', 'dfd_kadabra_scripts', 100);
		
		// Enqueue admin scripts and styles
		add_action('admin_enqueue_scripts', 'dfd_kadabra_admin_css');

		// Template Wrapping
		add_filter( 'template_include', array( 'DFD_Wrapping', 'wrap' ), 99 );
		
		add_filter('wp_get_attachment_link', 'dfd_kadabra_prettyadd');
		
		add_filter('widget_text', 'do_shortcode');
		
		add_filter('excerpt_length', 'dfd_kadabra_excerpt_length', 999 );
		add_filter('next_posts_link_attributes', 'dfd_kadabra_posts_link_attributes_1');
		add_filter('previous_posts_link_attributes', 'dfd_kadabra_posts_link_attributes_2');
		add_filter('mce_buttons','dfd_next_page_button');
		
		// Disable default gallery style
		add_filter( 'use_default_gallery_style' , 'dfd_kadabra_use_default_gallery_style_filter' );

		// Make theme available for translation
		load_theme_textdomain('dfd', get_template_directory() . '/lang');
		
		// Register wp_nav_menu() menus
		register_nav_menus(array(
			'primary_navigation' => __('Primary Navigation', 'dfd'),
			'top_left_navigation' => __('Top Left Navigation &#40for header style 3 and 4&#41', 'dfd'),
			'top_right_navigation' => __('Top Right Navigation &#40for header style 3 and 4&#41', 'dfd'),
			'side_area_menu' => __('Side area navigation', 'dfd'),
			'footer_menu' => __('Footer navigation', 'dfd'),
		));

		// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
		add_theme_support('post-thumbnails');

		// Add post formats (http://codex.wordpress.org/Post_Formats)
		add_theme_support('post-formats', array('gallery','video','quote','audio'));
		
		add_theme_support( 'automatic-feed-links' );

		add_post_type_support('page', 'excerpt');
		
		// Tell the TinyMCE editor to use a custom stylesheet
		add_editor_style('assets/css/editor-style.css');
		
		// Set default values for the upload media box
		dfd_kadabra_setup();
		
		dfd_kadabra_woocommerce_support();
		
		//add_action('admin_init', 'envato_toolkit_admin_init');
		
		add_filter('news_page_slider_slides_format', 'dfd_news_page_slider_slides_format');
	}
}


if (!function_exists('dfd_kadabra_setup')) {
	function dfd_kadabra_setup() {
		// Set default values for the upload media box
		update_option('image_default_link_type', 'none' );
		update_option('image_default_size', 'large' );
		// TODO: Check on theme setup
		update_option( 'yith_wcwl_button_position', 'shortcode' );
	}
}
/*
Visual Composer theme integration
*/
if ( class_exists( 'Vc_Manager', false ) ) {

	//require_once locate_template('/wpbakery/js_composer/js_composer.php');
	
	if ( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme(true);
	}

	if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
		vc_set_default_editor_post_types( array( 'page', 'post', 'my-product', 'timeline' ) );
	}
	
	if(function_exists('vc_disable_frontend')) {
		vc_disable_frontend();
	}

	if(!class_exists('Ultimate_VC_Addons')) {
		require_once locate_template('/inc/vc_custom/Ultimate_VC_Addons/Ultimate_VC_Addons.php');
	}

	require_once locate_template('/inc/vc_custom/dfd_vc_addons.php');
}

/**
 * Woocommerce support
 */
if (!function_exists('dfd_kadabra_woocommerce_support')) {
	function dfd_kadabra_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		# star rating for proucts in loop
		add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
		if (function_exists('dfd_woocommerce_disable_styles')) {
			dfd_woocommerce_disable_styles();
		}

		# Hook in on activation
		global $pagenow;
		if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
			add_action( 'init', 'dfd_kadabra_woocommerce_image_dimensions', 1 );
		}
	}
}

if (!function_exists('cut_string')) {
	function cut_string($string, $maxlen=100) {
		
		$len = (mb_strlen($string) > $maxlen)
			? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
			: $maxlen
		;

		$cutStr = mb_substr($string, 0, $len);
		return (mb_strlen($string) > $maxlen)
			? $cutStr . '...'
			: $cutStr
		;
	}
}

if (!function_exists('dfd_title_filter_function')) {
	function dfd_title_filter_function($title) {
		$before_title = bloginfo('name');
		$title = $before_title . $title;
		return $title;
	}
}
add_filter('wp_title', 'dfd_title_filter_function', 10, 2);

//Load JS and CSS files
function ronneby_all_scriptsandstyles() {

	wp_register_script ('slick_js', '/wp-content/themes/ronneby/assets/js/slick-1.5.9/slick/slick.js');
	wp_register_style ('slick_css', '/wp-content/themes/ronneby/assets/js/slick-1.5.9/slick/slick.css');
	wp_register_style ('slick_theme_css', '/wp-content/themes/ronneby/assets/js/slick-1.5.9/slick/slick-theme.css');
	wp_register_script ('hp_js', '/wp-content/themes/ronneby/assets/js/hp.js');
	wp_register_style ('font_awesome_css', '/wp-content/themes/ronneby/assets/css/font-awesome.min.css');
	wp_enqueue_script('slick_js');
	wp_enqueue_style( 'slick_css');
	wp_enqueue_style( 'slick_theme_css');
	wp_enqueue_style( 'font_awesome_css');
	wp_enqueue_script('hp_js');
	if(is_page_template ( 'templates/page-landing-page.php' ))
	{
		wp_register_style ('landing_css', '/wp-content/themes/ronneby/assets/css/pages/landing.css');
		wp_enqueue_style( 'landing_css');
		//!Enqueue our Scripts for this Specific Form
		wp_register_script ('validate', '/wp-content/plugins/Venture/assets/js/jquery.validate.js');
		wp_register_script ('validate_form', '/wp-content/plugins/Venture/assets/js/jquery.form.min.js');
		wp_register_script ('lead-js', '/wp-content/plugins/Venture/assets/js/lead-lp-val.js');
		wp_enqueue_script( 'validate');
		wp_enqueue_script( 'validate_form');
		wp_enqueue_script( 'lead-js');
		$rtl_languages = array("ar");
		if (in_array(ICL_LANGUAGE_CODE, $rtl_languages))
		{
			wp_register_style ('landing_rtl_css', '/wp-content/themes/ronneby/assets/css/pages/landing_rtl.css');
			wp_enqueue_style( 'landing_rtl_css');
		}
	}


	if ( is_front_page() ) {
//		wp_enqueue_script('slick_js');
//		wp_enqueue_style( 'slick_css');
//		wp_enqueue_style( 'slick_theme_css');
//		wp_enqueue_style( 'font_awesome_css');
//		wp_enqueue_script('hp_js');
	}

}

add_action( 'wp_enqueue_scripts', 'ronneby_all_scriptsandstyles' );

