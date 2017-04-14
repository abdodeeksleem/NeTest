<?php
$client_site = get_post_meta(get_the_ID(), 'folio_client_site', true);
if (!empty($client_site)) { ?>

	<div class="folio-inside-add-info clearfix">
		<div class="folio-client">
			<a href="<?php echo esc_url($client_site); ?>" class="button"><?php _e('Visit project', 'dfd'); ?></a>
		</div>
	</div>
<?php }