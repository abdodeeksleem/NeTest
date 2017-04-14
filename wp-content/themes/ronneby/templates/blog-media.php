<?php if(!has_post_format('quote')) : ?>
	<div class="entry-media">
	<?php
		switch(true) {
			case has_post_format('video'):
				get_template_part('templates/post', 'video');
				break;
			case has_post_format('audio'):
				get_template_part('templates/post', 'audio');
				?>
				<div class="post-comments-wrap">
					<?php get_template_part('templates/entry-meta/mini', 'comments-number'); ?>
				</div>
				<div class="post-like-wrap">
					<?php get_template_part('templates/entry-meta/mini', 'like'); ?>
				</div>
				<?php
				break;
			case has_post_format('gallery'):
				get_template_part('templates/post', 'gallery');
				break;
			default:
				get_template_part('templates/thumbnail/post');
		}
	?>
	</div>
<?php endif; ?>