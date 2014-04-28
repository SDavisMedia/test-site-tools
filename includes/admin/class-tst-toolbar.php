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
		 * only show link if on the front-end and user can activate plugins
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
		 * only show links if on the front-end and user can acces Tools menu
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
			
	
			/**
			 * show "Move to Trash" link if user has the capability and is on post/page
			 */
			$current_object = get_queried_object();
			if ( ! is_super_admin() || ! is_admin_bar_showing() || empty( $current_object ) ) {
				return;
			} elseif ( ! empty( $current_object->post_type ) && ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && current_user_can( $post_type_object->cap->edit_post, $current_object->ID ) ) { 
				$wp_admin_bar->add_menu( array( 
					'id'	=> 'delete',
					'title'	=> __( 'Move to Trash', 'tst' ),
					'href'	=> get_delete_post_link( $current_object->term_id )
				) );
			}
		}
	}
}
new TST_Toolbar();