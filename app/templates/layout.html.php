<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="<?php echo $keywords;?>">
  <meta name="description" content="<?php echo $description;?>">
  <meta name="author" content="<?php echo $authorName;?>">
  <link rel="favicon" href="/favicon.ico">
  <!-- <meta http-equiv="refresh" content="120"> -->
  
  <title><?php echo $title; ?></title>

  <!-- Font Awesome Icons-->
  <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.css';?>" rel="stylesheet"/>

  <!-- Custom styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css';?>"/>

  <!-- Google fonts web -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"/> 
  <!--font-family: 'Lato', sans-serif;-->

  <!-- PRISM -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/prism/prism.css';?>">
  <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>

</head>

<body>

<!-- HEADER FILE -->
<?php 
    include ROOT_PATH . '/app/helpers/header.php'; 
?>
<!-- //HEADER FILE -->

<div class="page-wrapper">
  <!-- JavaScript SDK For Facebook Page-->
  <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0"
      nonce="QCPHup8t"></script>
  <!-- //JavaScript SDK For Facebook Page-->

  <!-- mPopup box -->
  <div id="mpopupBox" class="mpopup">
      <!-- mPopup content -->
    <div class="mpopup-content">
        <div class="mpopup-head">
            <span class="close">X</span>
            <h3 class="">Join our newsletter</h3>
            <p>Be the first to receive new blogs directly to your mailbox</p>
        </div>
        <div class="mpopup-main">
          <!-- Join Our News Letter -->
          <div class="">
            <br />
              <form action="/index.php/mailinglist" method="post">
                <input type="text" name="newsletter[name]" class="text-input contact-input" placeholder="Name">
                <input type="email" name="newsletter[email]" class="text-input contact-input" placeholder="Email">
                <button type="submit" class="btn btn-big contact-btn"> Subscribe </button>
              </form>
          </div>
        </div>
        <!-- <div class="mpopup-foot">
        </div> -->
    </div>
  </div>

  <!-- BREADCRUMBS -->
  
  <!-- <?php $exceptionPages = ['/index.php/signin', '/index.php/signup']; ?>
    
  <?php if(!in_array($_GET['currentPage'], $exceptionPages)): ?>
    <div class="navigation">
      <?php $i = 0; ?>
      <?php foreach($_GET['navigationLink'] as $key => $value):?>
        <?php if($i === 0): ?>
          <?php if($key == $_GET['currentPage']):?>
            <a class="activeLink" href="<?php echo $key?>"><?php echo ucfirst($value); ?></a>
          <?php else:?>
            <a href="<?php echo $key?>"><?php echo ucfirst($value); ?></a>
          <?php endif;?>
        <?php else:?>
          <?php if($key == $_GET['currentPage']):?>
          <a class="activeLink" href="<?php echo $key?>"><?php echo '/ ' . ucfirst($value); ?></a>
          <?php else:?>
            <a href="<?php echo $key?>"><?php echo  '/ ' . ucfirst($value); ?></a>
          <?php endif;?>
        <?php endif ;?>
        <?php $i++; ?>
      <?php endforeach;?>
    </div>
  <?php endif; ?> -->
  
  <!-- BREADCRUMBS -->
  
  <!-- <i class="fa fa-chevron-up chevron-up" id="scroll-arrow" title="Go to the top"></i> -->
  <i class="fas fa-chevron-circle-up" id="scroll-arrow"></i>

  <!-- GENERATED CONTENT -->
    <?php echo $output; ?>
  <!--// GENERATED CONTENT -->
  
  <!-- <pre><code></code></pre> -->

  <!-- FOOTER FILE -->
  <?php 
      include ROOT_PATH . '/app/helpers/footer.php'; 
  ?>
  <!-- //FOOTER FILE -->
</div>


  <!-- SCRIPTS -->
  <!-- jQuery-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js';?>"></script>
    
  <!-- jQuery Cookie Plugin -->
  <script src="<?php echo BASE_URL . '/assets/jquery/jquerycookie/jquery.cookie.js'?>"></script>

  <!--  PRISM-->
  <!-- <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script> -->
  <!-- <script src="https://myCDN.com/prism@v1.x/components/prism-okaidia.min.js"></script>
  <script src="https://myCDN.com/prism@v1.x/plugins/autoloader/prism-autoloader.min.js"></script> -->
  
  <!-- SMOOTH SCROLL -->
  <script src="<?php echo BASE_URL . '/assets/js/smoothscroll.js'; ?>"></script>

  <!-- EMAIL LIST -->
  <script src="<?php echo BASE_URL . '/assets/js/emaillist.js'; ?>"></script>

  <!-- OPEN AND CLOSE SUBSCRIPTION POPUP -->
  <script src="<?php echo BASE_URL . '/assets/js/openclosesidenav.js'; ?>"></script>
 
  <!-- CLOSE NOTIFICATION MESSAGES -->
  <script src="<?php echo BASE_URL . '/assets/js/closeNotifications.js'; ?>"></script>
 
  <!-- Custom scripts -->
  <script src="<?php echo BASE_URL . '/assets/js/updateCode.js'; ?>"></script> 
</body>
</html>