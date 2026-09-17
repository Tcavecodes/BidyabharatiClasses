 (function($) {
     "use strict";


      /*======== Doucument Ready Function =========*/
    jQuery(document).ready(function () {
     //CACHE JQUERY OBJECTS
      $("#status").fadeOut();
      $("#preloader").delay(200).fadeOut("slow");
      $("body").delay(200).css({ "overflow": "visible" });

      
      /* Init Wow Js */
      new WOW().init();

    });

     /* ------------------------------------------------------------------------ */
     /* BACK TO TOP
    /* ------------------------------------------------------------------------ */
     $(document).on('click', '#back-to-top, .back-to-top', () => {
         $('html, body').animate({
             scrollTop: 0
         }, '500');
         return false;
     });
     $(window).on('scroll', () => {
         if ($(window).scrollTop() > 500) {
             $('#back-to-top').fadeIn(200);
         } else {
             $('#back-to-top').fadeOut(200);
         }
     });

    
     // Search link

    if (($('.ct-search-link')).length > 0) {
      $('.ct-search-link').on('click', function(e) {
        e.preventDefault();
        $('.ct-searchForm').addClass('is-open');
      });
      $('.ct-searchForm-close').on('click', function(e) {
        $('.ct-searchForm').removeClass('is-open');
        e.preventDefault();
      })
    }

     $('.banner-slider').slick({
      dots: false,
      infinite: true,
      speed: 1500,
      autoplay: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows:false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    $('.review-slider').slick({
      dots: true,
      arrows: false,
      infinite: true,
      speed: 800,
      autoplay: true,
      slidesToShow: 2,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    $('.review-slider2').slick({
      dots: true,
      arrows: false,
      infinite: true,
      speed: 800,
      autoplay: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    $('.review-slider3').slick({
      dots: true,
      arrows: true,
      infinite: true,
      speed: 800,
      autoplay: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

  var scene = document.getElementById('js-scene');
  if (scene) {
    var parallax = new Parallax(scene);
  }

  jQuery(document).ready(function ($) {
    if ($('.js-video-button').length > 0) {
      $('.js-video-button').modalVideo({
        channel: 'vimeo'
      });
    }

    /* ------------------------------------------------------------------------ */
    /* AUTO SCROLL FOR LATEST EVENTS & NOTICE BOARD (HOVER PAUSES)
    /* ------------------------------------------------------------------------ */
    function initTickerAutoScroll(selector, hoverWrapSelector, speed) {
      var containers = document.querySelectorAll(selector);
      if (!containers || containers.length === 0) return;

      containers.forEach(function (container) {
        if (container.dataset.autoscrollInit === 'true') return;
        container.dataset.autoscrollInit = 'true';

        var originalItems = Array.from(container.children);
        if (originalItems.length === 0) return;

        // Clone items for seamless continuous infinite looping
        originalItems.forEach(function (item) {
          var clone = item.cloneNode(true);
          clone.classList.add('en-ticker-clone');
          container.appendChild(clone);
        });

        var isPaused = false;
        var scrollPos = 0;
        var scrollSpeed = speed || 0.65; // pixels per animation frame

        function getLoopDistance() {
          var firstClone = container.children[originalItems.length];
          if (firstClone && originalItems[0]) {
            var diff = firstClone.offsetTop - originalItems[0].offsetTop;
            if (diff > 0) return diff;
          }
          return container.scrollHeight / 2;
        }

        var loopDistance = getLoopDistance();

        $(window).on('resize load', function () {
          loopDistance = getLoopDistance();
        });

        function tick() {
          if (!isPaused && !document.hidden) {
            scrollPos += scrollSpeed;
            if (loopDistance > 0 && scrollPos >= loopDistance) {
              scrollPos -= loopDistance;
            }
            container.scrollTop = scrollPos;
          } else {
            // Keep internal position synced with user scroll/wheel
            scrollPos = container.scrollTop;
          }
          requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);

        // Pause scrolling when mouse enters the container or its column card
        var hoverTarget = hoverWrapSelector ? container.closest(hoverWrapSelector) || container : container;

        hoverTarget.addEventListener('mouseenter', function () {
          isPaused = true;
        });

        hoverTarget.addEventListener('mouseleave', function () {
          isPaused = false;
          scrollPos = container.scrollTop;
        });

        // User manual wheel scroll sync
        container.addEventListener('wheel', function () {
          scrollPos = container.scrollTop;
        }, { passive: true });

        // Touch support for mobile devices
        var touchTimeout = null;
        container.addEventListener('touchstart', function () {
          isPaused = true;
          clearTimeout(touchTimeout);
        }, { passive: true });

        container.addEventListener('touchend', function () {
          clearTimeout(touchTimeout);
          touchTimeout = setTimeout(function () {
            isPaused = false;
            scrollPos = container.scrollTop;
          }, 1500);
        }, { passive: true });
      });
    }

    // Initialize auto-scrolling: Latest Events and Notice Board ticker
    initTickerAutoScroll('.en-events-list', '.en-col-wrap', 0.65);
    initTickerAutoScroll('.en-notice-list', '.en-notice-board-wrap', 0.55);
  });

})(jQuery);




