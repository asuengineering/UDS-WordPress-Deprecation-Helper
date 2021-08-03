<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://engineering.asu.edu
 * @since      0.1
 *
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @todo Justify why we need this or remove it. AFAIK nothing can be done with textdomains else than loading it.
 *       This, if true, makes this class a total waste of code.
 *
 * @since      0.1
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 * @author     Your Name <steve.ryan@asu.edu>
 */
class Uds_Wp_Depreciation_Helper_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'uds-wp-depreciation-helper',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
