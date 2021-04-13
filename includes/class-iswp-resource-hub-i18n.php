<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       jmlunalopez.com/wordpress-plugins
 * @since      1.0.0
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/includes
 * @author     Juan M. Luna <lunalopezjm@gmail.com>
 */
class Iswp_Resource_Hub_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iswp-resource-hub',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
