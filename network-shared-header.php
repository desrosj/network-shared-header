<?php
/**
Plugin Name: Network Shared Header
Plugin URI: http://wordpress.org/extend/plugins/toggle-wpautop
Description: Allows any site on a multisite install to have access to a specific site's header markup.
Version: 1.0
Author: Linchpin
Author URI: http://linchpin.agency/wordpress-plugins/
License: GPLv2
*/
class Network_Shared_Header {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'network_shared_header_generate', array( $this, 'network_shared_header_generate' ) );
	}

	/**
	 * admin_init function.
	 *
	 * @access public
	 * @return void
	 */
	function admin_init() {
		// If a filter is added to nsh_blog_id, it is possible
		if ( get_current_blog_id() != apply_filters( 'nsh_blog_id', 1 ) ) {
			if ( wp_next_scheduled( 'network_shared_header_generate' ) ) {
				wp_clear_scheduled_hook( 'network_shared_header_generate' );
			}
		}

		if ( ! wp_next_scheduled( 'network_shared_header_generate' ) ) {
			wp_schedule_event( time() + 60, apply_filters( 'nsh_refresh_frequency', 'twicedaily' ), 'network_shared_header_generate' );
		}
	}

	/**
	 * Generate the header output and cache it in options.
	 *
	 * @access public
	 * @return void
	 */
	function network_shared_header_generate() {
		if ( get_current_blog_id() != apply_filters( 'nsh_blog_id', 1 ) ) {
			return;
		}

		if ( ! locate_template( 'header-network.php' ) ) {
			return;
		}

		ob_start();

		get_header( 'network' );

		$header = ob_get_clean();

		update_site_option( 'network_shared_header', $header );
	}
}
$shared_network_header = new Network_Shared_Header();

/**
 * Returns the network shared header.
 *
 * @return mixed|string|void
 */
function get_network_shared_header() {
	$header = get_site_option( 'network_shared_header', '' );

	return $header;
}

/**
 * Echos the network shared header.
 */
function the_network_shared_header() {
	echo get_network_shared_header();
}