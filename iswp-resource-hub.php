<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              jmlunalopez.com/wordpress-plugins
 * @since             1.0.0
 * @package           Iswp_Resource_Hub
 *
 * @wordpress-plugin
 * Plugin Name:       ISWP Resource Hub
 * Plugin URI:        jmlunalopez.com/wordpress-plugins
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Juan M. Luna
 * Author URI:        jmlunalopez.com/wordpress-plugins
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iswp-resource-hub
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ISWP_RESOURCE_HUB_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iswp-resource-hub-activator.php
 */
function activate_iswp_resource_hub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iswp-resource-hub-activator.php';
	Iswp_Resource_Hub_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iswp-resource-hub-deactivator.php
 */
function deactivate_iswp_resource_hub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iswp-resource-hub-deactivator.php';
	Iswp_Resource_Hub_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iswp_resource_hub' );
register_deactivation_hook( __FILE__, 'deactivate_iswp_resource_hub' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iswp-resource-hub.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iswp_resource_hub() {

	$plugin = new Iswp_Resource_Hub();
	$plugin->run();

}
run_iswp_resource_hub();
