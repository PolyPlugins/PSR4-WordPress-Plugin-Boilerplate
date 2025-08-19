<?php

namespace Company\Test_Plugin;

use Company\Test_Plugin\Backend\Admin;
use Company\Test_Plugin\Backend\Enqueue;

class Backend_Loader {

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
    $this->load_enqueue();
    $this->load_admin();
  }
  
  /**
   * Load Enqueue
   *
   * @return void
   */
  public function load_enqueue() {
    $enqueue = new Enqueue($this->plugin);
    $enqueue->init();
  }
  
  /**
   * Load Admin
   *
   * @return void
   */
  public function load_admin() {
    $admin = new Admin($this->plugin);
    $admin->init();
  }

}