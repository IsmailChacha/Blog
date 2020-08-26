<?php header('HTTP/1.0 404 Not Found'); ?>
<?php include 'path.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="<?php echo 'Ismail Chacha';?>">
  <title><?php echo 'MINDSJOURNAL'; ?></title>
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css';?>"/>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"/> 
  <!--font-family: 'Lato', sans-serif;-->

</head>
<body>
<?php include ROOT_PATH . '/app/helpers/404header.php'; ?>

<div class="NotFound page-wrapper" style="position: relative;top: 66px;">
	<i class="fa fa-chevron-up chevron-up" id="scroll-arrow" title="Go to the top"></i>
	<!-- Page wrapper -->
	<div class="page-wrapper">
			<div class="content clearfix col-3">
          <h1 class="post-title errorpage">404</h1>
          <h2 class="fourofour"><?php echo 'PAGE NOT FOUND'; ?></h2>
			</div>
	</div>
		<!-- //Page wrapper-->
</div>

  <!-- SCRIPTS -->
  <!-- jQuery-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js';?>"></script>
    
  <!-- SMOOTH SCROLL -->
  <script src="<?php echo BASE_URL . '/assets/js/smoothscroll.js'; ?>"></script>
</body>
</html>