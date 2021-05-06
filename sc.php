<?php
/**
 * Plugin Name: OS System Configuration
 * Description: Adds a custom admin pages with sample styles and scripts.
 * Plugin URI: http://#
 * Author: Author
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: text-domain
 * Domain Path: domain/path
 */

/*
    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('SC') ) :

/**
 * SC
 */
class SC
{

	/** @var string The plugin version number. */
	var $version = '1.0.0';
	
	/** @var array The plugin settings array. */
	var $settings = array();
	
	/** @var array The plugin data array. */
	var $data = array();
	
	/** @var array Storage for class instances. */
	var $instances = array();
	
	/**
	 * __construct
	 *
	 * A dummy constructor to ensure SC is only setup once.
	 *
	 * @date	28/04/2021
	 * @since	1.0.0
	 *
	 * @param	void
	 * @return	void
	 */	
	function __construct() {
		// Do nothing.
	}
	
	/**
	 * initialize
	 *
	 * Sets up the SC plugin.
	 *
	 * @date	28/04/2021
	 * @since	1.0.0
	 *
	 * @param	void
	 * @return	void
	 */
	function initialize() {
		
		// Define constants.
		$this->define( 'SC', true );
		$this->define( 'SC_DOMAIN', 'system-configuration' );
		$this->define( 'SC_ICON', plugins_url('assets/images/sc.png', __FILE__ ) );
		$this->define( 'SC_PATH', plugin_dir_path( __FILE__ ) );
		$this->define( 'SC_BASENAME', plugin_basename( __FILE__ ) );
		$this->define( 'SC_VERSION', $this->version );
		$this->define( 'SC_FILE_MANAGER_PATH', plugin_dir_path(__FILE__));

		// Include utility functions.
		include_once( SC_PATH . 'shortcode.php');
		include_once( SC_PATH . 'widget.php');

		add_action( 'admin_menu', array($this, 'sc_admin_menu'), 5 );
		add_action( 'admin_enqueue_scripts', array($this, 'sc_admin_things'), 10 );

		// Register Theme opations fields
		register_setting('sc_replace_urls_misc', 'sc_replace_urls_misc');

		register_setting( 'sc-system-configuration-group', 'home' );
		register_setting( 'sc-system-configuration-group', 'siteurl' );
		register_setting( 'sc-system-configuration-group', 'api_url' );
		register_setting( 'sc-system-configuration-group', 'login' );
		register_setting( 'sc-system-configuration-group', 'signup' );
	}

	/* Admin  Things */
	function sc_admin_things()
	{
		wp_enqueue_script( 'sc-widget-script',	plugins_url('assets/js/widget-script.js', __FILE__), array('jquery'), 1.0, true );
		wp_enqueue_style ( 'sc-styles', 		plugins_url('assets/css/styles.css', __FILE__ ));
	}


	/**
	 * sc_admin_menu
	 *
	 * This function responsible to add menus and pages at sidebar.
	 *
	 * @date	28/04/2021
	 * @since	1.0.0
	 *
	 * @param	void
	 * @return	void
	 */

	function sc_admin_menu() 
	{
		if (is_admin())
		{	// admin actions
			add_menu_page('OS Setting', 'OS Setting', 'manage_options', 'os-setting', array($this, 'sc_admin_page_contents'), SC_ICON, 3);
			//add_menu_page    ( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null );
			//add_submenu_page('system-configuration', 'Configuration', 'Configuration', 'manage_options', 'configuration', array($this, 'sc_admin_page_contents'));
			add_submenu_page('os-setting', 'Replace URLs', 'Replace URLs', 'manage_options', 'replace-urls', array($this, 'sc_admin_page_replace_urls'));
		}
		else
		{
			// non-admin enqueues, actions, and filters
		}
	}

	function sc_admin_page_contents() 
	{
		include_once( SC_PATH . 'form.php');
	}
	function sc_admin_page_replace_urls() 
	{
		include_once( SC_PATH . 'replace-urls.php');
	}
	
	/**
	 * init
	 *
	 * Completes the setup process on "init" of earlier.
	 *
	 * @date	28/04/2021
	 * @since	1.0.0
	 *
	 * @param	void
	 * @return	void
	 */
	function init() {
				
	}

	/**
	 * define
	 *
	 * Defines a constant if doesnt already exist.
	 *
	 * @date	28/04/2021
	 * @since	1.0.0
	 *
	 * @param	string $name The constant name.
	 * @param	mixed $value The constant value.
	 * @return	void
	 */
	function define( $name, $value = true ) {
		if( !defined($name) ) 
		{
			define( $name, $value );
		}
	}

}

endif;

/*
 * SC
 *
 * The main function responsible for returning the one true acf Instance to functions everywhere.
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php $sc = sc(); ?>
 *
 * @date	28/04/2021
 * @since	1.0.0
 *
 * @param	void
 * @return	SC
 */
function sc() {
	global $sc;
	
	// Instantiate only once.
	if( !isset($sc) ) {
		$sc = new SC();
		$sc->initialize();
	}
	return $sc;
}
// Instantiate.
sc();


