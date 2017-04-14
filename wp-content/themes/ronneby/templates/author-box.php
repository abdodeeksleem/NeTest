<?php
/**
 * Author Box
 *
 * Displays author box with author description and thumbnail on single posts
 *
 * @package WordPress
 * @subpackage Dynamic theme, for WordPress
 */
?>

<?php
$author_info = get_the_author_meta('dfd_author_info');
?>

<div class="about-author">
    <div class="author-top-box">
	    <figure class="author-photo">
		    <?php echo get_avatar( get_the_author_meta('ID') , 100 ); ?>
	    </figure>
	    <div class="clearfix">
			<div class="author-top-inner">
				<h3 class="box-name">
					<?php 
						global $authordata;
						if ( is_object( $authordata ) ) {
							echo ($authordata->display_name) ? $authordata->display_name : $authordata->user_nicename;
						}
					?>
				</h3>
					<?php /* if (!empty($author_info)): ?>
						<h4 class="widget-sub-title"><?php echo $author_info; ?></h4>
					<?php endif; */ ?>
			</div>
			<div class="author-description">
				<p><?php the_author_meta('description'); ?></p>

					<?php echo author_social_networks(); ?>
			</div>
	    </div>
    </div>
</div>