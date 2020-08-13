  
  // SMOOTH SCROLL
  $(document).ready(function()
  {
    // Add smooth scrolling to all links
    $("#scroll-arrow").on('click', function(event) 
    {
      // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") 
      {
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
  window.onscroll = function()
  {
    scrollFunction();
  };

  function scrollFunction()
  {
    if(document.body.scrollTop >= 20 || document.documentElement.scrollTop >= 20)
    {
      myScrollButton.style.display = " block";
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