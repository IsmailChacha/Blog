  <!-- Admin content -->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/index.php/addpost';?>" class="btn btn-big">Add Article</a>
        <a href="<?php echo BASE_URL . '/index.php/manageposts';?>" class="btn btn-big">Manage Articles</a>
      </div>

      <h2 class="page-title"><?php echo $heading; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
      
      <form action="<?php echo BASE_URL . '/private/index.php/editarticle';?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="post[Id]" value="<?php echo $id ?? '' ?>">
        <input type="hidden" name="post[String]" value="<?php echo $string ?? '' ?>">
        <div>
          <label for="title">Title</label><br />
          <p id="statusMessage"></p>
          <input type="text" name="post[Title]" id="title" class="text-input" value="<?php echo $title  ?? '' ;?>" maxlength="50">
        </div>
        <div>
          <label for="body">Body</label><br />
          <textarea name="post[Body]" id="body"><?php echo $body ?? '' ;?></textarea> <br /><br />
          <!--<script>
            CKEDITOR.replace( 'body' );
          </script>-->
          <label for="description">Description</label><br />
          <textarea name="post[Description]" id="body" class="text-input"><?php echo $description ?? ''; ?></textarea>

          <label for="keywords">Keywords</label><br />
          <input type="text" name="post[Keywords]" class="text-input"value="<?php echo $keywords ?? '' ;?>"/>
        </div>
        <div>
          <label for="image">Image</label>
          <input type="file" name="image_name" id="" class="text-input">
        </div>
        <div>
        <label for="topic">Select categories for this post:</label><br /><br />
            <?php foreach ($categories as $category): ?>
              <?php if(isset($post)): ?>
                <?php if($post && $post->belongsToCategory($category->Id)): ?>
                <input type="checkbox" name="category[]" value="<?=$category->Id?>" checked/>
                <label><?=$category->Name?></label> &nbsp;&nbsp;
                <?php else: ?>
                  <input type="checkbox" name="category[]" value="<?=$category->Id?>"/>
                  <label><?=$category->Name?></label> &nbsp;&nbsp;
                <?php endif; ?>
              <?php else: ?>
                <input type="checkbox" name="category[]" value="<?=$category->Id?>"/>
                <label><?=$category->Name?></label> &nbsp;&nbsp;
              <?php endif; ?>
            <?php endforeach; ?>
        </div>
        </div>
        <div>
          <?php if(empty($published)):?>
            <input type="checkbox" name="post[Published]" value="1" id="" class="w3-check" disabled>
            <label for="published">Published </label><br /><br />
          <?php else:?>
            <input type="checkbox" name="post[Published]" value="1" id="" class="w3-check" checked disabled>
            <label for="published">Published </label><br /><br />
          <?php endif;?>
        </div>
        <div>
          <button type="submit" name="edit" class="btn btn-big" value="Save">Publish</button>
          <button type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>
          <button type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->