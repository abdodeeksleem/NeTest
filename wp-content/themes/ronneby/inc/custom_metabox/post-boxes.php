<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_post_metaboxes( array $meta_boxes ) {

	$prefix = 'blog_';
	
	$meta_boxes[] = array(
		'id'         => 'post_video_custom_fields',
		'title'      => __('Post Video', 'dfd'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
            array(
                'name' => __('YouTube video ID', 'dfd'),
                'desc'	=> '',
                'id'	=> 'post_youtube_video_url',
                'type'	=> 'text'
            ),
            array(
                'name' =>  __('Vimeo video ID', 'dfd'),
                'desc'	=> '',
                'id'	=> 'post_vimeo_video_url',
                'type'	=> 'text'
            ),
            array(
                'name' =>  __('Self hosted video file in mp4 format', 'dfd'),
                'desc'	=> '',
                'id'	=> 'post_self_hosted_mp4',
                'type'	=> 'file'
            ),
            array(
                'name' =>  __('Self hosted video file in webM format', 'dfd'),
                'desc'	=> '',
                'id'	=> 'post_self_hosted_webm',
                'type'	=> 'file'
            ),
		),
	);

        
	$meta_boxes[] = array(
		'id'         => 'post_audio_custom_fields',
		'title'      => __('Post Audio', 'dfd'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' =>  __('Use audio embed code', 'dfd'),
				'desc'	=> '',
				'id'	=> 'post_custom_post_audio_url',
				'type'	=> 'text'
			),
			array(
				'name' =>  __('Self hosted audio file in mp3 format', 'dfd'),
				'desc'	=> '',
				'id'	=> 'post_self_hosted_audio',
				'type'	=> 'file'
			),
			array(
				'name' =>  __('Soundcloud audio', 'dfd'),
				'desc'	=> '',
				'id'	=> 'post_soundcloud_audio',
				'type'	=> 'textarea_code'
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'post_quote_custom_fields',
		'title'      => __('Post Quote', 'dfd'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' =>  __('Quote author name', 'dfd'),
				'desc'	=> '',
				'id'	=> 'post_custom_author_name',
				'type'	=> 'text'
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'enable_post_thumb',
		'title'      => __('Single post settings', 'dfd'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'	=> __('Show title', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_style',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Simple', 'dfd'), 'value' => 'base', ),
					array( 'name' => __('Advanced', 'dfd'), 'value' => 'advanced', ),
				),
			),
			array(
				'name' =>  __('Enable post thumb in Stunning header', 'dfd'),
				'desc'	=> '',
				'id'	=> 'dfd_post_thumb_enable',
				'type' => 'select',
				'std' => 'disabled',
				'options' => array(
					array('name' => __('Disable', 'dfd'),'value' => 'disabled',),
					array('name' => __('Enable', 'dfd'),'value' => 'enabled',),
				),
			),
			array(
				'name' =>  __('Single post layout width', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_layout',
				'type' => 'select',
				'std' => 'boxed',
				'options' => array(
					array('name' => __('Boxed', 'dfd'),'value' => 'boxed',),
					array('name' => __('Full width', 'dfd'),'value' => 'full-width',),
				),
			),
			array(
				'name'	=> __('Enable stunning header', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_stun_header',
				'type'	=> 'radio_inline',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Enable', 'dfd'), 'value' => 'on', ),
                    array( 'name' => __('Disable', 'dfd'), 'value' => 'off', ),
				),
			),
			array(
				'name'	=> __('Sidebar cofiguration', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_sidebars',
				'type'	=> 'radio_inline',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
                    array( 'name' => __('No sidebars', 'dfd'), 'value' => '1col-fixed', ),
                    array( 'name' => __('Sidebar on left', 'dfd'), 'value' => '2c-l-fixed', ),
                    array( 'name' => __('Sidebar on right', 'dfd'), 'value' => '2c-r-fixed', ),
                    //array( 'name' => __('2 left sidebars', 'dfd'), 'value' => '3c-l-fixed', ),
                    //array( 'name' => __('2 right sidebars', 'dfd'), 'value' => '3c-r-fixed', ),
                    array( 'name' => __('Both left and right sidebars', 'dfd'), 'value' => '3c-fixed', ),
				),
			),
			array(
				'name'	=> __('Show title', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_show_title',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Show meta', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_show_meta',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Show Read more and Share', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_show_read_more_share',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
		),
	);
	$meta_boxes[] = array(
		'id'         => 'dfd_blog_settings_box',
		'title'      => __('Blog page options', 'dfd'),
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'show_on' => array(
			'key' => 'page-template',
			'value' => 'tmp-blog.php',
		),
		'fields'     => array(
			array(
				'name'	=> __('Enable stunning header', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'stun_header',
				'type'	=> 'radio_inline',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Enable', 'dfd'), 'value' => 'on', ),
                    array( 'name' => __('Disable', 'dfd'), 'value' => 'off', ),
				),
			),
			array(
				'name' => __('Blog layout width','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'layout',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Boxed','dfd'), 'value' => 'boxed', ),
					array( 'name' => __('Full width','dfd'), 'value' => 'full_width', ),
				),
				'std'  => '1',
			),
			array(
				'name'	=> __('Sidebar cofiguration', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'sidebars',
				'type'	=> 'radio_inline',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
                    array( 'name' => __('No sidebars', 'dfd'), 'value' => '1col-fixed', ),
                    array( 'name' => __('Sidebar on left', 'dfd'), 'value' => '2c-l-fixed', ),
                    array( 'name' => __('Sidebar on right', 'dfd'), 'value' => '2c-r-fixed', ),
                    //array( 'name' => __('2 left sidebars', 'dfd'), 'value' => '3c-l-fixed', ),
                    //array( 'name' => __('2 right sidebars', 'dfd'), 'value' => '3c-r-fixed', ),
                    array( 'name' => __('Both left and right sidebars', 'dfd'), 'value' => '3c-fixed', ),
				),
			),
			array(
				'name'	=> __('Show title', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'show_title',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Show meta', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'show_meta',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Heading position', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'heading_position',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Under media', 'dfd'), 'value' => 'bottom', ),
                    array( 'name' => __('Over media', 'dfd'), 'value' => 'top', ),
				),
			),
			array(
				'name'	=> __('Show description', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'show_description',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Description alignment', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'content_alignment',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
                    array( 'name' => __('Center', 'dfd'), 'value' => 'text-center', ),
                    array( 'name' => __('Left', 'dfd'), 'value' => 'text-left', ),
					array( 'name' => __('Right', 'dfd'), 'value' => 'text-right', ),
				),
			),
			array(
				'name'	=> __('Show Read more and Share', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'show_read_more_share',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Hide', 'dfd'), 'value' => 'off', ),
					array( 'name' => __('Show', 'dfd'), 'value' => 'on', ),
				),
			),
			array(
				'name'	=> __('Read more style', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'read_more_style',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Simple', 'dfd'), 'value' => 'simple', ),
					array( 'name' => __('Shuffle', 'dfd'), 'value' => 'chaffle', ),
					array( 'name' => __('Slide up', 'dfd'), 'value' => 'slide-up', ),
				),
			),
			array(
				'name' => __('Works per page', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'works_per_page',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
			array(
				'name' => __('Items offset', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'items_offset',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
			array(
				'name' => __('Blog layout style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'layout_style',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => '', ),
					array( 'name' => __('Standard','dfd'), 'value' => 'standard', ),
					array( 'name' => __('Left image','dfd'), 'value' => 'left-image', ),
					array( 'name' => __('Right image','dfd'), 'value' => 'right-image', ),
					array( 'name' => __('Masonry','dfd'), 'value' => 'masonry', ),
					array( 'name' => __('Grid','dfd'), 'value' => 'fitRows', ),
				),
				'std'  => '',
			),
			array(
				'name' => __('Number of columns','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'columns',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => '', ),
					array( 'name' => __('One column','dfd'), 'value' => '1', ),
					array( 'name' => __('Two columns','dfd'), 'value' => '2', ),
					array( 'name' => __('Three columns','dfd'), 'value' => '3', ),
					array( 'name' => __('Four columns','dfd'), 'value' => '4', ),
					array( 'name' => __('Five columns','dfd'), 'value' => '5', ),
					array( 'name' => __('Six columns','dfd'), 'value' => '6', ),
				),
				'std'  => '1',
			),
			array(
				'name'	=> __('Enable sort panel', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'sort_panel',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Enable', 'dfd'), 'value' => 'on', ),
                    array( 'name' => __('Disable', 'dfd'), 'value' => 'off', ),
				),
			),
			array(
				'name'	=> __('Enable sort panel alignment', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'sort_panel_align',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Left', 'dfd'), 'value' => 'text-left', ),
                    array( 'name' => __('Right', 'dfd'), 'value' => 'text-right', ),
                    array( 'name' => __('Center', 'dfd'), 'value' => 'text-center', ),
				),
			),
			array(
                'name' => __('Blog Category','dfd'),
                'desc'	=> __('Select blog items category','dfd'),
                'id'	=> $prefix . 'category',
                'taxonomy' => 'category',
                'type' => 'taxonomy_multicheck',
            ),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function dfd_post_add_custom_box() {

    $screens = array( 'post' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'dfd_post_gallery',
            __( 'Images gallery', 'dfd' ),
            'dfd_post_inner_custom_box',
            $screen,
            'side'
        );
    }
}
add_action( 'add_meta_boxes', 'dfd_post_add_custom_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function dfd_post_inner_custom_box( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'dfd_post_inner_custom_box', 'dfd_post_inner_custom_box_nonce' );


    ?>

    <div id="my_post_images_container">
        <ul class="my_post_images">
            <?php
            if ( metadata_exists( 'post', $post->ID, '_my_post_image_gallery' ) ) {
                $my_post_image_gallery = get_post_meta( $post->ID, '_my_post_image_gallery', true );
            } else {
                // Backwards compat
                $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' );
                $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
                $my_post_image_gallery = implode( ',', $attachment_ids );
            }

            $attachments = array_filter( explode( ',', $my_post_image_gallery ) );

            if ( $attachments ) {
                foreach ( $attachments as $attachment_id ) {
                    echo '<li class="image" data-attachment_id="' . esc_attr($attachment_id) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . __( 'Delete image', 'dfd' ) . '">' . __( 'Delete', 'dfd' ) . '</a></li>
								</ul>
							</li>';
                }
			} ?>
        </ul>

        <input type="hidden" id="my_post_image_gallery" name="my_post_image_gallery" value="<?php echo esc_attr( $my_post_image_gallery ); ?>" />

    </div>
    <p class="add_my_post_images hide-if-no-js">
        <a class="button" href="#"><?php _e( 'Add gallery images', 'dfd' ); ?></a>
    </p>
    <script type="text/javascript">
        jQuery(document).ready(function($){
			"use strict";
            // Uploading files
            var my_post_gallery_frame;
            var $image_gallery_ids = $('#my_post_image_gallery');
            var $my_post_images = $('#my_post_images_container ul.my_post_images');

            jQuery('.add_my_post_images').on( 'click', 'a', function( event ) {

                var $el = $(this);
                var attachment_ids = $image_gallery_ids.val();

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( my_post_gallery_frame ) {
                    my_post_gallery_frame.open();
                    return;
                }

                // Create the media frame.
                my_post_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php _e( 'Add Images to post Gallery', 'dfd' ); ?>',
                    button: {
                        text: '<?php _e( 'Add to gallery', 'dfd' ); ?>'
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                my_post_gallery_frame.on( 'select', function() {

                    var selection = my_post_gallery_frame.state().get('selection');

                    selection.map( function( attachment ) {

                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            $my_post_images.append('\
									<li class="image" data-attachment_id="' + attachment.id + '">\
										<img src="' + attachment.url + '" />\
										<ul class="actions">\
											<li><a href="#" class="delete" title="<?php _e( 'Delete image', 'dfd' ); ?>"><?php _e( 'Delete', 'dfd' ); ?></a></li>\
										</ul>\
									</li>');
                        }

                    } );

                    $image_gallery_ids.val( attachment_ids );
                });

                // Finally, open the modal.
                my_post_gallery_frame.open();
            });

            // Image ordering
            $my_post_images.sortable({
                items: 'li.image',
                cursor: 'move',
                scrollSensitivity:40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'wc-metabox-sortable-placeholder',
                start:function(event,ui){
                    ui.item.css('background-color','#f6f6f6');
                },
                stop:function(event,ui){
                    ui.item.removeAttr('style');
                },
                update: function(event, ui) {
                    var attachment_ids = '';

                    $('#my_post_images_container ul li.image').css('cursor','default').each(function() {
                        var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val( attachment_ids );
                }
            });

            // Remove images
            $('#my_post_images_container').on( 'click', 'a.delete', function() {

                $(this).closest('li.image').remove();

                var attachment_ids = '';

                $('#my_post_images_container ul li.image').css('cursor','default').each(function() {
                    var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $image_gallery_ids.val( attachment_ids );

                return false;
            } );

        });
    </script>


<?php

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function dfd_post_save_postdata( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['dfd_post_inner_custom_box_nonce'] ) )
        return $post_id;

    $nonce = $_POST['dfd_post_inner_custom_box_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'dfd_post_inner_custom_box' ) )
        return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }

    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    $mydata = $_POST['my_post_image_gallery'];

    // Update the meta field in the database.
    update_post_meta( $post_id, '_my_post_image_gallery', $mydata );
}
add_action( 'save_post', 'dfd_post_save_postdata' );