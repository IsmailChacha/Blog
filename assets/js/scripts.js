  $(document).ready(function () {
    $('.menu-toggle').on('click', function () {
      $('.nav').toggleClass('display-nav');
      $('.nav ul').toggleClass('display-nav');
    });
  });

  
  // OPENNING AND CLOSING THE SIDENAV
  const menu_toggle = document.getElementById('menu-toggle');
  menu_toggle.addEventListener('click', function openSideNav() {
    document.getElementById("sidenav").style.width = "90%";
    document.getElementById("page-wrapper").style.opacity = "0.5";
  });

  const closeSideNav = document.getElementById('closeSideNav');
  closeSideNav.addEventListener('click', function closeSideNav() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("page-wrapper").style.opacity = "1";
  });

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
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20)
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

  tinymce.init({
    selector: 'textarea',
    menu: 
    {
      file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
      edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
      view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
      insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
      format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
      tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
      table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
      help: { title: 'Help', items: 'help' }
    },
    plugins: 'a11ychecker advcode codesample casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
    toolbar: 'a11ycheck addcomment codesample showcomments casechange checklist code formatpainter pageembed permanentpen table',
    toolbar_mode: 'floating',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
  });