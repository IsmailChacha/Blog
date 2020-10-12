const toggler = document.querySelector(".theme-toggler");
if(toggler !== null)
{
    toggler.addEventListener("click", (event) => {
        const themeLink = document.querySelector("#theme-link");
        if(themeLink.getAttribute("href") == "https://thelinuxpost.com/assets/css/style.css")
        {
            themeLink.href = setTP("https://thelinuxpost.com/assets/css/dark-theme.css");
            toggler.innerHTML = '<i class="fas fa-sun"></i>';
        } else 
        {
            themeLink.href = setTP("https://thelinuxpost.com/assets/css/style.css");
            toggler.innerHTML = '<i class="fas fa-moon"></i>';
        }
    }); 
}

// check localStorage
(function checkLocalStorage()
{
    if(window.localStorage) //check if supported
    {
       const themeLink = document.querySelector("#theme-link");
       if(localStorage.getItem("theme")) //check if theme preference already exists
       {
           themeLink.href = localStorage.getItem("theme");
           const toggler = document.querySelector(".theme-toggler");
           if(themeLink.href == "https://thelinuxpost.com/assets/css/dark-theme.css")
           {
                toggler.innerHTML = '<i class="fas fa-sun"></i>';
           } else
           {
            toggler.innerHTML = '<i class="fas fa-moon"></i>';
           }
       } else 
       {
           themeLink.href = "https://thelinuxpost.com/assets/css/style.css"; //default theme
       }
    }
}());


function setTP(theme) //set theme preference
{
    if(window.localStorage) //check if supported
    {
      
       localStorage.setItem("theme", theme);
       return theme;
    }
}