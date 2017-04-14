<?php

add_filter( 'cmb_meta_boxes', 'to_top_metaboxes' );

function to_top_metaboxes( array $meta_boxes ) {
	$types = get_post_types(array('public'=>true, ));
	$types = array_keys($types);
	
	$meta_boxes[] = array(
		'id'         => 'one_page_scroll_spacer',
		'title'      => __('Special Features', 'dfd'),
		'pages'		=> $types,
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
                'name' => __('Enable white space', 'dfd'),
                'desc' => '',
                'id'   => 'dfd_enable_page_spacer',
                'type' => 'checkbox'
            ),
			array(
                'name' => __('Parallax footer', 'dfd'),
                'desc' => __('Please check this checkbox if you would like to enable parallax effect for footer section', 'dfd'),
                'id'   => 'crum_page_custom_footer_parallax',
                'type' => 'checkbox',
            ),
		),
	);
	
	return $meta_boxes;
}
