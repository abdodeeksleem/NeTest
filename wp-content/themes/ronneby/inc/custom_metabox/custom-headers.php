<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_headers_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_headers_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'dfd_headers_';
   
     $meta_boxes[] = array(
        'id'         => 'select_header',
        'title'      => __('Select header type', 'dfd'),
        'pages'      =>  get_post_types(),
        'context'    => 'side',
        'priority'   => 'default',
        'show_names' => true, // Show field names on the left
        'fields'     => array(         
            array(
                'name' => 'Header_Type',
                'desc' => '',
                'id' =>  $prefix.'header_style',
                'type' => 'header_select',   
                'std'  => 'Left Sidebar'
            ),
            array(
                'name' => 'Logo_position',
                'desc' => '',
                'id' =>  $prefix.'logo_position',
                'type' => 'logo_position_select',   
                'std'  => 'Left Sidebar'
            ),
            array(
                'name' => 'Menu_position',
                'desc' => '',
                'id' =>  $prefix.'menu_position',
                'type' => 'menu_position_select',   
                'std'  => 'Left Sidebar'
            ),
			/*array(
                'name' => 'Top_Header',
				'desc'	=> '',
                'id' =>  $prefix.'show_top_header',
				'type'	=> 'radio_inline',
                'std'  => 'Left Sidebar',
				'options' => array(
					array(
						'name' => __('On', 'dfd'),
						'value' => 'on',
					),
					array(
						'name' => __('Off', 'dfd'),
						'value' => 'off',
					),
				),
			),*/
			array(
                'name' => 'Side_Area',
				'desc'	=> '',
                'id' =>  $prefix.'show_side_area',
				'type'	=> 'radio_inline',
                'std'  => 'Left Sidebar',
				'options' => array(
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
                'name' => 'Top_inner_page',
				'desc'	=> '',
                'id' =>  $prefix.'show_top_inner_apge',
				'type'	=> 'radio_inline',
                'std'  => 'Left Sidebar',
				'options' => array(
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
        ),
    );
	$meta_boxes[] = array(
        'id'         => 'adaptive-header-options',
        'title'      => __('Smart header options', 'dfd'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'side',
        'priority'   => 'default',
        'show_on' => array(
			'key' => 'page-template',
			'value' => array(
				'tmp-one-page-scroll.php',
				'tmp-side-by-side.php'
			),
		),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'id'   => 'dfd_auto_header_colors',
                'name' => __('Enable smart header', 'dfd'),
                'desc' => __('', 'dfd'),
				'type'	=> 'radio_inline',
				'std'  => 'Left Sidebar',
				'options' => array(
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
		),
	);
	$meta_boxes[] = array(
        'id'         => 'enavle-nav-dots',
        'title'      => __('Navigation dots', 'dfd'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'side',
        'priority'   => 'default',
        'show_on' => array(
			'key' => 'page-template',
			'value' => array(
				'tmp-one-page-scroll.php',
			),
		),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'id'   => 'dfd_enable_dots',
                'name' => __('Disable dots navigation', 'dfd'),
                'desc' => __('', 'dfd'),
				'type' => 'checkbox',
				'std'  => 'Left Sidebar',
            ),
			array(
                'id'   => 'dfd_enable_animation',
                'name' => __('Enable 3d animation', 'dfd'),
                'desc' => __('', 'dfd'),
				'type' => 'checkbox',
				'std'  => 'Left Sidebar',
            ),
			array(
                'id'   => 'dfd_animation_style',
                'name' => __('3d animation style', 'dfd'),
                'desc' => __('', 'dfd'),
				'type' => 'select',
				'options' => array(
					array(
						'name' => __('Style 1','dfd'),
						'value' => 'dfd-3d-style-1',
					),
					array(
						'name' => __('Style 2','dfd'),
						'value' => 'dfd-3d-style-2',
					),
					/*array(
						'name' => __('Style 3','dfd'),
						'value' => 'dfd-3d-style-3',
					),*/
				),
				'std'  => 'Left Sidebar',
            ),
		),
	);

    // Add other metaboxes as needed

    return $meta_boxes;
}