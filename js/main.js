(function($) {
  // $(document).ready(function() {
  //    $('#target').load('header.html');
  //    console.log("a");
  // });

  "use strict";
  $(window).on("load", function() { // makes sure the whole site is loaded
    //preloader
    $("#status").fadeOut(); // will first fade out the loading animation
    $("#preloader").delay(450).fadeOut("slow"); // will fade out the white DIV that covers the website.

    //masonry
    $('.grid').masonry({
      itemSelector: '.grid-item'

    });
    if(fav_count == 1){
      console.log(fav_count);
      $("div.favadddel").replaceWith( '<button id="buttonother" class="btn jb jfont" type="submit" name="favdel"><i class="fa fa-list" aria-hidden="true"></i>欲しいものリストから削除</button>' );


    }else if(fav_count == 0){
      console.log(fav_count);
      $("div.favadddel").replaceWith( '<button id="buttonother" class="btn jb2 jfont" type="submit" name="favadd"><i class="fa fa-list" aria-hidden="true"></i>欲しいものリストに追加</button>' );
    }
  });

  // $(function(){
  //   $("#header1").load("header.html");
  // });




  // var fav_count = 0;
  $(document).ready(function(){
  //chackagree
  $('input[value="1"]:radio').one('click', function(){
    $("div.aa1").replaceWith( '<button id="buttonother" class="btn jb" type="submit" name="buy">購入確定</button>' );
  });
  $('input[value="0"]:radio').one('click', function(){
    $("div.aa1").replaceWith( '<button id="buttonother" class="btn jb" type="submit" name="buy" disabled="disabled">購入確定</button>' );
  });
  $('input[value="1"]:radio').on('click', function(){
    $("button.jb").replaceWith( '<button id="buttonother" class="btn jb" type="submit" name="buy">購入確定</button>' );
  });
  $('input[value="0"]:radio').on('click', function(){
    $("button.jb").replaceWith( '<button id="buttonother" class="btn jb" type="submit" name="buy" disabled="disabled">購入確定</button>' );
  });

  //if have favorite_list checked

    //header
    $('#target').load('header.html');
    console.log("a");

    //active menu
    $(document).on("scroll", onScroll);

    $('a[href^="#"]').on('click', function (e) {
      e.preventDefault();
      $(document).off("scroll");

      $('a').each(function () {
        $(this).removeClass('active');
      })
      $(this).addClass('active');

      var target = this.hash;
      $target = $(target);
      $('html, body').stop().animate({
        'scrollTop': $target.offset().top+2
      }, 500, 'swing', function () {
        window.location.hash = target;
        $(document).on("scroll", onScroll);
      });
    });


    //scroll js
    smoothScroll.init({
      selector: '[data-scroll]', // Selector for links (must be a valid CSS selector)
      selectorHeader: '[data-scroll-header]', // Selector for fixed headers (must be a valid CSS selector)
      speed: 500, // Integer. How fast to complete the scroll in milliseconds
      easing: 'easeInOutCubic', // Easing pattern to use
      updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
      offset: 0, // Integer. How far to offset the scrolling anchor location in pixels
      callback: function ( toggle, anchor ) {} // Function to run after scrolling
    });

    //menu
    // var bodyEl = document.body,
    // content = document.querySelector( '.content-wrap' ),
    // openbtn = document.getElementById( 'open-button' ),
    // closebtn = document.getElementById( 'close-button' ),
    // isOpen = false;
    //
    // function inits() {
    //   initEvents();
    // }
    //
    // function initEvents() {
    //   openbtn.addEventListener( 'click', toggleMenu );
    //   if( closebtn ) {
    //     closebtn.addEventListener( 'click', toggleMenu );
    //   }

      // close the menu element if the target it´s not the menu element or one of its descendants..
    //   content.addEventListener( 'click', function(ev) {
    //     var target = ev.target;
    //     if( isOpen && target !== openbtn ) {
    //       toggleMenu();
    //     }
    //   } );
    // }

    // function toggleMenu() {
    //   if( isOpen ) {
    //     classie.remove( bodyEl, 'show-menu' );
    //   }
    //   else {
    //     classie.add( bodyEl, 'show-menu' );
    //   }
    //   isOpen = !isOpen;
    // }

    // inits();


    console.log("c");
    //typed js
    $(".typed").typed({
        strings: fnList,
        typeSpeed: 100,
        backDelay: 900,
        // loop
        loop: true
    });

    //owl carousel
    $('.owl-carousel').owlCarousel({
      autoPlay: 3000, //Set AutoPlay to 3 seconds

      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1],
      itemsTablet : [768,1],
      itemsMobile : [479,1],

      // CSS Styles
      baseClass : "owl-carousel",
      theme : "owl-theme"
    });

    $('.owl-carousel2').owlCarousel({
      autoPlay: 3000, //Set AutoPlay to 3 seconds

      items : 1,
      itemsDesktop : [1199,1],
      itemsDesktopSmall : [979,1],
      itemsTablet : [768,1],
      itemsMobile : [479,1],
      autoPlay : false,

      // CSS Styles
      baseClass : "owl-carousel",
      theme : "owl-theme"
    });

    //contact
    $('input').blur(function() {

      // check if the input has any value (if we've typed into it)
      if ($(this).val())
        $(this).addClass('used');
      else
        $(this).removeClass('used');
    });

    //pop up porfolio
    $('.portfolio-image .show-imgs li a').magnificPopup({
      type: 'image',
      gallery: {
        enabled: true
      }
      // other options
    });

    //Skill
    jQuery('.skillbar').each(function() {
      jQuery(this).appear(function() {
        jQuery(this).find('.count-bar').animate({
          width:jQuery(this).attr('data-percent')
        },3000);
        var percent = jQuery(this).attr('data-num');
        jQuery(this).find('.count').html('<span>' + percent + '</span>');
      });
    });
    // jQuery('.skillbar').each(function() {
    //   jQuery(this).appear(function() {
    //     jQuery(this).find('.count-bar').animate({
    //       width:jQuery(this).attr('data-percent')
    //     },3000);
    //     var percent = jQuery(this).attr('data-percent');
    //     jQuery(this).find('.count').html('<span>' + percent + '</span>');
    //   });
    // });


  });


  //header
  function inits() {
    window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 300,
            header = document.querySelector(".for-sticky");
        if (distanceY > shrinkOn) {
            classie.add(header,"opacity-nav");
        } else {
            if (classie.has(header,"opacity-nav")) {
                classie.remove(header,"opacity-nav");
            }
          }
      });
    }

  window.onload = inits();

  //nav-active
  function onScroll(event){
    var scrollPosition = $(document).scrollTop();
    $('.menu-list a').each(function () {
      var currentLink = $(this);
      var refElement = $(currentLink.attr("href"));
      if (refElement.position().top <= scrollPosition && refElement.position().top + refElement.height() > scrollPosition) {
        $('.menu-list a').removeClass("active");
        currentLink.addClass("active");
      }
      else{
        currentLink.removeClass("active");
      }
    });
  }


})(jQuery);
