<?php
global $dfd_ronneby;
if (isset($dfd_ronneby['show_login_form']) && strcmp($dfd_ronneby['show_login_form'],'1') === 0) : ?>
<div class="login-header">
	<?php if (!is_user_logged_in()): ?>
		<div class="links">
			<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="drop-login" data-reveal-id="loginModal">
				<i class="icon-user-2"></i>
			</a>
		</div>

		<div id="loginModal" class="reveal-modal">
			<?php crum_login_form(''); ?>
			<a class="close-reveal-modal"><?php _e('Close', 'dfd'); ?></a>
		</div>
	<?php else: ?>

		<div class="links">
			<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>">
				<i class="icon-user-lock"></i>
			</a>
		</div>

	<?php endif; ?>
</div>
<?php endif; ?>
