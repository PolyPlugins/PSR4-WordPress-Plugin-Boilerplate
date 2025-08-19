<?php

namespace Company\Test_Plugin;

class Dependency_Loader {

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
    $this->load_frontend();
    $this->load_backend();
  }
  
  /**
   * Load Frontend
   *
   * @return void
   */
  public function load_frontend() {
    $frontend_loader = new Frontend_Loader($this->plugin);
    $frontend_loader->init();
  }
  
  /**
   * Load Backend
   *
   * @return void
   */
  public function load_backend() {
    $backend_loader = new Backend_Loader($this->plugin);
    $backend_loader->init();
  }

}