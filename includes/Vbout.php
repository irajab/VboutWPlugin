<?php
class VboutWP {
	const PLUGIN_VERSION = "1.0";

	const DEFAULT_TIMEZONE = "America/New_York";
	
	///	API STATUS
	const VBOUT_STATUS_DISACTIVE	= 0;	//API NOT CONNECTED
	const VBOUT_STATUS_ACTIVE 		= 1;	//API CONNECTED
	const VBOUT_STATUS_LOCKED 		= 2;	//API IS LOCKED
	const VBOUT_STATUS_ERROR 		= 3;	//API ERROR CONNECTION
	
	///	API METHODS
	const VBOUT_METHOD_USERKEY	= 0;	//API CONNECTED THROUGH USER KEY
	const VBOUT_METHOD_APPKEY 	= 1;	//API CONNECTED THROUGH APP KEY (AppKey|ClientSecret|AuthToken)
	
	///	PLUGIN AVAILABILITY OPTION
	const VBOUT_AVAILABLE_BOTH		= 0;	//PLUGIN WILL BE AVAILABLE FOR BOTH POSTS/PAGES
	const VBOUT_AVAILABLE_POSTONLY	= 1;	//PLUGIN WILL BE AVAILABLE FOR POSTS ONLY
	const VBOUT_AVAILABLE_PAGEONLY	= 2;	//PLUGIN WILL BE AVAILABLE FOR PAGES ONLY
	//const VBOUT_AVAILABLE_MEDIAONLY	= 3;	//PLUGIN WILL BE AVAILABLE FOR MEDIA /// EXTRA OPTION NOT USED FOR NOW
	
	///	PLUGIN ATTACHMENT OPTION
	const VBOUT_ATTACH_EVERYWHERE	= 0;	//PLUGIN WILL BE ATTACHED INSIDE THE QUICK MENU AND POST FORM (EDIT/ADD)
	const VBOUT_ATTACH_MENUONLY		= 1;	//PLUGIN WILL BE ATTACHED INSIDE THE QUICK MENU ONLY
	const VBOUT_ATTACH_FORMONLY		= 2;	//PLUGIN WILL ATTACHED INSIDE THE POST FORM (EDIT/ADD) ONLY
	
	static $options = array(
		///...
		'connect'=>array(
			///...
			"appkey",
			"clientsecret",
			"authtoken",
			//...
			"userkey",
		),
	
		///...
		'settings'=>array(
			"plugin_availability",
			"plugin_attachment",
			//... SOCIAL MEDIA
			"sm_activated",
			//... EMAIL MARKETING
			"em_activated",
			"em_emailname",
			"em_emailsubject",
			"em_fromemail",
			"em_fromname",
			"em_replyto",
			///...
			"sync_emaillist",
			///... TRACKING CODE
			"tracking_activated",
			"tracking_domain",
			"tracking_code",
		),
		
		///...
		'others'=>array(
			"plugin_version",
			"status",
			"method",
			"api_status_checksum",
			"api_business",
			"flash_message",
			///... 
			"sm_channels",
			"em_lists",
			"tracking_domains",
		)
	);
	
	public static function process() 
	{
		self::initializeOptions();
		self::initializeFilters();
	}

