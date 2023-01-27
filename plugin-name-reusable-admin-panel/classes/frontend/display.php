<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link         http://example.com
 * @since        1.0.0
 *
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/public
 * @author       Your Name <email@example.com>
 */

namespace Company\Plugin_Name\Frontend;

if (!defined('ABSPATH')) exit;

class Display {

	/**
	 * Full path and filename of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin   Full path and filename of plugin.
	 */
	protected $plugin;

	/**
	 * The path to the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The path to the plugin.
	 */
  protected $plugin_path;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The ID of this plugin.
	 */
	protected $plugin_slug;
  
	/**
	 * The plugin's options array
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array       $settings   The plugin's options array
	 */
  protected $settings;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected   
	 * @var      string      $version   The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @param   string   $plugin_slug   The name of this plugin.
	 * @param   string   $plugin_path   The path to the plugin.
	 * @param   string   $plugin_slug   The ID of this plugin.
	 * @param   string   $settings      The plugin's options array
	 * @param   string   $version       The version of this plugin.
	 */
	public function __construct( $plugin, $plugin_path, $plugin_slug, $settings, $version ) {

		$this->plugin      = $plugin;
		$this->plugin_path = $plugin_path;
		$this->plugin_slug = $plugin_slug;
		$this->settings    = $settings;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since   1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_slug, plugin_dir_url( $this->plugin ) . 'css/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since   1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_slug, plugin_dir_url( $this->plugin ) . 'js/public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Display an option saved to Reusable Admin Panel's settings array.
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function display_option() {

		// This is purely for demonstration purposes.
		// Uncommenting the below code will display the value of the Color Picker field from Reusable Admin Panel on the front-end.
		// if ($this->get_option('general', 'color-picker')) {
		// 	echo $this->get_option('general', 'color-picker');
		// } else {
		// 	echo "You haven't set a value for the Color Picker field yet.";
		// }

	}

	/**
   * Get option from settings array
	 * 
	 * Reusable Admin Panel is only instantiated within admin, making it's methods inaccessible to the front-end, so we unfortunately have to reuse a piece of it's code.
	 * In the future we may implement a static method within Reusable Admin Panel to avoid redundancy, but this would require the $settings property to be passed as well.
	 * Let us know if you're interested in us adding a static method via support
	 * https://wordpress.org/support/plugin/reusable-admin-panel/
   *
	 * @since    1.0.0
   * @param    mixed   $section        Section of setting
   * @param    mixed   $option         Get option of the previously specified section
   * @return   mixed   $option_value   Returns the value of the option
   */
  private function get_option($section, $option) {

    if (!empty($this->settings[$section][$option]['value'])) {
      $option_value = $this->settings[$section][$option]['value'];
    } else {
      $option_value = '';
    }
    
    return $option_value;
		
  }

}
