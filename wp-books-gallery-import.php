<?php
/**
 * Plugin Name:			WP Books Gallery Import
 * Plugin URI:			https://github.com/GitMubarak/wp-books-gallery-import
 * Description:			This is an extension WP Books Gallery Plugin which allows user to import books
 * Version:				1.2
 * Author:				HM Plugin
 * Author URI:			https://hmplugin.com
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * Tested up to:        6.2.2
 * Text Domain:         wp-books-gallery-import
 * Domain Path:         /languages/
 * License:				GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
if ( ! defined('ABSPATH') ) exit;

define( 'WBGI_PATH', plugin_dir_path( __FILE__ ) );
define( 'WBGI_ASSETS', plugins_url('/assets/', __FILE__) );
define( 'WBGI_SLUG', plugin_basename( __FILE__ ) );
define( 'WBGI_PRFX', 'wbgi_' );
define( 'WBGI_CLS_PRFX', 'cls-wbgi-' );
define( 'WBGI_TXT_DOMAIN', 'wp-books-gallery-import' );
define( 'WBGI_VERSION', '1.2' );

// post_exists() doesn't work on admin end.
// So need to include this.
// Otherwise fatal error;
if ( ! function_exists( 'post_exists' ) ) {
	
	require_once( ABSPATH . 'wp-admin/includes/post.php' );
}

class Wbgi
{
	
	function __construct() {
		add_action( 'plugins_loaded', [$this, 'wbgi_extension_initialize'] );
	}
	
	function wbgi_extension_initialize() {
		
		if ( class_exists( 'WBG_Master' ) ) {
			
			$this->wbgi_load_dependencies();
			$this->wbgi_trigger_admin_hooks();
		}
	}
	
	private function wbgi_load_dependencies() {
		
		//require_once WBGP_PATH . 'inc/' . WBGP_CLS_PRFX . 'common.php';
		require_once WBGI_PATH . 'admin/' . WBGI_CLS_PRFX . 'admin.php';
	}
	
	private function wbgi_trigger_admin_hooks() {
		
		$wbgi_admin = new Wbgi_Admin();
		add_action( 'admin_enqueue_scripts', [$wbgi_admin, 'wbgi_enqueue_assets'] );
		add_action( 'admin_menu', [$wbgi_admin, 'wbgi_create_tools_submenu'] );
	}
}

new Wbgi();

//add_action( 'plugins_loaded', array( $this, 'wbg_load_plugin_textdomain' ) );
//add_action('init', 'wbg_load_plugin_textdomain', 999 );

function wbg_load_plugin_textdomain() {
	
	$post_arr = array(
		'post_type'		=> 'books',
		'post_title'   	=> 'Book Title-2',
		'post_content' 	=> 'Book-2 content',
		'post_status'  	=> 'publish',
		'post_author'  	=> get_current_user_id(),
		'meta_input'   => array(
			'wbg_status' 		=> 'active',
			'wbg_author' 		=> 'Hossni Mubarak',
			'wbg_publisher'		=> 'Hasan Book House',
			'wbg_published_on' 	=> date('Y-m-d'),
			'wbg_isbn'			=>	'1234567890',
			'wbg_pages'			=> '360',
			'wbg_country'		=> 'Bangladesh',
			'wbg_language'		=> 'Bangla',
			'wbg_dimension'		=> '6/10 inch',
			'wbg_filesize'		=> '1mb',
			'wbg_download_link' => 'https://hmplugin.com',
		),
	);
	
	$post_exists = post_exists( 'Book Title-2', '', '', 'books');
	
	if ( ! $post_exists ) {
		
		$post_id = wp_insert_post( $post_arr, $wp_error );
		
		if ( !is_wp_error( $post_id ) ) {
			wp_set_object_terms( $post_id, array('Test Category'), 'book_category' );
		} else {
			//there was an error in the post insertion, 
			echo $post_id->get_error_message();
		}
		
	}
};