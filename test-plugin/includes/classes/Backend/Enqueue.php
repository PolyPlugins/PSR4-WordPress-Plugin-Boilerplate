<?php

namespace Company\Test_Plugin\Backend;

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
    add_action('admin_enqueue_scripts', array($this, 'maybe_enqueue'));
  }
  
  /**
   * Enqueue scripts and styles
   *
   * @return void
   */
  public function maybe_enqueue() {
    $page        = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
    $plugin_slug = dirname(plugin_basename($this->plugin));

    if($page == $plugin_slug) {
      $this->enqueue();
    }
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
    wp_enqueue_script('test-plugin-admin', plugins_url('/js/backend/admin.js', $this->plugin), array('jquery', 'wp-i18n'), Utils::get_plugin_version(), true);
    wp_set_script_translations('test-plugin-admin', 'test-plugin', plugin_dir_path($this->plugin) . '/languages/');
  }
  
}