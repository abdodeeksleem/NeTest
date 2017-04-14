<?php
/*
* Add-on Name: Clients Testimonials
*/
if(!class_exists('Dfd_Twitter')) 
{
	class Dfd_Twitter{
		function __construct(){
			add_action('admin_init',array($this,'dfd_twitter_init'));
			add_shortcode('dfd_twitter',array($this,'dfd_twitter_shortcode'));
		}
		function dfd_twitter_init(){
			if(function_exists('vc_map')) {
				vc_map(
					array(
					   'name' => __('Twitter module','dfd'),
					   'base' => 'dfd_twitter',
					   'class' => 'vc_info_banner_icon',
					   'icon' => 'vc_icon_info_banner',
					   'category' => __('DFD VC Addons','dfd'),
					   'description' => __('Displays recent tweets carousel','dfd'),
					   'params' => array(
							array(
								"type" => "ult_param_heading",
								"text" => __('Please make sure that you have all necessary options filled in Twitter options section of <a href="'.admin_url('admin.php?page=_options').'" target="_blank">Theme options panel</a> before using this module.', 'dfd'),
								"param_name" => "main_heading_typograpy",
								"class" => "ult-param-heading",
								'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Number of slides to display', 'dfd'),
								'param_name' => 'slides_to_show',
								'value' => 1,
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Number of slides to scroll', 'dfd'),
								'param_name' => 'slides_to_scroll',
								'value' => 1,
							),
							array(
								'type' => 'number',
								'class' => '',
								'heading' => __('Slideshow speed', 'dfd'),
								'param_name' => 'slideshow_speed',
								'value' => 3000,
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable autoslideshow','dfd'),
								'param_name' => 'auto_slideshow',
								'value' => array('Enable autoslideshow' => 'yes'),
							),
							array(
								'type' => 'checkbox',
								'class' => '',
								'heading' => __('Enable pagination','dfd'),
								'param_name' => 'enable_dots',
								'value' => array('Enable pagination' => 'yes'),
							),
							array(
								'type' => 'dropdown',
								'heading' => __('Text Alignment','dfd'),
								'param_name' => 'text_alignment',
								'value' => array(
									__('Left','dfd') => 'text-left',
									__('Center','dfd') => 'text-center',
									__('Right','dfd') => 'text-right'
								)
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
						),
					)
				);
			}
		}
		// Shortcode handler function
		function dfd_twitter_shortcode($atts)
		{
			$output = $el_class = $tweets = $text_alignment = $module_animation = '';
			
			extract(shortcode_atts( array(
				'slides_to_show' => '1',
				'slides_to_scroll' => '1',
				'slideshow_speed' => '3000',
				'auto_slideshow' => '',
				'enable_dots' => '',
				'text_alignment' => 'text-left',
				'module_animation' => '',
				'el_class' => '',
			),$atts));
			
			if(empty($slides_to_show)) {
				$slides_to_show = 1;
			}
			
			if(empty($slides_to_scroll)) {
				$slides_to_scroll = 1;
			}
			
			if(empty($slideshow_speed)) {
				$slideshow_speed = 3000;
			}
			
			if(empty($auto_slideshow)) {
				$auto_slideshow = 'false';
			} else {
				$auto_slideshow = 'true';
			}
			
			if(empty($enable_dots)) {
				$enable_dots = 'false';
			} else {
				$enable_dots = 'true';
			}
			
			$unique_id = uniqid('dfd-twitter-module-');
			
			// Get the tweets from Twitter.
			require_once locate_template('/inc/lib/twitteroauth.php');
			$twitter = new DFDTwitter();
			$tweets = $twitter->getTweets();

			$animate = $animation_data = '';

			if ( ! ( $module_animation == '' ) ) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "' . esc_attr($module_animation) . '" ';
			}
			
			$output .= '<div class="dfd-twitter-module '.esc_attr($el_class).' '.esc_attr($animate).'" '.$animation_data.'>';
				if(!$twitter->hasError()) {
					if(!empty($tweets)) {
						$output .= '<div id="'.esc_attr($unique_id).'">';
							foreach($tweets as $tweet) {
								$output .= '<div class="tweet-item">';
									$output .= '<div class="tweet '.esc_attr($text_alignment).'">';
										$output .= '<div class="tweet-content">';
											$output .= $tweet['text'];
										$output .= '</div>';
										$output .= '<div class="date subtitle">';
											$output .= date('d F Y', $tweet['time']);//human_time_diff($t['time'], current_time('timestamp'));
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							}
						$output .= '</div>';
					}
				} else {
					$output .= '<p class="text-bold text-center">';
						$output .= $twitter->getError()->message;
					$output .= '</p>';
				}
			$output .= '</div>';
			if(!$twitter->hasError() && !empty($tweets)) {

				$breakpoint_first = ($slides_to_show > 3) ? 3 : $slides_to_show;

				$breakpoint_second = ($slides_to_show > 2) ? 2 : $slides_to_show;

				$output .= '<script type="text/javascript">
					(function($) {
						"use strict";
						$(document).ready(function() {
							$("#'.esc_js($unique_id).'").slick({
								infinite: true,
								slidesToShow: '.esc_js($slides_to_show).',
								slidesToScroll: '.esc_js($slides_to_scroll).',
								arrows: false,
								dots: '.esc_js($enable_dots).',
								autoplay: '.esc_js($auto_slideshow) .',
								autoplaySpeed: '.esc_js($slideshow_speed) .',
								responsive: [
									{
										breakpoint: 1280,
										settings: {
											slidesToShow: '.esc_js($breakpoint_first).',
											infinite: true,
											arrows: false,
											dots: '.esc_js($enable_dots) .'
										}
									},
									{
										breakpoint: 800,
										settings: {
											slidesToShow: '.$breakpoint_second.',
											infinite: true,
											arrows: false,
											dots: '.esc_js($enable_dots) .'
										}
									}
								]
							});
						});
						$("#'. esc_js($unique_id) .'").next(".slider-controls").find(".next").click(function(e) {
							$("#'. esc_js($unique_id) .'").slickNext();

							e.preventDefault();
						});

						$("#'. esc_js($unique_id).'").next(".slider-controls").find(".prev").click(function(e) {
							$("#'. esc_js($unique_id) .'").slickPrev();

							e.preventDefault();
						});
						$("#'. esc_js($unique_id) .' .tweet-item").on("mousedown select",(function(e){
							e.preventDefault();
						}));

					})(jQuery);

				</script>';
			}
					
			return $output;
		}
	}
}
if(class_exists('Dfd_Twitter'))
{
	$Dfd_Twitter = new Dfd_Twitter;
}
