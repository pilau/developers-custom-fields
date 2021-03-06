<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://sltaylor.co.uk
 * @since             1.0.0
 * @package           Pilau_DCF
 *
 * @wordpress-plugin
 * Plugin Name:       Pilau Developer's Custom Fields
 * Plugin URI:        https://github.com/pilau/developers-custom-fields
 * Description:       Provides developers with powerful and flexible tools for managing post and user custom fields.
 * Version:           1.0.0
 * Author:            Steve Taylor
 * Author URI:        http://sltaylor.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pilau-dcf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The file path for the main plugin file
 *
 * This is used for the in_plugin_update_message-{$file} hook
 *
 * @since	1.0.0
 */
define( 'PDCF_PRIMARY_FILE_PATH', plugin_basename( __FILE__ ) );


register_activation_hook( __FILE__, 'activate_pilau_dcf' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pilau-dcf-activator.php
 */
function activate_pilau_dcf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pilau-dcf-activator.php';
	Pilau_DCF_Activator::activate();
}

register_deactivation_hook( __FILE__, 'deactivate_pilau_dcf' );
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pilau-dcf-deactivator.php
 */
function deactivate_pilau_dcf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pilau-dcf-deactivator.php';
	Pilau_DCF_Deactivator::deactivate();
}


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pilau-dcf.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pilau_dcf() {

	$plugin = new Pilau_DCF();
	$plugin->run();

}
run_pilau_dcf();
