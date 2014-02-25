<?php
/**
* Plugin Name: Commons Admin Bar
* Plugin URI: http://commons.hwdsb.on.ca
* Description: A customized version of the WP Admin bar
* Author: mrjarbenne
* Version: 1.0
* Author URI: https://mrjarbenne.ca
* License:
*/


add_action( 'plugins_loaded', array( 'HWDSB_Adminbar', 'init' ) );

/**
 * HWDSB Adminbar mods.
 */
class HWDSB_Adminbar {
	/**
	 * Static initializer.
	 */
	public static function init() {
		return new self;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'add_custom_parent_menu' ), 11 );
	}

	/**
	 * Adds custom "Home" menu to WP Adminbar.
	 *
	 * Also removes the "WP logo" menu.
	 */
	public function add_custom_parent_menu( $wp_admin_bar ) {

		/**
		 * Removing the "W" menu
		 */
		$wp_admin_bar->remove_menu( 'wp-logo' );

		/**
		 * Create a "Home" menu.
		 *
		 * First, just create the parent menu item.
		 */
		$wp_admin_bar->add_menu( array(
			'id' => 'commonlinks',
			'parent' => '0', //puts it on the left-hand side
			'title' => 'Home',
			'href' => ('http://commons.hwdsb.on.ca/')
		) );

		/**
		 * Add submenu items to "Home" menu.
		 */
		// Only show the following for logged-in users
		if ( current_user_can( 'read' ) ) {
			// Support link
			$wp_admin_bar->add_menu( array(
				'id' => 'support',
				'parent' => 'commonlinks',
				'title' => 'Support',
				'href' => ('http://support.commons.hwdsb.on.ca/')
			) );

			// Blog request form
			$wp_admin_bar->add_menu( array(
				'id' => 'blogrequest',
				'parent' => 'commonlinks',
				'title' => 'Blog Request Form',
				'href' => ('http://support.commons.hwdsb.on.ca/blog-request-form/' )
			) );

			// Developers blog
			$wp_admin_bar->add_menu( array(
				'id' => 'developments',
				'parent' => 'commonlinks',
				'title' => 'Developments',
				'href' => ('http://dev.commons.hwdsb.on.ca/' )
			) );

		}

	}

}