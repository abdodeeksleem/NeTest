<?php
// Function parses header styles

/*
 * Backgrounds
 */
global $dfd_ronneby;
if (isset($dfd_ronneby['wrapper_bg_color']) && $dfd_ronneby['wrapper_bg_color']) {
    echo '#change_wrap_div{ background-color: '.esc_attr($dfd_ronneby['wrapper_bg_color']).' !important; }';
}
if (isset($dfd_ronneby['wrapper_bg_image']['url']) && $dfd_ronneby['wrapper_bg_image']['url']) {
    echo '#change_wrap_div{ background-image: url("'.esc_url($dfd_ronneby['wrapper_bg_image']['url']).'") !important; } ';
}
if (isset($dfd_ronneby['wrapper_custom_repeat']) && $dfd_ronneby['wrapper_custom_repeat']) {
    echo '#change_wrap_div{ background-repeat: '.esc_attr($dfd_ronneby['wrapper_custom_repeat']).' !important; }';
}

// body
if (isset($dfd_ronneby['body_bg_color']) && $dfd_ronneby['body_bg_color']) {
    echo 'body{ background-color: '.esc_attr($dfd_ronneby['body_bg_color']).' !important; }';
}
if (isset($dfd_ronneby['body_bg_image']['url']) && $dfd_ronneby['body_bg_image']['url']) {
    echo 'body{ background-image: url("'.esc_url($dfd_ronneby['body_bg_image']['url']).'") !important; }';
}
if (isset($dfd_ronneby['body_custom_repeat']) && $dfd_ronneby['body_custom_repeat']) {
    echo 'body{ background-repeat: '.esc_attr($dfd_ronneby['body_custom_repeat']).' !important; }';
}
if (isset($dfd_ronneby['body_bg_fixed']) && $dfd_ronneby['body_bg_fixed']) {
    echo 'body{ background-attachment: fixed !important; } ';
}

// footer
if (isset($dfd_ronneby['footer_bg_color']) && $dfd_ronneby['footer_bg_color']) {
    echo '#footer{ background-color: '.esc_attr($dfd_ronneby['footer_bg_color']).'} ';
}
if (isset($dfd_ronneby['footer_bg_image']['url']) && $dfd_ronneby['footer_bg_image']['url']) {
    echo '#footer{ background-image: url("'.esc_url($dfd_ronneby['footer_bg_image']['url']).'")} ';
}
if (isset($dfd_ronneby['footer_custom_repeat']) && $dfd_ronneby['footer_custom_repeat']) {
    echo '#footer{ background-repeat: '.esc_attr($dfd_ronneby['footer_custom_repeat']).'} ';
}

// sub footer
if (isset($dfd_ronneby['sub_footer_bg_color']) && $dfd_ronneby['sub_footer_bg_color']){
    echo '#sub-footer { background-color: '.esc_attr($dfd_ronneby['sub_footer_bg_color']).' !important; } ';
}
if (isset($dfd_ronneby['sub_footer_bg_image']['url']) && $dfd_ronneby['sub_footer_bg_image']['url']){
    echo '#sub-footer { background-image: url("'.esc_url($dfd_ronneby['sub_footer_bg_image']['url']).'") !important; } ';
}

if (isset($dfd_ronneby['sub_footer_custom_repeat']) && $dfd_ronneby['sub_footer_custom_repeat']){
    echo '#sub-footer { background-repeat: '.esc_attr($dfd_ronneby['sub_footer_custom_repeat']).' !important; } ';
}

if (isset($dfd_ronneby['enable_lightbox_counter']) && strcmp($dfd_ronneby['enable_lightbox_counter'],'off') === 0){
    echo 'div.pp_default .pp_nav { display: none !important; } ';
}

if (isset($dfd_ronneby['enable_lightbox_share']) && strcmp($dfd_ronneby['enable_lightbox_share'],'off') === 0){
    echo 'div.pp_default .pp_social { display: none !important; } ';
}

if (isset($dfd_ronneby['enable_lightbox_arrows']) && strcmp($dfd_ronneby['enable_lightbox_arrows'],'off') === 0){
    echo 'div.pp_default .pp_next:before, a.pp_previous:before { display: none !important; } ';
}

if (isset($dfd_ronneby['enable_zoom_button']) && strcmp($dfd_ronneby['enable_zoom_button'],'off') === 0){
    echo 'a.pp_expand, a.pp_contract { display: none !important; } ';
}

if (isset($dfd_ronneby['lightbox_elements_color']) && $dfd_ronneby['lightbox_elements_color']){
    echo 'a.pp_next:before, a.pp_previous:before,div.pp_default .pp_nav .pp_play:before,div.pp_default .pp_nav .pp_pause:before,'
		  .'div.pp_default a.pp_arrow_previous:before,div.pp_default a.pp_arrow_next:before, div.pp_default .pp_nav .currentTextHolder,'
		  .'div.ppt,div.pp_default .pp_expand:after,div.pp_default .pp_contract:after,{ color: '.esc_attr($dfd_ronneby['lightbox_elements_color']).' !important; } ';
	echo 'div.pp_default .pp_close:before, div.pp_default .pp_close:after { background: '.esc_attr($dfd_ronneby['lightbox_elements_color']).' !important; }';
}

if (isset($dfd_ronneby['lightbox_overlay_style']) && strcmp($dfd_ronneby['lightbox_overlay_style'],'simple') === 0 && isset($dfd_ronneby['lightbox_overley_bg_color']) && $dfd_ronneby['lightbox_overley_bg_color']){
    echo 'div.pp_overlay { background: '.esc_attr($dfd_ronneby['lightbox_overley_bg_color']).' !important; } ';
}

if (
	isset($dfd_ronneby['lightbox_overlay_style']) &&
	strcmp($dfd_ronneby['lightbox_overlay_style'],'gradient') === 0 &&
	isset($dfd_ronneby['lightbox_overley_color_gradient']) &&
	$dfd_ronneby['lightbox_overley_color_gradient']
){
    echo 'div.pp_overlay {'
		. 'background: -webkit-linear-gradient(left, '.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['from']).','.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['to']).') !important;'
		. 'background: -moz-linear-gradient(left, '.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['from']).','.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['to']).') !important;'
		. 'background: -o-linear-gradient(left, '.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['from']).','.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['to']).') !important;'
		. 'background: -ms-linear-gradient(left, '.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['from']).','.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['to']).') !important;'
		. 'background: linear-gradient(left, '.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['from']).','.esc_attr($dfd_ronneby['lightbox_overley_color_gradient']['to']).') !important;'
		. '} ';
}

if (isset($dfd_ronneby['lightbox_overley_bg_opacity']) && $dfd_ronneby['lightbox_overley_bg_opacity']){
    echo 'div.pp_overlay { opacity: '.esc_attr($dfd_ronneby['lightbox_overley_bg_opacity']/100).' !important; } ';
}

/*
 * Custom CSS
 */
echo isset($dfd_ronneby['custom_css']) ? $dfd_ronneby['custom_css'] : '';