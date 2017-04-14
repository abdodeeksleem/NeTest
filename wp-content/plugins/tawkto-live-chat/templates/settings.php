<?php

/**
 * @package Tawk.to Widget for Wordpress
 * @author Tawk.to
 * @copyright (C) 2014- Tawk.to
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
?>

<script type="text/javascript" src="<?php echo $base_url ?>/public/js/jquery-1.11.0.min.js"></script>

<iframe
	id="tawkIframe"
	src=""
	style="min-height: 400px; width : 100%; border: none; margin-top: 20px">
</iframe>

<script type="text/javascript">
	var currentHost = window.location.protocol + "//" + window.location.host;
	var url = "<?php echo $iframe_url ?>&parentDomain=" + currentHost;

	jQuery('#tawkIframe').attr('src', url);

	var iframe = jQuery('#tawk_widget_customization')[0];

	window.addEventListener('message', function(e) {
		if(e.origin === '<?php echo $base_url ?>') {

			if(e.data.action === 'setWidget') {
				setWidget(e);
			}

			if(e.data.action === 'removeWidget') {
				removeWidget(e);
			}
		}
	});

	function setWidget(e) {
		jQuery.post(ajaxurl, {
			action : 'tawkto_setwidget',
			pageId : e.data.pageId,
			widgetId : e.data.widgetId
		}, function(r) {
			if(r.success) {
				e.source.postMessage({action: 'setDone'}, '<?php echo $base_url ?>');
			} else {
				e.source.postMessage({action: 'setFail'}, '<?php echo $base_url ?>');
			}

		});
	}

	function removeWidget(e) {
		jQuery.post(ajaxurl, {action: 'tawkto_removewidget'}, function(r) {
			if(r.success) {
				e.source.postMessage({action: 'removeDone'}, '<?php echo $base_url ?>');
			} else {
				e.source.postMessage({action: 'removeFail'}, '<?php echo $base_url ?>');
			}
		});
	}
</script>

   <form method="post" action="options.php">
   <?php
   settings_fields( 'tawk_options' ); 
   do_settings_sections( 'tawk_options' );
   
   $visibility = get_option( 'tawkto-visibility-options',FALSE );
   if($visibility == FALSE){
   		$visibility = array (
				'always_display' => 1,
				'show_onfrontpage' => 0,
				'show_oncategory' => 0,
				'show_ontagpage' => 0
			);
   }
   ?>
   <div id="tawkvisibilitysettings">
    <h2>Visibility Options</h2>
    <p>Please Note: that you can use the visibility options below, or you can show  the tawk.to widget on any page independent of these visibility options by simply using the [tawkto] shortcode in the post or page.</p>
    <table class="form-table">
      <tr valign="top">
      <th scope="row">Always show Tawk.To widget on every page</th>
      <td><input type="checkbox" id="always_display" name="tawkto-visibility-options[always_display]" value="1" <?php echo checked( 1, $visibility['always_display'], false ); ?> /></td>
      </tr>
      <tr valign="top">
      <th scope="row">Show on front page</th>
      <td><input type="checkbox" id="show_onfrontpage" name="tawkto-visibility-options[show_onfrontpage]" value="1" <?php echo checked( 1, $visibility['show_onfrontpage'], false ); ?> /></td>
      </tr>
      <tr valign="top">
      <th scope="row">Show on Category pages</th>
      <td><input type="checkbox" id="show_oncategory" name="tawkto-visibility-options[show_oncategory]" value="1" <?php echo checked( 1, $visibility['show_oncategory'], false ); ?> /></td>
      </tr>
      <tr valign="top">
      <th scope="row">Show on Tag pages</th>
      <td><input type="checkbox" id="show_ontagpage" name="tawkto-visibility-options[show_ontagpage]" value="1" <?php echo checked( 1, $visibility['show_ontagpage'], false ); ?> /></td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </div>

  </form>
  