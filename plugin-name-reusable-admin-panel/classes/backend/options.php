<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/admin
 * @author       Your Name <email@example.com>
 */

namespace Company\Plugin_Name\Backend;

use PolyPlugins\Settings;

if (!defined('ABSPATH')) exit;

class Options {

	/**
	 * Full path and filename of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin   Full path and filename of plugin.
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
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The ID of this plugin.
	 */
	protected $plugin_slug;

	/**
	 * The unique name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string      $plugin_slug   The unique name of this plugin.
	 */
  protected $plugin_name;

  /**
	 * The settings class configuration
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array       $config   The settings class configuration
	 */
  protected $config;

  /**
	 * The plugin's options fields
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array       $fields   The plugin's options fields
	 */
  protected $fields;

  /**
	 * The Settings class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $settings   The Settings class
	 */
  protected $settings;

  /**
	 * Store admin notices
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array       $admin_notice   Store admin notices
	 */
  protected $admin_notice;

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
	 * @param   string   $plugin        The name of this plugin.
	 * @param   string   $namespace     Namespace of plugin.
	 * @param   string   $plugin_slug   The ID of this plugin.
	 * @param   string   $plugin_name   The unique name of this plugin.
	 * @param   string   $version       The version of this plugin.
	 */
	public function __construct( $plugin, $namespace, $plugin_slug, $plugin_name, $version ) {

		$this->plugin      = $plugin;
		$this->namespace   = $namespace;
		$this->plugin_slug = $plugin_slug;
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Initialize Reusable Admin Panel
	 *
	 * @since   1.0.0
	 */
	public function init_reusable_admin_panel() {

		$this->config  = array(
      'page'       => 'options-general.php', // You can use non php pages such as woocommerce here to display a submenu under Woocommerce
      'position'   => 1, // Lower number moves the link position up in the submenu
      'capability' => 'manage_options', // What permission is required to see and edit settings
      'logo'       => '/img/logo.png', // Your custom logo
      'css'        => '/css/admin.css', // Your custom colors and styles
      'support'    => 'https://www.polyplugins.com/support/', // Your support link
    );

    $this->fields = array(
      'general' => array(
        array(
          'name'     => __('Enabled', $this->plugin_slug),
          'type'     => 'switch',
          'default'  => false,
        ),
        array(
          'name'     => __('Username', $this->plugin_slug),
          'type'     => 'text',
          'default'  => false,
          'help'     => __('Enter a username.', $this->plugin_slug),
        ),
        array(
          'name'     => __('Password', $this->plugin_slug),
          'type'     => 'password',
          'default'  => 'test',
          'help'     => __('Enter a password. Note: This is stored in the DB as plain text as most other plugins do, we will change this if requested.', $this->plugin_slug),
        ),
        array(
          'name'     => __('Number', $this->plugin_slug),
          'type'     => 'number',
          'default'  => false,
          'help'     => __('Enter a number.', $this->plugin_slug),
          'required' => true,
        ),
        array(
          'name'     => __('Time', $this->plugin_slug),
          'type'     => 'time',
          'default'  => false,
          'help'     => __('Select a time.', $this->plugin_slug),
        ),
        array(
          'name'     => __('Date', $this->plugin_slug),
          'type'     => 'date',
          'default'  => false,
          'help'     => __('Select a date.', $this->plugin_slug),
        ),
        array(
          'name'     => __('Color Picker', $this->plugin_slug),
          'type'     => 'color',
          'default'  => '#00ff00',
          'help'     => __('Select a color.', $this->plugin_slug),
        ),
        array(
          'name'     => __('Dropdown', $this->plugin_slug),
          'type'     => 'dropdown',
          'options'  => array('Red', 'Blue'),
          'default'  => false,
          'help'     => __('Select an option from the dropdown.', $this->plugin_slug),
        ),
      ),
    );

		if (class_exists('PolyPlugins\Settings')) {
      $this->settings = new Settings($this->plugin, $this->namespace, $this->config, $this->fields);
      $this->settings->init();
    } else {
      $this->add_notice('"' . $this->plugin_name . '"' . " requires <a href='/wp-admin/plugin-install.php?tab=plugin-information&amp;plugin=reusable-admin-panel&amp;TB_iframe=true&amp;width=772&amp;height=608' class='thickbox open-plugin-details-modal' aria-label='More information about Reusable Admin Panel' data-title='Reusable Admin Panel'>Reusable Admin Panel</a> to be installed.");
    }

	}

  /**
   * Display the notice on the admin backend
   *
   * @since    1.0.0
   * @return   void
   */
  public function display_notice() {

    if (isset($this->admin_notice) && $this->admin_notice) {
    ?>
    <div class="notice notice-<?php echo $this->admin_notice['type']; ?>">
      <p><?php echo $this->admin_notice['message']; ?></p>
    </div>
    <?php
    }

  }

  /**
   * Enqueue the admin notice
   *
   * @since    1.0.0
   * @param    string   $message   The message being displayed in admin
   * @param    string   $type      Optional. The type of message displayed. Default error.
   * @return   void
   */
  private function add_notice($message, $type = 'error') {

    $this->admin_notice = array(
      'message' => $message,
      'type'   => $type
    );

  }

}
