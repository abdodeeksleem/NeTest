<?php
global $dfd_ronneby;

$data_atts = '';

$gallery_page_style = DfdMetaBoxSettings::compared('dfd_gallery_layout_style', 'standard');

$gallery_items_offset = DfdMetaBoxSettings::compared('dfd_gallery_items_offset', 0);

$show_title = DfdMetaBoxSettings::compared('dfd_gallery_show_title', false);

$title_position = DfdMetaBoxSettings::compared('dfd_gallery_title_position', false);

if(strcmp($gallery_page_style, 'masonry') === 0 || strcmp($gallery_page_style, 'fitRows') === 0) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('dfd-isotope-gallery');
	$gallery_page_columns = DfdMetaBoxSettings::compared('dfd_gallery_columns', 1);
	
	$data_atts .= ' data-columns="'.esc_attr($gallery_page_columns).'"';
	$data_atts .= ' data-layout-style="'.esc_attr($gallery_page_style).'"';
}

$galler_number = get_post_meta($post->ID, 'dfd_gallery_works_per_page', true);
$number_per_page = ($galler_number) ? $galler_number : '16';

$galler_custom_categories = array();

$selected_custom_categories = wp_get_object_terms($post->ID, 'gallery_category');
if (!empty($selected_custom_categories) && !is_wp_error($selected_custom_categories)) {
	foreach ($selected_custom_categories as $term) {
		$galler_custom_categories[] = $term->term_id;
	}
}

if ($galler_custom_categories) {
	$galler_custom_categories = implode(",", $galler_custom_categories);
}

if (is_front_page()) {
	$page = get_query_var('page');
	$paged = ($page) ? $page : 1;
} else {
	$page = get_query_var('paged');
	$paged = ($page) ? $page : 1;
}

if ($galler_custom_categories) {
	$args = array(
		'post_type' => 'gallery',
		'posts_per_page' => $number_per_page,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'gallery_category',
				'field' => 'id',
				'terms' => $galler_custom_categories,
			)
		)
	);
} else {
	$args = array(
		'post_type' => 'gallery',
		'posts_per_page' => $number_per_page,
		'paged' => $paged
	);
}

if($gallery_items_offset) {
	$gallery_items_offset = $gallery_items_offset / 2;
}
?>
<div class="dfd-gallery-wrap" <?php echo !empty($gallery_items_offset) ? 'style="margin: -'.esc_attr($gallery_items_offset).'px;"' : '' ?>>
	<div class="dfd-gallery dfd-gallery-<?php echo esc_attr($gallery_page_style) ?>" <?php echo $data_atts ?>>
		<?php
		$wp_query = new WP_Query($args);

		while ($wp_query->have_posts()) : $wp_query->the_post();

			if (has_post_thumbnail()) {
				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL

				$_gallery_id = get_the_id();

				if (metadata_exists('post', $_gallery_id, '_gallery_image_gallery')) {
					$image_gallery = get_post_meta($_gallery_id, '_gallery_image_gallery', true);
				} else {
					// Backwards compat
					$attachment_ids = get_posts('post_parent=' . $_gallery_id . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
					$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
					$image_gallery = implode(',', $attachment_ids);
				}

				$img_src = $img_url;

				if(strcmp($gallery_page_style, 'fitRows') === 0) {
					$img_url = dfd_aq_resize($img_url, 900, 600, true, true, true);
				}

				if(!$img_url) {
					$img_url = $img_src;
				}

				$gallery_id = uniqid($_gallery_id);

				$attachments = array_filter(explode(',', $image_gallery));
				
				$title_html = '';
				
				if($show_title) {
					$gallery_url = get_permalink();
					$title = get_the_title();
					$title_html .= '<div class="block-title dfd-title-'.esc_attr($title_position).'"><a href="'.esc_url($gallery_url).'" title="'.esc_attr($title).'">'.$title.'</a></div>';
				}
			?>
				<div class="dfd-gallery-single-item">
					<div class="cover" <?php echo !empty($gallery_items_offset) ? 'style="padding: '.esc_attr($gallery_items_offset).'px;"' : '' ?>>
						<?php
						if($show_title && $title_position && strcmp($title_position, 'top') === 0) {
							echo $title_html;
						}
						?>
						<a href="<?php echo esc_url($img_url) ?>" data-rel="prettyPhoto[<?php echo esc_attr($gallery_id) ?>]">
							<img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>"/>
						</a>
						<?php if($attachments) : ?>
							<div class="hide">
								<?php
								foreach ($attachments as $attachment_id) {
									$image_src = wp_get_attachment_image_src($attachment_id, 'full');
									if (empty($image_src[0])) {
										continue;
									}
									$attachment_img_url = $image_src[0];

									if (strcmp($attachment_img_url, $img_url)===0) {
										continue;
									}

									echo '<a href="'. $attachment_img_url .'" data-rel="prettyPhoto['. $gallery_id .']"></a>';
								}
								?>
							</div>
						<?php endif; ?>
						<?php
						if($show_title && $title_position && strcmp($title_position, 'top') !== 0) {
							echo $title_html;
						}
						?>
					</div>
				</div>
			<?php
			}

		endwhile;

		?>
		<?php if ($wp_query->max_num_pages > 1) : ?>

			<nav class="page-nav">

				<?php echo dfd_kadabra_pagination(); ?>

			</nav>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</div>
</div>