<div class="blog-top-block">
	<div class="box-name">Filter by:</div>
	<div class="sel-dropdown">
		<a href="#">Categories<span></span></a>
		<ul class="sel-dropdown category-filer">
		<?php
			$categories = get_categories();
			foreach($categories as $category) :
				$t_id = $category->term_id;
				$icon = get_option("taxonomy_$t_id");
		?>
				<li>
					<div class="icon-wrap"><i class="<?php echo !empty($icon['custom_term_meta']) ? $icon['custom_term_meta'] : 'crdash-Arrow2CircleRight'; ?>"></i></div>
					<a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a>
				</li>

			<?php endforeach; ?>
		</ul>
	</div>
	<div class="sel-dropdown">
		<a href="#">Tags<span></span></a>
		<ul class="sel-dropdown filter-tags">
		<?php
			$tags = get_tags();
				foreach($tags as $tag) :
					$t_id = $tag->term_id;
			?>
					<li>
						<a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
					</li>

				<?php endforeach; ?>
		</ul>
	</div>
</div>