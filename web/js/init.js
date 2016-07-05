
window.onload = function(){

    $('.scroll-pane').jScrollPane();

};




$(document).ready(function(){


  // var owl = jQuery(".slick");

  $('.slick').slick({

        slidesToShow: 2,

        slidesToScroll: 1,

        autoplay: true,

        autoplaySpeed: 5000,

        arrows: true,

        dots: false,

        speed: 500
      });



  $(document).on('click', '.btnModal5', function(event){
      event.preventDefault();
      $.fancybox({
        scrolling: 'visible',
        href: '#myModal5',
        wrapCSS: 'wrap_fanc',
        padding: 0 
    });
    $('.scroll-pane').jScrollPane();
  });


  // $(document).on('click', '.btnModal3', function(event){
  //     event.preventDefault();
  //     $.fancybox({
  //       scrolling: 'visible',
  //       href: '#myModal3',
  //       wrapCSS: 'wrap_fanc',
  //       padding: 0
  //   });
  //
  //   $('.slick').slick('slickAdd',"0");
  //    // jQuery(".slick").owlCarousel({
  //    //      loop:true,
  //    //      margin:0,
  //    //      nav:true,
  //    //      navText:[''],
  //    //      items:2,
  //    //      margin: 10,
  //    //      dots:false
  //    //  });
  // });



  $('.btnModal').fancybox({
        scrolling: 'visible',
        wrapCSS: 'wrap_fanc',
        padding: 0,
        fitToView:false
    });

    $("a.fancy").fancybox({
        'transitionIn'	:	'elastic',
        'transitionOut'	:	'elastic',
        'speedIn'		:	600,
        'speedOut'		:	200,
        'overlayShow'	:	false
    })
 });