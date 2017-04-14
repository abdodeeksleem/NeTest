<?php
global $dfd_ronneby;

if(isset($dfd_ronneby['header_seventh_soc_icons_hover_style']) && !empty($dfd_ronneby['header_seventh_soc_icons_hover_style'])) {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-'.$dfd_ronneby['header_seventh_soc_icons_hover_style'];
} else {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-1';
}

$header_container_class = 'without-top-panel dfd-header-layout-fixed';
$header_container_class .= (isset($dfd_ronneby['enable_sticky_header']) && strcmp($dfd_ronneby['enable_sticky_header'], 'off') === 0) ? ' sticky-header-disabled' : ' sticky-header-enabled';
$header_container_class .= (isset($dfd_ronneby['header_seventh_content_alignment']) && !empty($dfd_ronneby['header_seventh_content_alignment'])) ? ' '.$dfd_ronneby['header_seventh_content_alignment'] : ' text-left';

if(isset($dfd_ronneby['stun_header_title_align_header_7']) && strcmp($dfd_ronneby['stun_header_title_align_header_7'],'1') === 0) {
	$header_container_class = ' dfd-keep-menu-fixer';
}
?>
<?php get_template_part('templates/header/block', 'search'); ?>
<div id="header-container" class="<?php echo dfd_get_header_style(); ?> without-top-panel logo-position-left <?php echo esc_attr($header_container_class); ?>">
	<div class="dfd-top-row dfd-tablet-hide">
		<div class="row">
			<div class="twelve columns">
				<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
				<a href="#" title="menu" class="dfd-menu-button">
					<span class="icon-wrap dfd-top-line"></span>
					<span class="icon-wrap dfd-middle-line"></span>
					<span class="icon-wrap dfd-bottom-line"></span>
				</a>
			</div>
		</div>
		<?php get_template_part('templates/header/block', 'toppanel'); ?>
	</div>
	<section id="header">
		<div class="header-wrap">
			<div class="row decorated">
				<div class="columns twelve header-main-panel">
					<div class="header-col-left">
						<div class="mobile-logo">
							<?php if($dfd_ronneby['mobile_logo_image']['url']) : ?>
								<img src="<?php echo esc_url($dfd_ronneby['mobile_logo_image']['url']); ?>" alt="logo" />
							<?php else : ?>
								<?php get_template_part('templates/header/block', 'custom_logo'); ?>
							<?php endif; ?>
						</div>
						<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
					</div>
					<div class="header-col-right text-center clearfix">
						<div class="header-icons-wrapper">
							<?php get_template_part('templates/header/block', 'responsive-menu'); ?>
							<?php get_template_part('templates/header/search', 'button'); ?>
							<?php get_template_part('templates/header/block', 'lang_sel'); ?>
							<?php if (is_plugin_active('woocommerce/woocommerce.php')) echo dfd_woocommerce_total_cart(); ?>
						</div>
					</div>
					<div class="header-col-fluid">
						<?php get_template_part('templates/header/block', 'main_menu'); ?>
					</div>
					<?php if(isset($dfd_ronneby['head_seventh_show_soc_icons']) && $dfd_ronneby['head_seventh_show_soc_icons'] || isset($dfd_ronneby['header_seventh_copyright']) && $dfd_ronneby['header_seventh_copyright']) : ?>
						<div class="dfd-header-bottom dfd-tablet-hide">
							<?php if(isset($dfd_ronneby['head_seventh_show_soc_icons']) && $dfd_ronneby['head_seventh_show_soc_icons']) : ?>
								<div class="clear"></div>
								<div class="widget soc-icons <?php echo esc_attr($header_soc_icons_hover_style) ?>">
									<?php echo crum_social_networks(true); ?>
								</div>
								<div class="clear"></div>
							<?php endif; ?>
							<?php if(isset($dfd_ronneby['header_seventh_copyright']) && $dfd_ronneby['header_seventh_copyright']) { ?>
								<div class="dfd-copyright"><?php echo $dfd_ronneby['header_seventh_copyright']; ?></div>
							<?php } ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</div>