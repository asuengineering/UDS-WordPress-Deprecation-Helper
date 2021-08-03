<?php
/**
 * Fired during plugin activation
 *
 * @link       https://engineering.asu.edu
 * @since      0.1
 *
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @todo This should probably be in one class together with Deactivator Class.
 * @since      0.1
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 * @author     Your Name <steve.ryan@asu.edu>
 */
class Uds_Wp_Depreciation_Helper_Activator {

	/**
	 * The $_REQUEST during plugin activation.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      array    $request    The $_REQUEST array during plugin activation.
	 */
	private static $request = array();

	/**
	 * The $_REQUEST['plugin'] during plugin activation.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin    The $_REQUEST['plugin'] value during plugin activation.
	 */
	private static $plugin  = 'uds-wp-depreciation-helper/uds-wp-depreciation-helper.php';

	/**
	 * The $_REQUEST['action'] during plugin activation.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      array    $action    The $_REQUEST[action] value during plugin activation.
	 */
	private static $action  = 'activate';

	/**
	 * Activate the plugin.
	 *
	 * Checks if the plugin was (safely) activated.
	 * Place to add any custom action during plugin activation.
	 *
	 * @since    0.1
	 */
	public static function activate() {

		if ( false === self::get_request()
			|| false === self::validate_request( self::$plugin, self::$action )
			|| false === self::check_caps()
			|| ! check_admin_referer( 'activate-plugin_' . self::$request['plugin'] )
		) {

			exit;

		}

		/**
		 * The plugin is now safely activated.
		 * Perform your activation actions here.
		 */

	}

	/**
	 * Get the request.
	 *
	 * Gets the $_REQUEST array and checks if necessary keys are set.
	 * Populates self::request with necessary and sanitized values.
	 *
	 * @since    0.1
	 * @return bool|array false or self::$request array.
	 */
	private static function get_request() {

		if ( ! empty( $_REQUEST )
			&& isset( $_REQUEST['_wpnonce'] )
			&& isset( $_REQUEST['plugin'] )
			&& isset( $_REQUEST['action'] )
			&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'activate-plugin_' . sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) )
		) {

			self::$request['plugin'] = sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) );
			self::$request['action'] = sanitize_text_field( wp_unslash( $_REQUEST['action'] ) );

			return self::$request;

		} else {

			return false;
		}

	}

	/**
	 * Validate the Request data.
	 *
	 * Validates the $_REQUESTed data is matching this plugin and action.
	 *
	 * @since    0.1
	 * @param string $plugin The Plugin folder/name.php.
	 * @param string $action The action we expect.
	 * @return bool false if either plugin or action does not match, else true.
	 */
	private static function validate_request( $plugin, $action ) {

		if ( $plugin === self::$request['plugin']
			&& $action === self::$request['action']
		) {

			return true;

		}

		return false;

	}

	/**
	 * Check Capabilities.
	 *
	 * We want no one else but users with activate_plugins or above to be able to active this plugin.
	 *
	 * @since    0.1
	 * @return bool false if no caps, else true.
	 */
	private static function check_caps() {

		if ( current_user_can( 'activate_plugins' ) ) {
			return true;
		}

		return false;

	}

}

