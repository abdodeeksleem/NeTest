<?php
	$data_title = get_the_title();
	$data_link = get_permalink();
?>
<div class="dfd-blog-share-popup-wrap" data-directory="<?php echo get_template_directory_uri(); ?>" data-url="<?php echo esc_url($data_link) ?>" data-text="Make your sharing widget with Sharrre (jQuery Plugin)" data-title="<?php _e('Share','dfd') ?>"></div>