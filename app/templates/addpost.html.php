  <!-- Admin content -->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/index.php/manageposts';?>" class="btn btn-big">Manage Articles</a>
        <a href="<?php echo BASE_URL . '/private/index.php/drafts';?>" class="btn btn-big">Drafts</a>
      </div>

      <h2 class="page-title"><?php echo $heading; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
      
      <form action="<?php echo BASE_URL . '/private/index.php/addpost';?>" method="post" enctype="multipart/form-data">
        <div>
          <label for="title">Title</label><br /><br />
          <p id="statusMessage"></p>
          <input type="text" name="post[Title]" id="title" class="text-input" value="<?php echo $title  ?? '';?>" maxlength="70">
        </div>
        <div>
          <label for="body">Body</label><br /><br />
          <textarea name="post[Body]" id="body" class="text-input"><?php echo $body ?? '' ;?></textarea> <br /><br />
          <!--<script>
            CKEDITOR.replace( 'body' );
          </script>-->
          <label for="description">Description</label><br /><br />
          <textarea name="post[Description]" class="text-input"><?php echo $description ?? ''; ?></textarea><br /><br />

          <label for="keywords">Keywords</label><br /><br />
          <textarea name="post[Keywords]" class="text-input"><?php echo $keywords ?? '' ;?></textarea>
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
        <?php if($_SESSION['Superuser']):?>
          <button type="submit" name="add" class="btn btn-big" value="add">Publish</button>
          <button type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>
          <!-- <button type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button> -->
        <?php elseif($_SESSION['Admin']):?>
          <button type="submit" name="draft" class="btn btn-big" value="Save">Save</button>
          <!-- <button type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button> -->
        <?php endif;?>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->