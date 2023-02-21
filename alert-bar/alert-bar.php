<?php
/**
 * Plugin Name: Alert Bar
 * Description: Displays an alert banner on your page that can be dismissed.
 * Version: 1.0.0
 * Author: April Marshall
 * Author URI: http://www.aprilagain.com
 */

require_once albar_dir("lib/class-alert-bar.php");

# Admin routines
if(is_admin()){
	# define sections and fields for options page
	add_action('admin_init', array('Alert_Bar_Options', 'register_settings'));

	# styles and scripts
	add_action('admin_enqueue_scripts', array('Alert_Bar','admin_enqueue'));

	# plugin options page
	add_action('admin_menu', 'albar_settings_page');
	function albar_settings_page() {
		add_options_page('Alert Bar', 'Alert Bar', 'manage_options', 'albar_settings', array('Alert_Bar_Options','settings_page'));
	}

	# Action links on main Plugins screen
	$plugin = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin", 'albar_plugin_actions' );
	function albar_plugin_actions($links){
		$settings_link = '<a href="options-general.php?page=albar_settings">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
} #end: admin routines

# Front end routines
else{
	# Default message
	add_action( 'wp', array( 'Alert_Bar','default_message' ) );

	# Shortcodes
	## alert
	add_shortcode( 'albar_alert', array('Alert_Bar', 'do_alert' ) );

} # end: front end routines
#end main routine

###
# Helper functions
###
# paths
function albar_url($s){ return plugins_url($s, __FILE__); }
function albar_dir($s){ return plugin_dir_path(__FILE__) . $s; }
