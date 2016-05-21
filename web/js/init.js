
window.onload = function(){

    $('.scroll-pane').jScrollPane();

};




$(document).ready(function(){


  var owl = jQuery(".slick");



  $('.btnModal').fancybox({
        scrolling: 'visible',
        wrapCSS: 'wrap_fanc',
        padding: 0,
        fitToView:false,
        beforeShow: function() {
          owl.owlCarousel({
          loop:true,
          margin:0,
          nav:true,
          navText:[''],
          items:2,
          margin: 10,
          dots:false
      });
      }

    });



 });