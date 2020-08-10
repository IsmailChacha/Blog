<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="<?php echo $keywords ?? '';?>">
  <meta name="description" content="<?php echo $description ?? '';?>">
  <meta name="author" content="<?php //echo $post->getAuthor()->FirstName ?? ''. ' ' . $post->getAuthor()->LastName ?? '';?>">
  
  <title><?php echo $title; ?></title>

  <!-- Font awesome Icons-->
  <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.min.css';?> " rel="stylesheet">

  <!-- Custom styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>">

  <!-- Admin styles -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/admin.css'; ?>">

  <!-- CKEditor 5 CDN -->
  <!--<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>-->

  <!-- TINY MCE CDN -->
  <script src="https://cdn.tiny.cloud/1/njws75lq3200zpiulso28at7bkoi4ws0tqp8k2kyk06x883j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;1,300&display=swap" rel="stylesheet"> 
  <!--font-family: 'Lato', sans-serif;-->
  
   <!-- PRISM -->
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . '/assets/prism/prism.css';?>">
  <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
  <pre class="language-markup"><code></code></pre>

</head>
<body>
  <!-- Admin Header -->
    <?php require_once(ROOT_PATH. '/app/helpers/admin-header.php');?>
  <!-- //Admin Header -->

  <!-- Admin page wrapper -->
  <div class="admin-wrapper">
    <i class="fas fa-arrow-up" id="scroll-arrow"></i>
  
    <!-- Admin Left Sidebar -->
    <?php require_once(ROOT_PATH. '/app/helpers/superuser-sidebar.php');?>
    <!-- //Admin Left Sidebar -->

    
    <!-- GENERATED CONTENT -->

    <?php echo $output?>

    <!-- //GENERATED CONTENT -->

  </div>
  <!-- //Admin page wrapper -->

  <!-- Dont forget to add jQuery cdn link when you deploy -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- jQuery || To be removed during deployment-->
  <script src="<?php echo BASE_URL . '/assets/libraries/jquery-3.5.1.js'; ?>"></script>

  <!-- Custom scripts -->
  <script src="<?php echo BASE_URL . '/assets/js/scripts.js'; ?>"></script>
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