<?php
/*
 * Plugin Name: PSP
 * Plugin URI: http://www.dgmedialink.com
 * Description: A brief description of the plugin.
 * Version: 1.0.0
 * Author: Nicoleta
 * Text Domain: form
 * License: Public Domain
 * Version: 1.1
 */

define('ROOT', plugin_dir_path(__FILE__));

// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'psp_options_install');
$DOCUMENT_ROOT = $_SERVER ['DOCUMENT_ROOT'];
require_once ($DOCUMENT_ROOT . '/wp-load.php');

require_once('zotapay/zotapay_payment.php');
require_once('zotapay/zotapay_response.php');
require_once('zotapay/zotapay_success.php');
require_once('zotapay/zotapay_callback.php');
