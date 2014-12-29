<?php
/*
 * Plugin Name: Vbout Wordpress Plugin
 * Plugin URI: https://developers.vbout.com/thirdparty/plugins
 * Description: Vbout Dashboard integration with wordpress
 * Author: vboutdevteam
 * Version: 1.0
 * Author URI: https://developers.vbout.com/
 * License: GPLv2
 */

 function register_session(){
    if( !session_id() )
        session_start();
}

add_action('init','register_session');

require_once ABSPATH . "wp-admin/includes/plugin.php";
require_once ABSPATH . "wp-includes/pluggable.php";

define("VBOUT_URL", plugins_url('', __FILE__));

define("VBOUT_DIR", WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "vboutwp");

require_once VBOUT_DIR . "/vbout-src/services/ApplicationWS.php";
require_once VBOUT_DIR . "/vbout-src/services/SocialMediaWS.php";
require_once VBOUT_DIR . "/vbout-src/services/EmailMarketingWS.php";
require_once VBOUT_DIR . "/includes/Vbout.php";

VboutWP::process();

if (current_user_can("administrator")) {
	if (basename($_SERVER['SCRIPT_FILENAME']) == "options.php" && $_POST['action'] == "update" && $_POST['option_page'] == "vbout-settings") {
		VboutWP::checkApiStatus();
	} elseif (basename($_SERVER['SCRIPT_FILENAME']) == "options.php" && $_POST['action'] == "update" && $_POST['option_page'] == "vbout-schedule") {
		VboutWP::sendToVbout();
	}

	VboutWP::adminInit();	
}