<?php
if ( ! defined('ABSPATH') ) exit;

/*
* Master Class Admin
*/
class Wbgi_Admin
{
	//use Wbgp_Common;
	
	/*
	* Function for loading pagination assets file
	*/
	function wbgi_enqueue_assets() {
		
		wp_enqueue_script(
			'wbgi-admin',
			WBGI_ASSETS . 'js/wbgi-admin.js',
			['jquery'],
			WBGI_VERSION,
			TRUE
		);
	}
	

	function wbgi_create_tools_submenu() {
		add_management_page( 
			__('WBG Books Import', WBGI_TXT_DOMAIN),
			__('WBG Books Import', WBGI_TXT_DOMAIN),
			'manage_options', 
			'wbg-books-import',
			array( $this, 'wbgi_generate_import_page_content' ),
		);
	}

	function wbgi_generate_import_page_content() {

		require_once WBGI_PATH . 'admin/book-import-page.php';
	}

	protected function wbgi_display_notification( $type, $msg ) { 
		?>
		<div class="wbg-alert <?php esc_attr_e( $type ); ?>">
			<span class="wbg-closebtn">&times;</span> 
			<strong><?php esc_html_e( ucfirst( $type ), WBGI_TXT_DOMAIN ); ?>!</strong> <?php esc_html_e($msg, WBGI_TXT_DOMAIN); ?>
		</div>
		<?php 
	}
}