<?php
/**
 * Plugin Name: Custom Team Manager
 * Plugin URI: http://webspiderbd.com
 * Description: A custom plugin to manage your team members. Shortcode enabled. Responsive Layout. Easy to use. Just need to install/activate this plugin and add team members through Management Team menu on Dashboard.
 * Version: 2.1.1
 * Author: webspiderbd team
 * Author URI: http://webspiderbd.com
 */

require_once(dirname(__FILE__) . '/inc/functions.php');
require_once(dirname(__FILE__) . '/inc/shortcodes.php');

// register style on initialization
add_action('init', 'register_style');
function register_style() {
    wp_register_style( 'stylesheet', plugins_url('/css/stylesheet.css', __FILE__), false, '2.1.1', 'all');
}

// use the registered style above
add_action('wp_enqueue_scripts', 'enqueue_style');
function enqueue_style(){
   wp_enqueue_style( 'stylesheet' );
}

// register admin-style on initialization

function cmt_wp_admin_style() {
        wp_register_style( 'cmt_admin_css', plugins_url('/css/admin-style.css', __File__), false, '2.1.1', 'all' );
        wp_enqueue_style( 'cmt_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'cmt_wp_admin_style' );


/* Runs when plugin is activated */
register_activation_hook(__FILE__,'cmt_install'); 
register_deactivation_hook(__FILE__, 'cmt_uninstall');

function cmt_uninstall() {
	
}
	
function cmt_install() {

	// check if there is a page with same name
	function get_page_by_name($pagename){
		$pages = get_pages();
		foreach ($pages as $page) if ($page->post_name == $pagename) return $page;
			return false;
	}

	$page = get_page_by_name('team-members');
	// if there is no page with same name, then create one
	if (empty($page)) {
		$members_page = array(
		'post_type' => 'page',
		'post_name' => 'team-members',
		'post_title' => 'Team Members',
		'post_status' => 'publish',
		'post_content'	=>	'[team-members]' 
		);

		wp_insert_post($members_page);

	}
	
	$page = get_page_by_name('team-members-profile');
	// if there is no page with same name, then create one
	if (empty($page)) {
		$members_profile_page = array(
		'post_type' => 'page',
		'post_name' => 'team-members-profile',
		'post_title' => 'Team Members Profile',
		'post_status' => 'publish',
		'post_content'	=>	'[team-members-profile]' 
		);
		wp_insert_post($members_profile_page);

	}

}


?>