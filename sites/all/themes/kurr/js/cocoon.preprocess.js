(function($){
  Drupal.behaviors.cocoonpreprocess = {
    attach: function (context, settings) {
      $('.cocoon-main-menu .menu a').addClass('inner-link');
      $('#education .education.row:nth-child(2n-1)').addClass('fadeInRight');
      $('#education .education.row:nth-child(2n)').addClass('fadeInLeft');
      $('.block-webform .form-actions').addClass('large-12 text-center columns');
      $('.block-webform .form-actions .submit').addClass('submit-button');
    }
  };
}(jQuery));