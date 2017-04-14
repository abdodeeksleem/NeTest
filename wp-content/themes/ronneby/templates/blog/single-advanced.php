<?php
$show_title = DfdMetaBoxSettings::compared('blog_single_show_title', false);

$show_meta = DfdMetaBoxSettings::compared('blog_single_show_meta', false);

$show_read_more_share = DfdMetaBoxSettings::compared('blog_single_show_read_more_share', false);
?>
<article <?php post_class(); ?>>
	<div class="dfd-single-post-heading">
		<?php if($show_title == 'on') : ?>
			<div class="dfd-news-categories">
				<?php get_template_part('templates/entry-meta/mini', 'category'); ?>
			</div>
			<div class="dfd-blog-title"><?php the_title(); ?></div>
		<?php endif; ?>
		<?php if($show_meta == 'on') : ?>
			<?php get_template_part('templates/entry-meta', 'post-bottom') ?>
		<?php endif; ?>
	</div>
	<div class="entry-content">

		<?php     

		if(!get_post_format()) {
			get_template_part($post->ID, 'standard');
			the_content();
		} elseif (has_post_format('video')) {
			get_template_part('templates/post', 'video');
			the_content();
		} elseif (has_post_format('gallery')) {
			get_template_part('templates/post', 'gallery');
			the_content();
		} elseif (has_post_format('quote')) {
			get_template_part('templates/post', 'quote');
		} elseif (has_post_format('audio')) {
			get_template_part('templates/post', 'audio');
			the_content();
		}
	 ?>

	</div>
	<?php if($show_read_more_share == 'on') : ?>
		<div class="dfd-meta-container">
			<div class="dfd-commentss-tags">
				<div class="post-comments-wrap">
					<?php get_template_part('templates/entry-meta/mini', 'comments-number'); ?>
					<span class="box-name"><?php _e('Comments','dfd') ?></span>
				</div>
				<div class="dfd-single-tags clearfix">
					<?php get_template_part('templates/entry-meta/mini', 'tags'); ?>
				</div>
			</div>
			<div class="dfd-like-share">
				<div class="post-like-wrap left">
					<?php get_template_part('templates/entry-meta/mini', 'like'); ?>
				</div>
				<?php get_template_part('templates/entry-meta/mini','share-blog') ?>
			</div>
		</div>
	<?php endif; ?>

</article>