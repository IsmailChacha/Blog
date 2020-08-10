  <!-- Admin content -->
  <div class="admin-content">


    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL.'/private/index.php/addtopic';?>" class="btn btn-big">Add Topic</a>
        <a href="<?php echo BASE_URL.'/private/index.php/managetopics';?>" class="btn btn-big">Manage Topics</a>
      </div>

      <h2 class="page-title"><?php echo $heading ?? ''; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

      <form action="<?php echo BASE_URL.'/private/index.php/addtopic';?>" method="post">
        <div>
          <label for="name">Name</label>
          <input type="text" name="topic[name]" id="" class="text-input" value="<?php echo $Name ?? ''; ?>">
        </div>
        <div>
          <label for="description">Description</label>
          <textarea name="topic[description]" id="body"><?php echo $Description ?? ''; ?></textarea>
        </div>
        <div>
          <button type="submit" name="add" class="btn btn-big">Add Topic</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->