<?php
global $dfd_ronneby;
if (isset($dfd_ronneby['custom_logo_image_second']['url']) && !empty($dfd_ronneby['custom_logo_image_second']['url'])) :
	$header_logo_width = $dfd_ronneby['header_logo_width'];
	$header_logo_height = $dfd_ronneby['header_logo_height'];
	
	$_logo_size = array($header_logo_width, $header_logo_height);
	$custom_logo_image_url = (isset($dfd_ronneby['custom_logo_image_second']['url']) && $dfd_ronneby['custom_logo_image_second']['url']) ? $dfd_ronneby['custom_logo_image_second']['url'] : '';
	$custom_logo_image = dfd_aq_resize($custom_logo_image_url, $_logo_size[0], $_logo_size[1]);
	
	if (empty($custom_logo_image)) {
		$custom_logo_image = $custom_logo_image_url;
	}
	
	$custom_retina_logo_image = '';
	$logo_image_w = '';
	$logo_image_h = '';
	
	if (
		isset($dfd_ronneby['custom_retina_logo_image_second']['url']) &&
		!empty($dfd_ronneby['custom_retina_logo_image_second']['url']) &&
		//file_exists($dfd_ronneby['custom_retina_logo_image_second']['url']) &&
		ini_get('allow_url_fopen') && 
		getimagesize($dfd_ronneby['custom_retina_logo_image_second']['url'])
	)
	{
		# Retina ready logo
		$custom_retina_logo_image = dfd_aq_resize($dfd_ronneby['custom_retina_logo_image_second']['url'], $_logo_size[0]*2, $_logo_size[1]*2);
		if(!$custom_retina_logo_image) $custom_retina_logo_image = $dfd_ronneby['custom_retina_logo_image_second']['url'];
		list($logo_image_w, $logo_image_h) = getimagesize($dfd_ronneby['custom_retina_logo_image_second']['url']);
	}
		
?>
	<div class="logo-for-panel">
		<div class="inline-block">
			<a href="<?php echo home_url(); ?>/">
				<img src="/wp-content/themes/ronneby/assets/images/logo.png" />
			</a>
		</div>
	</div>
<?php endif; ?>