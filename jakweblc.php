<?php
/*
Plugin Name: Liv3 Chat
Plugin URI: https://Liv3Chat.com
Description: Will embed the live support chat from Liv3 Chat with extra settings.
Version: 0.2
Author: Liv3chat.com
Text Domain: Liv3-live-chat
*/
if(!class_exists('jakwebLC_Settings')){

	class jakwebLC_Settings{
		const JAKWEBLC_WIDGET_ID_VARIABLE = 'jakweblc-embed-widget-id';
		const JAKWEBLC_VISIBILITY_OPTIONS = 'jakweblc-lc-options';

		public function __construct(){

			if(!get_option('jakweblc-lc-options',false) )
			{
			$jaklcoptions = array (
				'always_display' => 1,
				'show_onfrontpage' => 0,
				'show_oncategory' => 0,
				'show_ontagpage' => 0,
				'show_onarticlepages' => 0,
				'exclude_url' => 0,
				'excluded_url_list' => '',
				'include_url' => 0,
				'included_url_list' => '',
				'display_on_shop' => 0,
				'display_on_productcategory' => 0,
				'display_on_productpage' => 0,
				'display_on_producttag' => 0
			);
			update_option( 'jakweblc-lc-options', $jaklcoptions);
			}

			if (isset($_GET['reset']) && $_GET['reset'] == '1')
			{
				$this->jaklc_reset_widgetid();
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["widgetid_form"]))
			{
				$this->jaklc_action_setwidget($_POST);
			}
			elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["options"]))
			{
				$this->jaklc_update_options($_POST);
			}

			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'add_menu'));

			add_action('admin_enqueue_scripts', array($this,'jakweb_settings_assets') );
		}

		public function jakweb_settings_assets($hook)
		{
			if($hook != 'settings_page_zipp_chat')
				return;

			wp_register_style( 'jakweb_admin_style', plugins_url( 'assets/jakweb.admin.css' , __FILE__ ) );
        	wp_enqueue_style( 'jakweb_admin_style' );

        	wp_enqueue_script( 'jakweb_admin_script', plugins_url( 'assets/jakweb.admin.js' , __FILE__ ) );
        
		}

		public function admin_init(){
			register_setting( 'jakweb_options', 'jakweblc-lc-options', array(&$this,'validate_options') );
		}

		public function jaklc_action_setwidget($data) {

			if (!isset($data['widgetid']) || empty($data['widgetid']) || !is_numeric($data['widgetid'])) {
				add_action( 'admin_notices', array($this,'jaklc_widgetid_error') );
				return false;
			}

			update_option(self::JAKWEBLC_WIDGET_ID_VARIABLE, $data['widgetid']);
			add_action( 'admin_notices', array($this,'jaklc_widgetid_update') );
			return true;
			
		}

		public function jaklc_widgetid_error() {
		    ?>
		    <div class="error notice">
		        <p><?php _e( 'Please use only digits.', 'zipp-live-chat' ); ?></p>
		    </div>
		<?php
		}

		public function jaklc_widgetid_update() {
		    ?>
		    <div class="updated notice">
		        <p><?php _e( 'Your widgetID has been added, excellent!', 'zipp-live-chat' ); ?></p>
		    </div>
		<?php
		}

		public function jaklc_option_update() {
		    ?>
		    <div class="updated notice">
		        <p><?php _e( 'Your live support chat options has been saved, awesome!', 'zipp-live-chat' ); ?></p>
		    </div>
		<?php
		}

		public function jaklc_widgetid_removed() {
		    ?>
		    <div class="updated notice">
		        <p><?php _e( 'Your widgetID has been removed, add another one!', 'zipp-live-chat' ); ?></p>
		    </div>
		<?php
		}

		protected function jaklc_reset_widgetid()
		{
			update_option(self::JAKWEBLC_WIDGET_ID_VARIABLE, "");
			add_action( 'admin_notices', array($this,'jaklc_widgetid_removed') );
		}

		protected function jaklc_update_options($data)
		{
			$jaklcoptions = array (
				'always_display' => ($data['always_display'] != '1') ? 0 : 1,
				'show_onfrontpage' => ($data['show_onfrontpage'] != '1') ? 0 : 1,
				'show_oncategory' => ($data['show_oncategory'] != '1') ? 0 : 1,
				'show_ontagpage' => ($data['show_ontagpage'] != '1') ? 0 : 1,
				'show_onarticlepages' => ($data['show_onarticlepages'] != '1') ? 0 : 1,
				'exclude_url' => ($data['exclude_url'] != '1') ? 0 : 1,
				'excluded_url_list' => sanitize_text_field($data['excluded_url_list']),
				'include_url' => ($data['include_url'] != '1') ? 0 : 1,
				'included_url_list' => sanitize_text_field($data['included_url_list']),
				'display_on_shop' => ($data['display_on_shop'] != '1') ? 0 : 1,
				'display_on_productcategory' => ($data['display_on_productcategory'] != '1') ? 0 : 1,
				'display_on_productpage' => ($data['display_on_productpage'] != '1') ? 0 : 1,
				'display_on_producttag' => ($data['display_on_producttag'] != '1') ? 0 : 1
			);
			update_option( 'jakweblc-lc-options', $jaklcoptions);

			add_action( 'admin_notices', array($this,'jaklc_option_update') );
			add_action( 'admin_notices', array($this,'jakweb_admin_notice') );
			return true;
		}

		function jakweb_admin_notice() {
			    ?>
			    <div class="notice notice-warning is-dismissible">
			        <p><?php _e( 'In case you are using a caching plugin, please empty the cache to see some results.', 'zipp-live-chat' ); ?></p>
			    </div>
			    <?php
		}

		public function validate_options($input){

			$input['always_display'] = ($input['always_display'] != '1') ? 0 : 1;
			$input['show_onfrontpage'] = ($input['show_onfrontpage'] != '1') ? 0 : 1;
			$input['show_oncategory'] = ($input['show_oncategory'] != '1') ? 0 : 1;
			$input['show_ontagpage'] = ($input['show_ontagpage'] != '1') ? 0 : 1;
			$input['show_onarticlepages'] = ($input['show_onarticlepages'] != '1') ? 0 : 1;
			$input['exclude_url'] = ($input['exclude_url'] != '1') ? 0 : 1;
			$input['excluded_url_list'] = sanitize_text_field($input['excluded_url_list']);
			$input['include_url'] = ($input['include_url'] != '1') ? 0 : 1;
			$input['included_url_list'] = sanitize_text_field($input['included_url_list']);
			$input['display_on_shop'] = ($input['display_on_shop'] != '1') ? 0 : 1;
			$input['display_on_productcategory'] = ($input['display_on_productcategory'] != '1') ? 0 : 1;
			$input['display_on_productpage'] = ($input['display_on_productpage'] != '1') ? 0 : 1;
			$input['display_on_producttag'] = ($input['display_on_producttag'] != '1') ? 0 : 1;

			return $input;
		}

		public function add_menu(){
			add_options_page(
				__('Liv3 Chat Settings','zipp-live-chat'),
				__('Liv3 Chat','zipp-live-chat'),
				'manage_options',
				'zipp_chat',
				array(&$this, 'create_plugin_settings_page')
			);
		}

		public function create_plugin_settings_page(){

			global $wpdb;

			if(!current_user_can('manage_options'))	{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}

			$lc_embedid = get_option(self::JAKWEBLC_WIDGET_ID_VARIABLE);

			include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
		}

		public static function ids_are_correct($page_id, $widget_id) {
			return preg_match('/^[0-9]{24}$/', $lc_embedid) === 1;
		}
	}
}

