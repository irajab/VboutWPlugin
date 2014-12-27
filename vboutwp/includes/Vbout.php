<?php
class VboutWP {
	const PLUGIN_VERSION = "1.0",
		  DEFAULT_TIMEZONE = "America/New_York";
	
	static $options = array(
		"appkey",
		"clientsecret",
		"authtoken",
		//....
		"sync_emaillist",
		"plugin_version"
	);
	
	public static function process() 
	{
		self::initializeOptions();
		self::initializeFilters();
	}

	public static function initializeFilters() 
	{
		add_action('admin_menu', array(__CLASS__, 'admin_menu'));

		//add_action('wp_dashboard_setup', array(__CLASS__, 'wp_dashboard_setup'));
		//add_action('widgets_init', array(__CLASS__, 'widgets_init'));
	}

	public static function initializeOptions() 
	{ 
		//	DEFAULT AUTHENTICATION KEYS
		add_filter("default_option_vbout_appkey", array(__CLASS__, "defaultAppKey"));
		add_filter("default_option_vbout_clientsecret", array(__CLASS__, "defaultClientSecret"));
		add_filter("default_option_vbout_authtoken", array(__CLASS__, "defaultAuthToken"));
		
		//	DEFAULT SYNC VALUES
		add_filter("default_option_vbout_sync_emaillist", array(__CLASS__, "defaultSyncEmailList"));
		
		//	OTHER DEFAULT VALUES
		add_filter("default_option_vbout_plugin_version", array(__CLASS__, "defaultVersion"));

		//add_filter("default_option_vbout_acc_timezone", array(__CLASS__, "defaultTimezone"));
		//add_filter("default_option_vbout_acc_business", array(__CLASS__, "defaultBusiness"));
		
		/////////////////////////////////////////////////////////////////////////////////////
		if (current_user_can("administrator")):
			foreach (self::$options as $option):
				$key = "vbout_{$option}";

				if (get_option($key, "@unset") === "@unset"):
					add_option($key, get_option($key));
				endif;

				register_setting("vbout-settings", $key);
			endforeach;
		endif;
		/////////////////////////////////////////////////////////////////////////////////////
	}
	
	public static function defaultBusiness($default = null) 
	{
		if ($default) 
			return $default;

		return "<span style='color: red;'>NOT CONNECTED</span>";
	}

