<?php
global $dfd_ronneby;

$data_atts = $sort_panel_html = $media_content_file = '';

$blog_page_style = DfdMetaBoxSettings::compared('blog_layout_style', 'standard');

$blog_items_offset = DfdMetaBoxSettings::compared('blog_items_offset', 0);

$show_title = DfdMetaBoxSettings::compared('blog_show_title', false);

$show_meta = DfdMetaBoxSettings::compared('blog_show_meta', false);

$heading_position = DfdMetaBoxSettings::compared('blog_heading_position', 'bottom');

$show_description = DfdMetaBoxSettings::compared('blog_show_description', false);

$content_alignment = DfdMetaBoxSettings::compared('blog_content_alignment', false);

$show_read_more_share = DfdMetaBoxSettings::compared('blog_show_read_more_share', false);

$read_more_style = DfdMetaBoxSettings::compared('blog_read_more_style', false);

$enable_sort_panel = DfdMetaBoxSettings::compared('blog_sort_panel', false);

$sort_panel_align = DfdMetaBoxSettings::compared('blog_sort_panel_align', false);

$blog_number = get_post_meta($post->ID, 'blog_works_per_page', true);
$number_per_page = ($blog_number) ? $blog_number : '16';

$blog_custom_categories = array();

$selected_custom_categories = wp_get_object_terms($post->ID, 'category');
if (!empty($selected_custom_categories) && !is_wp_error($selected_custom_categories)) {
	foreach ($selected_custom_categories as $term) {
		$blog_custom_categories[] = $term->term_id;
	}
}

if ($blog_custom_categories) {
	$blog_custom_categories = implode(",", $blog_custom_categories);
}

if (is_front_page()) {
	$page = get_query_var('page');
	$paged = ($page) ? $page : 1;
} else {
	$page = get_query_var('paged');
	$paged = ($page) ? $page : 1;
}

if ($blog_custom_categories) {
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $number_per_page,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $blog_custom_categories,
			)
		)
	);
} else {
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $number_per_page,
		'paged' => $paged
	);
}

$item_css = $block_css = $before_content = $after_content = '';
if($blog_items_offset) {
	$blog_items_offset = $blog_items_offset / 2;
	$block_css .= 'style="margin: -'.esc_attr($blog_items_offset).'px;"';
	$item_css .= 'style="padding: '.esc_attr($blog_items_offset).'px;"';
}

if(strcmp($blog_page_style, 'left-image') === 0 || strcmp($blog_page_style, 'right-image') === 0) {
	$media_content_file .= 'fitRows-';
	$before_content .= '<div class="dfd-content-wrap">';
	$after_content .= '</div>';
}
if(strcmp($blog_page_style, 'masonry') === 0 || strcmp($blog_page_style, 'fitRows') === 0) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('dfd-isotope-blog');
	$blog_page_columns = DfdMetaBoxSettings::compared('blog_columns', 1);
	
	$data_atts .= ' data-columns="'.esc_attr($blog_page_columns).'"';
	$data_atts .= ' data-layout-style="'.esc_attr($blog_page_style).'"';
	if(strcmp($enable_sort_panel,'on') === 0) {
		$taxonomy = 'category';
		if ($blog_custom_categories) {
			$categories = get_terms($taxonomy, array('include' => $blog_custom_categories));
		} else {
			$categories = get_terms($taxonomy);
		}
		$sort_panel_html .= '<div class="clearfix" '.$item_css.'>';
			$sort_panel_html .= '<div class="sort-panel '.esc_attr($sort_panel_align).'">';
				$sort_panel_html .= '<ul class="filter">';
					$sort_panel_html .= '<li class="active"><a data-filter=".post" href="#">'. __('All', 'dfd') .'</a></li>';
					foreach ($categories as $category) {
						$sort_panel_html .= '<li><a data-filter=".post[data-category~=\'' . strtolower(preg_replace('/\s+/', '-', $category->slug)) . '\']" href="#">' . $category->name . '</a></li>';
					}
				$sort_panel_html .= '</ul>';
			$sort_panel_html .= '</div>';
		$sort_panel_html .= '</div>';
	}
	$media_content_file .= $blog_page_style.'-';
}

