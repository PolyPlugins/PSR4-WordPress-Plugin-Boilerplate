<?php

namespace Company\Test_Plugin\Frontend;

use Company\Test_Plugin\Utils;

class Enqueue {

  /**
	 * Full path and filename of plugin.
	 *
	 * @var string $version Full path and filename of plugin.
	 */
  private $plugin;
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct($plugin) {
    $this->plugin = $plugin;
  }
  
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    add_action('wp_enqueue_scripts', array($this, 'enqueue'));
  }
  
  /**
   * Enqueue scripts and styles
   *
   * @return void
   */
  public function enqueue() {
    $this->enqueue_styles();
    $this->enqueue_scripts();
  }
  
  /**
   * Enqueue styles
   *
   * @return void
   */
  private function enqueue_styles() {
    // Enqueue your styles
  }
  
  /**
   * Enqueue scripts
   *
   * @return void
   */
  private function enqueue_scripts() {
    wp_enqueue_script('test-plugin-email', plugins_url('/js/frontend/email.js', $this->plugin), array('jquery', 'wp-i18n'), Utils::get_plugin_version(), true);
    wp_localize_script(
      'test-plugin-email',
      'test_plugin_object',
      array(
        'email' => Utils::get_option('general', 'email'),
      )
    );
    wp_set_script_translations('test-plugin-email', 'test-plugin', plugin_dir_path($this->plugin) . '/languages/');
  }
  
}