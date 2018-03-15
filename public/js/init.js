// Parallax

(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('.parallax').parallax();

  }); // end of document ready
})(jQuery); // end of jQuery name space

// Dropdown
$('.dropdown-trigger').dropdown();
$('.article-categories').dropdown();

// select
$(document).ready(function(){
    $('select').formSelect();
});


