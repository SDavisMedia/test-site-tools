<?php
/*
 * Plugin Name: Test Site Tools
 * Plugin URI: http://buildwpyourself.com/downloads/test-site-tools/
 * Description: A simple WordPress plugin that makes it easier to manage test/demo sites - this plugin will slowly develop over time based on personal experiences with managing test/demo sites.
 * Version: 1.0.0
 * Author: Sean Davis
 * Author URI: http://seandavis.co
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 3.8
 * Text Domain: tst
 * Domain Path: /inc/languages/
 * 
 * This plugin is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see http://www.gnu.org/licenses/.
 *
 * @package Test Site Tools
 * @category Core
 */


// No accessing this file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * main plugin class
 *
 * This class sets up the rest of the plugin by requiring the necessary
 * files, defining constants, and other important stuff.
 *
 * @since 1.0.0
 */
class TST_Test_Site_Tools {

		
	/**
	 * constructor for TST_Test_Site_Tools 
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// define plugin name
		define( 'TST_NAME', __( 'Test Site Tools', 'tst' ) );
		
		// define plugin version
		define( 'TST_VERSION', '1.0.0' );
		
		// define plugin directory
		define( 'TST_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		
		// define plugin root file
		define( 'TST_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// load text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );
		
		// require additional plugin files
		$this->includes();
	}
	

	/**
	 * load TST textdomain
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'tst', false, TST_DIR . "inc/languages" );
	}
	
	
	/**
	 * require additional plugin files
	 *
	 * @since 1.0.0
	 */
	private function includes() {
		require_once( TST_DIR . 'inc/admin/class-tst-toolbar.php' );	// admin toolbar
	}
}
new TST_Test_Site_Tools();