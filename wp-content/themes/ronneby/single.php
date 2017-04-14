<?php
global $dfd_ronneby;

while (have_posts()) : the_post();

$blog_style = DfdMetaBoxSettings::compared('blog_single_style', false);

if(!$blog_style || empty($blog_style)) {
	$blog_style = 'base';
}

$blog_stun_header = DfdMetaBoxSettings::compared('blog_single_stun_header', false);

$blog_layout = DfdMetaBoxSettings::compared('blog_single_layout', false);

$blog_sidebars = DfdMetaBoxSettings::compared('blog_single_sidebars', false);

if($blog_stun_header != 'off') {
	get_template_part('templates/header/top', 'page');
}

if(empty($blog_layout) || $blog_layout == 'boxed') {
	$blog_layout .= ' row';
}

$blog_layout .= ' dfd-single-style-'.$blog_style;

?>

<section id="layout" class="single-post dfd-equal-height-children">
	<div class="single-post dfd-single-layout-<?php echo esc_attr($blog_layout) ?>">

		<?php
		if(!empty($blog_sidebars) && $blog_sidebars) {
			switch($blog_sidebars) {
				case '3c-l-fixed':
					$dfd_layout = 'sidebar-left2';
					$dfd_width = 'six dfd-eq-height';
					break;
				case '3c-r-fixed':
					$dfd_layout = 'sidebar-right2';
					$dfd_width = 'six dfd-eq-height';
					break;
				case '2c-l-fixed':
					$dfd_layout = 'sidebar-left';
					$dfd_width = 'nine dfd-eq-height';
					break;
				case '2c-r-fixed':
					$dfd_layout = 'sidebar-right';
					$dfd_width = 'nine dfd-eq-height';
					break;
				case '3c-fixed':
					$dfd_layout = 'sidebar-both';
					$dfd_width = 'six dfd-eq-height';
					break;
				case '1col-fixed':
				default:
					$dfd_layout = '';
					$dfd_width = 'twelve';
			}
			echo '<div class="blog-section ' . esc_attr($dfd_layout) . '">';
			echo '<section id="main-content" role="main" class="' . esc_attr($dfd_width) . ' columns">';
		} else {
			set_layout('single', true);
		}
		?>
        
		<?php get_template_part('templates/inside-pagination'); ?>
		
			<?php get_template_part('templates/blog/single',$blog_style) ?>
		
        <?php endwhile; ?>
		
        <?php
		
		comments_template();

        if(!empty($blog_sidebars) && $blog_sidebars) {
			echo ' </section>';

			if (($blog_sidebars == "2c-l-fixed") || ($blog_sidebars == "3c-fixed")) {
				get_template_part('templates/sidebar', 'left');
				echo ' </div>';
			}
			if (($blog_sidebars == "3c-l-fixed")){
				get_template_part('templates/sidebar', 'right');
				echo ' </div>';
				get_template_part('templates/sidebar', 'left');
			}
			if ($blog_sidebars == "3c-r-fixed"){
				get_template_part('templates/sidebar', 'left');
				echo ' </div>';
			}
			if (($blog_sidebars == "2c-r-fixed") || ($blog_sidebars == "3c-fixed") || ($blog_sidebars == "3c-r-fixed") ) {
				get_template_part('templates/sidebar', 'right');
			}
			echo '</div>';
        } else {
			set_layout('single', false);
		}

        ?>

    </div>
	<?php
		if (isset($dfd_ronneby['blog_items_disp']) && $dfd_ronneby['blog_items_disp']) { ?>
			<div class="block-under-single-post">
				<div class="row">
					<?php echo do_shortcode($dfd_ronneby['block_single_blog_item']); ?>
				</div>
			</div>
	<?php } ?>
</section>