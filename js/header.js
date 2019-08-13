$(function() {

  $('.js_local_nav').hover(function(){
    $('.js_local_menu:not(:animated)', this).slideDown();
  }, function(){
    $('.js_local_menu', this).slideUp();
  });

});

