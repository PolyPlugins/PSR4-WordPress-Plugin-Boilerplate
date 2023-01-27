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
 * Plugin Name:       WordPress Plugin Boilerplate with Reusable Admin Panel
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
	 * @var      Loader      $loader   Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Full path and filename of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $version   Full path and filename of plugin.
	 */
	protected $plugin;
  
  /**
	 * Namespace of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $namespace   Namespace of plugin.
	 */
  protected $namespace;

	/**
	 * The path to the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The path to the plugin.
	 */
  protected $plugin_path;

	/**
	 * The path to the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The path to the plugin.
	 */
  protected $plugin_slug;

	/**
	 * The slug but with _ instead of -
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug_id   The slug but with _ instead of -
	 */
  protected $plugin_slug_id;

	/**
	 * The unique name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The name used to uniquely identify this plugin.
	 */
  protected $plugin_name;

	/**
	 * The unique name for the plugins options.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $settings_name   The name used to uniquely identify this plugins options.
	 */
  protected $settings_name;
  
	/**
	 * The plugin's settings array
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array       $settings   The plugin's settings array
	 */
  protected $settings;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $version   The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the wordpress plugin boilerplate and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Define Properties
    $this->version        = '1.0.0';
    $this->plugin         = __FILE__;
    $this->namespace      = __NAMESPACE__;
    $this->plugin_path    = plugin_dir_path( $this->plugin );
    $this->plugin_slug    = dirname( plugin_basename( $this->plugin ) );
    $this->plugin_slug_id = str_replace( '-', '_', $this->plugin_slug );
    $this->plugin_name    = __( mb_convert_case( str_replace( '-', ' ', $this->plugin_slug ), MB_CASE_TITLE ), $this->plugin_slug );
		$this->settings_name  = $this->plugin_slug_id . '_' .  strtolower(str_replace('\\', '_', $this->namespace)) . '_settings';
    $this->settings       = get_option($this->settings_name);

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

		$plugin_admin = new Options( $this->plugin, $this->namespace, $this->plugin_slug, $this->plugin_name, $this->version );

		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'init_reusable_admin_panel' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_notice' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Display( $this->plugin, $this->plugin_path, $this->plugin_slug, $this->settings, $this->version );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_body_open', $plugin_public, 'display_option' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since   1.0.0
	 */
	public function run() {

		$this->loader->run();

	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since    1.0.0
	 * @return   Plugin_Name_Loader   Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since    1.0.0
	 * @return   string   The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;

	}

}

$plugin = new Plugin();
$plugin->run();
