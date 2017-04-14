<?php
global $dfd_ronneby;

$single_gallery_stun_header = DfdMetaBoxSettings::compared('dfd_gallery_single_stun_header', false);

$single_gallery_layout = DfdMetaBoxSettings::compared('dfd_gallery_single_layout', false);

$single_gallery_sidebars = DfdMetaBoxSettings::compared('dfd_gallery_single_sidebars', false);

if($single_gallery_stun_header != 'off') {
	get_template_part('templates/header/top', 'page');
}
?>
<section id="layout" class="dfd-single-gallery dfd-equal-height-children">
    <div class="row <?php echo esc_attr($single_gallery_layout) ?>">

        <?php
		if(!empty($single_gallery_sidebars) && $single_gallery_sidebars) {
			switch($single_gallery_sidebars) {
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
			echo '<section id="main-content" role="main" class="' . $dfd_width . ' columns">';
		} else {
			set_layout('single', true);
		}
	?>

	<?php get_template_part('templates/gallery/gallery','media'); ?>

	<?php
		if(!empty($single_gallery_sidebars) && $single_gallery_sidebars) {
			echo ' </section>';

			if (($single_gallery_sidebars == "2c-l-fixed") || ($single_gallery_sidebars == "3c-fixed")) {
				get_template_part('templates/sidebar', 'left');
				echo ' </div>';
			}
			if (($single_gallery_sidebars == "3c-l-fixed")){
				get_template_part('templates/sidebar', 'right');
				echo ' </div>';
				get_template_part('templates/sidebar', 'left');
			}
			if ($single_gallery_sidebars == "3c-r-fixed"){
				get_template_part('templates/sidebar', 'left');
				echo ' </div>';
			}
			if (($single_gallery_sidebars == "2c-r-fixed") || ($single_gallery_sidebars == "3c-fixed") || ($single_gallery_sidebars == "3c-r-fixed") ) {
				get_template_part('templates/sidebar', 'right');
			}
			echo '</div>';
        } else {
			set_layout('single', false);
		}
        ?>

    </div>
</section>