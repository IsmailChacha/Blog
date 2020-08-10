$(document).ready(function () {
  $('.menu-toggle').on('click', function () {
    $('.nav').toggleClass('display-nav');
    $('.nav ul').toggleClass('display-nav');
  });

// Slick Carousel
  $('.post-wrapper').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    nextArrow: $('.next'),
    prevArrow: $('.prev'),
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }
      // You can unslick at a given point by adding 
      // settings: "unslick" 
      // instead of a settings object
    ]

  });
});

  // OPENNING AND CLOSING SIDENAV
  function openSideNav() {
    document.getElementById("sidenav").style.width = "90%";
    document.getElementById("page-wrapper").style.opacity = "0.5";
  }

  function closeSideNav() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("page-wrapper").style.opacity = "1";
  }