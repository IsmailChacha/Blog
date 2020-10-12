// $(document).ready(function () 
// {
// 	$('.menu-toggle').on('click', function () {
// 		$('.nav').toggleClass('display-nav');
// 		$('.nav ul').toggleClass('display-nav');
// 	});
// });

  // OPENNING AND CLOSING THE SIDENAV
  const menu_toggle = document.getElementById('menu-toggle');
  menu_toggle.addEventListener('click', function () 
  {
    document.getElementById("sidenav").style.transition = "all 1s";
    document.getElementById("sidenav").style.top = "0px";
  });

  const closeSideNav = document.getElementById('closeSideNav');
  closeSideNav.addEventListener('click', function () 
  {
    document.getElementById("sidenav").style.transition = "all 1s";
    document.getElementById("sidenav").style.top = "-1000px";
  });
  
   //spinner/loader
  const loader = document.querySelector(".loader");
  window.addEventListener("load", (event) => {
      loader.classList.add("hidden");
  });
        