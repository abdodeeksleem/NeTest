<?php get_template_part('templates/header/top', 'page'); ?>

<section id="layout" class="blog-page dfd-equal-height-children">
    <div class="row">

		<?php set_layout('404'); ?>
		
		<article id="post-0" class="not-found404 clearfix">
			
			<header class="entry-header main-title text-center">
				<h1><?php _e('oops', 'dfd'); ?></h1>
				<p class="name"><?php _e('<strong>404</strong>Nothing was found', 'dfd'); ?></p>
				<p class="subtitle-name"><?php _e('Perhaps searching, or one of the links below, can help.', 'dfd'); ?></p>
            </header>
			
			<div class="container columns six">
				<div class="arhives">
					<select name="archive-menu" onChange="document.location.href = this.options[this.selectedIndex].value;">
						<option value="">Search in archives</option>
						<?php wp_get_archives('type=monthly&format=option'); ?>
					</select>
				</div>
			</div>
			
			<div class="container columns six">
				<?php get_search_form(); ?>
			</div>
			
		</article>
	</div>	
</section>