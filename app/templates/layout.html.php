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

  <!-- Font awesome Icons-->
  <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.css';?>" rel="stylesheet"> <!--load all styles -->
  <!-- Custom styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css';?>">
  <!-- Google fonts web -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"> 
  <!--font-family: 'Lato', sans-serif;-->
  <!-- Slick css styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . '/assets/libraries/slick-1.8.1/slick/slick.css'; ?>" />
   <!-- Add the new slick-theme.css if you want the default styling -->
  <!-- <link rel="stylesheet" type="text/css" href="./libraries/slick-1.8.1/slick/slick-theme.css" /> -->

  <!-- PRISM -->
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . '/assets/prism/prism.css';?>">
  <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
  <pre class="language-markup"><code>...</code></pre>

</head>

<body>
<?php
//HEADER FILE
include ROOT_PATH . '/app/helpers/header.php';
?>

<main>
  <div class="navigation">
    <?php foreach($_GET['navigationLink'] as $key => $value):?>
      <a href="<?php echo $key?>"><?php echo $value . '&raquo;'; ?></a>
    <?php endforeach;?>
  </div>
  <i class="fas fa-arrow-up" id="scroll-arrow"></i>
  <?php echo $output; ?>

</main>

<?php
//FOOTER FILE
include ROOT_PATH . '/app/helpers/footer.php';
?>

  <!-- SCRIPTS -->
  <!-- Dont forget to add jQuery cdn link when you deploy -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- Custom scripts -->
  <script src="<?php echo BASE_URL . '/assets/js/scripts.js'; ?>"></script>

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js'; ?>"></script>

  <!-- Slick Carousel jQuery Plugin-->
  <script type="text/javascript" src="assets/libraries/slick-1.8.1/slick/slick.min.js"></script>
  <script>
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
  </script>
</body>
</html>