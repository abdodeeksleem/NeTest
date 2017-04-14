<?php
global $dfd_ronneby;

$show_header_top_panel = isset($dfd_ronneby['header_third_top_panel']) && strcmp($dfd_ronneby['header_third_top_panel'], 'on') === 0;

if(isset($dfd_ronneby['header_third_soc_icons_hover_style']) && !empty($dfd_ronneby['header_third_soc_icons_hover_style'])) {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-'.$dfd_ronneby['header_third_soc_icons_hover_style'];
} else {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-1';
}
$header_container_class = '';
if(!isset($dfd_ronneby['header_third_sticky']) || strcmp($dfd_ronneby['header_third_sticky'], 'off') !== 0) {
	$header_container_class .= 'dfd-enable-headroom';
}
$header_container_class .= ($show_header_top_panel) ? ' with-top-panel' : ' without-top-panel';
$header_container_class .= (isset($dfd_ronneby['enable_sticky_header']) && strcmp($dfd_ronneby['enable_sticky_header'], 'off') === 0) ? ' sticky-header-disabled' : ' sticky-header-enabled';
$header_container_class .= (isset($dfd_ronneby['fixed_header_mode']) && strcmp($dfd_ronneby['fixed_header_mode'], 'on') === 0) ? ' dfd-header-layout-fixed' : '';
$header_container_class .= (isset($dfd_ronneby['head_third_enable_buttons']) && strcmp($dfd_ronneby['head_third_enable_buttons'], '1') === 0) ? '' : ' dfd-header-buttons-disabled';

?>

<div id="header-container landing-page-bonus" class="<?php echo dfd_get_header_style(); ?> <?php echo esc_attr($header_container_class); ?>">
	<section id="header" >
		<div class="row-fluid">
			<div class="header-landing-logo columns one">
				<a href="<?php echo home_url(); ?>/" class="fixed-header-logo">
					<img src="/wp-content/themes/ronneby/assets/images/logo.png" alt="logo"/>
				</a>
			</div>
			<div class=" columns ten landing-media">
				<div class="landing-social-media">
					<a href="#"><div class="facebook"></div></a>
					<a href="#"><div class="twitter"></div></a>
					<a href="#"><div class="linkedin"></div></a>
					<a href="#"><div class="googleplus"></div></a>
				</div>
			</div>
		</div>
	</section>
</div>