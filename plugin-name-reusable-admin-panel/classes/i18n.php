<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link         http://example.com
 * @since        1.0.0
 *
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/classes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since        1.0.0
 * @package      Plugin_Name
 * @subpackage   Plugin_Name/classes
 * @author       Your Name <email@example.com>
 */

namespace Company\Plugin_Name;

if (!defined('ABSPATH')) exit;

class i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since   1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugin-name',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
