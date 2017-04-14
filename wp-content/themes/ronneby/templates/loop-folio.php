<?php
global $dfd_ronneby;

$data_atts = $sort_panel_html = '';

$folio_page_style = DfdMetaBoxSettings::compared('folio_layout_style', 'standard');

$folio_items_offset = DfdMetaBoxSettings::compared('folio_items_offset', 0);

$folio_hover_style = DfdMetaBoxSettings::get('folio_hover');

if(!$folio_hover_style) {
	$folio_hover_style = 'portfolio-hover-style-1';
}

$show_title = DfdMetaBoxSettings::compared('folio_show_title', false);

$show_meta = DfdMetaBoxSettings::compared('folio_show_meta', false);

$show_description = DfdMetaBoxSettings::compared('folio_show_description', false);

$content_alignment = DfdMetaBoxSettings::compared('folio_content_alignment', false);

$enable_sort_panel = DfdMetaBoxSettings::compared('folio_sort_panel', false);

$sort_panel_align = DfdMetaBoxSettings::compared('folio_sort_panel_align', false);

$folio_number = get_post_meta($post->ID, 'folio_works_per_page', true);
$number_per_page = ($folio_number) ? $folio_number : '16';

$folio_custom_categories = array();

$selected_custom_categories = wp_get_object_terms($post->ID, 'my-product_category');
if (!empty($selected_custom_categories) && !is_wp_error($selected_custom_categories)) {
	foreach ($selected_custom_categories as $term) {
		$folio_custom_categories[] = $term->term_id;
	}
}

if ($folio_custom_categories) {
	$folio_custom_categories = implode(",", $folio_custom_categories);
}

if (is_front_page()) {
	$page = get_query_var('page');
	$paged = ($page) ? $page : 1;
} else {
	$page = get_query_var('paged');
	$paged = ($page) ? $page : 1;
}

if ($folio_custom_categories) {
	$args = array(
		'post_type' => 'my-product',
		'posts_per_page' => $number_per_page,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'my-product_category',
				'field' => 'id',
				'terms' => $folio_custom_categories,
			)
		)
	);
} else {
	$args = array(
		'post_type' => 'my-product',
		'posts_per_page' => $number_per_page,
		'paged' => $paged
	);
}

if(strcmp($folio_page_style, 'masonry') === 0 || strcmp($folio_page_style, 'fitRows') === 0) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('dfd-isotope-portfolio');
	$folio_page_columns = DfdMetaBoxSettings::compared('folio_columns', 1);
	
	$data_atts .= ' data-columns="'.esc_attr($folio_page_columns).'"';
	$data_atts .= ' data-layout-style="'.esc_attr($folio_page_style).'"';
	if(strcmp($enable_sort_panel,'on') === 0) {
		$taxonomy = 'my-product_category';
		if ($folio_custom_categories) {
			$categories = get_terms($taxonomy, array('include' => $folio_custom_categories));
		} else {
			$categories = get_terms($taxonomy);
		}
		$sort_panel_html .= '<div class="row '.esc_attr($sort_panel_align).'">';
			ob_start();
			dfd_folio_sort_panel($categories);
			$sort_panel_html .= ob_get_clean();
		$sort_panel_html .= '</div>';
	}
}

if($folio_items_offset) {
	$folio_items_offset = $folio_items_offset / 2;
}
?>
<div class="dfd-potfolio-wrap" <?php echo !empty($folio_items_offset) ? 'style="margin: -'.esc_attr($folio_items_offset).'px;"' : '' ?>>
	<?php
	echo $sort_panel_html;
	?>
	<div class="dfd-portfolio dfd-portfolio-<?php echo esc_attr($folio_page_style) ?>" <?php echo $data_atts ?>>
		<?php
		$wp_query = new WP_Query($args);

		while ($wp_query->have_posts()) : $wp_query->the_post();

			if (has_post_thumbnail()) {
				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL

				$img_src = $img_url;

				if(strcmp($folio_page_style, 'fitRows') === 0) {
					$img_url = dfd_aq_resize($img_url, 900, 600, true, true, true);
				}

				if(!$img_url) {
					$img_url = $img_src;
				}
				
				$terms = get_the_terms(get_the_ID(), 'my-product_category');
				$article_tags_classes = '';

				if(is_array($terms)) {
					$article_tags_classes .= 'data-category="';
					if(is_array($terms)) {
						foreach ($terms as $term) {
							$article_tags_classes .= ' ' . strtolower(preg_replace('/\s+/', '-', $term->slug)) . ' ';
						}
					}
					$article_tags_classes .= '"';
				}
				
			?>
				<div class="project <?php echo esc_attr($folio_hover_style); ?>" <?php echo $article_tags_classes ?>>
					<div class="cover <?php echo esc_attr($content_alignment) ?>" <?php echo !empty($folio_items_offset) ? 'style="padding: '.esc_attr($folio_items_offset).'px;"' : '' ?>>
						<div class="entry-thumb">
							<img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>"/>
							<?php get_template_part('templates/portfolio/entry-hover'); ?>
						</div>
						<?php if($show_title || $show_meta || $show_description) : ?>
							<?php if($show_title) : ?>
								<div class="block-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<?php endif; ?>

							<?php if($show_meta) : ?>
								<?php get_template_part('templates/folio', 'terms'); ?>
							<?php endif; ?>

							<?php if($show_description) :
								$excerpt = '<p>'.get_the_excerpt().'</p>';
								?>
								<div class="entry-content">
									<?php echo $excerpt; ?>
									<a href="<?php the_permalink(); ?>" class="more-button chaffle" title="" data-lang="en"><?php _e('More', 'dfd'); ?></a>
								</div>
							<?php endif; ?>
						<?php endif; ?>
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