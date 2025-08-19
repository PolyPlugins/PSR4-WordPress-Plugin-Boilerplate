jQuery(document).ready(function ($) {

  const { __, _x, _n, _nx } = wp.i18n;

  $('#general-action-1').on('click', function() {
    Swal.fire({
      title: __('Success', 'test-plugin'),
      html: __('Button clicked!', 'test-plugin'),
      icon: 'success',
      confirmButtonColor: '#46BEA4',
      iconColor: '#46BEA4',
    });
  });

});
