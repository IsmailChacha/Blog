	$(document).ready(function () 
	{
		$('.menu-toggle').on('click', function () {
			$('.nav').toggleClass('display-nav');
			$('.nav ul').toggleClass('display-nav');
		});
	});

  // OPENNING AND CLOSING THE SIDENAV
  const menu_toggle = document.getElementById('menu-toggle');
  menu_toggle.addEventListener('click', function () 
  {
    document.getElementById("sidenav").style.width = "90%";
    document.getElementById("page-wrapper").style.opacity = "0.5";
  });

  const closeSideNav = document.getElementById('closeSideNav');
  closeSideNav.addEventListener('click', function () 
  {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("page-wrapper").style.opacity = "1";
  });