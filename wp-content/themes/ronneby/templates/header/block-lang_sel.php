<?php
global $dfd_ronneby;
if (isset($dfd_ronneby['wpml_lang_show']) && $dfd_ronneby['wpml_lang_show']): ?>
	<div class="lang-sel sel-dropdown">
		<a href="#"><span><?php echo (defined('ICL_LANGUAGE_CODE'))?  ucfirst(ICL_LANGUAGE_CODE):''; ?></span></a>

			<ul>
				<?php
				function dfd_language_selector_flags() {
					if (function_exists('icl_get_languages')) {
						$languages = icl_get_languages('skip_missing=0&orderby=code');

						if (!empty($languages)) {
							foreach ($languages as $l) {
								echo '<li>';
								echo '<a href="' . $l['url'] . '">';
								echo '<span>'.$l['translated_name'].'</span>';
								echo '</a>';
								echo '</li>';
							}
						}
					}
				}

				dfd_language_selector_flags();
				?>
			</ul>
	</div>
<?php elseif (isset($dfd_ronneby['lang_shortcode']) && $dfd_ronneby['lang_shortcode']): ?>
	<?php echo do_shortcode($dfd_ronneby['lang_shortcode']); ?>
<?php endif; ?>
