<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="<?php echo $keywords;?>">
  <meta name="description" content="<?php echo $description;?>">
  <meta name="author" content="<?php echo $authorName;?>">
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
  <pre><code class="language-xxxx">...</code></pre>

</head>

<body>

<!-- HEADER FILE -->
  <?php include ROOT_PATH . '/app/helpers/header.php'; ?>
<!-- //HEADER FILE -->

<main>

  <div class="navigation">
    <?php foreach($_GET['navigationLink'] as $key => $value):?>
      <?php if($key == $_GET['currentPage']):?>
        <a class="activeLink" href="<?php echo $key?>"><?php echo $value . '&raquo;'; ?></a>
      <?php else:?>
        <a href="<?php echo $key?>"><?php echo $value . '&raquo;'; ?></a>
      <?php endif;?>
    <?php endforeach;?>
  </div>

  <i class="fas fa-arrow-up" id="scroll-arrow" title="Go to the top"></i>

  <!-- GENERATED CONTENT -->
    <?php echo $output; ?>
  <!--// GENERATED CONTENT -->

</main>

<!-- FOOTER FILE -->
  <?php include ROOT_PATH . '/app/helpers/footer.php';?>
<!-- //FOOTER FILE -->

  <!-- SCRIPTS -->
  <!-- jQuery-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- Custom scripts -->
  <script src="<?php echo BASE_URL . '/assets/js/scripts.js'; ?>"></script>

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js';?>"></script>
    
  <!--  PRISM-->
  <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
  <!-- <script src="https://myCDN.com/prism@v1.x/components/prism-okaidia.min.js"></script>
	<script src="https://myCDN.com/prism@v1.x/plugins/autoloader/prism-autoloader.min.js"></script> -->
</body>
</html>