	public static function initializeOptions() 
	{ 
		//	DEFAULT INIT PLUGIN
		///	THIS VARIABLE USED TO TEST WHETHER API IS ACTIVATED OR NOT
		add_filter("default_option_vbout_status", array(__CLASS__, "defaultStatus"));
		///	THIS VARIABLE USED TO TELL WHICH METHOD YOU CHOSE TO CONNECT TO VBOUT
		add_filter("default_option_vbout_method", array(__CLASS__, "defaultMethod"));
		
		//	AUTHENTICATION KEYS: YOU CAN CONNECT TO API USING 2 METHODS
		///	APP KEY
		add_filter("default_option_vbout_appkey", array(__CLASS__, "defaultAppKey"));
		add_filter("default_option_vbout_clientsecret", array(__CLASS__, "defaultClientSecret"));
		add_filter("default_option_vbout_authtoken", array(__CLASS__, "defaultAuthToken"));
		/// USER KEY
		add_filter("default_option_vbout_userkey", array(__CLASS__, "defaultUserKey"));
		////////////////////////////////////////////////////////////////
		
		//	DEFAULT GENERAL PLUGIN OPTIONS
		add_filter("default_option_vbout_plugin_availability", array(__CLASS__, "defaultPluginAvailability"));
		add_filter("default_option_vbout_plugin_attachment", array(__CLASS__, "defaultPluginAttachment"));
		////////////////////////////////////////////////////////////////
		
		//	DEFAULT SOCIAL MEDIA FEATURE OPTIONS
		add_filter("default_option_vbout_sm_activated", array(__CLASS__, "defaultSocialMediaActivated"));
		add_filter("default_option_vbout_sm_channels", array(__CLASS__, "defaultSocialMediaChannels"));
		
		//	DEFAULT EMAIL MARKETING CAMPAIGN FEATURE OPTIONS
		add_filter("default_option_vbout_em_activated", array(__CLASS__, "defaultEmailMarketingActivated"));
		add_filter("default_option_vbout_em_lists", array(__CLASS__, "defaultEmailMarketingLists"));
		
		add_filter("default_option_vbout_em_emailname", array(__CLASS__, "defaultCampaignName"));
		add_filter("default_option_vbout_em_emailsubject", array(__CLASS__, "defaultCampaignSubject"));
		add_filter("default_option_vbout_em_fromemail", array(__CLASS__, "defaultCampaignFromEmail"));
		add_filter("default_option_vbout_em_fromname", array(__CLASS__, "defaultCampaignFromName"));
		add_filter("default_option_vbout_em_replyto", array(__CLASS__, "defaultCampaignReplyto"));
		
		//	DEFAULT EMAIL MARKETING SYNC LISTS FEATURE OPTIONS
		add_filter("default_option_vbout_sync_emaillist", array(__CLASS__, "defaultSyncEmailList"));
		
		//	DEFAULT DOMAIN TRACKING CODE INJECTION
		add_filter("default_option_vbout_tracking_activated", array(__CLASS__, "defaultTrackingActivated"));
		add_filter("default_option_vbout_tracking_domain", array(__CLASS__, "defaultTrackingDomain"));
		add_filter("default_option_vbout_tracking_code", array(__CLASS__, "defaultTrackingCode"));
		
		//	OTHER DEFAULT VALUES
		add_filter("default_option_vbout_plugin_version", array(__CLASS__, "defaultVersion"));

		///	DEPRECATED AND NOT USED ANYMORE
		//add_filter("default_option_vbout_acc_timezone", array(__CLASS__, "defaultTimezone"));
		//add_filter("default_option_vbout_acc_business", array(__CLASS__, "defaultBusiness"));
		
		/////////////////////////////////////////////////////////////////////////////////////
		if (current_user_can("administrator")):
			foreach (self::$options as $optionKey => $optionVars):
				foreach($optionVars as $optionVar):
					$key = "vbout_{$optionVar}";

					if (get_option($key, "@unset") === "@unset"):
						add_option($key, get_option($key));
					endif;

					register_setting("vbout-".$optionKey, $key);
				endforeach;
			endforeach;
		endif;
		/////////////////////////////////////////////////////////////////////////////////////
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//	LIST OF DEFAULT OPTIONS INITIALIZATION METHODS										+
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/////////////////////////////////////////////////////////////////////////////////////////
	public static function defaultStatus($default = null) 
	{
		if ($default) 
			return $default;

		return self::VBOUT_STATUS_DISACTIVE;
	}
	
	public static function defaultMethod($default = null) 
	{
		if ($default) 
			return $default;

		return self::VBOUT_METHOD_USERKEY;
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
	
	public static function defaultUserKey($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultPluginAvailability($default = null) 
	{
		if ($default) 
			return $default;

		return self::VBOUT_AVAILABLE_BOTH;
	}
	
	public static function defaultPluginAttachment($default = null) 
	{
		if ($default) 
			return $default;

		return self::VBOUT_ATTACH_EVERYWHERE;
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultSocialMediaActivated($default = null) 
	{
		if ($default) 
			return $default;

		return TRUE;
	}
	
	public static function defaultSocialMediaChannels($default = null) 
	{
		if ($default) 
			return $default;

		return serialize(array("Facebook"=>array(),"Twitter"=>array(),"Linkedin"=>array()));
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultEmailMarketingActivated($default = null) 
	{
		if ($default) 
			return $default;

		return TRUE;
	}
	
	public static function defaultEmailMarketingLists($default = null) 
	{
		if ($default) 
			return $default;

		return serialize(array());
	}

	public static function defaultCampaignName($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultCampaignSubject($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultCampaignFromEmail($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultCampaignFromName($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultCampaignReplyto($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultSyncEmailList($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultTrackingActivated($default = null) 
	{
		if ($default) 
			return $default;

		return FALSE;
	}
	
	public static function defaultTrackingDomain($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}

	public static function defaultTrackingCode($default = null) 
	{
		if ($default) 
			return $default;

		return "";
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public static function defaultVersion($default = null) {
		if ($default)
			return $default;

		return self::PLUGIN_VERSION;
	}
	//	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/////////////////////////////////////////////////////////////////////////////////////////

	public static function initializeFilters() 
	{
		///	ADDING VBOUT MENU TO WORDPRESS LEFT SIDEBAR
		add_action('admin_menu', array(__CLASS__, 'admin_menu'));
		add_action('synchronize_wp_users_hook', array(__CLASS__, 'synchronize_wp_users'));
		
		add_filter("plugin_action_links_vboutwp/vboutwp.php", array(__CLASS__, 'your_plugin_settings_link'));
		//add_action('wp_dashboard_setup', array(__CLASS__, 'wp_dashboard_setup'));
		//add_action('widgets_init', array(__CLASS__, 'widgets_init'));
		
		add_filter( 'tiny_mce_before_init', array(__CLASS__, 'wpse24113_tiny_mce_before_init') );
	}
	
	public static function your_plugin_settings_link($links) { 
		if (in_array($plugin_status, array(self::VBOUT_STATUS_DISACTIVE, self::VBOUT_STATUS_DISACTIVE, self::VBOUT_STATUS_ERROR))) {
			$settings_link = '<a href="admin.php?page=vbout-connect">Settings</a>'; 
		} else {
			$settings_link = '<a href="admin.php?page=vbout-settings">Settings</a>'; 
		}
		
		array_unshift($links, $settings_link); 
		return $links; 
	}

	
	public static function wpse24113_tiny_mce_before_init( $initArray )
	{
$initArray['setup'] = <<<JS
[function(ed) {
	ed.onChange.add(function(ed, e) {
		//your function goes here
		triggerLivePreview(ed);
	});

	ed.onInit.add(function(ed, e) {
		//your function goes here
		triggerLivePreview(ed);
	});
}][0]
JS;
    return $initArray;
}

	public static function adminInit() 
	{
		///	STUPID INITIATION I DON'T KNOW WHY I PUT IT THERE BUT WHAT THE HELL... LEAVE IT!!!
		if (get_option("vbout_plugin_version") != self::PLUGIN_VERSION)
			update_option("vbout_plugin_version", self::PLUGIN_VERSION);
		
		// JavaScript
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		
		wp_enqueue_script('vb-jsqtip-tooltip', VBOUT_URL.'/js/jquery.qtip.min.js', array( 'jquery' ));
		wp_enqueue_script('vb-jschosen-dropbox', VBOUT_URL.'/js/chosen.jquery.min.js', array( 'jquery' ));
		wp_enqueue_script('vb-core-script', VBOUT_URL.'/js/vbout-core.js', array( 'jquery', 'vb-jschosen-dropbox' ));
		
		// CSS
		wp_enqueue_style('jquery-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		wp_enqueue_style( 'vb-core-css', VBOUT_URL.'/css/vboutwp.css', array(), NULL );
		wp_enqueue_style( 'vb-jschosen-css', VBOUT_URL.'/js/chosen.min.css', array(), NULL );
		wp_enqueue_style( 'vb-jsqtip-css', VBOUT_URL.'/js/jquery.qtip.min.css', array(), NULL );
		
		//	APPEND TRACKING TO FOOTER IF ENABLED
		$tracking_enabled = get_option('vbout_tracking_activated');
		if ($tracking_enabled) {
			add_action('wp_footer', array(__CLASS__, 'embed_tracking_code'));
		}
	}
	
	public static function sendToVbout()
	{	
		if (isset($_POST['vb_post_to_channels']) || isset($_POST['vb_post_to_campaign'])) {
			$results = array();
			$hasError = false;
			$errorMessage = '';
			
			////echo '<pre>';
			////print_r($_REQUEST); exit;
			////return;
			
			$post = get_post($_POST['post_id']);
			
			$business = unserialize(get_option('vbout_api_business'));
			
			date_default_timezone_set($business['timezone']);
			
			if (get_option('vbout_method') == self::VBOUT_METHOD_USERKEY) {
				$app_key = array(
					'key' => get_option('vbout_userkey')
				);
			} elseif (get_option('vbout_method') == self::VBOUT_METHOD_APPKEY) {
				$app_key = array(
					'app_key' => get_option('vbout_appkey'),
					'client_secret' => get_option('vbout_clientsecret'),
					'oauth_token' => get_option('vbout_authtoken')
				);
			}

			//	CHECK TIME 12-hours | 24-hours
			//if (preg_match("/(1[012]|0[0-9]):[0-5][0-9]/", $_REQUEST['vb_post_schedule_time']) || preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $_REQUEST['vb_post_schedule_time'])) {
			$scheduledDateTime = $_REQUEST['vb_post_schedule_date'].' '.$_REQUEST['vb_post_schedule_time']['Hours'].':'.$_REQUEST['vb_post_schedule_time']['Minutes'].' '.$_REQUEST['vb_post_schedule_time']['TimeAmPm'];
			//} else {
			//	$scheduledDateTime = $_REQUEST['vb_post_schedule_date'].' 00:00';
			//}

			//	CHECK IF POST TO CHANNELS
			if (isset($_REQUEST['vb_post_to_channels'])) {
				$sm = new SocialMediaWS($app_key);
				
				foreach($_REQUEST['channels'] as $channelName => $channelId) {
					if ($channelName != 'twitter') {
						if ($channelName != 'linkedin_companies') {
							$params = array(
								//top share content
								'message'=>($_REQUEST['photo_url'] != NULL)?$_REQUEST['post_title']:$_REQUEST['post_title'].' '.$_REQUEST['post_url'],
								//share photo
								'photo'=>strip_tags($_REQUEST['photo_url']),
								//share photo title
								'photo_title'=>strip_tags($_REQUEST['post_title']),
								//share photo url
								'photo_url'=>strip_tags($_REQUEST['post_url']),
								//share description
								'photo_caption'=>strip_tags($_REQUEST['post_description']),
								
								'channel'=>$channelName,
								'channelid'=>implode(',', $channelId),
								'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
								'scheduleddate'=>strtotime($scheduledDateTime),
								'trackableLinks'=>isset($_REQUEST['vb_post_schedule_shortenurls'])?'true':'false'
							);
						} else {
							foreach($channelId as $channelLinkedin) {
								$params = array(
									//top share content
									'message'=>($_REQUEST['photo_url'] != NULL)?$_REQUEST['post_title']:$_REQUEST['post_title'].' '.$_REQUEST['post_url'],
									//share photo
									'photo'=>strip_tags($_REQUEST['photo_url']),
									//share photo title
									'photo_title'=>strip_tags($_REQUEST['post_title']),
									//share photo url
									'photo_url'=>strip_tags($_REQUEST['post_url']),
									//share description
									'photo_caption'=>strip_tags($_REQUEST['post_description']),
									
									'channel'=>'linkedin_company',
									'channelid'=>implode(',', $channelId),
									'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
									'scheduleddate'=>strtotime($scheduledDateTime),
									'trackableLinks'=>isset($_REQUEST['vb_post_schedule_shortenurls'])?'true':'false'
								);
							}
						}
					} else {
						$params = array(
							//top share content
							'message'=>$_REQUEST['post_title'].' '.strip_tags($_REQUEST['post_url']),
							//share photo
							'photo'=>strip_tags($_REQUEST['photo_url']),
							//share photo title
							'photo_title'=>strip_tags($_REQUEST['post_title']),
							//share photo url
							'photo_url'=>strip_tags($_REQUEST['post_url']),
							//share description
							'photo_caption'=>strip_tags($_REQUEST['post_description']),
							
							'channel'=>$channelName,
							'channelid'=>implode(',', $channelId),
							'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
							'scheduleddate'=>strtotime($scheduledDateTime),
							'trackableLinks'=>isset($_REQUEST['vb_post_schedule_shortenurls'])?'true':'false'
						);
					}
						
					///echo '<pre>';
					///print_r($params);
					//print_r($sm->addNewPost($params));
					$results['social'][$channelName] = $sm->addNewPost($params);
					
					if (is_array($results['social'][$channelName]) && isset($results['social'][$channelName]['errorCode'])) {
						$hasError = true;
						$errorMessage .= $channelName.' : '.$results['social'][$channelName]['errorCode'].' - '.$results['social'][$channelName]['errorMessage'];
						
						if (isset($results['social'][$channelName]['fields']))
							$errorMessage .= '<ul><li>'.implode('</li><li>', $results['social'][$channelName]['fields']).'</li></ul>';
					}
				}
			}

			if (isset($_REQUEST['vb_post_to_campaign'])) {
				$em = new EmailMarketingWS($app_key);
				
				$params = array(
					'type'=>'standard',
					'name'=>$_REQUEST['vb_post_schedule_emailname'],
					'subject'=>$_REQUEST['vb_post_schedule_emailsubject'],
					'fromemail'=>$_REQUEST['vb_post_schedule_fromemail'],
					'from_name'=>$_REQUEST['vb_post_schedule_fromname'],
					'reply_to'=>$_REQUEST['vb_post_schedule_replyto'],
					'isdraft'=>'false',
					'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
					'scheduled_datetime'=>date('Y-m-d h:i A', strtotime($scheduledDateTime)),
					'recipients'=>($_REQUEST['campaign'] != NULL)?implode(',', $_REQUEST['campaign']):'',
					'body'=>$_REQUEST['content']
				);
				
				//print_r($params);
				//print_r($em->addNewCampaign($params)); exit;
				$results['campaign'] = $em->addNewCampaign($params);
				
				if (is_array($results['campaign']) && isset($results['campaign']['errorCode'])) {
					$hasError = true;
					$errorMessage .= $results['campaign']['errorCode'].' - '.$results['campaign']['errorMessage'];
					
					if (isset($results['campaign']['fields']))
						$errorMessage .= '<ul><li>'.implode('</li><li>', $results['campaign']['fields']).'</li></ul>';
				}
			}
			
			//IF THERE IS AN ERROR ADD CUSTOM MESSAGE OF THE ERROR
			if ($hasError) {
				//print_r($errorMessage);
				//$_SESSION['vb_custom_error'] = $errorMessage;
				
				$message = array(
					'type'=>'error',
					'message'=>$errorMessage
				);
				
				update_option("vbout_flash_message", serialize($message));
			} else {
				//$_SESSION['vb_custom_success'] = 'Your message has been sent successfully to vbout.';
				$message = array(
					'type'=>'updated',
					'message'=>__( 'Your marketing task has been scheduled. Click <a href="https://www.vbout.com/dashboard" target="_blank">here</a> to manage your submissions on Vbout.com', 'vblng' )
				);
				
				update_option("vbout_flash_message", serialize($message));
			}
			
			//exit;
		}
		
		header('location: '.get_admin_url().'admin.php?page=vbout-schedule&id='.$_POST['post_id']);
		exit;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	public static function updateExtraOptions()
	{
		if (isset($_POST['option_page']) && $_POST['option_page'] == 'vbout-settings') {
			///... SAVE DEFAULT FACEBOOK PAGES
			///		\_ REMOVE ALL DEFAULT FIRST
			$channels 	= unserialize(get_option('vbout_sm_channels'));
			$channels['default'] = array();
			
			if (isset($_POST['vbout_sm_channels_facebook']) && $_POST['vbout_sm_channels_facebook'] != NULL) {
				foreach($_POST['vbout_sm_channels_facebook'] as $page)
					$channels['default']['Facebook'][] = $page;
			}
			///... SAVE DEFAULT TWITTER PROFILES
			///		\_ REMOVE ALL DEFAULT FIRST
			if (isset($_POST['vbout_sm_channels_twitter']) && $_POST['vbout_sm_channels_twitter'] != NULL) {
				foreach($_POST['vbout_sm_channels_twitter'] as $profile)
					$channels['default']['Twitter'][] = $profile;
			}
			///... SAVE DEFAULT LINKEDIN PROFILES
			///		\_ REMOVE ALL DEFAULT FIRST
			if (isset($_POST['vbout_sm_channels_linkedin']) && $_POST['vbout_sm_channels_linkedin'] != NULL) {
				foreach($_POST['vbout_sm_channels_linkedin'] as $profile)
					$channels['default']['Linkedin']['profiles'][] = $profile;
			}
			
			if (isset($_POST['vbout_sm_channels_linkedincompanies']) && $_POST['vbout_sm_channels_linkedincompanies'] != NULL) {
				foreach($_POST['vbout_sm_channels_linkedincompanies'] as $company)
					$channels['default']['Linkedin']['companies'][] = $company;
			}
			
			update_option("vbout_sm_channels", serialize($channels));
			///... SAVE DEFAULT LISTS
			///		\_ REMOVE ALL DEFAULT FIRST
			$lists 		= unserialize(get_option('vbout_em_lists'));
			$lists['default'] = array();
			
			if (isset($_POST['vbout_em_lists']) && $_POST['vbout_em_lists'] != NULL) {
				foreach($_POST['vbout_em_lists'] as $list)
					$lists['default'][] = $list;
			}
			
			update_option("vbout_em_lists", serialize($lists));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////////
	public static function checkApiStatus()
	{
		if (isset($_POST['vbout_method']) && $_POST['vbout_method'] != NULL) {
			if ($_POST['vbout_method'] == self::VBOUT_METHOD_USERKEY) {
				$app_key = array(
					'key' => $_POST['vbout_userkey']
				);
			} elseif ($_POST['vbout_method'] == self::VBOUT_METHOD_APPKEY) {
				$app_key = array(
					'app_key' => $_POST['vbout_appkey'],
					'client_secret' => $_POST['vbout_clientsecret'],
					'oauth_token' => $_POST['vbout_authtoken']
				);
			}
			
			///if (get_option("vbout_api_status_checksum") != base64_encode(serialize($app_key))) {
			///	update_option("vbout_api_status_checksum", base64_encode(serialize($app_key)));
				
				$app = new ApplicationWS($app_key);
		
				$results = $app->getBusinessInfo();

				if (isset($results['errorMessage'])) {
					update_option("vbout_status", self::VBOUT_STATUS_DISACTIVE);
					
					$message = array(
						'type'=>'error',
						'message'=>$results['errorMessage']
					);
					
					update_option("vbout_flash_message", serialize($message));
				} else {
					update_option("vbout_status", self::VBOUT_STATUS_ACTIVE);
					update_option("vbout_api_business", serialize($results));
					
					$message = array(
						'type'=>'updated',
						'message'=>__( 'You have successfully connected your Vbout account to your Wordpress site.', 'vblng' )
					);
					
					update_option("vbout_flash_message", serialize($message));
					
					///	UPDATE DEFAULT VARIABLES FROM VBOUT
					$sm = new SocialMediaWS($app_key);

					//	GET VBOUT CHANNELS
					$channels = $sm->getChannels();
					$defaultChannels = array("Facebook"=>array(),"Twitter"=>array(),"Linkedin"=>array(), "default"=>array());
					
					if (isset($channels['Facebook']) && $channels['Facebook']['count'] > 0) {
						foreach($channels['Facebook']['pages'] as $page)
							$defaultChannels['Facebook'][] = array('value'=>$page['id'], 'label'=>$page['name'], 'default'=>false);
					}

					if (isset($channels['Twitter']) && $channels['Twitter']['count'] > 0) {
						foreach($channels['Twitter']['profiles'] as $profile)
							$defaultChannels['Twitter'][] = array('value'=>$profile['id'], 'label'=>$profile['fullname'], 'default'=>false);
					}
					
					if (isset($channels['Linkedin']['profiles']) && $channels['Linkedin']['count'] > 0) {
						foreach($channels['Linkedin']['profiles'] as $profile)
							$defaultChannels['Linkedin']['profiles'][] = array('value'=>$profile['id'], 'label'=>$profile['fullname'], 'default'=>false);
					}

					if (isset($channels['Linkedin']['companies']) && $channels['Linkedin']['count'] > 0) {
						foreach($channels['Linkedin']['companies'] as $company)
							$defaultChannels['Linkedin']['companies'][] = array('value'=>$company['companyId'], 'label'=>$company['companyName'], 'default'=>false);
					}

					update_option("vbout_sm_channels", serialize($defaultChannels));
					////////////////////////////////////////////////////////////////////////////////////

					$em = new EmailMarketingWS($app_key);

					//	GET VBOUT LISTS
					$lists = $em->getMyLists();
					$defaultLists = array('lists'=>array(), 'default'=>array(), 'sync'=>array());
					
					if (isset($lists['count']) && $lists['count'] > 0) {
						foreach($lists['items'] as $list)
							$defaultLists['lists'][] = array('value'=>$list['id'], 'label'=>$list['name'], 'default'=>false, 'sync'=>false);
					}
					
					update_option("vbout_em_lists", serialize($defaultLists));
					
					$trk = new WebsiteTrackWS($app_key);
					
					$domains = $trk->getDomains();
					$defaultDomains = array();

					if (isset($domains['count']) && $domains['count'] > 0) {
						foreach($domains['items'] as $domain)
							$defaultDomains[] = array('value'=>$domain['id'], 'label'=>$domain['domain'], 'code'=>$domain['trackercode']);
					}
					
					update_option("vbout_tracking_domains", serialize($defaultDomains));
				}
				
				update_option("vbout_method", $_POST['vbout_method']);

				update_option("vbout_userkey", $_POST['vbout_userkey']);
				update_option("vbout_appkey", $_POST['vbout_appkey']);
				update_option("vbout_clientsecret", $_POST['vbout_clientsecret']);
				update_option("vbout_authtoken", $_POST['vbout_authtoken']);
				
				//GOTO SETTINGS IF NOT FAILED
				if (!isset($results['errorMessage'])) {
					header('location: '.get_admin_url().'admin.php?page=vbout-settings');
					exit;
				}
			///}
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////

	static function admin_menu() 
	{
		global $wp_version;

		///	VBOUT OPTION PAGE
		$plugin_status = get_option('vbout_status');
		
		if (in_array($plugin_status, array(self::VBOUT_STATUS_DISACTIVE, self::VBOUT_STATUS_DISACTIVE, self::VBOUT_STATUS_ERROR))) {
			add_menu_page( __( 'Vbout Settings', 'vblng' ), __( 'Vbout Settings', 'vblng' ), 'manage_options', 'vbout-connect', array(__CLASS__, 'admin_options_page'), VBOUT_URL."/images/wp-logo.png", 1000);
		} elseif ($plugin_status == self::VBOUT_STATUS_ACTIVE) {
			add_menu_page( __( 'Vbout Settings', 'vblng' ), __( 'Vbout Settings', 'vblng' ), 'manage_options', 'vbout-connect', array(__CLASS__, 'admin_options_page'), VBOUT_URL."/images/wp-logo.png", 1000);
			add_menu_page( __( 'Vbout Settings', 'vblng' ), __( 'Vbout Settings', 'vblng' ), 'manage_options', 'vbout-settings', array(__CLASS__, 'admin_options_page'), VBOUT_URL."/images/wp-logo.png", 1000);
		}
		
		///	PLUGIN GENERAL SETTINGS
		$plugin_availability = get_option('vbout_plugin_availability');
		$plugin_attachment = get_option('vbout_plugin_attachment');
		
		$socialMediaActivated = get_option('vbout_sm_activated');
		$emailMarketingActivated = get_option('vbout_em_activated');
		
		if (in_array($plugin_attachment, array(self::VBOUT_ATTACH_EVERYWHERE, self::VBOUT_ATTACH_MENUONLY)) && ($socialMediaActivated || $emailMarketingActivated)) {
			add_submenu_page('non-existed-page', 'Vbout Schedule', 'Vbout Schedule', 'manage_options', 'vbout-schedule', array(__CLASS__, 'admin_schedule_page'));
			
			if (in_array($plugin_availability, array(self::VBOUT_AVAILABLE_BOTH, self::VBOUT_AVAILABLE_POSTONLY))) {
				add_filter('post_row_actions', array(__CLASS__, 'add_extra_options'), 10, 2);
			}
			
			if (in_array($plugin_availability, array(self::VBOUT_AVAILABLE_BOTH, self::VBOUT_AVAILABLE_PAGEONLY))) {
				add_filter('page_row_actions', array(__CLASS__, 'add_extra_options'), 10, 2);
			}
		}
		
		if (in_array($plugin_attachment, array(self::VBOUT_ATTACH_EVERYWHERE, self::VBOUT_ATTACH_FORMONLY)) && ($socialMediaActivated || $emailMarketingActivated)) {
			if (in_array($plugin_availability, array(self::VBOUT_AVAILABLE_BOTH, self::VBOUT_AVAILABLE_POSTONLY))) {
				if ( current_user_can( 'publish_posts' ) ) {
					add_meta_box('vbou_meta_box', __('Schedule this Post on Vbout?', 'vbout'), array(__CLASS__, 'vbout_meta_box'), 'post', 'normal', 'default');
				}
			}
			
			if (in_array($plugin_availability, array(self::VBOUT_AVAILABLE_BOTH, self::VBOUT_AVAILABLE_PAGEONLY))) {
				if ( current_user_can( 'publish_posts' ) ) {
					add_meta_box('vbou_meta_box', __('Schedule this Page on Vbout?', 'vbout'), array(__CLASS__, 'vbout_meta_box'), 'page', 'normal', 'default');
				}
			}
			
			/// ADD ACTIONS AFTER SAVE/UPDATE/EDIT/ETC....
			add_action('save_post', array(__CLASS__, 'send_vbout_queries'));
		}
		
		/// Adds the action to the hook
		add_action('admin_notices', array(__CLASS__, 'vbout_custom_notices'));
	}

	///////////////////////////////////////////////////////////////////////////////////////	
	static function add_extra_options($actions, $page_object)
	{
		//WP_Post Object ( [ID] => 1 [post_author] => 1 [post_date] => 2014-12-26 13:23:30 [post_date_gmt] => 2014-12-26 13:23:30 [post_content] => Welcome to WordPress. This is your first post. Edit or delete it, then start blogging! [post_title] => Hello world! [post_excerpt] => [post_status] => publish [comment_status] => open [ping_status] => open [post_password] => [post_name] => hello-world [to_ping] => [pinged] => [post_modified] => 2014-12-26 13:23:30 [post_modified_gmt] => 2014-12-26 13:23:30 [post_content_filtered] => [post_parent] => 0 [guid] => http://localhost/wpplugin/?p=1 [menu_order] => 0 [post_type] => post [post_mime_type] => [comment_count] => 1 [filter] => raw )
		$actions['vbout_link'] = '<a href="'.get_admin_url().'admin.php?page=vbout-schedule&id='.$page_object->ID.'">Schedule on Vbout</a>';
	 
	   return $actions;
	}
	///////////////////////////////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////////////////////////////	
	static function embed_tracking_code()
	{
		// Ignore admin, feed, robots or trackbacks
		if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
			return;
		}
		
		$tracking_code = get_option('vbout_tracking_code');
		if (empty($tracking_code) || trim($tracking_code) == '') {
			return;
		}
		
		// Output
		echo stripslashes($tracking_code);
	}
	///////////////////////////////////////////////////////////////////////////////////////	
	
	static function admin_options_page() 
	{
		$input_fields = array();
		$hidden_fields = "";
		
		$plugin_status = get_option('vbout_status');
		$plugin_method = get_option('vbout_method');
		
		$form_name = "vbout-update-options";
		$form_page = "settings";
		$form_title = __( 'Vbout Plugin Settings', 'vblng' );
		
		$submit_button = __( 'Save Changes', 'vblng' );
		
		//sprintf('<h1 style="color: red; margin: 0;">%1$s*</h1>', __('Protection Inactive', 'vblng'))
		
		if ($plugin_status == self::VBOUT_STATUS_DISACTIVE || (isset($_GET['page']) && $_GET['page'] == 'vbout-connect')) {
			$input_fields = implode("\n", array(
				self::template('form_objects/header', array(
					'header' => __( 'Connect your Vbout App to your Wordpress Site', 'vblng' ),
					'description' => __( 'You need to have an account with Vbout.com to activate this plugin. Click <a href="https://www.vbout.com/pricing" target="_blank">here</a> to signup for a FREE trial.<br /><br />You can connect using your main API key or an application specific key. An application key can be revoked from your Vbout.com settings at anytime but your API key cannot be changed. If you are the only one with access to your Vbout and Wordpress accounts, your API Key is the easier option, otherwise, configure an application from your account and use it below. Click <a href="https://developers.vbout.com/quickstart" target="_blank">here</a> for more information.<br /><div style="text-align: center;"><iframe width="853" height="480" src="//www.youtube.com/embed/1m54s5LCr4g?rel=0" frameborder="0" allowfullscreen></iframe></div>', 'vblng' )
				)),
				
				self::template('form_objects/slider', array(
					'sliderId' => "UserKeySlider",
					'description' => __( '- If you have a <strong style="color: red">[User Key]</strong>, please click <a class="sliderButton" data-method="0" data-slider="UserKeySlider" href="javascript://">here</a>.', 'vblng' ),
					'form_fields' => implode("\n", array(
						self::template('form_objects/text', array(
							'key' => 'vbout_userkey',
							'name' => __( 'My User Key', 'vblng' ),
							'value' => esc_attr(get_option('vbout_userkey')),
							'description' => implode('<br />', array(
								implode('&nbsp;&nbsp;', array(__( 'Your Vbout account User Key. Click <a href="https://www.vbout.com/settings/apikeys" target="_blank">here</a> to obtain your api key.', 'vblng' )))
							))
						))
					))
				)),
				
				self::template('form_objects/slider', array(
					'sliderId' => "AppKeySlider",
					'description' => __( '- If you have an <strong style="color: red">[Application Key]</strong>, please click <a class="sliderButton" data-method="1" data-slider="AppKeySlider" href="javascript://">here</a>.', 'vblng' ),
					'form_fields' => implode("\n", array(
						self::template('form_objects/text', array(
							'key' => 'vbout_appkey',
							'name' => __( 'Application Key', 'vblng' ),
							'value' => esc_attr(get_option('vbout_appkey')),
							'description' => implode('<br />', array(
								implode('&nbsp;&nbsp;', array(__( 'Your application key.', 'vblng' )))
							))
						)),
						
						self::template('form_objects/text', array(
							'key' => 'vbout_clientsecret',
							'name' => __( 'Client Secret', 'vblng' ),
							'value' => esc_attr(get_option('vbout_clientsecret')),
							'description' => implode('<br />', array(
								implode('&nbsp;&nbsp;', array(__( 'Client secret of your application.', 'vblng' )))
							))
						)),
						
						self::template('form_objects/text', array(
							'key' => 'vbout_authtoken',
							'name' => __( 'Authentication Token', 'vblng' ),
							'value' => esc_attr(get_option('vbout_authtoken')),
							'description' => implode('<br />', array(
								implode('&nbsp;&nbsp;', array(__( 'Authentication token of your application.', 'vblng' )))
							))
						))
					))
				))
			));
			
			$hidden_fields .= implode(PHP_EOL, array(
				'<input type="hidden" name="vbout_method" value="'.get_option('vbout_method').'" />'
			));
			
			$submit_button = __( 'Connect to Vbout', 'vblng' );
			
			$form_name = "vbout-connect";
			$form_page = "connect";
			$form_title = __( 'Vbout Connect Settings', 'vblng' );
			
		} elseif ($plugin_status == self::VBOUT_STATUS_LOCKED) {
			//__( 'Save Changes', 'vblng' )
		} elseif ($plugin_status == self::VBOUT_STATUS_ACTIVE) {
			$channels 	= unserialize(get_option('vbout_sm_channels'));
			$lists 		= unserialize(get_option('vbout_em_lists'));
			$domains 	= unserialize(get_option('vbout_tracking_domains'));
			
			$stupidBusiness = unserialize(get_option('vbout_api_business'));
			
			$settings_tabs_header = array(
				'general' => __( 'General', 'vblng' ), 
				'social_media' => __( 'Social Media', 'vblng' ),
				'email_marketing' => __( 'Email Marketing', 'vblng' ),
				'tracking' => __( 'Site Tracking', 'vblng' ),
				'support' => __( 'Support', 'vblng' ),
			);
			
			$current_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'general';
			$settings_tabs = array();
			
			$settings_tabs['general'] = implode("\n", array(
				self::template('form_objects/header', array(
					'header' => $settings_tabs_header['general'],
					'description' => __( 'You are connected to ('.$stupidBusiness['businessName'].') click <a href="'.get_admin_url().'admin.php?page=vbout-connect">here</a> to change your key.<Br /><Br />Please choose what type of content will use the plugin:', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'key' => 'vbout_plugin_availability',
					'name' => __( 'Activate this Plugin for', 'vblng' ),
					'options' => array(
						array('label' => __( 'Both (Posts and Pages)', 'vblng' ), 'value' => self::VBOUT_AVAILABLE_BOTH),
						array('label' => __( 'Posts Only', 'vblng' ), 'value' => self::VBOUT_AVAILABLE_POSTONLY),
						array('label' => __( 'Pages Only', 'vblng' ), 'value' => self::VBOUT_AVAILABLE_PAGEONLY),
					),
					'value' => esc_attr(get_option('vbout_plugin_availability')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array('Choose where the plugin is available.'))
					))
				)),
				
				self::template('form_objects/dropdown', array(
					'key' => 'vbout_plugin_attachment',
					'name' => __( 'Show Plugin Option on', 'vblng' ),
					'options' => array(
						array('label' => __( 'Both (Quick Menu and Inside Forms)', 'vblng' ), 'value' => self::VBOUT_ATTACH_EVERYWHERE),
						array('label' => __( 'Quick Menu Only', 'vblng' ), 'value' => self::VBOUT_ATTACH_MENUONLY),
						array('label' => __( 'Inside Forms Only', 'vblng' ), 'value' => self::VBOUT_ATTACH_FORMONLY),
					),
					'value' => esc_attr(get_option('vbout_plugin_attachment')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array('Choose where the plugin is attached.'))
					))
				)),
			));

			$settings_tabs['social_media'] = implode("\n", array(
				/////////////////////////////////////////////////////////////////////////////////////////
				///	SOCIAL MEDIA SETTINGS
				self::template('form_objects/header', array(
					'header' => $settings_tabs_header['social_media'],
					'description' => __( 'Please choose the default settings for marketing on social media through Vbout.com:', 'vblng' )
				)),
				
				self::template('form_objects/radio', array(
					'options' => array(
						array('label' => __( 'Yes', 'vblng' ), 'value' => true),
						array('label' => __( 'No', 'vblng' ), 'value' => false)
					),

					'key' => 'vbout_sm_activated',
					'name' => __( 'Push Content to Social Media', 'vblng' ),
					'value' => get_option('vbout_sm_activated'),
					'description' => __( 'Whether or not you wish to offer posting your content to your social media channels.', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'multiple' => true,
					'class' => 'chosen-select',
					'options' => $channels['Facebook'],
					'key' => 'vbout_sm_channels_facebook',
					'name' => __( 'Facebook Pages', 'vblng' ),
					'value' => isset($channels['default']['Facebook'])?$channels['default']['Facebook']:array(),
					'description' => __( 'Choose which Facebook page(s) you want to be shown in the social media menu. <br /><span style="color: red;">Note: All pages will be shown if none chosen.</span>', 'vblng' )
				)),
				
				
				self::template('form_objects/dropdown', array(
					'multiple' => true,
					'class' => 'chosen-select',
					'options' => $channels['Twitter'],
					'key' => 'vbout_sm_channels_twitter',
					'name' => __( 'Twitter Profiles', 'vblng' ),
					'value' => isset($channels['default']['Twitter'])?$channels['default']['Twitter']:array(),
					'description' => __( 'Choose which Twitter profile(s) you want to be shown in the social media menu. <br /><span style="color: red;">Note: All profiles will be shown if none chosen.</span>', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'multiple' => true,
					'class' => 'chosen-select',
					'options' => $channels['Linkedin']['profiles'],
					'key' => 'vbout_sm_channels_linkedin',
					'name' => __( 'Linkedin Profiles', 'vblng' ),
					'value' => isset($channels['default']['Linkedin']['profiles'])?$channels['default']['Linkedin']['profiles']:array(),
					'description' => __( 'Choose which Linkedin profile(s) you want to be shown in the social media menu. <br /><span style="color: red;">Note: All profiles will be shown if none chosen.</span>', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'multiple' => true,
					'class' => 'chosen-select',
					'options' => $channels['Linkedin']['companies'],
					'key' => 'vbout_sm_channels_linkedincompanies',
					'name' => __( 'Linkedin Companies', 'vblng' ),
					'value' => isset($channels['default']['Linkedin']['companies'])?$channels['default']['Linkedin']['companies']:array(),
					'description' => __( 'Choose which Linkedin companies(s) you want to be shown in the social media menu. <br /><span style="color: red;">Note: All companies will be shown if none chosen.</span>', 'vblng' )
				)),
			));
				/////////////////////////////////////////////////////////////////////////////////////////
				
			$settings_tabs['email_marketing'] = implode("\n", array(
				/////////////////////////////////////////////////////////////////////////////////////////
				///	EMAIL MARKETING SETTINGS
				self::template('form_objects/header', array(
					'header' => $settings_tabs_header['email_marketing'],
					'description' => __( 'Please choose default settings for turning your content into email marketing posts on Vbout.com:', 'vblng' )
				)),
				
				self::template('form_objects/radio', array(
					'options' => array(
						array('label' => __( 'Yes', 'vblng' ), 'value' => true),
						array('label' => __( 'No', 'vblng' ), 'value' => false)
					),

					'key' => 'vbout_em_activated',
					'name' => __( 'Push Content to Email Marketing', 'vblng' ),
					'value' => get_option('vbout_em_activated'),
					'description' => __( 'Whether or not you wish to offer posting your content to your email marketing engine.', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'multiple' => true,
					'class' => 'chosen-select',
					'options' => $lists['lists'],
					'key' => 'vbout_em_lists',
					'name' => __( 'Subscriber\'s Lists', 'vblng' ),
					'value' => $lists['default'],
					'description' => __( 'Choose which list(s) you want to be shown in the "send as email campaign" menu. <br /><span style="color: red;">Note: All lists will be shown if none chosen.</span>', 'vblng' )
				)),
				
				self::template('form_objects/text', array(
					'key' => 'vbout_em_emailname',
					'name' => __( 'Default Email Name', 'vblng' ),
					'value' => esc_attr(get_option('vbout_em_emailname')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Enter the default email name here if you want it to be same in every campaign.', 'vblng' )))
					))
				)),
				
				self::template('form_objects/text', array(
					'key' => 'vbout_em_emailsubject',
					'name' => __( 'Default Email Subject', 'vblng' ),
					'value' => esc_attr(get_option('vbout_em_emailsubject')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Enter the default email subject here if you want it to be same in every campaign.', 'vblng' )))
					))
				)),
				
				self::template('form_objects/text', array(
					'key' => 'vbout_em_fromemail',
					'name' => __( 'Default From Email', 'vblng' ),
					'value' => esc_attr(get_option('vbout_em_fromemail')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Enter the default from email here if you want it to be same in every campaign.', 'vblng' )))
					))
				)),
				
				self::template('form_objects/text', array(
					'key' => 'vbout_em_fromname',
					'name' => __( 'Default From Name', 'vblng' ),
					'value' => esc_attr(get_option('vbout_em_fromname')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Enter the default from name here if you want it to be same in every campaign.', 'vblng' )))
					))
				)),
				
				self::template('form_objects/text', array(
					'key' => 'vbout_em_replyto',
					'name' => __( 'Default Reply to', 'vblng' ),
					'value' => esc_attr(get_option('vbout_em_replyto')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Enter the default reply to email here if you want it to be same in every campaign.', 'vblng' )))
					))
				)),
				
				self::template('form_objects/dropdown', array(
					'key' => 'vbout_sync_emaillist',
					'name' => __( 'Users Synchronization List', 'vblng' ),
					'options' => array_merge(array(array('value'=>'', 'label'=>'- NONE -')), $lists['lists']),
					'value' => esc_attr(get_option('vbout_sync_emaillist')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array('Choose which list on Vbout.com you want to synch your wordpress users with. The email of each user on your Wordpress will be sent to your chosen list on Vbout to be used for marketing and automation. (This is a one-way synchronization).<br /><p style="color: red;">To enable the synchronization features please install the following Cron Job on your hosting account: </p><pre>wget -q -O - '.get_site_url().'/wp-cron.php?doing_wp_cron >/dev/null 2>&1</pre><p style="color: red;">The default recommended synchronization frequency is once per day but you can modify this as you see fit.</p>'))
					))
				)),
				/////////////////////////////////////////////////////////////////////////////////////////
			));

			$settings_tabs['tracking'] = implode("\n", array(
				/////////////////////////////////////////////////////////////////////////////////////////
				///	SITE TRACKING SETTINGS
				self::template('form_objects/header', array(
					'header' => $settings_tabs_header['tracking'],
					'description' => __( 'Please choose default settings for site tracking by Vbout.com (used for conversion tracking, behavioral targeting and more).', 'vblng' )
				)),
				
				self::template('form_objects/radio', array(
					'options' => array(
						array('label' => __( 'Yes', 'vblng' ), 'value' => true),
						array('label' => __( 'No', 'vblng' ), 'value' => false)
					),

					'key' => 'vbout_tracking_activated',
					'name' => __( 'Activate Site Tracking', 'vblng' ),
					'value' => get_option('vbout_tracking_activated'),
					'description' => __( 'Whether or not to push Vbout site tracking code inside your Wordpress footer.', 'vblng' )
				)),
				
				self::template('form_objects/dropdown', array(
					'trackingcode'=>true,
					'key' => 'vbout_tracking_domain',
					'name' => __( 'Site Domains', 'vblng' ),
					'options' => array_merge(array(array('value'=>'', 'label'=>'- NONE -')), $domains),
					'value' => esc_attr(get_option('vbout_tracking_domain')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array('Choose which domain you want tracking code to be included.'))
					))
				)),
				
				self::template('form_objects/textarea', array(
					'key' => 'vbout_tracking_code',
					'name' => __( 'Vbout Site Tracking Code', 'vblng' ),
					'value' => esc_attr(get_option('vbout_tracking_code')),
					'description' => implode('<br />', array(
						implode('&nbsp;&nbsp;', array(__( 'Here you can edit the Tracking code.', 'vblng' )))
					))
				)),
				/////////////////////////////////////////////////////////////////////////////////////////
			));
			
			$settings_tabs['support'] = implode("\n", array(
				self::template('form_objects/header', array(
					'header' => $settings_tabs_header['support'],
					'description' => __( '<a href="https://www.vbout.com/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wordpress" target="_blank">Vbout.com - All-in One Marketing Automation</a><br /><br />For any questions, suggestions or bug reporting please contact us directly at:  <a href="mailto:Support@Vbout.com">Support@Vbout.com</a>.<br /><br /><div style="text-align: center;"><iframe width="853" height="480" src="//www.youtube.com/embed/1m54s5LCr4g?rel=0" frameborder="0" allowfullscreen></iframe></div>', 'vblng' )
				)),
			));
			
			$input_fields = self::template('form_objects/tabs', array(
				'tab_headers' => $settings_tabs_header,
				'current_tab' => $current_tab,
				'settings_tabs' => $settings_tabs
			));
		}
	
		///	FIXED HIDDEN FIELDS
		$hidden_fields .= implode(PHP_EOL, array(
			'<input type="hidden" name="option_page" value="vbout-'.$form_page.'" />',
			'<input type="hidden" name="action" value="update" />',
			wp_nonce_field('vbout-'.$form_page.'-options', '_wpnonce', true, false)
		));
		
		///	FIXED FLASH MESSAGES
		if (get_option("vbout_flash_message") !== FALSE) {
			$message = unserialize(get_option("vbout_flash_message"));
			
			$flash_message = implode(PHP_EOL, array(
				'<div id="message" class="'.$message['type'].'"><p><strong>'.$message['message'].'</strong></p></div>'
			));
			
			//	REMOVE THE STUPID MESSAGE FROM DB
			update_option("vbout_flash_message", '');
		}

		///	FINALY RENDER THE FORM
		echo self::template('form_objects/form', compact('input_fields', 'hidden_fields', 'flash_message') + array(
			'id' => $form_name,
			'title' => $form_title,
			'icon' => 'icon-users',

			'submit' => $submit_button,
			'cancel' => __( 'Reset', 'vblng' )
		));
	}

	static function vbout_custom_notices()
	{
		if (get_option("vbout_flash_message") !== FALSE) {
			$message = unserialize(get_option("vbout_flash_message"));
			
			echo '<div id="message" class="'.$message['type'].'"><p><strong>'.$message['message'].'</strong></p></div>';
			
			//	REMOVE THE STUPID MESSAGE FROM DB
			update_option("vbout_flash_message", '');
		}
	}
	
	static function send_vbout_queries()
	{
		if ( current_user_can( 'publish_posts' ) ) {
			if ($_POST != NULL) {
				$results = array();
				$hasError = false;
				$errorMessage = '';
				
				//echo '<pre>';
				//print_r($_REQUEST);
				//return;
					
				if (get_option('vbout_method') == self::VBOUT_METHOD_USERKEY) {
					$app_key = array(
						'key' => get_option('vbout_userkey')
					);
				} elseif (get_option('vbout_method') == self::VBOUT_METHOD_APPKEY) {
					$app_key = array(
						'app_key' => get_option('vbout_appkey'),
						'client_secret' => get_option('vbout_clientsecret'),
						'oauth_token' => get_option('vbout_authtoken')
					);
				}

				$business = unserialize(get_option('vbout_api_business'));
				
				date_default_timezone_set($business['timezone']);
								
				//	CHECK TIME 12-hours | 24-hours
				//if (preg_match("/(1[012]|0[0-9]):[0-5][0-9]/", $_REQUEST['vb_post_schedule_time']) || preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $_REQUEST['vb_post_schedule_time'])) {
				$scheduledDateTime = $_REQUEST['vb_post_schedule_date'].' '.$_REQUEST['vb_post_schedule_time']['Hours'].':'.$_REQUEST['vb_post_schedule_time']['Minutes'].' '.$_REQUEST['vb_post_schedule_time']['TimeAmPm'];
				//} else {
				//	$scheduledDateTime = $_REQUEST['vb_post_schedule_date'].' 00:00';
				//}

				//	CHECK IF POST TO CHANNELS
				if (isset($_REQUEST['vb_post_to_channels'])) {
					$sm = new SocialMediaWS($app_key);

					foreach($_REQUEST['channels'] as $channelName => $channelId) {
						/*$params = array(
							'message'=>strip_tags($_REQUEST['content']),
							'photo'=>strip_tags($_REQUEST['photo_url']),
							'photo_title'=>strip_tags($_REQUEST['photo_alt']),
							'photo_url'=>strip_tags($_REQUEST['post_url']),
							'channel'=>$channelName,
							'channelid'=>implode(',', $channelId),
							'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
							'scheduleddate'=>strtotime($scheduledDateTime)
						);*/
						
						if ($channelName != 'twitter') {
							$params = array(
								//top share content
								'message'=>($_REQUEST['photo_url'] != NULL)?$_REQUEST['post_title']:$_REQUEST['post_title'].' '.$_REQUEST['post_url'],
								//share photo
								'photo'=>strip_tags($_REQUEST['photo_url']),
								//share photo title
								'photo_title'=>strip_tags($_REQUEST['post_title']),
								//share photo url
								'photo_url'=>strip_tags($_REQUEST['post_url']),
								//share description
								'photo_caption'=>strip_tags($_REQUEST['post_description']),
								
								'channel'=>$channelName,
								'channelid'=>implode(',', $channelId),
								'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
								'scheduleddate'=>strtotime($scheduledDateTime),
								'trackableLinks'=>isset($_REQUEST['vb_post_schedule_shortenurls'])?'true':'false'
							);
						} else {
							$params = array(
								//top share content
								'message'=>$_REQUEST['post_title'].' '.strip_tags($_REQUEST['post_url']),
								//share photo
								'photo'=>strip_tags($_REQUEST['photo_url']),
								//share photo title
								'photo_title'=>strip_tags($_REQUEST['post_title']),
								//share photo url
								'photo_url'=>strip_tags($_REQUEST['post_url']),
								//share description
								'photo_caption'=>strip_tags($_REQUEST['post_description']),
								
								'channel'=>$channelName,
								'channelid'=>implode(',', $channelId),
								'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
								'scheduleddate'=>strtotime($scheduledDateTime),
								'trackableLinks'=>isset($_REQUEST['vb_post_schedule_shortenurls'])?'true':'false'
							);
						}
						
						//print_r($params);  exit;
						//print_r($sm->addNewPost($params)); exit;
						$results['social'][$channelName] = $sm->addNewPost($params);
						
						if (is_array($results['social'][$channelName]) && isset($results['social'][$channelName]['errorCode'])) {
							$hasError = true;
							$errorMessage .= $results['social'][$channelName]['errorCode'].' - '.$results['social'][$channelName]['errorMessage'];
							
							if (isset($results['social'][$channelName]['fields']))
								$errorMessage .= '<ul><li>'.implode('</li><li>', $results['social'][$channelName]['fields']).'</li></ul>';
						}
					}
				}
				
				if (isset($_REQUEST['vb_post_to_campaign'])) {
					$em = new EmailMarketingWS($app_key);
					
					$params = array(
						'type'=>'standard',
						'name'=>$_REQUEST['vb_post_schedule_emailname'],
						'subject'=>$_REQUEST['vb_post_schedule_emailsubject'],
						'fromemail'=>$_REQUEST['vb_post_schedule_fromemail'],
						'from_name'=>$_REQUEST['vb_post_schedule_fromname'],
						'reply_to'=>$_REQUEST['vb_post_schedule_replyto'],
						'isdraft'=>'false',
						'isscheduled'=>isset($_REQUEST['vb_post_schedule_isscheduled'])?'true':'false',
						'scheduled_datetime'=>date('Y-m-d H:i', strtotime($scheduledDateTime)),
						'recipients'=>($_REQUEST['campaign'] != NULL)?implode(',', $_REQUEST['campaign']):'',
						'body'=>$_REQUEST['content']
					);
					
					//print_r($params);
					//print_r($em->addNewCampaign($params));
					$results['campaign'] = $em->addNewCampaign($params);
					
					if (is_array($results['campaign']) && isset($results['campaign']['errorCode'])) {
						$hasError = true;
						$errorMessage .= $results['campaign']['errorCode'].' - '.$results['campaign']['errorMessage'];
						
						if (isset($results['campaign']['fields']))
							$errorMessage .= '<ul><li>'.implode('</li><li>', $results['campaign']['fields']).'</li></ul>';
					}
				}
				
				//IF THERE IS AN ERROR ADD CUSTOM MESSAGE OF THE ERROR
				if ($hasError) {
					//print_r($errorMessage);
					//$_SESSION['vb_custom_error'] = $errorMessage;
					
					$message = array(
						'type'=>'error',
						'message'=>$errorMessage
					);
					
					update_option("vbout_flash_message", serialize($message));
				} else {
					//$_SESSION['vb_custom_success'] = 'Your message has been sent successfully to vbout.';
					$message = array(
						'type'=>'updated',
						'message'=>__( 'Your marketing task has been scheduled. Click <a href="https://www.vbout.com/dashboard" target="_blank">here</a> to manage your submissions on Vbout.com', 'vblng' )
					);
					
					update_option("vbout_flash_message", serialize($message));
				}
				
				//header('location: '.get_admin_url().'post.php?post='.$_POST['post_id']);
			}
		}
	}
	
	static function vbout_meta_box()
	{
		$socialMediaActivated = get_option('vbout_sm_activated');
		$emailMarketingActivated = get_option('vbout_em_activated');
		
		$channels 	= unserialize(get_option('vbout_sm_channels'));
		$lists 		= unserialize(get_option('vbout_em_lists'));
		
		require VBOUT_DIR.'/includes/meta_box.php';
	}
	
	static function admin_schedule_page()
	{
		$socialMediaActivated = get_option('vbout_sm_activated');
		$emailMarketingActivated = get_option('vbout_em_activated');
		
		$channels 	= unserialize(get_option('vbout_sm_channels'));
		$lists 		= unserialize(get_option('vbout_em_lists'));
		
		require VBOUT_DIR.'/includes/meta_box2.php';
	}
	
	///////////////////////////////////////////////////////////////////////////////////////
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
	///////////////////////////////////////////////////////////////////////////////////////
	
	public static function synchronize_wp_users()
	{
		$listToSync = get_option('sync_emaillist');
		
		if ($listToSync == NULL)
			return;
		
		//	GET WORDPRESS USERS
		$blogUsers = get_users();
		
		if ($blogUsers != NULL) {
		
			if (get_option('vbout_method') == self::VBOUT_METHOD_USERKEY) {
				$app_key = array(
					'key' => get_option('vbout_userkey')
				);
			} elseif (get_option('vbout_method') == self::VBOUT_METHOD_APPKEY) {
				$app_key = array(
					'app_key' => get_option('vbout_appkey'),
					'client_secret' => get_option('vbout_clientsecret'),
					'oauth_token' => get_option('vbout_authtoken')
				);
			}

			foreach($blogUsers as $user) {
				//	CHECK IF USER ALREADY EXISTS
				$em = new EmailMarketingWS($app_key);
							
				//print_r($params);
				//print_r($em->searchContact($params));
				$results['contact'] = $em->searchContact($user->user_email);
			
				if (is_array($results['contact']) && isset($results['contact']['errorCode'])) {
					//	CONTACT NOT FOUND
					//	ADD NEW CONTACT
					$params = array(
						'email'=>$user->user_email,
						'status'=>1,
						'listid'=>$listToSync
					);
						
					//print_r($params);
					//print_r($em->addNewContact($params));
					$results['contact'] = $em->addNewContact($params);
				}
			}
		}
	}
	
	public static function on_activation()
	{
		wp_schedule_event( time(), 'daily', 'synchronize_wp_users_hook' );
	}
	
	///////////////////////////////////////////////////////////////////////////////////////
	//+	CLEANING OPTIONS FROM DATABASE AFTER DESACTIVATION - PLEASE DO NOT REMOVE		///
	///////////////////////////////////////////////////////////////////////////////////////
	public static function on_deactivation()
	{
		if ( ! current_user_can( 'activate_plugins' ) )
            return;
		
		wp_clear_scheduled_hook( 'synchronize_wp_users_hook' );
		
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );
		
		foreach (self::$options as $optionKey => $optionVars):
			foreach($optionVars as $optionVar):
				$key = "vbout_{$optionVar}";

				delete_option($key);
			endforeach;
		endforeach;
	}
	///////////////////////////////////////////////////////////////////////////////////////
}