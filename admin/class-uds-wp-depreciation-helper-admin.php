<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://engineering.asu.edu
 * @since      0.1
 *
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the admin-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Uds_Wp_Depreciation_Helper
 * @subpackage Uds_Wp_Depreciation_Helper/admin
 * @author     Your Name <steve.ryan@asu.edu>
 */
class Uds_Wp_Depreciation_Helper_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	private $plugin_prefix;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $plugin_prefix    The unique prefix of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_prefix, $version ) {

		$this->plugin_name   = $plugin_name;
		$this->plugin_prefix = $plugin_prefix;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_styles( $hook_suffix ) {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uds-wp-depreciation-helper-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Enqueues global JavaScript files for the admin area.
	 *
	 * @since    0.1
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uds-wp-depreciation-helper-admin.js', array( 'jquery' ), $this->version, false );

	}

	/** 
	 * Perform TGMPA check for dependent plugins. Requires ACF Pro.
	 */
	public function udswp_depreciation_helper_register_required_plugins() {
		/*
		 * This check requires the TGMPA class.
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
	
			// The 'is_callable' setting checks for the ability to register a block, specific for ACF Pro.
			array(
				'name'        => 'Advanced Custom Fields Pro',
				'slug'        => 'advanced-custom-fields-pro',
				'is_callable' => 'acf_register_block_type',
				'required'    => 'true',
			),
	
		);
	
		/*
		 * Array of configuration settings.
		 */
		$config = array(
			'id'           => 'udswp-depreciation-helper',     // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'manage_options',         // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
	
		tgmpa( $plugins, $config );
	}

	/** 
	 * Create theme options page which checks which ACF partials should be loaded.
	 */
	public function udswp_deprecation_helper_acf_create_options_panel() {
		if( function_exists('acf_add_options_page') ) {
	
			acf_add_options_page(array(
				'page_title' 	=> 'Deprecation Helper',
				'menu_title'	=> 'Deprecation Helper',
				'menu_slug' 	=> 'deprecation-helper',
				'parent_slug'   => 'options-general.php',
				'capability'	=> 'edit_posts',
				'redirect'		=> false
			));
		}
	}

	/** 
	 * Create load paths for ACF Local JSON files. 
	 */
	public function udswp_depreciation_helper_acf_json_load_point( $paths ) {
		
		// These should always be loaded.
		$paths[] = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/acf-json';

		// Check for v1 Hero option. Load ACF JSON fields if needed.
		if ( get_field( 'uds-depreciation-panel-v1-hero', 'options') ) {
			$paths[] = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/acf-json/uds-hero-v1';
		}
		
		return $paths;
	}

}
