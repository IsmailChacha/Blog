<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-177395620-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-177395620-1');
        </script>
        <script data-ad-client="ca-pub-3063889868488382" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NSSB3P2');</script>
        <!-- End Google Tag Manager -->
        <!--reCaptcha-->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        
        <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?php echo $keywords;?>">
        <meta name="description" content="<?php echo $description;?>">
        <meta name="author" content="<?php echo $authorName;?>">
        <meta http-equiv="refresh" content="10000"> 
        <meta property="og:title" content="<?php echo $title; ?>">
        <meta property="og:image" content="<?php echo $featuredImage ;?>">
        <meta property="og:description" content="<?php echo $description;?>">
        <meta property="og:url" content="<?php echo 'https://thelinuxpost.com' . $_SERVER['REQUEST_URI'];?>">
        <meta name="twitter:card" content="summary_large_image">
        <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.css';?>" rel="stylesheet"/>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css';?>" id="theme-link"/>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"/> 
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/prism/prism.css';?>">
        <link rel="favicon" href="<?php echo $featuredImage ;?>">
        
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NSSB3P2"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php 
            $exceptionPages = ['/signin', '/signup'];
        ?>
        <?php 
            include ROOT_PATH . '/app/helpers/header.php';
        ?>
        <main class="page-wrapper">
            <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_default_style " data-a2a-scroll-show="150,60" style="bottom:0px; left:0px;">
                <a class="a2a_button_facebook"></a>
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_whatsapp"></a>
                <a class="a2a_button_pinterest"></a>
                <!--<a class="a2a_dd" href="https://www.addtoany.com/share"></a>-->
            </div>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0" nonce="QCPHup8t"></script>
            <!-- //JavaScript SDK For Facebook Page-->
            <div id="mpopupBox" class="mpopup">
                <div class="mpopup-content">
                    <div class="mpopup-head">
                    <span class="close">X</span>
                    <h3 class="">Join our newsletter</h3>
                    <p>Be the first to receive new blogs directly to your mailbox</p>
                    </div>
                <div class="mpopup-main">
                    <div class="">
                        <br />
                        <form action="/mailinglist" method="post">
                            <input type="text" name="newsletter[name]" class="text-input contact-input" placeholder="Name">
                            <input type="email" name="newsletter[email]" class="text-input contact-input" placeholder="Email">
                            <button type="submit" class="btn btn-big contact-btn"> Subscribe </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php 
                if(!in_array($_SERVER['REQUEST_URI'], $exceptionPages))
                {
                    require 'app/helpers/navbar.html.php';
                }
                
            ?>
            <?php echo $output; ?>
        </main>
        <?php 
            include ROOT_PATH . '/app/helpers/footer.php';
        ?>
        
        <!--Loader-->
        <div class="loader">
            <img src="/loader2.gif" title="Loader"/>
        </div> 
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="<?php echo BASE_URL . '/assets/jquery/jquerycookie/jquery.cookie.js'?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.AreYouSure/1.9.0/jquery.are-you-sure.min.js"></script>
        <script src="<?php echo BASE_URL . '/assets/js/forms.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/smoothscroll.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/emaillist.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/openclosesidenav.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/closeNotifications.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/updateCode.js'; ?>"></script> 
        <script src="<?php echo BASE_URL . '/assets/js/theme-handler.js'; ?>"></script> 
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <script> // var a2a_config = a2a_config || {}; // a2a_config.track_links = 'ga';</script>
        
    </body>
</html>