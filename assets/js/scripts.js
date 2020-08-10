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

  // SMOOTH SCROLL
  $(document).ready(function(){
    // Add smooth scrolling to all links
    $("#scroll-arrow").on('click', function(event) {
  
      // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") {
        // Prevent default anchor click behavior
        event.preventDefault();
  
        // Store hash
        let hash = this.hash;
  
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){
     
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
      } // End if
    });
  });

  // GET THE SCROLL BUTTON
  const myScrollButton = document.getElementById("scroll-arrow");
  // WHEN THE USER SCROLLS DOWN 20px FROM THE TOP, SHOW THE BUTTON
  window.onscroll = function(){scrollFunction()};

  function scrollFunction()
  {
    if(document.body.scrollTop > 40 || document.documentElement.scrollTop > 40)
    {
      myScrollButton.style.display = "block";
    } else 
    {
      myScrollButton.style.display = "none";
    }
  }


  myScrollButton.addEventListener('click', topFunction);

  function topFunction()
  {
    document.scrollTop = 0; //For Safari
    document.documentElement.scrollTop = 0; //For Chrome, IE and Opera
  }