?>
<div class="dfd-blog-wrap" <?php echo $block_css ?>>
	<?php
	echo $sort_panel_html;
	?>
	<div class="dfd-blog dfd-blog-<?php echo esc_attr($blog_page_style) ?>" <?php echo $data_atts ?>>
		<?php
		$wp_query = new WP_Query($args);

		while ($wp_query->have_posts()) : $wp_query->the_post();

			if (has_post_thumbnail()) {
				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL

				$img_src = $img_url;

				if(strcmp($blog_page_style, 'fitRows') === 0) {
					$img_url = dfd_aq_resize($img_url, 900, 600, true, true, true);
				}

				if(!$img_url) {
					$img_url = $img_src;
				}
				
				$terms = get_the_terms(get_the_ID(), 'category');
				$article_tags_classes = '';

				if(strcmp($enable_sort_panel,'on') === 0) {
					$article_tags_classes .= 'data-category="';
					if(is_array($terms)) {
						foreach ($terms as $term) {
							$article_tags_classes .= ' ' . strtolower(preg_replace('/\s+/', '-', $term->slug)) . ' ';
						}
					}
					$article_tags_classes .= '"';
				}
				
				$post_class_elems = get_post_class();

				$post_class = implode(' ', $post_class_elems);
				
				$post_class .= ' dfd-title-'.$heading_position;

			?>
				<div class="<?php echo esc_attr($post_class) ?>" <?php echo $article_tags_classes; ?>>
					<div class="cover <?php echo esc_attr($content_alignment) ?>" <?php echo $item_css ?>>

						<?php
						if($heading_position == 'bottom') {
							get_template_part('templates/blog', $media_content_file.'media');
						}
						?>

						<?php echo $before_content; ?>

						<?php if($show_title == 'on') : ?>
							<div class="dfd-news-categories">
								<?php get_template_part('templates/entry-meta/mini', 'category'); ?>
							</div>
							<div class="dfd-blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<?php endif; ?>

						<?php if($show_meta == 'on') { ?>
							<div class="dfd-meta-wrap">
								<?php get_template_part('templates/entry-meta', 'post-bottom'); ?>
							</div>
						<?php } ?>
							
						<?php
						if($heading_position == 'top') {
							get_template_part('templates/blog', $media_content_file.'media');
						}
						?>

						<?php if($show_description == 'on') :
							$excerpt = get_the_excerpt();
							?>
							<?php if(has_post_format('quote') && ($blog_page_style == 'masonry' || $blog_page_style == 'standard')) { ?>
								<div class="entry-media">
									<?php get_template_part('templates/post', 'quote'); ?>
									<div class="post-comments-wrap">
										<?php get_template_part('templates/entry-meta/mini', 'comments-number'); ?>
									</div>
									<div class="post-like-wrap">
										<?php get_template_part('templates/entry-meta/mini', 'like'); ?>
									</div>
								</div>
							<?php } else { ?>
									<div class="entry-content">
										<?php echo !empty($excerpt) ? '<p>'.$excerpt.'</p>' : ''; ?>
									</div>
							<?php } ?>
						<?php endif; ?>
						<?php if($show_read_more_share == 'on') : ?>
							<div class="dfd-read-share clearfix">
								<div class="read-more-wrap">
									<a href="<?php the_permalink(); ?>" class="more-button <?php echo esc_attr($read_more_style) ?>" title="<?php _('Read more','dfd') ?>" data-lang="en"><?php _e('More', 'dfd'); ?></a>
								</div>
								<?php get_template_part('templates/entry-meta/mini','share-blog') ?>
							</div>
						<?php endif; ?>
						<?php echo $after_content; ?>
					</div>
				</div>
			<?php
			}

		endwhile;
		?>
	</div>
		
	<?php if ($wp_query->max_num_pages > 1) : ?>

		<nav class="page-nav">

			<?php echo dfd_kadabra_pagination(); ?>

		</nav>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</div>