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
		add_filter( 'allowed_redirect_hosts', array( $this, 'whitelist_subdomains' ),   10, 2 );
		add_action( 'admin_bar_menu',         array( $this, 'add_custom_parent_menu' ), 11 );
		add_action( 'admin_bar_menu',         array( $this, 'add_random_site' ),        5 );
		add_action( 'wp_head',                array( $this, 'add_random_site_css' ),    999 );
	}

	/**
	 * Whitelists HWDSB subdomains so users are able to be redirected to them.
	 *
	 * By default, only the root domain is whitelisted to be redirected.  However,
	 * we want subdomains from HWDSB to be recognized and redirected as well.
	 *
	 * @param array $retval By default, only the root domain is whitelisted
	 * @param string $subdomain The subdomain being tested for redirection.
	 * @return array
	 */
	public function whitelist_subdomains( $retval, $subdomain ) {
		if ( strpos( $subdomain, 'hwdsb.on.ca' ) !== false ) {
			$retval[] = $subdomain;
		}

		return $retval;
	}

	/**
	 * Adds custom "Home" menu to WP Adminbar.
	 *
	 * Also removes the "WP logo" menu.
	 *
	 * @param object $wp_admin_bar The WP Admin Bar object
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

	/**
	 * Inserts a "Random Site" icon in the top-right corner of the WP Admin Bar.
	 *
	 * @param object $wp_admin_bar The WP Admin Bar object
	 */
	public function add_random_site( $wp_admin_bar ) {
		if ( is_admin() ) {
			return;
		}

		if ( ! function_exists( 'bp_is_active' ) ) {
			return;
		}

		if ( ! is_multisite() && ! bp_is_active( 'blogs' ) ) {
			return;
		}

		$title = '<span class="ab-icon"></span>';

		$wp_admin_bar->add_node( array(
			'parent' => 'top-secondary',
			'id'     => 'random-site',
			'title'  => $title,
			'href'   => bp_get_blogs_directory_permalink() . '?random-blog',
			'meta'  => array(
				'title' => __( 'Random Site', 'hwdsb' ),
				'rel'   => 'nofollow',
			)
		) );

	}

	/**
	 * Inline CSS for the "Random Site" dashicon for the WP adminbar menu item.
	 */
	public function add_random_site_css() {
		if ( ! function_exists( 'bp_is_active' ) ) {
			return;
		}

		if ( ! is_multisite() && ! bp_is_active( 'blogs' ) ) {
			return;
		}

	?>

		<style type="text/css">
			#wpadminbar #wp-admin-bar-random-site > .ab-item:before {
			    content: "\f463";
			    top: 2px;
			    width: 8px;
			}

			@media screen and ( max-width: 782px ) {
				#wpadminbar #wp-admin-bar-random-site a.ab-item {
					text-overflow: clip;
				}

				#wpadminbar #wp-admin-bar-random-site > .ab-item {
					text-indent: 100%;
					white-space: nowrap;
					overflow: hidden;
					width: 52px;
					padding: 0;
					color: #999;
					position: relative;
				}

				#wpadminbar #wp-admin-bar-random-site > .ab-item:before {
					display: block;
					text-indent: 0;
					font: normal 32px/1 'dashicons';
					speak: none;
					top: 7px;
					width: 52px;
					text-align: center;
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
				}

				#wpadminbar li#wp-admin-bar-random-site {
					display: block;
				}
			}
		</style>

	<?php
	}

}