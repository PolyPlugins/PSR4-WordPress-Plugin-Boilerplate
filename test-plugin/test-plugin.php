<?php

/**
 * Plugin Name: Test Plugin
 * Description: Demo plugin for Settings Class for WordPress
 * Version: 3.0.0
 * Author: Company
 * Text Domain: test-plugin
 * Author URI: https://www.polyplugins.com
 * Plugin URI: https://www.polyplugins.com
 */

namespace Company\Test_Plugin;

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

if (!defined('ABSPATH')) exit;

class Test_Plugin
{

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
  public function __construct() {
    $this->plugin = __FILE__;
  }
  
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    $this->load_dependencies();
  }
  
  /**
   * Load dependencies
   *
   * @return void
   */
  public function load_dependencies() {
    $dependency_loader = new Dependency_Loader($this->plugin);
    $dependency_loader->init();
  }
  
  /**
   * Full path and filename of plugin.
   *
   * @return string $plugin The full path and filename of plugin.
   */
  public static function get_plugin() {
    $plugin = __FILE__;

    return $plugin;
  }

}

$test_plugin = new Test_Plugin;
$test_plugin->init();
