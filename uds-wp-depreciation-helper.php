<?php
/**
 * Plugin Name:       UDS-WordPress Deprecation Helper
 * Plugin URI:        https://github.com/asuengineering/UDS-WordPress-Deprecation-Helper
 * Description:       A plugin to run along side of the UDS-WordPress theme for ASU. Contains deprecated blocks and other theme pieces. Use as a crutch until production sites can be remediated.
 * Author:            Steve Ryan
 * Author URI:        https://engineering.asu.edu/
 * Text Domain:       uds-wp-depreciation-helper
 * Domain Path:       /languages
 * 
 * GitHub Plugin URI: https://github.com/asuengineering/UDS-WordPress-Deprecation-Helper
 * Version:           0.1.1
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UDS_WP_DEPRECIATION_HELPER_VERSION', '0.1' );

/**
 * The code that runs during plugin activation.
 *
 * This action is documented in includes/class-uds-wp-depreciation-helper-activator.php
 * Full security checks are performed inside the class.
 */
function plugin_name_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uds-wp-depreciation-helper-activator.php';
	Uds_Wp_Depreciation_Helper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * This action is documented in includes/class-uds-wp-depreciation-helper-deactivator.php
 * Full security checks are performed inside the class.
 */
function plugin_name_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uds-wp-depreciation-helper-deactivator.php';
	Uds_Wp_Depreciation_Helper_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'plugin_name_activate' );
register_deactivation_hook( __FILE__, 'plugin_name_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-uds-wp-depreciation-helper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Generally you will want to hook this function, instead of callign it globally.
 * However since the purpose of your plugin is not known until you write it, we include the function globally.
 *
 * @since    0.1
 */
function plugin_name_run() {

	$plugin = new Uds_Wp_Depreciation_Helper();
	$plugin->run();

}
plugin_name_run();
