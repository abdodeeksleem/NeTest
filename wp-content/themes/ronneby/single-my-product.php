<?php
global $dfd_ronneby;
$description_position = dfd_get_folio_description_align();
$gallery_type = dfd_get_folio_gallery_type(); 
$folio_inside_template = dfd_get_folio_inside_template();

$single_folio_class = (strcmp($folio_inside_template, 'folio_inside_1') === 0) ? $gallery_type : '';
$inside_format = $inside_width = '';
if(!empty($post) && is_object($post)) {
	$inside_format .= get_post_meta($post->ID, 'folio_layout_type', true);
	$inside_width .= get_post_meta($post->ID, 'folio_layout_width', true);
}
if(!empty($inside_format) && strcmp($inside_format, 'page_builder_only_stunn') !== 0) {
	get_template_part('templates/header/top', 'folio');
}
$single_folio_class .= ' '. $inside_format;
 ?>

<?php get_template_part('templates/inside-pagination'); ?>

<section id="layout" class="single-folio <?php echo esc_attr($folio_inside_template); ?> <?php echo esc_attr($single_folio_class); ?>">

	<?php 
	if(!empty($inside_format) && strcmp($inside_format, 'default') !== 0) {
		get_template_part('templates/content', 'page');
	} else {
	?>
		<div class="row project <?php echo esc_attr($inside_width); ?>">
			<?php
			if (!post_password_required(get_the_id())) {
				get_template_part('templates/portfolio/inside', $folio_inside_template);
			} else {
				the_content();
			}
			?>
		</div>
	<?php comments_template(); ?>
	<?php
		if ($dfd_ronneby['recent_items_disp']) {
			echo '<div class="dfd-portfolio-shortcodes">';
				echo do_shortcode($dfd_ronneby['block_single_folio_item']);
			echo '</div>';
		}
	}
	?>

</section>

<?php if (strcmp($folio_inside_template, 'folio_inside_2') === 0) : ?>
	<?php if (isset($dfd_ronneby['portfolio_single_slider']) && strcmp($dfd_ronneby['portfolio_single_slider'],'slider') === 0): ?>
		<script type="text/javascript">
			jQuery(window).load(function () {
				var target_flexslider = jQuery('#my-work-slider');
				target_flexslider.flexslider({
					namespace: "my-work-",
					animation: "slide",
					controlNav: "thumbnails",
					animationLoop: false,
					smoothHeight: true,
					directionNav: false,

					start: function (slider) {
						slider.removeClass('loading');
					}

				});
			});
		</script>
	<?php endif;?>
<?php endif; ?>

<?php if (strcmp($folio_inside_template, 'folio_inside_1') === 0) : ?>
	<?php 
		
		switch ($gallery_type) {
			case 'default':
				?>
				<script type="text/javascript">
					(function($) {
						"use strict";
						$(document).ready(function() {
							$('.portfolio-inside-main-carousel').slick({
								infinite: true,
								slidesToShow: 1,
								slidesToScroll: 1,
								speed: 600,
								arrows: false,
								asNavFor: '.portfolio-inside-thumbs-carousel',
								autoplay: true,
								autoplaySpeed: 7000,
								dots: false
							});
							$('.portfolio-inside-thumbs-carousel').slick({
								infinite: true,
								slidesToShow: 5,
								slidesToScroll: 1,
								asNavFor: '.portfolio-inside-main-carousel',
								speed: 600,
								//centerMode: true,
								arrows: false,
								focusOnSelect: true,
								dots: false,
								responsive: [
								{
									breakpoint: 1280,
									settings: {
										slidesToShow: 4,
										infinite: true,
										arrows: false,
										dots: false
									}
								},
								{
									breakpoint: 1024,
									settings: {
										slidesToShow: 3,
										infinite: true,
										arrows: false,
										dots: false
									}
								},
								{
									breakpoint: 600,
									settings: {
										slidesToShow: 2,
										arrows: false,
										dots: false
									}
								}
							]
							});
						});
						
					})(jQuery);
				</script>
				<?php
				break;
			case 'big_images_list':
				break;
			case 'middle_image_list':
				?>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						var container = jQuery('#my-work-slider > ul');
						container.addClass('row collapse');
						jQuery('> li', container).addClass('columns six');
						container.portfolio_inside_isotop(2);
					});
				</script>
				<?php
				break;
			case 'small_images_list':
				?>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						var container = jQuery('#my-work-slider > ul');
						container.addClass('row collapse');
						jQuery('> li', container).addClass('columns four');
						container.portfolio_inside_isotop(3);
					});
				</script>
				<?php
				break;
			case 'advanced_gallery':
				?>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						var container = jQuery('#my-work-slider > ul');
						container.addClass('row collapse');
						jQuery('> li', container).first().addClass('columns eight').end().not(':first').addClass('columns four');
					});
				</script>
				<?php
				break;
		}; ?>
<?php endif; ?>