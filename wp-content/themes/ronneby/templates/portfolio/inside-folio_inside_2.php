<?php
global $dfd_ronneby;
while (have_posts()) { 
	the_post();
	$mvb_content = get_post_meta(get_the_ID(), '_bshaper_artist_content', true );
	$mvb_enable = get_post_meta( get_the_ID(), '_bshaper_activate_metro_builder', true );
	if (!empty($mvb_content) && strcmp($mvb_enable, '1') === 0) {
		the_content();
	}
}
?>

<div class="twelve columns">
	<?php
	$embed_url = get_post_meta($post->ID, 'folio_embed', true);

	if ($embed_url):

		$embed_code = wp_oembed_get($embed_url);

		echo '<div class="single-folio-video">' . $embed_code . '</div>';

	endif;

	if ((get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')) {
//		wp_enqueue_style('dfd_zencdn_video_css');
		wp_enqueue_script('dfd_zencdn_video_js');
		
		if (has_post_thumbnail()) {
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
			$article_image = dfd_aq_resize($img_url, 800, 600, true, true, true);
			if($article_image) {
				$article_image = $img_url;
			}
			?>
			
		<?php } ?>

		<video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
			   preload="auto"
			   width="800"
			   height="600"
			   poster="<?php echo esc_url($article_image); ?>"
			   data-setup="{}">


			<?php if (get_post_meta($post->ID, 'folio_self_hosted_mp4', true)): ?>
				<source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_mp4', true) ?>" type='video/mp4'>
			<?php endif; ?>
			<?php if (get_post_meta($post->ID, 'folio_self_hosted_webm"', true)): ?>
				<source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_webm"', true) ?>" type='video/webm'>
			<?php endif; ?>
		</video>


	<?php
	} ?>

	<?php
	if (metadata_exists('post', $post->ID, '_my_product_image_gallery')) {
		$my_product_image_gallery = get_post_meta($post->ID, '_my_product_image_gallery', true);
	} else {
		// Backwards compat
		$attachment_ids = get_posts('post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
		$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
		$my_product_image_gallery = implode(',', $attachment_ids);
	}

	$attachments = array_filter(explode(',', $my_product_image_gallery));

	if ($attachments) {


		echo '<div id="my-work-slider" class="loading"><ul class="slides">';

		foreach ($attachments as $attachment_id) {

			$image_attributes = wp_get_attachment_image_src($attachment_id); // returns an array
			$image_src = wp_get_attachment_image_src($attachment_id, 'full'); // returns an array

			$thumb_image = dfd_aq_resize($image_attributes[0], 126, 88, true, true, true);
			
			if(!$thumb_image) {
				$thumb_image = $image_attributes[0];
			}

			echo '<li data-thumb="' . esc_url($thumb_image) . '">';
			echo '<a href="'.esc_url($image_src[0]).'" data-rel="prettyPhoto[pp_gal]">';
			echo wp_get_attachment_image($attachment_id, 'full');
			echo '</a>';
			echo '</li>';
		}
		echo '  </ul></div>';
	} elseif (has_post_thumbnail() && (!$embed_url)) {

		$thumb = get_post_thumbnail_id();
		echo wp_get_attachment_image($thumb, 'full');
	}

	if (isset($dfd_ronneby['portfolio_page_select']) && $dfd_ronneby['portfolio_page_select']) {
		$page = $dfd_ronneby['portfolio_page_select'];
		$slug = get_permalink($page);
	}
	?>
</div>
<article class="folio-info folio-info-variant-2 twelve columns">

	<dl class="tabs contained horisontal clearfix">

		<dd class="active"><a href="#folio-desc-1"><?php _e('Description', 'dfd') ?></a></dd>

		<?php
		if (function_exists('get_field_objects')) {
			$fields = get_field_objects();
		} else {
			$fields = false;
		}
		if ($fields) {
			$i = 2;
			foreach ($fields as $field_name => $field) {
				if ($field['label']) {
					echo '<dd><a href="#folio-desc-' . $i . '">';
					echo $field['label'];
					echo '</a></dd>';

					$i++;
				}
			}
		} ?>

	</dl>
	<ul class="tabs-content contained">
		<li id="folio-desc-1Tab" class="active">

			<?php 
			while (have_posts()) { 
				the_post();
				echo get_the_content();
			}
			?>

		</li>

		<?php if ($fields) {
			$i = 2;
			foreach ($fields as $field_name => $field) {
				if ($field['label']) {
					echo '<li id="folio-desc-' . $i . 'Tab">';
					echo do_shortcode($field['value']);
					echo '</li>';

					$i++;
				}
			}
		} ?>
	</ul>

	<?php get_template_part('templates/entry-meta', 'portfolio'); ?>

	<?php get_template_part('templates/folio', 'terms'); ?>
</article>	
<div class="twelve columns">
	<div class="pages-nav twelve columns ">

		<?php previous_post_link('<div class="prev-link">%link</div>', 'Prev work'); ?>

		<?php if(!empty($page)): ?>
			<a class="to-folio" href="<?php echo esc_url($slug); ?>"></a>
		<?php endif; ?>

		<?php next_post_link('<div class="next-link">%link</div>', 'Next work'); ?>

	</div>

</div>
