<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'dfd_headers_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function dfd_headers_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'preloader_';

	$meta_boxes[] = array(
		'id'         => 'dfd_preloader_settings_box',
		'title'      => __('Preloader options', 'dfd'),
		'pages'      => array('post', 'page', 'my-product', 'product'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
	            'name' => __('Background image','dfd'),
	            'desc' => '',
	            'id'   => $prefix . 'bg_img',
                'type' => 'file',
                'save_id' => false, // save ID using true
				'std'  => '',
	        ),
			array(
				'name' => __('Background position','dfd'),
				'desc' => '',
				'id' => $prefix . 'bg_img_position',
				'type' => 'select',
				'options' => dfd_get_bgposition_redux(),
				'std'  => '',
			),
			array(
                'name' => __('Background color','dfd'),
                'desc' => '',
                'id'   => $prefix . 'bg_color',
                'type' => 'colorpicker',
                'save_id' => false, // save ID using true
                'std'  => '',
            ),
			array(
				'name' => __('Background size','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'bg_size',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('Cover','dfd'),
						'value' => 'cover',
					),
					array(
						'name' => __('Contain','dfd'),
						'value' => 'contain',
					),
					array(
						'name' => __('Inheirt','dfd'),
						'value' => 'inherit',
					),
				),
				'std'  => '',
			),
			array(
				'name' => __('Background repeat','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'bg_repeat',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('No-repeat','dfd'),
						'value' => 'no-repeat',
					),
					array(
						'name' => __('Repeat All','dfd'),
						'value' => 'repeat',
					),
					array(
						'name' => __('Repeat Horizontally','dfd'),
						'value' => 'repeat-x',
					),
					array(
						'name' => __('Repeat Vertically','dfd'),
						'value' => 'repeat-y',
					),
					array(
						'name' => __('Inheirt','dfd'),
						'value' => 'inherit',
					),
				),
				'std'  => '',
			),
			array(
				'name' => __('Background attachment','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'bg_attachment',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('Inherit','dfd'),
						'value' => 'inherit',
					),
					array(
						'name' => __('Scroll','dfd'),
						'value' => 'scroll',
					),
					array(
						'name' => __('Fixed','dfd'),
						'value' => 'fixed',
					),
				),
				'std'  => '',
			),
			array(
				'name'	=> __('Enable counter', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'enable_counter',
				'type'	=> 'radio_inline',
				'options' => array(
					array(
						'name' => __('Inherit from theme options', 'dfd'),
						'value' => '',
					),
					array(
						'name' => __('On', 'dfd'),
						'value' => 'on',
					),
					array(
						'name' => __('Off', 'dfd'),
						'value' => 'off',
					),
				),
			),
			array(
				'name' => __('Preloader style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'style',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('Inherit from options','dfd'),
						'value' => '',
					),
					array(
						'name' => __('None','dfd'),
						'value' => 'none',
					),
					array(
						'name' => __('CSS Animetion','dfd'),
						'value' => 'css_animation',
					),
					array(
						'name' => __('Image','dfd'),
						'value' => 'image',
					),
					array(
						'name' => __('Progress bar','dfd'),
						'value' => 'progress_bar',
					),
				),
				'std'  => '',
			),
			array(
				'name' => __('Animation style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'animation_style',
				'type' => 'select',
				'options' => dfd_preloader_animation_style_cmb(),
				'std'  => '',
			),
			array(
                'name' => __('Animation base color','dfd'),
                'desc' => '',
                'id'   => $prefix . 'animation_color',
                'type' => 'colorpicker',
                'save_id' => false, // save ID using true
                'std'  => '',
            ),
			array(
	            'name' => __('Preloader image','dfd'),
	            'desc' => '',
	            'id'   => $prefix . 'img',
                'type' => 'file',
                'save_id' => false, // save ID using true
				'std'  => '',
	        ),
			array(
                'name'	=> __('Preloader bar height', 'dfd'),
                'desc'	=> '',
                'id'	=> $prefix . 'bar_height',
                'type'	=> 'text',
            ),
			array(
                'name' => __('Preloader bar background color','dfd'),
                'desc' => '',
                'id'   => $prefix . 'bar_bg',
                'type' => 'colorpicker',
                'save_id' => false, // save ID using true
                'std'  => '',
            ),
			array(
                'name'	=> __('Preloader bar opacity', 'dfd'),
                'desc'	=> __('Please enter value from 1 to 100 here to change bar background opacity','dfd'),
                'id'	=> $prefix . 'bar_opacity',
                'type'	=> 'text',
            ),
			array(
				'name' => __('Preloader bar position','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'bar_position',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('Middle','dfd'),
						'value' => 'middle',
					),
					array(
						'name' => __('Top','dfd'),
						'value' => 'top',
					),
					array(
						'name' => __('Bottom','dfd'),
						'value' => 'bottom',
					),
				),
				'std'  => '',
			),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
