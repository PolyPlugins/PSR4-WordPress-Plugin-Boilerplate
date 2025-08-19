jQuery(document).ready(function ($) {

  const { __, _x, _n, _nx } = wp.i18n;

  let email   = test_plugin_object.email ? test_plugin_object.email : __('not detected. Please add an email in settings.', 'test-plugin');
  let message = __('Settings Class for WordPress email setting is ' + email, 'test-plugin');

  alert(message);

});
