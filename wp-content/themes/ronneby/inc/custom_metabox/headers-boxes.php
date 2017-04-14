<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'stunnig_headers_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function stunnig_headers_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'stunnig_headers_';
	
	$meta_boxes[] = array(
		'id'         => 'header_img_metabox',
		'title'      => __('Stunning header options', 'dfd'),
		'pages'      => array('post', 'page', 'my-product', 'product'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
	            'name' => 'Background image',
	            'desc' => __('Select image pattern for stunning header background', 'dfd'),
	            'id'   => $prefix . 'bg_img',
                'type' => 'file',
                'save_id' => false, // save ID using true
				'std'  => '',
	        ),
			array(
				'name' => 'Background position',
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'bg_img_position',
				'type' => 'select',
				'options' => dfd_get_bgposition_redux(),
				'std'  => '',
			),
			array(
                'name' => 'Background color',
                'desc' => __('Select color for header background', 'dfd'),
                'id'   => $prefix . 'bg_color',
                'type' => 'colorpicker',
                'save_id' => false, // save ID using true
                'std'  => '',
            ),
            array(
                'name'	=> __('Page subtitle', 'dfd'),
                'desc'	=> '',
                'id'	=> $prefix . 'subtitle',
                'type'	=> 'text',
            ),
            array(
                'name'	=> __('Stunning header height', 'dfd'),
                'desc'	=> '',
                'id'	=> $prefix . 'custom_height',
                'type'	=> 'text',
            ),
			array(
				'name' => 'Text alignment',
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'text_alignment',
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('None', 'dfd'),
						'value' => '',
					),
					array(
						'name' => __('Center', 'dfd'),
						'value' => 'text-center',
					),
					array(
						'name' => __('Left', 'dfd'),
						'value' => 'text-left',
					),
					array(
						'name' => __('Right', 'dfd'),
						'value' => 'text-right',
					),
				),
				'std'  => '',
			),
			array(
				'name'	=> __('Fixed background image position', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'stan_header_fixed',
				'type'	=> 'radio_inline',
				'options' => array(
					array(
						'name' => __('On', 'dfd'),
						'value' => '1',
					),
					array(
						'name' => __('Off', 'dfd'),
						'value' => '0',
					),
				),
			),
			array(
				'name'	=> __('Background check', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'stan_header_bgcheck',
				'type'	=> 'radio_inline',
				'options' => array(
					array(
						'name' => __('Light', 'dfd'),
						'value' => '0',
					),
					array(
						'name' => __('Dark', 'dfd'),
						'value' => '1',
					),
				),
			),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
