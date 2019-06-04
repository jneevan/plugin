<?php
/*
	Plugin Name: Add Gallery
	Description: Add, Edit, Delete galleries
	Version: 1.0
	Author: Neevan
	
*/

#Activation of the plugin (Creating a table in the database)
function gallery_install()
{
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	if($wpdb->get_var("SHOW TABLES LIKE $galleryplug") != $galleryplug){
		$cr_galleryplug = "CREATE TABLE IF NOT EXISTS $galleryplug(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(100)  NOT NULL,
					`desc` varchar(200) NOT NULL,
					`img1` varchar(255) NOT NULL,
					`img2` varchar(255) NOT NULL,
					`img3` varchar(255) NOT NULL,
					`shortcode` varchar(255) NOT NULL,
					PRIMARY KEY(`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

		$wpdb->query($cr_galleryplug);
	}
	add_option('gallery_on_page');
}
register_activation_hook(__FILE__, 'gallery_install');

#Deactivating a plugin (Removing a table from the database)
function gallery_uninstall()
{
	global $wpdb;
	$galleryplug = $wpdb->prefix . 'gallery';
	$dr_gallery = "DROP TABLE IF EXISTS $galleryplug;";
	$wpdb->query($dr_gallery);
	delete_option('gallery_on_page');
}
register_deactivation_hook(__FILE__, 'gallery_uninstall');

#Determination of the desired'action'
function gallery_editor()
{
	switch ($_GET['c']) {
		case 'add':
			$action = 'add';
			break;
		case 'edit':
			$action = 'edit';
			break;
		default:
			$action = 'all';
			break;
	}
	include_once "includes/$action.php";
}

#Create shortcode
function gallery_short($atts, $content = null){
	extract(shortcode_atts(array(
	'id' => ''
	), $atts));
	ob_start();
	include_once 'includes/added.php';
	return ob_get_clean();
}
add_filter('widget_text', 'do_shortcode');
add_shortcode('ac_gallery', 'gallery_short');

#Generate menu item ' Gallery'
function gallery_admin_menu()
{
	$page_suffix = add_menu_page(' Gallery', ' Gallery', 8, 'gallery', 'gallery_editor', 'http://findicons.com/files/icons/2360/spirit20/20/table_edit.png');
	add_action( 'admin_print_styles-' . $page_suffix, 'admin_styles' );
}

#Connecting styles in admin
add_action( 'admin_init', 'reg_admin_style' );
add_action( 'admin_menu', 'gallery_admin_menu' );
 
function reg_admin_style() {
	wp_register_style( 'bootstrap', plugins_url('/css/bootstrap.min.css', __FILE__) );
	wp_register_style( 'lightbox', plugins_url('/css/lightbox.css', __FILE__) );
	wp_register_style( 'style', plugins_url('/css/style.css', __FILE__) );
}
 
function admin_styles() {
	wp_enqueue_style( 'style' );
	wp_enqueue_style( 'bootstrap' );
}

#Connecting styles and scripts on the client side
add_action( 'admin_init', 'reg_wp_style' );

function reg_wp_style() {
	wp_register_script('lightbox-js', plugins_url('/js/lightbox.js', __FILE__), array('jquery'), '1.0', true );
	wp_register_style( 'lightbox', plugins_url('/css/lightbox.css', __FILE__) );
	wp_register_style( 'style', plugins_url('/css/style.css', __FILE__) );
	
	wp_enqueue_script('lightbox-js');
	wp_enqueue_style( 'lightbox' );
	wp_enqueue_style( 'style' );
}
add_action('wp_enqueue_scripts', 'reg_wp_style');