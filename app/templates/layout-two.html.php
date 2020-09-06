<!DOCTYPE html>
<html lang="en" class="hide-scroll-bar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="<?php echo $keywords ?? '';?>">
  <meta name="description" content="<?php echo $description ?? '';?>">
  <meta name="author" content="<?php echo $authorName ?? 'Ismail Chacha';?>">
  
  <title><?php echo $title; ?></title>

  <!-- Font awesome Icons-->
  <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.min.css';?> " rel="stylesheet">

  <!-- Custom styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>">
  
  <!-- Admin styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/admin.css'; ?>">

  <!-- TINYMCE CDN -->
  <script src="https://cdn.tiny.cloud/1/njws75lq3200zpiulso28at7bkoi4ws0tqp8k2kyk06x883j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"> 
  <!--font-family: 'Lato', sans-serif;-->
  
   <!-- PRISM -->
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . '/assets/prism/prism.css';?>">

</head>
<body>
  <!-- Admin Header -->
    <?php require_once(ROOT_PATH. '/app/helpers/admin-header.php');?>
  <!-- //Admin Header -->

  <!-- Admin page wrapper -->
  <div class="admin-wrapper">
  <i class="fas fa-chevron-circle-up" id="scroll-arrow"></i>
  
    <!-- Admin Left Sidebar -->
    <?php require_once(ROOT_PATH. '/app/helpers/superuser-sidebar.php');?>
    <!-- //Admin Left Sidebar -->

    
    <!-- Admin content -->
    <div class="admin-content hide-scroll-bar">
      <!-- GENERATED CONTENT -->
        <?php echo $output; ?>
      <!--// GENERATED CONTENT -->
    </div>
    <!-- Admin content -->

  </div>
  <!-- //Admin page wrapper -->

  <!-- Dont forget to add jQuery cdn link when you deploy
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js'; ?>"></script>

  <!-- SMOOTH SCROLL -->
  <script src="<?php echo BASE_URL . '/assets/js/smoothscroll.js'; ?>"></script>

  <!-- CLOSE NOTIFICATION MESSAGES -->
  <script src="<?php echo BASE_URL . '/assets/js/closeNotifications.js'; ?>"></script>
 
  <!-- Custom scripts -->
  <script src="<?php echo BASE_URL . '/assets/js/scripts.js';?>"></script>

  <!-- PRISM  -->
  <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
  
  <!-- TINYMCE -->
  <script src="<?php echo BASE_URL . '/assets/js/tinymce.js';?>"></script>
</body>
</html>