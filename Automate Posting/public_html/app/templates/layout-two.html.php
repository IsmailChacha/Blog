<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?php echo $keywords ?? '';?>">
        <meta name="description" content="<?php echo $description ?? '';?>">
        <meta name="author" content="<?php echo $authorName ?? 'Ismail Chacha';?>">
        <link href="<?php echo BASE_URL . '/assets/icons/font-awesome-web/css/all.min.css';?> " rel="stylesheet">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/admin.css'; ?>">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <?php require_once(ROOT_PATH. '/app/helpers/admin-header.php');?>
        <div class="admin-wrapper">
            <i class="fa fa-arrow-up" id="scroll-arrow" title="Go to the top"></i>
            <?php require_once(ROOT_PATH. '/app/helpers/superuser-sidebar.php');?>
            <div class="admin-content">
                <?php echo $output; ?>
            </div>
        </div>
        
        <!--Loader-->
        <div class="loader">
            <img src="/loader2.gif" title="Loader"/>
        </div>         
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/tt9aq3ysz1b3wdzyy7n6ng4qo9ixs8hq8whih1x6wfr86b7o/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="<?php echo BASE_URL . '/assets/js/smoothscroll.js'; ?>"></script>
        <!--<script src="<?php echo BASE_URL . '/assets/js/closeNotifications.js'; ?>"></script>-->
        <script src="<?php echo BASE_URL . '/assets/js/scripts.js';?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/openclosesidenav.js'; ?>"></script>
        <script src="<?php echo BASE_URL . '/assets/prism/prism.js';?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/tinymce.js';?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.AreYouSure/1.9.0/jquery.are-you-sure.min.js"></script>
        <script src="<?php echo BASE_URL . '/assets/js/areyousure.js';?>"></script>
    </body>
</html>