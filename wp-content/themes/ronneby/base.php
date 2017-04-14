<?php get_header();
global $dfd_ronneby;
$body_class = $main_wrap_class = '';
if(DfdMetaboxSettings::get('dfd_enable_page_spacer')) {
	$body_class .=  ' dfd-custom-padding-html';
}
if(DfdMetaboxSettings::get('crum_page_custom_footer_parallax')) {
	$main_wrap_class .= ' dfd-parallax-footer';
}
?>

<body <?php body_class($body_class); ?>>
<?php if(!empty($body_class) && $body_class != '') : ?>
	<span class="dfd-frame-line line-top"></span>
	<span class="dfd-frame-line line-bottom"></span>
	<span class="dfd-frame-line line-left"></span>
	<span class="dfd-frame-line line-right"></span>
<?php endif; ?>
<?php if (function_exists('dfd_site_preloader_html')) { dfd_site_preloader_html();}
get_template_part('templates/side-area');

if(isset($dfd_ronneby['site_boxed']) && $dfd_ronneby['site_boxed']) { ?>
<div class="boxed_layout">
<?php } ?>

<?php get_template_part('templates/section', 'header'); ?>

	<div id="main-wrap" class="<?php echo esc_attr($main_wrap_class); ?>">

		<div id="change_wrap_div">

			<?php include crum_template_path(); ?>

		</div>

		<div class="body-back-to-top align-right"><i class="dfd-icon-up_2"></i></div>

		<?php /*get_template_part('templates/section', 'twitter-panel');*/ ?>
	</div>
<?php
if(!is_page_template ( 'templates/page-landing-page.php' ))
{
	get_footer();
}
else
{
	load_template( dirname( __FILE__ ) . '/templates/footer-landing-page.php' );
}
 ?>