if(!class_exists('Liv3Chat')){
	class JakwebLC{
		public function __construct(){
			$jakweblc_settings = new jakwebLC_Settings();
			add_shortcode( 'Liv3 Chat', array($this,'shortcode_print_embed_code') );

		}

		public static function activate(){

			$jaklcoptions = array (
				'always_display' => 1,
				'show_onfrontpage' => 0,
				'show_oncategory' => 0,
				'show_ontagpage' => 0,
				'show_onarticlepages' => 0,
				'exclude_url' => 0,
				'excluded_url_list' => '',
				'include_url' => 0,
				'included_url_list' => '',
				'display_on_shop' => 0,
				'display_on_productcategory' => 0,
				'display_on_productpage' => 0,
				'display_on_producttag' => 0
			);

			add_option(jakwebLC_Settings::JAKWEBLC_WIDGET_ID_VARIABLE, '', '', 'yes');
			add_option(jakwebLC_Settings::JAKWEBLC_VISIBILITY_OPTIONS, $jaklcoptions, '', 'yes');
		}

		public static function deactivate(){
			delete_option(jakwebLC_Settings::JAKWEBLC_WIDGET_ID_VARIABLE);
			delete_option(jakwebLC_Settings::JAKWEBLC_VISIBILITY_OPTIONS);
		}

		public function shortcode_print_embed_code(){
			add_action('wp_footer',  array($this, 'embed_code'), 100);
		}

		public function getCurrentCustomerDetails () {
			if(is_user_logged_in() ){
				$current_user = wp_get_current_user();
				$user_info = array(
					'name' => $current_user->display_name,
					'email' => $current_user->user_email
				);
				return $user_info;
			}
			return NULL;
		}

		public function embed_code()
		{
			$lc_embedid = get_option('jakweblc-embed-widget-id');

			// Available languages
			$local_lang = get_locale();
			$lc_set_lang = 'en';
			$jaklc_lang = array("de", "es", "fr", "cn", "dk", "el", "he", "hu", "it", "jp", "nl", "pl", "pt", "ru", "se", "tw");
			if (in_array($local_lang, $jaklc_lang)) {
				$lc_set_lang = $local_lang;
			}

   			$logged_in = $this->getCurrentCustomerDetails();
			
			if(!empty($lc_embedid))
			{
				include(sprintf("%s/templates/widget.php", dirname(__FILE__)));
			}
		}

		public function print_embed_code()
		{
			$lcoptions = get_option( 'jakweblc-lc-options' );
			
			$display = FALSE;

			if(($lcoptions['show_onfrontpage'] == 1) && (is_home() || is_front_page()) ){ $display = TRUE; }
			if(($lcoptions['show_oncategory'] == 1) && is_category() ){ $display = TRUE; }
			if(($lcoptions['show_ontagpage'] == 1) && is_tag() ){ $display = TRUE; }
			if($lcoptions['always_display'] == 1){ $display = TRUE; }
			if(($lcoptions['show_onarticlepages'] == 1) && is_single() ){ $display = TRUE; }

			if(($lcoptions['exclude_url'] == 1)){
				$excluded_url_list = $lcoptions['excluded_url_list'];

				$current_url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
				$current_url = urldecode($current_url);

				$ssl      = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' );
			    $sp       = strtolower( $_SERVER['SERVER_PROTOCOL'] );
			    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );

			    $current_url = $protocol.'://'.$current_url;
			    $current_url = strtolower($current_url);

				$excluded_url_list = explode(",", $excluded_url_list);
				foreach($excluded_url_list as $exclude_url)
				{
					$exclude_url = strtolower(urldecode(trim($exclude_url)));
					if(!empty($exclude_url))
					{
						if (strpos($current_url, $exclude_url) !== false) 
						{
							if(strcmp($current_url, $exclude_url) === 0)
							{
								$display = false;
							}
						}
					}
				}
			}

			if(isset($lcoptions['include_url']) && $lcoptions['include_url'] == 1){
				$included_url_list = $lcoptions['included_url_list'];
				$current_url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
				$current_url = urldecode($current_url);

				$ssl      = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' );
			    $sp       = strtolower( $_SERVER['SERVER_PROTOCOL'] );
			    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );

			    $current_url = $protocol.'://'.$current_url;
			    $current_url = strtolower($current_url);

				$included_url_list = explode(",", $included_url_list);
				foreach($included_url_list as $include_url)
				{
					$include_url = strtolower(urldecode(trim($include_url)));
					if(!empty($include_url))
					{
						if (strpos($current_url, $include_url) !== false) 
						{
							if(strcmp($current_url, $include_url) === 0)
							{
								$display = TRUE;
							}
						}
					}
				}
			}

			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
   			{
				if(($lcoptions['display_on_shop'] == 1) && is_shop() ){ $display = TRUE; }
				if(($lcoptions['display_on_productcategory'] == 1) && is_product_category() ){ $display = TRUE; }
				if(($lcoptions['display_on_productpage'] == 1) && is_product() ){ $display = TRUE; }
				if(($lcoptions['display_on_producttag'] == 1) && is_product_tag() ){ $display = TRUE; }
			}

			if($display == TRUE)
			{
				$this->embed_code();
			}
		}
	}
}

if(class_exists('JakwebLC')){
	register_activation_hook(__FILE__, array('JakwebLC', 'activate'));
	register_deactivation_hook(__FILE__, array('JakwebLC', 'deactivate'));

	$jakweblc3 = new JakwebLC();

	if(isset($jakweblc3)){

		function zipp_chat_settings_link($links){
			$settings_link = '<a href="options-general.php?page=zipp_chat">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}

		$plugin = plugin_basename(__FILE__);
		add_filter("plugin_action_links_$plugin", 'zipp_chat_settings_link');
	}

	add_action('wp_footer',  array($jakweblc3, 'print_embed_code'));
}
?>