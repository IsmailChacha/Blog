  <!-- Admin content wrapper-->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
      </div>

      <h2 class="page-title"><?php echo $heading ?? '';?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

      <form action="<?php echo BASE_URL.'/private/index.php/searchuser';?>" method="post">
        <div>
          <input type="email" name="email" class="text-input" placeholder = "Enter email" value="<?php echo $email ?? '';?>">
        </div>

        <div>
          <button type="submit" name="" class="btn btn-big">Search user</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->