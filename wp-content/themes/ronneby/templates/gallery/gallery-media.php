<?php
global $dfd_ronneby;
$gallery_images_html = $data_atts = $single_gallery_style = '';//  data-slides-to-show="" data-autoplay="" data-slideshow-speed=""

$single_gallery_style = DfdMetaBoxSettings::compared('dfd_gallery_single_type', 'carousel');

$single_width = DfdMetaBoxSettings::compared('dfd_gallery_single_image_width', 900);

$single_height = DfdMetaBoxSettings::compared('dfd_gallery_single_image_height', 600);

$gallery_items_offset = DfdMetaBoxSettings::compared('dfd_gallery_single_items_offset', 0);
if($gallery_items_offset) {
	$gallery_items_offset = $gallery_items_offset / 2;
}

if(strcmp($single_gallery_style, 'masonry') === 0 || strcmp($single_gallery_style, 'fitRows') === 0) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('dfd-isotope-gallery');
	$single_columns = DfdMetaBoxSettings::compared('dfd_gallery_single_columns', 1);
	
	$data_atts .= ' data-columns="'.esc_attr($single_columns).'"';
	$data_atts .= ' data-layout-style="'.esc_attr($single_gallery_style).'"';
} else {
	wp_enqueue_script('dfd-carousel-gallery');
	$single_slides = DfdMetaBoxSettings::compared('dfd_gallery_single_slides', 1);
	
	$data_atts .= ' data-slides="'.esc_attr($single_slides).'"';
	
	$single_autoplay = DfdMetaBoxSettings::compared('dfd_gallery_single_autoplay', 'true');
	$data_atts .= ' data-autoplay="'.esc_attr($single_autoplay).'"';
	
	$single_slideshow_speed = DfdMetaBoxSettings::compared('dfd_gallery_single_slideshow_speed', 3000);
	
	$data_atts .= ' data-slideshow-speed="'.esc_attr($single_slideshow_speed).'"';	
}

if (metadata_exists('post', $post->ID, '_gallery_image_gallery')) {
	$image_gallery = get_post_meta($post->ID, '_gallery_image_gallery', true);
} else {
	// Backwards compat
	$attachment_ids = get_posts('post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
	$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
	$image_gallery = implode(',', $attachment_ids);
}
$attachments = array_filter(explode(',', $image_gallery));

if($attachments) {
	foreach($attachments as $attachment_key => $attachment_id) {
		$image_src = wp_get_attachment_url($attachment_id, 'full');
		$image_url = $item_css = '';
		if(strcmp($single_gallery_style, 'masonry') !== 0) {
			$image_url = dfd_aq_resize($image_src, $single_width, $single_height, true, true, true);
		}
		if(!$image_url || empty($image_url)) {
			$image_url = $image_src;
		}
		if(!empty($gallery_items_offset)) {
			$item_css .= 'style="padding: '.esc_attr($gallery_items_offset).'px;"';
		}
		$gallery_images_html .= '<div class="dfd-gallery-single-item">';
		$gallery_images_html .= '<div class="cover" '.$item_css.'>';
		$gallery_images_html .= '<a href="'.esc_url($image_src).'" data-rel="prettyPhoto[pp_gal]">';
		$gallery_images_html .= '<img src="'.esc_url($image_url).'"  alt="'.esc_attr(get_the_title()).'" />';
		$gallery_images_html .= '</a>';
		$gallery_images_html .= '</div>';
		$gallery_images_html .= '</div>';
	}
}
?>
<div class="dfd-gallery-wrap" <?php echo !empty($gallery_items_offset) ? 'style="margin: -'.esc_attr($gallery_items_offset).'px;"' : '' ?>>
	<div class="dfd-gallery dfd-gallery-<?php echo esc_attr($single_gallery_style) ?>" <?php echo $data_atts ?>>
		<?php echo $gallery_images_html ?>
	</div>
</div>