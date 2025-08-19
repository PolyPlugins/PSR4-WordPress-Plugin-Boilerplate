<?php

namespace Company\Test_Plugin;

use Company\Test_Plugin\Frontend\Enqueue;

class Frontend_Loader {

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
    $this->plugin         = $plugin;
  }
  
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    $this->load_enqueue();
  }
  
  /**
   * Load UI
   *
   * @return void
   */
  public function load_enqueue() {
    $enqueue = new Enqueue($this->plugin);
    $enqueue->init();
  }

}