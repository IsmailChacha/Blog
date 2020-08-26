  <!-- Admin content -->
  <div class="admin-content">
    <div class="content">
      <div class="button-group">
      </div>

      <h2 class="page-title"><?php echo $heading ?? ''; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

      <form action="<?php echo BASE_URL.'/private/index.php/addtopic';?>" method="post">
        <div>
          <label for="name">Name</label><br /><br />
          <input type="text" name="topic[name]" id="" class="text-input" value="<?php echo $Name ?? ''; ?>"><br /><br />
        </div>
        <div>
          <label for="description">Description</label><br /><br />
          <textarea name="topic[description]" class="text-input" id="body"><?php echo $Description ?? ''; ?></textarea><br /><br />
        </div>
        <div>
          <button type="submit" name="add" class="btn btn-big">Add Topic</button>
        </div>
      </form>
    </div>
  </div>
