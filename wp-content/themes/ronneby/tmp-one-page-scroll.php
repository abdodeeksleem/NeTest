<?php
/*
Template Name: For one page scroll
*/

$additional_layout_class = DfdMetaboxSettings::get('dfd_enable_page_spacer') ? 'dfd-custom-padding-html' : '';
if(DfdMetaboxSettings::get('dfd_enable_animation')) {
	$enable_animation = 'true';
	$enable_dots = 'false';
	$animation_style_class = DfdMetaboxSettings::get('dfd_animation_style');
	$additional_layout_class = ' dfd-enable-onepage-animation '.$animation_style_class;
} else {
	$enable_dots = DfdMetaboxSettings::get('dfd_enable_dots') ? 'false' : 'true';
	$enable_animation = 'false';
}
?>


<section id="layout" class="no-title one-page-scroll <?php echo esc_attr($additional_layout_class); ?>" data-enable-dots="<?php echo $enable_dots ?>" data-enable-animation="<?php echo $enable_animation ?>">


	<?php get_template_part('templates/content', 'page'); ?>

	
</section>