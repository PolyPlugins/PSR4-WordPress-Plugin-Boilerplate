<?php

namespace Company\Test_Plugin\Backend;

use Company\Test_Plugin\Utils;
use PolyPlugins\Settings\Settings;

class Admin {

  /**
	 * Full path and filename of plugin.
	 *
	 * @var string $plugin Full path and filename of plugin.
	 */
  private $plugin;

	/**
	 * The settings class configuration
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array   $fields The settings class configuration
	 */
  private $config;
  
	/**
	 * The plugin's options fields
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array   $fields The plugin's options fields
	 */
  private $fields;
  
  /**
   * __construct
   *
   * @param  mixed $plugin
   * @return void
   */
  public function __construct($plugin) {
    $this->plugin = $plugin;
    $this->config = self::get_config();
    $this->fields = self::get_fields();
  }
    
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    add_action('init', array($this, 'loaded'));
  }
  
  /**
   * Loaded
   *
   * @return void
   */
  public function loaded() {
    $settings = new Settings($this->plugin, $this->config, $this->fields);
    $settings->init();
  }
  
  /**
   * Get config
   *
   * @param  string       $key    The config key to fetch
   * @return array|string $config The setting's config or specific config key
   */
  public static function get_config($key = '') {
    static $config = null; // Set static property so it only needs to build array once

    if ($config === null) {
      $config = array(
        'name'             => __('Test Plugin', 'test-plugin'), // The plugin name. Comment out to have it build the name from plugin slug
        'menu_name'        => __('Test Plugin', 'test-plugin'), // The name you want to show in the admin menu. Comment out to have it build the name from plugin slug
        'settings_name'    => Utils::get_settings_name(), // To prevent conflicts you should include your company name as the suffix. This is the setting name you want to use for get_option. 
        'page'             => 'options-general.php', // You can use non php pages such as woocommerce here to display a submenu under WooCommerce
        'position'         => 1, // Lower number moves the link position up in the submenu
        'capability'       => 'manage_options', // What permission is required to see and edit settings
        'css'              => '/css/backend/settings.css', // Your custom colors and styles. Comment out to use only the default style.
        'js'               => '/js/backend/settings.js', // Your custom javascript. Enqueue you're own if you need translations. Comment out to only use the default js.
        'template'         => 'recharge', // Change the theme the settings uses. Comment out to use the default or enter 'default'
        'support'          => 'https://www.polyplugins.com/support/', // Your support link. Comment out to have no support link.
        'action_links' => array( // Optional, add action links to the listing on admin plugins page
          array(
            'label'    => __('Settings', 'test-plugin'),
            'style'    => 'color: orange; font-weight: 700;',
            'external' => false
          ),
          array(
            'url'      => 'https://www.polyplugins.com',
            'label'    => __('Go Pro', 'test-plugin'),
            'style'    => 'color: green; font-weight: 700;',
            'external' => true
          ),
        ),
        'meta_links' => array( // Optional, add meta links to the listing on admin plugins page
          array(
            'url'      => 'https://github.com/PolyPlugins/product-redirection-for-woocommerce/projects',
            'label'    => __('Roadmap', 'test-plugin'),
            'style'    => 'color: purple; font-weight: 700;',
            'external' => true
          ),
          array(
            'label'    => __('Support', 'test-plugin'),
            'style'    => 'font-weight: 700;',
            'external' => true
          ),
        ),
        'sidebar' => array( // Optional, add a permanent sidebar
          'heading'      => __('Something Not Working?', 'test-plugin'),
          'body'         => __('Feel free to reach out!', 'test-plugin'),
          'button_label' => __('Email Us', 'test-plugin'),
          'button_url'   => 'https://www.polyplugins.com/contact/'
        ),
      );
    }

    if ($key) {
      return isset($config[$key]) ? $config[$key] : '';
    }

    return $config;
  }
  
  /**
   * Get fields
   *
   * @return array The setting's fields
   */
  public static function get_fields() {
    static $fields = null; // Set static property so it only needs to build array once

    if ($fields === null) {
      $fields = array(
        'general' => array(
          'icon' => 'gear-fill',
          'fields' => array(
            array(
              'name'     => __('Enabled', 'test-plugin'),
              'type'     => 'switch',
              'default'  => false,
            ),
            array(
              'name'      => __('Button', 'test-plugin'),
              'label'     => __('Dual Buttons', 'test-plugin'),
              'type'      => 'button',
              'data'      => array(
                array(
                  'title' => __('Action 1', 'test-plugin'), // general-action-1 would be the id you'd target in js
                  'class' => 'primary',
                  ),
                array(
                  'title'  => __('Action 2', 'test-plugin'),
                  'class'  => 'secondary',
                  'url'    => 'https://www.polyplugins.com', // If no url then javascript:void(0) is used, this is useful for custom js
                  'target' => '_blank',
                )
              )
            ),
            array(
              'name'        => __('Username', 'test-plugin'),
              'label'       => __('The Username', 'test-plugin'),
              'description' => __('Enter a description.', 'test-plugin'),
              'type'        => 'text',
              'placeholder' => __('Enter your username...', 'test-plugin'),
              'default'     => false,
              'help'        => __('Enter a username.', 'test-plugin'),
            ),
            array(
              'name'     => __('Textarea', 'test-plugin'),
              'type'     => 'textarea',
              'default'  => __('Description goes here...', 'test-plugin'),

              'help'     => __('Enter a description.', 'test-plugin'),
            ),
            array(
              'name'     => __('Larger Textarea', 'test-plugin'),
              'type'     => 'textarea',
              'rows'     => 6,
              'default'  => __('Description goes here...', 'test-plugin'),

              'help'     => __('Enter a description.', 'test-plugin'),
            ),
            array(
              'name'     => __('Email', 'test-plugin'),
              'type'     => 'email',
              'default'  => 'test@example.com',
              'help'     => __('Enter your email...', 'test-plugin'),
            ),
            array(
              'name'     => __('URL', 'test-plugin'),
              'type'     => 'url',
              'default'  => false,
              'help'     => __('Enter a URL. Ex: https://www.example.com', 'test-plugin'),
            ),
            array(
              'name'     => __('Password', 'test-plugin'),
              'type'     => 'password',
              'default'  => 'test',
              'help'     => __('Enter a password. Note: This is stored in the DB as plain text as most other plugins do, we will change this if requested.', 'test-plugin'),
            ),
            array(
              'name'     => __('Number', 'test-plugin'),
              'type'     => 'number',
              'min'      => 1,
              'max'      => 10,
              'step'     => 2,
              'default'  => false,
              'help'     => __('Enter a number.', 'test-plugin'),
              'required' => true,
            ),
            array(
              'name'     => __('Time', 'test-plugin'),
              'type'     => 'time',
              'default'  => false,
              'help'     => __('Select a time.', 'test-plugin'),
            ),
            array(
              'name'     => __('Date', 'test-plugin'),
              'type'     => 'date',
              'default'  => false,
              'help'     => __('Select a date.', 'test-plugin'),
            ),
            array(
              'name'     => __('Color Picker', 'test-plugin'),
              'type'     => 'color',
              'default'  => '#00ff00',
              'help'     => __('Select a color.', 'test-plugin'),
            ),
            array(
              'name'     => __('Dropdown', 'test-plugin'),
              'type'     => 'dropdown',
              'options'  => array(__('Red', 'test-plugin'), __('Blue', 'test-plugin')),
              'default'  => false,
              'help'     => __('Select an option from the dropdown.', 'test-plugin'),
            ),
            array(
              'name'     => __('Disabled Dropdown', 'test-plugin'),
              'type'     => 'dropdown',
              'options'  => array(__('Red', 'test-plugin'), __('Blue', 'test-plugin')),
              'default'  => false,
              'disabled' => true,
              'help'     => __('Select an option from the dropdown.', 'test-plugin'),
            ),
          ),
          'subsections' => array(
            'debug' => array(
              'icon'  => 'bug-fill',
              'label' => __('Debug', 'test-plugin'),
              'fields' => array(
                array(
                  'name'    => __('Debug Mode', 'test-plugin'),
                  'type'    => 'switch',
                  'default' => false,
                ),
              )
            ),
          ),
        ),
        'api' => array(
          'icon' => 'cloud-arrow-up-fill',
          'note' => array(
            'message' => __('Use notes to display messages about specific sections', 'test-plugin'),
            'class'   => 'warning', // Use success, warning, or error
          ),
          'fields' => array(
            array(
              'name'     => __('Dropdown Toggle', 'test-plugin'),
              'type'     => 'dropdown_toggle',
              'options'  => array(
                'Production' => array(
                  'name'     => __('API Key', 'test-plugin'),
                  'type'     => 'text',
                ),
                'Development' => array(
                  'name'     => __('API Key', 'test-plugin'),
                  'type'     => 'text',
                )
              ),
            ),
          ),
        )
      );
    }
    
    return $fields;
  }

}