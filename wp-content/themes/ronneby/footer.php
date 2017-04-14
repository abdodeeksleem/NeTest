<?php
global $dfd_ronneby;
$footer_style_option = isset($dfd_ronneby['footer_variant']) ? $dfd_ronneby['footer_variant'] : '';
$footer_style = !empty($footer_style_option) ? $footer_style_option : '1';
$footer_class = 'footer-style-'.$footer_style;
$footer_class .= ($dfd_ronneby['footer_bg_dark'] && strcmp($dfd_ronneby['footer_bg_dark'], '1') === 0) ? ' dfd-background-dark' : '';
$footer_class .= (strcmp($footer_style_option, '4') === 0) ? ' no-paddings' : '';

$dark_sub_footer_bg = (isset($dfd_ronneby['sub_footer_bg_dark']) && strcmp($dfd_ronneby['sub_footer_bg_dark'], '1') === 0) ? ' dfd-background-dark' : '';
?>

<?php if($footer_style != '4') : ?>

	<div id="footer-wrap">
		<?php if(
			isset($dfd_ronneby['copyright_footer']) &&
			//strcmp($dfd_ronneby['copyright_footer'], '1' === 0) &&
			isset($dfd_ronneby['enable_subfooter']) &&
			(strcmp($dfd_ronneby['enable_subfooter'], '1') === 0) &&
			isset($dfd_ronneby['footer_copyright_position']) &&
			(strcmp($dfd_ronneby['footer_copyright_position'], 'footer') !== 0)
		) : ?>
			<section id="sub-footer" class="<?php echo esc_attr($dark_sub_footer_bg); ?>">
				<div class="row">
					<div class="twelve columns subfooter-copyright text-center">
						<?php echo $dfd_ronneby['copyright_footer']; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<section id="footer" class="<?php echo esc_attr($footer_class); ?>">

			<?php get_template_part('templates/footer/style', $footer_style); ?>

		</section>



	</div>
<?php endif; ?>

<?php if(isset($dfd_ronneby['site_boxed']) && $dfd_ronneby['site_boxed']) : ?>
	</div>
	<script type="text/javascript">
		(function($) {
			var sideHeaderSetter = function() {
				var header = $('#header-container');
				if(header.hasClass('header-style-5')) {
					var bodyWrapper = $('.boxed_layout');
					var bodyWrapperOffset = bodyWrapper.offset().left;
					if(header.hasClass('left')) {
						header.find('#header').css('left', bodyWrapperOffset);
					}
					if(header.hasClass('right')) {
						header.find('#header').css('right', bodyWrapperOffset);
					}
				}
			};
			sideHeaderSetter();
			$(window).on('load resize', sideHeaderSetter);
		})(jQuery);
	</script>
<?php endif; ?>

<?php echo isset($dfd_ronneby['custom_js']) ? $dfd_ronneby['custom_js'] : ''; ?>

<div id="sidr">
	<a href="#sidr-close" class="dl-trigger icon-mobile-menu dfd-sidr-close">
		<span class="icon-wrap dfd-middle-line"></span>
		<span class="icon-wrap dfd-top-line"></span>
		<span class="icon-wrap dfd-bottom-line"></span>
	</a>
	<div class="sidr-inner"></div>
	<!--	<div class="dfd-search-mobile-show" style="display: none;">-->
	<!--		--><?php //get_template_part('templates/searchform', 'mini'); ?>
	<!--	</div>-->
</div>

<?php
if( ($_SERVER['SERVER_NAME'] ==  "themes.dfd.name") || $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === 'localhost'){
	require_once locate_template('inc/dfd_buttons.php'); //Custom style Panel
}
?>
<?php wp_footer(); ?>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5HVJCJ"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5HVJCJ');</script>
<!-- End Google Tag Manager -->
</body>
</html>
