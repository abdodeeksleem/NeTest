<?php
add_filter( 'cmb_meta_boxes', 'dfd_gallery_boxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function dfd_gallery_boxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'dfd_gallery_';

	$meta_boxes[] = array(
		'id'         => 'dfd_preloader_settings_box',
		'title'      => __('Single gallery options', 'dfd'),
		'pages'      => array('gallery'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'	=> __('Enable stunning header', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_stun_header',
				'type'	=> 'radio_inline',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Enable', 'dfd'), 'value' => 'on', ),
                    array( 'name' => __('Disable', 'dfd'), 'value' => 'off', ),
				),
			),
			array(
				'name' => __('Single gallery layout style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_layout',
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
				'name' => __('Single gallery style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_type',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => false, ),
					array( 'name' => __('Carousel','dfd'), 'value' => 'carousel', ),
					array( 'name' => __('Masonry','dfd'), 'value' => 'masonry', ),
					array( 'name' => __('Grid','dfd'), 'value' => 'fitRows', ),
				),
				'std'  => '1',
			),
			array(
				'name' => __('Items offset', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_items_offset',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
			array(
				'name' => __('Number of slides to show','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_slides',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => false, ),
					array( 'name' => __('One','dfd'), 'value' => '1', ),
					array( 'name' => __('Two','dfd'), 'value' => '2', ),
					array( 'name' => __('Three','dfd'), 'value' => '3', ),
					array( 'name' => __('Four','dfd'), 'value' => '4', ),
					array( 'name' => __('Five','dfd'), 'value' => '5', ),
					array( 'name' => __('Six','dfd'), 'value' => '6', ),
				),
				'std'  => '',
			),
			array(
				'name'	=> __('Enable autoslideshow', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'single_autoplay',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => false, ),
					array( 'name' => __('Enable', 'dfd'), 'value' => 'true', ),
                    array( 'name' => __('Disable', 'dfd'), 'value' => 'false', ),
				),
			),
			array(
				'name' => __('Slideshow speed', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_slideshow_speed',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
			array(
				'name' => __('Number of columns','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_columns',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => '', ),
					array( 'name' => __('One column','dfd'), 'value' => '1', ),
					array( 'name' => __('Two columns','dfd'), 'value' => '2', ),
					array( 'name' => __('Three columns','dfd'), 'value' => '3', ),
					array( 'name' => __('Four columns','dfd'), 'value' => '4', ),
					array( 'name' => __('Five columns','dfd'), 'value' => '5', ),
					//array( 'name' => __('Six columns','dfd'), 'value' => '6', ),
				),
				'std'  => '1',
			),
			array(
				'name' => __('Image width', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_image_width',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
			array(
				'name' => __('Image height', 'dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'single_image_height',
				'type' => 'text',
				'save_id' => false, // save ID using true
				'std' => ''
			),
		),
	);
	$meta_boxes[] = array(
		'id'         => 'dfd_preloader_settings_box',
		'title'      => __('Gallery options', 'dfd'),
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'show_on' => array(
			'key' => 'page-template',
			'value' => 'tmp-gallery.php',
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
				'name' => __('Single gallery layout width','dfd'),
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
				'name'	=> __('Title position', 'dfd'),
				'desc'	=> '',
				'id'	=> $prefix . 'title_position',
				'type'	=> 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options', 'dfd'), 'value' => '', ),
					array( 'name' => __('Over the image', 'dfd'), 'value' => 'top', ),
                    array( 'name' => __('Under the image', 'dfd'), 'value' => 'bottom', ),
                    array( 'name' => __('In front of the image', 'dfd'), 'value' => 'front', ),
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
				'name' => __('Gallery layout style','dfd'),
				'desc' => __('', 'dfd'),
				'id' => $prefix . 'layout_style',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Inherit from theme options','dfd'), 'value' => '', ),
					array( 'name' => __('Standard','dfd'), 'value' => 'standard', ),
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
                'name' => __('Gallery Category','dfd'),
                'desc'	=> __('Select Gallery items category','dfd'),
                'id'	=> $prefix . 'category',
                'taxonomy' => 'gallery_category',
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
function dfd_gallery_add_custom_box() {

    $screens = array( 'gallery' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'dfd_gallery_gallery',
            __( 'Images gallery', 'dfd' ),
            'dfd_gallery_inner_custom_box',
            $screen,
            'side'
        );
    }
}
add_action( 'add_meta_boxes', 'dfd_gallery_add_custom_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function dfd_gallery_inner_custom_box( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'dfd_gallery_inner_custom_box', 'dfd_gallery_inner_custom_box_nonce' );


    ?>

    <div id="gallery_images_container">
        <ul class="gallery_images">
            <?php
            if ( metadata_exists( 'post', $post->ID, '_gallery_image_gallery' ) ) {
                $gallery_image_gallery = get_post_meta( $post->ID, '_gallery_image_gallery', true );
            } else {
                // Backwards compat
                $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' );
                $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
                $gallery_image_gallery = implode( ',', $attachment_ids );
            }

            $attachments = array_filter( explode( ',', $gallery_image_gallery ) );

            if ( $attachments ) {
                foreach ( $attachments as $attachment_id ) {
                    echo '<li class="image" data-attachment_id="' . esc_attr($attachment_id) . '">
								' . wp_get_attachment_image( $attachment_id ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . __( 'Delete image', 'dfd' ) . '">' . __( 'Delete', 'dfd' ) . '</a></li>
								</ul>
							</li>';
                }
			} ?>
        </ul>

        <input type="hidden" id="gallery_image_gallery" name="gallery_image_gallery" value="<?php echo esc_attr( $gallery_image_gallery ); ?>" />

    </div>
    <p class="add_gallery_images hide-if-no-js">
        <a class="button" href="#"><?php _e( 'Add gallery images', 'dfd' ); ?></a>
    </p>
    <script type="text/javascript">
        jQuery(document).ready(function($){

            // Uploading files
            var gallery_gallery_frame;
            var $image_gallery_ids = $('#gallery_image_gallery');
            var $gallery_images = $('#gallery_images_container ul.gallery_images');

            jQuery('.add_gallery_images').on( 'click', 'a', function( event ) {

                var $el = $(this);
                var attachment_ids = $image_gallery_ids.val();

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( gallery_gallery_frame ) {
                    gallery_gallery_frame.open();
                    return;
                }

                // Create the media frame.
                gallery_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php _e( 'Add Images to post Gallery', 'dfd' ); ?>',
                    button: {
                        text: '<?php _e( 'Add to gallery', 'dfd' ); ?>'
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                gallery_gallery_frame.on( 'select', function() {

                    var selection = gallery_gallery_frame.state().get('selection');

                    selection.map( function( attachment ) {

                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            $gallery_images.append('\
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
                gallery_gallery_frame.open();
            });

            // Image ordering
            $gallery_images.sortable({
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

                    $('#gallery_images_container ul li.image').css('cursor','default').each(function() {
                        var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val( attachment_ids );
                }
            });

            // Remove images
            $('#gallery_images_container').on( 'click', 'a.delete', function() {

                $(this).closest('li.image').remove();

                var attachment_ids = '';

                $('#gallery_images_container ul li.image').css('cursor','default').each(function() {
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
function dfd_gallery_save_postdata( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['dfd_gallery_inner_custom_box_nonce'] ) )
        return $post_id;

    $nonce = $_POST['dfd_gallery_inner_custom_box_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'dfd_gallery_inner_custom_box' ) )
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
    $mydata = $_POST['gallery_image_gallery'];

    // Update the meta field in the database.
    update_post_meta( $post_id, '_gallery_image_gallery', $mydata );
}
add_action( 'save_post', 'dfd_gallery_save_postdata' );