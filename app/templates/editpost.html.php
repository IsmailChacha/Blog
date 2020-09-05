<div class="content">
  <div class="button-group">
  </div>

  <h2 class="page-title"><?php echo $heading; ?></h2>
  <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
  <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
  
  <form action="<?php echo BASE_URL . '/private/index.php/editarticle';?>" method="post" enctype="multipart/form-data" id="editpost">
    <input type="hidden" name="post[Id]" value="<?php echo $id ?? '' ?>">
    <input type="hidden" name="post[String]" value="<?php echo $string ?? '' ?>">
    <div>
      <label for="title">Title</label><br />
      <p id="statusMessage"></p>
      <input type="text" name="post[Title]" id="title" class="text-input" value="<?php echo $title  ?? '' ;?>" maxlength="70"><br /><br />
    </div>
    <div>
      <label for="body">Body</label><br /><br />
      <textarea name="post[Body]" class="text-input"><?php echo $body ?? '' ;?></textarea> <br /><br />
      <!--<script>
        CKEDITOR.replace( 'body' );
      </script>-->
      <label for="description">Description</label><br /><br />
      <textarea name="post[Description]" class="text-input"><?php echo $description ?? ''; ?></textarea><br /><br />

      <label for="keywords">Keywords</label><br /><br />
      <textarea name="post[Keywords]" class="text-input"><?php echo $keywords ?? '' ;?></textarea><br /><br />
    </div>
    <div>
      <label for="image">Image</label><br /><br />
      <input type="file" name="image_name" id="" class="text-input"><br />
    </div>
  </form>
</div>

<!-- CONTROLS -->
<div class="admin-controls-container">
<div class="admin-controls">
<form action="<?php echo BASE_URL . '/private/index.php/editpost';?>" method="post" enctype="multipart/form-data">
  <div>
  <label for="topic">Select categories for this post:</label><br /><br />

    <?php foreach ($categories as $category): ?>
      <?php if(isset($post)): ?>
        <?php if($post && $post->belongsToCategory($category->Id)): ?>
        <input type="checkbox" name="category[]" value="<?=$category->Id?>" checked/>
        <label><?=$category->Name?></label> &nbsp;&nbsp;
        <?php else: ?>
          <input type="checkbox" form="editpost" name="category[]" value="<?=$category->Id?>"/>
          <label><?=$category->Name?></label> &nbsp;&nbsp;
        <?php endif; ?>
      <?php else: ?>
        <input type="checkbox" form="editpost" name="category[]" value="<?=$category->Id?>"/>
        <label><?=$category->Name?></label> &nbsp;&nbsp;
      <?php endif; ?>
    <?php endforeach; ?><br /><br />
  </div>
  <div>
    <?php if(empty($published)):?>
      <input type="checkbox" form="editpost" name="post[Published]" value="1" id="" class="w3-check" disabled>
      <label for="published">Published </label>
    <?php else:?>
      <input type="checkbox" form="editpost" name="post[Published]" value="1" id="" class="w3-check" checked disabled>
      <label for="published">Published </label>
    <?php endif;?>
  </div>
  <div>
  <?php if($_SESSION['Superuser']):?>
    <button form="editpost" type="submit" name="edit" class="btn btn-big" value="edit">Publish</button>
    <button form="editpost" type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>
    <!-- <button form="editpost" type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button> -->
  <?php elseif($_SESSION['Admin']):?>
    <button form="editpost" type="submit" name="draft" class="btn btn-big" value="Save">Save</button>
    <!-- <button form="editpost" type="submit" name="preview" class="btn btn-big" value="Preview">Preview</button> -->
  <?php endif;?>
  </div>
</form>
</div>