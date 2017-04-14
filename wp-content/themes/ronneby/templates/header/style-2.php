<?php
global $post, $dfd_ronneby;

$show_header_top_panel = isset($dfd_ronneby['header_second_top_panel']) && strcmp($dfd_ronneby['header_second_top_panel'], 'on') === 0;

$header_logo_position = '';
$header_container_class = '';
if(!isset($dfd_ronneby['header_second_sticky']) || strcmp($dfd_ronneby['header_second_sticky'], 'off') !== 0) {
	$header_container_class .= 'dfd-enable-headroom';
}
$header_container_class .= ' dfd-header-layout-fixed';
if (!empty($post) && is_object($post)) {
	$page_id = $post->ID;

	$logo_position = get_post_meta($page_id, 'dfd_headers_logo_position', true);
	$header_logo_position = !empty($logo_position) ? $logo_position : 'left';
	$auto_colours = get_post_meta($page_id, 'dfd_auto_header_colors', true);
	if(strcmp($auto_colours, 'on') === 0) {
		$header_container_class .= ' dfd-smart-header';
		?>
		<script type="text/javascript">
			var dfd_smart_logo_dark = '<?php echo isset($dfd_ronneby['custom_logo_image']['url']) && $dfd_ronneby['custom_logo_image']['url'] ? esc_url($dfd_ronneby['custom_logo_image']['url']) : ''; ?>';
			var dfd_smart_logo_light = '<?php echo isset($dfd_ronneby['custom_logo_image_second']['url']) && $dfd_ronneby['custom_logo_image_second']['url'] ? esc_url($dfd_ronneby['custom_logo_image_second']['url']) : ''; ?>';
		</script>
		<?php
	}
}

if(empty($header_logo_position)) {
	$header_logo_position = 'left';
}

if(isset($dfd_ronneby['header_second_soc_icons_hover_style']) && !empty($dfd_ronneby['header_second_soc_icons_hover_style'])) {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-'.$dfd_ronneby['header_second_soc_icons_hover_style'];
} else {
	$header_soc_icons_hover_style = 'dfd-soc-icons-hover-style-1';
}

$header_container_class .= ($show_header_top_panel) ? ' with-top-panel' : ' without-top-panel';
$header_container_class .= (isset($dfd_ronneby['enable_sticky_header']) && strcmp($dfd_ronneby['enable_sticky_header'], 'off') === 0) ? ' sticky-header-disabled' : ' sticky-header-enabled';
$header_container_class .= (isset($dfd_ronneby['head_second_enable_buttons']) && strcmp($dfd_ronneby['head_second_enable_buttons'], '1') === 0) ? '' : ' dfd-header-buttons-disabled';
if(isset($dfd_ronneby['stun_header_title_align_header_2']) && strcmp($dfd_ronneby['stun_header_title_align_header_2'],'1') === 0) {
	$header_container_class = ' dfd-keep-menu-fixer';
}

