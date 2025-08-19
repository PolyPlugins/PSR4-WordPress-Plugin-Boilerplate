<?php

namespace Company\Test_Plugin;

class Utils {
  
  /**
   * Get options
   *
   * @return array $options The test plugin options
   */
  public static function get_options() {
    $settings_name = self::get_settings_name();
    $options       = get_option($settings_name);

    return $options;
  }
  
  /**
   * Get option from options array
   *
   * @param  string $section The section to retrieve from options
   * @param  string $option  The option to retrieve from options
   * @return mixed  $option  The retrieved option value
   */
  public static function get_option($section, $option) {
    $options = self::get_options();
    $option  = isset($options[$section][$option]['value']) ? $options[$section][$option]['value'] : false;

    return $option;
  }
  
  /**
   * Get subsection option from options array
   *
   * @param  string $section    The section to retrieve from options
   * @param  string $subsection The subsection to retrieve from options
   * @param  string $option     The option to retrieve from options
   * @return mixed  $option     The retrieved option value
   */
  public static function get_subsection_option($section, $subsection, $option) {
    $options = self::get_options();
    $key     = $section . '-' . $subsection;
    $option  = isset($options[$key][$option]['value']) ? $options[$key][$option]['value'] : false;

    return $option;
  }

  /**
   * Get the plugin settings name
   *
   * @return string $settings_name The plugin settings name
   */
  public static function get_settings_name() {
    $plugin        = self::get_plugin();
    $key           = 'plugin_settings_name_' . md5($plugin);
    $settings_name = get_option($key, '');

    if (!$settings_name) {
      $author       = Utils::get_plugin_author();
      $plugin_slug  = dirname(plugin_basename($plugin));
      $plugin_name  = mb_convert_case(str_replace('-', ' ', $plugin_slug), MB_CASE_TITLE);

      $settings_name = strtolower(str_replace(' ', '_', $plugin_name) . '_settings' . '_' . str_replace(' ', '_', $author));

      update_option($key, $settings_name);
    }

    return $settings_name;
  }
  
  /**
   * Full path and filename of plugin.
   *
   * @return string $plugin The full path and filename of plugin.
   */
  public static function get_plugin() {
    $plugin = Test_Plugin::get_plugin();

    return $plugin;
  }

  /**
   * Get the plugin version
   *
   * @return string $version The plugin version
   */
  public static function get_plugin_version() {
    $plugin = Test_Plugin::get_plugin();
    $key    = 'plugin_version_' . md5($plugin);

    // Get cached data
    $option = get_option($key, array(
      'version'   => null,
      'filemtime' => 0,
    ));

    $current_filemtime = filemtime($plugin);

    // Only update if the file has changed
    if ($current_filemtime !== $option['filemtime']) {
      $plugin_data = get_file_data(
        $plugin,
        array(
          'Version' => 'Version',
        ),
        false
      );

      $option = array(
        'version'   => $plugin_data['Version'],
        'filemtime' => $current_filemtime,
      );

      update_option($key, $option);
    }

    return $option['version'];
  }

  /**
   * Get the plugin author
   *
   * @return string $author The plugin author
   */
  public static function get_plugin_author() {
    $plugin        = Test_Plugin::get_plugin();
    $key           = 'plugin_author_' . md5($plugin);
    $plugin_author = get_option($key, '');

    if (!$plugin_author) {
      $plugin_data = get_file_data(
        $plugin,
        array(
          'Author'  => 'Author',
        ),
        false
      );
      
      $plugin_author = $plugin_data['Author'];

      update_option($key, $plugin_data['Author']);
    }

    return $plugin_author;
  }

  /**
   * Send success json
   *
   * @param  string $message The message to send
   * @param  int    $code    The status code
   * @return void
   */
  public static function send_success($message, $code = 200) {
    $message = $message ? sanitize_text_field($message) : __('Success', 'test-plugin');
    $code    = is_numeric($code) ? (int) $code : 200;

    wp_send_json_success(array(
      'message' => sanitize_text_field($message),
      'status' => $code
    ), $code);
  }
  
  /**
   * Send error json
   *
   * @param  mixed $message
   * @param  mixed $code
   * @return void
   */
  public static function send_error($message, $code = 400) {
    $message = $message ? sanitize_text_field($message) : __('Error', 'test-plugin');
    $code    = is_numeric($code) ? (int) $code : 400;

    wp_send_json_error(array(
      'message' => sanitize_text_field($message),
      'status' => $code
    ), $code);
  }

}