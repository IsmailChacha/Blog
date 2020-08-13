  <!-- Admin content -->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/index.php/manageposts';?>" class="btn btn-big">Manage Articles</a>
      </div>

      <h2 class="page-title"><?php echo $heading; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
      
      <form action="<?php echo BASE_URL . '/index.php/addpost';?>" method="post" enctype="multipart/form-data">
        <div>
          <label for="title">Title</label><br /><br />
          <input type="text" name="post[Title]" id="" class="text-input" value="<?php echo $title  ?? '' ;?>">
        </div>
        <div>
          <label for="body">Body</label><br />
          <textarea name="post[Body]" id="body"><?php echo $body ?? '' ;?></textarea> <br /><br />
          <!--<script>
            CKEDITOR.replace( 'body' );
          </script>-->
          <label for="description">Description</label>
          <textarea name="post[Description]" id="body" class="text-input"><?php echo $description ?? ''; ?></textarea>

          <label for="keywords">Keywords</label>
          <input type="text" name="post[Keywords]" class="text-input"value="<?php echo $Keywords ?? '' ;?>"/>
        </div>
        <div>
          <label for="image">Image</label><br /><br />
          <input type="file" name="Image" id="" class="text-input">
        </div>
        <div>
          <label for="topic">Select categories for this post:</label><br /><br />
            <?php foreach ($categories as $category): ?>
              <input type="checkbox" name="category[]" value="<?=$category->Id?>" />
              <label><?=$category->Name?></label> &nbsp;&nbsp;
            <?php endforeach; ?>
        </div>
        <div>
          <?php if(empty($published)):?>
            <input type="checkbox" name="post[Published]" value="1" id="" class="w3-check" disabled>
            <label for="published">Published </label>
          <?php else:?>
            <input type="checkbox" name="post[Published]" value="1" id="" class="w3-check" checked disabled>
            <label for="published">Published </label>
          <?php endif;?>
        </div>
        <div>
          <button type="submit" name="add" class="btn btn-big" value="add">Publish</button>
          <button type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>
          <button type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->