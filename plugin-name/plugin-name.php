<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

namespace Company\Plugin_Name;

use Company\Plugin_Name\Loader;
use Company\Plugin_Name\i18n;
use Company\Plugin_Name\Frontend\Display;
use Company\Plugin_Name\Backend\Options;

if (!defined('ABSPATH')) exit;

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in classes/activator.php
 */
register_activation_hook( __FILE__, array( __NAMESPACE__ . '\Activator', 'activate' ) );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in classes/deactivator.php
 */
register_deactivation_hook( __FILE__, array( __NAMESPACE__ . '\Deactivator', 'deactivate' ) );

class Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Full path and filename of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    Full path and filename of plugin.
	 */
	protected $plugin;

	/**
	 * The unique name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The name used to uniquely identify this plugin.
	 */
  protected $plugin_name;

	/**
	 * The unique name for the admin menu.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The name used in the admin menu.
	 */
	protected $plugin_menu_name;

	/**
	 * The unique name for the plugins options.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The name used to uniquely identify this plugins options.
	 */
  protected $plugin_options_name;

	/**
	 * The path to the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The path to the plugin.
	 */
  protected $plugin_path;

	/**
	 * The path to the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The path to the plugin.
	 */
  protected $plugin_slug;

	/**
	 * The slug but with _ instead of -
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The slug but with _ instead of -
	 */
  protected $plugin_slug_id;

	/**
	 * The plugin's options array
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The plugin's options array
	 */
  protected $options;

	/**
	 * The plugin's support link
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The plugin's options array
	 */
  protected $support;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the wordpress plugin boilerplate and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Define Properties
    $this->version             = '1.0.0';
    $this->plugin              = __FILE__;
    $this->plugin_path         = plugin_dir_path( $this->plugin );
    $this->plugin_slug         = dirname( plugin_basename( $this->plugin ) );
    $this->plugin_slug_id      = str_replace( '-', '_', $this->plugin_slug );
    $this->plugin_name         = __('WordPress Plugin Boilerplate', $this->plugin_slug);
    $this->plugin_menu_name    = __('WordPress Plugin Boilerplate', $this->plugin_slug);
    $this->plugin_options_name = $this->plugin_slug_id . '_options';
    $this->plugin_options      = get_option( $this->plugin_options_name );
    $this->plugin_support      = '<a href="http://example.com/support/" target="_blank">' . __("Get Support", $this->plugin_slug) . '</a>';

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
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Options( $this->plugin, $this->plugin_path, $this->plugin_slug, $this->version );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Display( $this->plugin, $this->plugin_path, $this->plugin_slug, $this->version );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

$plugin = new Plugin();
$plugin->run();
