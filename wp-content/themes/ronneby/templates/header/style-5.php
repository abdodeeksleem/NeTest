<?php
global $dfd_ronneby;

if(isset($dfd_ronneby['header_fifth_soc_icons_hover_style']) && !empty($dfd_ronneby['header_fifth_soc_icons_hover_style'])) {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-'.$dfd_ronneby['header_fifth_soc_icons_hover_style'];
} else {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-1';
}
$header_container_class = 'dfd-header-layout-fixed';
$header_container_class .= (isset($dfd_ronneby['header_fifth_alignment']) && !empty($dfd_ronneby['header_fifth_alignment'])) ? ' '.$dfd_ronneby['header_fifth_alignment'] : ' left';
$header_container_class .= (isset($dfd_ronneby['header_fifth_content_alignment']) && !empty($dfd_ronneby['header_fifth_content_alignment'])) ? ' '.$dfd_ronneby['header_fifth_content_alignment'] : ' text-left';

?>
<?php get_template_part('templates/header/block', 'search'); ?>
<div id="header-container" class="<?php echo dfd_get_header_style(); ?> <?php echo esc_attr($header_container_class); ?>">
	<section id="header">
		<div class="dfd-side-header-container">
			<div class="logo-wrap header-top-logo-panel dfd-tablet-hide">
				<div class="row">
					<div class="columns twelve">
						<?php get_template_part('templates/header/block', 'custom_logo_side'); ?>
					</div>
				</div>
			</div>
			<div class="header-wrap">
				<div class="row decorated">
					<div class="columns twelve header-main-panel">
						<div class="header-col-left">
							<div class="mobile-logo">
								<?php if($dfd_ronneby['mobile_logo_image']['url']) : ?>
									<img src="<?php echo esc_url($dfd_ronneby['mobile_logo_image']['url']); ?>" alt="logo"/>
								<?php else : ?>
									<?php get_template_part('templates/header/block', 'custom_logo'); ?>
								<?php endif; ?>
							</div>
						</div>
						<div class="header-col-right">
							<div class="header-icons-wrapper">
								<?php get_template_part('templates/header/block', 'responsive-menu'); ?>
								<?php get_template_part('templates/header/block', 'lang_sel'); ?>
								<?php if (is_plugin_active('woocommerce/woocommerce.php')) echo dfd_woocommerce_total_cart(); ?>
								<?php get_template_part('templates/header/search', 'button'); ?>
							</div>
						</div>
						<div class="header-col-fluid">
							<?php get_template_part('templates/header/block', 'main_menu'); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="dfd-header-bottom dfd-tablet-hide">
				<?php get_template_part('templates/header/search', 'button'); ?>
				<?php if (is_plugin_active('woocommerce/woocommerce.php')) echo dfd_woocommerce_total_cart(); ?>
				<?php if(isset($dfd_ronneby['head_fifth_show_header_soc_icons']) && $dfd_ronneby['head_fifth_show_header_soc_icons']) { ?>
					<div class="clear"></div>
					<div class="widget soc-icons <?php echo esc_attr($header_soc_icons_hover_style) ?>">
						<?php echo crum_social_networks(true); ?>
					</div>
					<div class="clear"></div>
				<?php } ?>
				<?php if(isset($dfd_ronneby['header_fifth_copyright']) && $dfd_ronneby['header_fifth_copyright']) { ?>
					<div class="dfd-copyright">
						<?php echo $dfd_ronneby['header_fifth_copyright']; ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
</div>