?>
<?php get_template_part('templates/header/block', 'search'); ?>
<div id="header-container" class="<?php echo dfd_get_header_style(); ?> <?php echo esc_attr($header_container_class); ?>">
	<section id="header">
		<?php if ($show_header_top_panel) : ?>
			<div class="header-top-panel">
				<div class="row">
					<div class="columns twelve header-info-panel">
						<div class="social-media">
							<a href="#"><div class="facebook"></div></a>
							<a href="#"><div class="twitter"></div></a>
							<a href="#"><div class="linkedin"></div></a>
							<a href="#"><div class="googleplus"></div></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if (strcmp($header_logo_position, 'top-left') === 0 || strcmp($header_logo_position, 'top-center') === 0 || strcmp($header_logo_position, 'top-right') === 0) : ?>
			<div class="logo-wrap header-top-logo-panel">
				<div class="row">
					<div class="columns twelve">
						<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="header-wrap">
			<div class="row decorated">
				<div class="columns twelve header-main-panel">
					<div class="header-col-left">
						<div class="mobile-logo">
							<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
						</div>
						<?php if (strcmp($header_logo_position, 'left') === 0) : ?>
							<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
						<?php endif; ?>
						<?php if (strcmp($header_logo_position, 'right') === 0) : ?>
						<div class="header-icons-wrapper">
							<?php get_template_part('templates/header/block', 'responsive-menu'); ?>
							<?php get_template_part('templates/header/block', 'lang_sel'); ?>
						</div>

						<div class="user-account-btns">
							<?php if (is_user_logged_in() && !is_admin()) { ?>
								<span>Hello <?php  global $current_user; echo "<a href='/my-account'>".$current_user->display_name."</a>"; ?><span class="arrow-down"></span><span class="arrow-up"></span></span>
								<a class="my-account-btn" href="/my-account"><?php echo __("My Account","trade")?></a>
								<a class="open-account-btn" href="/trade"><?php echo __("Trade Now","trade")?></a>
								<a class="login-btn" href="<?php echo wp_logout_url("/"); ?>"><?php echo __("Logout","trade")?></a>
							<?php }else { ?>
								<a class="open-account-btn green-btn show-popup" href="/registration" data-showpopup="2"><?php echo __("Open account","trade")?></a>
								<a class="login-btn show-popup" href="/login" data-showpopup="1"><?php echo __("Login","trade")?></a>
                                <a class="open-account-btn" href="/trade" data-showpopup="1"><?php echo __("Trade Now","trade")?></a>
							<?php } ?>
							<?php endif; ?>
						</div>
						<div class="header-col-right text-center clearfix">
							<?php if (strcmp($header_logo_position, 'right') !== 0) : ?>
								<div class="header-icons-wrapper">
									<?php get_template_part('templates/header/block', 'responsive-menu'); ?>
									<?php get_template_part('templates/header/block', 'lang_sel'); ?>
								</div>
								<div class="user-area-mobile">
									<?php if (is_user_logged_in() && !is_admin()) { ?>
										<div class="dropdown">
											<span>Hello <?php  global $current_user; echo "<a href='/my-account'>".$current_user->display_name."</a>"; ?><span class="arrow-down"></span><span class="arrow-up"></span></span>

											<div class="dropdown-content">
												<a class="my-account-btn" href="/my-account"><?php echo __("My Account","trade")?></a>
												<a class="open-account-btn" href="http://mobile-ettemad.sirixtrader.com/#home"><?php echo __("Trade Now","trade")?></a>
												<a class="login-btn" href="<?php echo wp_logout_url("/"); ?>"><?php echo __("Logout","trade")?></a>
											</div>
										</div>
									<?php }else { ?>
										<a class="open-account-btn green-btn show-popup" href="/registration" data-showpopup="2"><?php echo __("Open account","trade")?></a>
										<a class="login-btn show-popup" href="/login" data-showpopup="1"><?php echo __("Login","trade")?></a>
										<a class="open-account-btn" href="http://mobile-ettemad.sirixtrader.com/#home"><?php echo __("Trade Now","trade")?></a>
									<?php } ?>
								</div>
								<div class="user-account-btns">
									<?php if (is_user_logged_in() && !is_admin()) { ?>
										<span>Hello <?php  global $current_user; echo "<a href='/my-account'>".$current_user->display_name."</a>"; ?></span>
										<a class="my-account-btn" href="/my-account"><?php echo __("My Account","trade")?></a>
										<a class="open-account-btn" href="/trade"><?php echo __("Trade Now","trade")?></a>
										<a class="login-btn" href="<?php echo wp_logout_url("/"); ?>"><?php echo __("Logout","trade")?></a>
									<?php }else { ?>
										<a class="open-account-btn green-btn show-popup" href="/real-registration" data-showpopup="2"><?php echo __("Open account","trade")?></a>
										<a class="login-btn show-popup" href="/login" data-showpopup="1"><?php echo __("Login","trade")?></a>
                                        <a class="open-account-btn" href="/trade" data-showpopup="1"><?php echo __("Trade Now","trade")?></a>
									<?php } ?>
								</div>
							<?php endif; ?>
							<?php if (strcmp($header_logo_position, 'right') === 0) : ?>
								<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
							<?php endif; ?>
						</div>
						<div class="header-col-fluid">
							<a href="<?php echo home_url(); ?>/" class="fixed-header-logo">
								<img src="/wp-content/themes/ronneby/assets/images/logo.png" alt="logo"/>
							</a>
							<?php get_template_part('templates/header/block', 'main_menu'); ?>
						</div>
					</div>
				</div>
			</div>
			<?php if (strcmp($header_logo_position, 'bottom-left') === 0 || strcmp($header_logo_position, 'bottom-center') === 0 || strcmp($header_logo_position, 'bottom-right') === 0 || strcmp($header_logo_position, 'middle') === 0) : ?>
				<div class="logo-wrap header-top-logo-panel">
					<div class="row">
						<div class="columns twelve">
							<?php get_template_part('templates/header/block', 'custom_logo_second'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
	</section>
</div>