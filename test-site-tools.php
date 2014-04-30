<?php
/*
 * Plugin Name: Test Site Tools
 * Plugin URI: http://buildwpyourself.com/downloads/test-site-tools/
 * Description: A simple WordPress plugin that makes it easier to manage test/demo sites - this plugin will slowly develop over time based on personal experiences with managing test/demo sites.
 * Version: 1.0.1
 * Author: Sean Davis
 * Author URI: http://seandavis.co
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 3.9
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
if ( ! defined( 'ABSPATH' ) ) exit; // No accessing this file directly

// checking for other plugins
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * main plugin class
 *
 * This class sets up the rest of the plugin by requiring the necessary
 * files, defining constants, and other important stuff.
 */
class TST_Test_Site_Tools {

		
	/**
	 * constructor for TST_Test_Site_Tools 
	 */
	public function __construct() {
		
		// define plugin name
		define( 'TST_NAME', 'Test Site Tools', 'tst' );
		
		// define plugin version
		define( 'TST_VERSION', '1.0.1' );
		
		// define plugin directory
		define( 'TST_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		
		// define plugin root file
		define( 'TST_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// load text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );
		
		// load the CSS for See More Themes if the actual plugin is not activated
		$see_more_themes = is_plugin_active( 'see-more-themes/see-more-themes.php' ) ? true : false;
		if ( false === $see_more_themes ) :
			add_action( 'admin_enqueue_scripts', array( $this, 'tst_see_more_themes_styles' ), 10, 2 );
		endif;
		
		// require additional plugin files
		$this->includes();
	}
	

	/**
	 * load TST textdomain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'tst', false, TST_DIR . "languages" );
	}
	
	
	/**
	 * require additional plugin files
	 */
	private function includes() {
		require_once( TST_DIR . 'includes/admin/class-tst-toolbar.php' );	// admin toolbar
	}
	
	/**
	 * grab the stylesheet that applies to the themes page
	 */
	public function tst_see_more_themes_styles( $hook ) {
		if ( 'themes.php' == $hook || 'theme-install.php' == $hook ) {
			wp_enqueue_style( 'tst-see-more-themes-css', TST_URL . 'assets/css/see-more-themes.css' );
		}
	}
}
new TST_Test_Site_Tools();