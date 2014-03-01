<?php
/**
 * build useful admin toolbar links and info
 *
 * @since 1.0.0
 */
class TST_Toolbar {

		
	/**
	 * Constructor for TST_Toolbar
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// hack into the admin toolbar
		add_action( 'admin_bar_menu', array( $this, 'tst_toolbar' ), 999 );
	}
	
	
	/**
	 * add links and info to admin toolbar
	 *
	 * @param $wp_admin_bar
	 * @since 1.0.0
	 */
	public function tst_toolbar( $wp_admin_bar ) {

		/**
		 * There's no need to show the link from the WordPress dashboard. Also, don't 
		 * show it if the user doesn't have permission to access the Plugins screen.
		 */
		if ( is_admin() || ! current_user_can( 'activate_plugins' ) ) {
			return;
		} else {
			// plugins screen
			$wp_admin_bar->add_node( array(
				'parent' => 'site-name',
				'id'     => 'plugins',
				'title'  => __( 'Plugins', 'tst' ),
				'href'   => admin_url( 'plugins.php' ) 
			) );
		}
		
		/**
		 * There's no need to show the link from the WordPress dashboard. Also, don't 
		 * show it if the user doesn't have permission to access the Tools screen.
		 */
		if ( is_admin() || ! current_user_can( 'import' ) ) {
			return;
		} else {
			// import content screen
			$wp_admin_bar->add_node( array(
				'parent' => 'site-name',
				'id'     => 'import-content',
				'title'  => __( 'Import Content', 'tst' ),
				'href'   => admin_url( 'import.php' ) 
			) );
			// regenerate thumbnails screen *if the plugin is activated*
			if ( class_exists( 'RegenerateThumbnails' ) ) {
				$wp_admin_bar->add_node( array(
					'parent' => 'site-name',
					'id'     => 'regen-thumbs',
					'title'  => __( 'Regenerate Thumbs', 'tst' ),
					'href'   => admin_url( 'tools.php?page=regenerate-thumbnails' ) 
				) );
			}
		}
	}
}
new TST_Toolbar();