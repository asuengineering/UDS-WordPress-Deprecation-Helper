<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://engineering.asu.edu
 * @since      0.1
 *
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/includes
 * @author     Your Name <steve.ryan@asu.edu>
 */
class Uds_Wp_Depreciation_Helper {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      Uds_Wp_Depreciation_Helper_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	protected $plugin_prefix;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function __construct() {

		if ( defined( 'UDS_WP_DEPRECIATION_HELPER_VERSION' ) ) {

			$this->version = UDS_WP_DEPRECIATION_HELPER_VERSION;

		} else {

			$this->version = '0.1';

		}

		$this->plugin_name = 'uds-wp-depreciation-helper';
		$this->plugin_prefix = 'uds-wp-depreciation-helper_';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Uds_Wp_Depreciation_Helper_Loader. Orchestrates the hooks of the plugin.
	 * - Uds_Wp_Depreciation_Helper_i18n. Defines internationalization functionality.
	 * - Uds_Wp_Depreciation_Helper_Admin. Defines all hooks for the admin area.
	 * - Uds_Wp_Depreciation_Helper_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uds-wp-depreciation-helper-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uds-wp-depreciation-helper-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uds-wp-depreciation-helper-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uds-wp-depreciation-helper-public.php';

		$this->loader = new Uds_Wp_Depreciation_Helper_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Uds_Wp_Depreciation_Helper_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Uds_Wp_Depreciation_Helper_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Uds_Wp_Depreciation_Helper_Admin( $this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Check for ACF Pro using TGMPA
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/tgmpa/class-tgm-plugin-activation.php';	// Loads TGMPA script
		$this->loader->add_action( 'tgmpa_register', $plugin_admin, 'udswp_depreciation_helper_register_required_plugins' );

		// Load the plugin options panel
		$this->loader->add_action( 'acf/init', $plugin_admin, 'udswp_deprecation_helper_acf_create_options_panel');
		
		// Load the ACF JSON files conditionally based on options set in panel.
		$this->loader->add_filter( 'acf/settings/load_json', $plugin_admin, 'udswp_depreciation_helper_acf_json_load_point' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Uds_Wp_Depreciation_Helper_Public( $this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Shortcode name must be the same as in shortcode_atts() third parameter.
		$this->loader->add_shortcode( $this->get_plugin_prefix() . 'shortcode', $plugin_public, 'plugin_name_shortcode_func' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The unique prefix of the plugin used to uniquely prefix technical functions.
	 *
	 * @since     0.1
	 * @return    string    The prefix of the plugin.
	 */
	public function get_plugin_prefix() {
		return $this->plugin_prefix;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1
	 * @return    Uds_Wp_Depreciation_Helper_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