	public static function defaultAppKey($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultClientSecret($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}
	
	public static function defaultAuthToken($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultSyncEmailList($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultVersion($default = null) {
		if ($default)
			return $default;

		return self::PLUGIN_VERSION;
	}

	public static function defaultTimezone($default = null) {
		if ($default)
			return $default;

		return self::DEFAULT_TIMEZONE;
	}
	
	public static function adminInit() {

		if (get_option("vbout_plugin_version") != self::PLUGIN_VERSION)
			update_option("vbout_plugin_version", self::PLUGIN_VERSION);
			
		if (get_option("vbout_acc_business") == NULL)
			update_option("vbout_acc_business", "<span style='color: red;'>NOT CONNECTED</span>");
		
		if (get_option("vbout_acc_timezone") == NULL)
			update_option("vbout_acc_timezone", self::DEFAULT_TIMEZONE);
	}

	public static function checkApiStatus()
	{
		if ((isset($_POST['vbout_appkey']) && $_POST['vbout_appkey'] != NULL) && 
			(isset($_POST['vbout_clientsecret']) && $_POST['vbout_clientsecret'] != NULL) && 
			(isset($_POST['vbout_authtoken']) && $_POST['vbout_authtoken'] != NULL)) {
			
			$app_key = array(
				'app_key' => $_POST['vbout_appkey'],
				'client_secret' => $_POST['vbout_clientsecret'],
				'oauth_token' => $_POST['vbout_authtoken']
			);
			
			if (get_option("vbout_api_status_checksum") != base64_encode(serialize($app_key))) {
				update_option("vbout_api_status_checksum", base64_encode(serialize($app_key)));
				
				$app = new ApplicationWS($app_key);
		
				$results = $app->getBusinessInfo();

				if (isset($results['errorMessage'])) {
					//'<div id="message" class="error"><p><strong>'..'</strong></p></div>'
					update_option("vbout_api_status_flag", "false");
					update_option("vbout_api_status_error", $results['errorMessage']);
				} else {
					update_option("vbout_api_status_flag", "true");
					update_option("vbout_api_status_error", "");
					
					update_option("vbout_acc_business", $results['businessName']);
					update_option("vbout_acc_timezone", $results['timezone']);
				}
			}
		}
	}

	static function admin_menu() 
	{
		global $wp_version;

		add_menu_page('Vbout Settings', 'Vbout Settings', 'manage_options', 'vbout-settings', array(__CLASS__, 'admin_options_page'), "https://www.vbout.com/images/wp-logo.png?new", 81);
		
		//	ADD CUSTOM LINKS TO DIFFERENT AREAS
		add_filter('post_row_actions', array(__CLASS__, 'add_vbout_options'), 10, 2);
		add_filter('page_row_actions', array(__CLASS__, 'add_vbout_options'), 10, 2);
		
		// ADD CUSTOM BOXES TO DIFFERENT AREAS
		add_action('add_meta_boxes', array(__CLASS__, 'add_vbout_meta_box'));
	}
	
	static function add_vbout_meta_box()
	{
		if ( current_user_can( 'publish_posts' ) ) {
			$post_types = get_post_types();
			
			foreach( $post_types as $post_type )
			{
				add_meta_box('vbou_meta_box', __('Schedule this '.ucfirst($post_type).' on Vbout?', 'vbout'), array(__CLASS__, 'vbout_meta_box'), $post_type, 'normal', 'default');
			}
		}
	}
	
	static function vbout_meta_box()
	{
		require VBOUT_DIR.'/includes/meta_box.php';
	}
	
	static function add_vbout_options($actions, $page_object)
	{
		//WP_Post Object ( [ID] => 1 [post_author] => 1 [post_date] => 2014-12-26 13:23:30 [post_date_gmt] => 2014-12-26 13:23:30 [post_content] => Welcome to WordPress. This is your first post. Edit or delete it, then start blogging! [post_title] => Hello world! [post_excerpt] => [post_status] => publish [comment_status] => open [ping_status] => open [post_password] => [post_name] => hello-world [to_ping] => [pinged] => [post_modified] => 2014-12-26 13:23:30 [post_modified_gmt] => 2014-12-26 13:23:30 [post_content_filtered] => [post_parent] => 0 [guid] => http://localhost/wpplugin/?p=1 [menu_order] => 0 [post_type] => post [post_mime_type] => [comment_count] => 1 [filter] => raw )
		$actions['vbout_link'] = '<a href="javascript://">Schedule on Vbout</a>';
	 
	   return $actions;
	}
	
	static function admin_options_page() 
	{
		$emaillists = array();
		
		$input_fields = implode("\n", array(
			self::template('settings_form/header', array(
				'header' => 'API Authentication Settings'.' ('.get_option('vbout_acc_business').')',
				'description' => 'You have to assign authentication keys before you can able to use this plugin.'
			)),
			
			self::template('settings_form/text', array(
				'key' => 'vbout_appkey',
				'name' => 'Application Key',
				'value' => esc_attr(get_option('vbout_appkey')),
				'description' => implode('<br />', array(
					implode('&nbsp;&nbsp;', array('Your application key.'))
				))
			)),
			
			self::template('settings_form/text', array(
				'key' => 'vbout_clientsecret',
				'name' => 'Client Secret',
				'value' => esc_attr(get_option('vbout_clientsecret')),
				'description' => implode('<br />', array(
					implode('&nbsp;&nbsp;', array('Client secret of your application.'))
				))
			)),
			
			self::template('settings_form/text', array(
				'key' => 'vbout_authtoken',
				'name' => 'Authentication Token',
				'value' => esc_attr(get_option('vbout_authtoken')),
				'description' => implode('<br />', array(
					implode('&nbsp;&nbsp;', array('Authentication token of your application.'))
				))
			)),
			
			self::template('settings_form/header', array(
				'header' => 'Synchronize Users',
				'description' => 'Synchronize Wordpress Users to Vbout email list.'
			)),
			
			self::template('settings_form/dropdown', array(
				'key' => 'vbout_sync_emaillist',
				'name' => 'Vbout Lists',
				'options' => $emaillists,
				'value' => get_option('vbout_sync_emaillist'),
				'description' => implode('<br />', array(
					implode('&nbsp;&nbsp;', array('Choose the list that you want to synchronize with.'))
				))
			)),
			
		));
		
		$hidden_fields = implode(PHP_EOL, array(
			'<input type="hidden" name="option_page" value="vbout-settings" />',
			'<input type="hidden" name="action" value="update" />',
			wp_nonce_field('vbout-settings-options', '_wpnonce', true, false)
		));
		
		//CHECK API STATUS
		if (get_option("vbout_api_status_flag") == "false")
			$api_status = implode(PHP_EOL, array(
				'<div id="message" class="error"><p><strong>'.get_option("vbout_api_status_error").'</strong></p></div>'
			));

		echo self::template('settings_form/form', compact('input_fields', 'hidden_fields', 'api_status') + array(
			'title' => 'Vbout Settings',
			'icon' => 'icon-users',

			'submit' => 'Save Changes',
			'cancel' => 'Reset'
		));
	}

	public static function template($name, $data = array()) 
	{
		if (!$name || !file_exists(($template__ = VBOUT_DIR . "/templates/{$name}.html.php"))) {
			return false;
		}

		if (!empty($data)) {
			extract($data, EXTR_OVERWRITE);
		}

		ob_start();
		include $template__;
		return ob_get_clean();
	}

	public static function getPlugins() {
		if (!($defaults = get_plugins())):
			return false;
		endif;

		foreach ($defaults as $key => $value):
			if (strpos($key, DIRECTORY_SEPARATOR) !== false):
				list($plugin, $Script) = explode(DIRECTORY_SEPARATOR, $key, 2);
				$plugins[$plugin] = $value + compact("Script");
			else:
				$plugins[$key] = $value;
			endif;
		endforeach;

		return $plugins;
	}
}