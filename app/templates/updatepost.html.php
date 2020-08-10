  <!-- Admin content -->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/index.php/addpost';?>" class="btn btn-big">Add Post</a>
        <a href="<?php echo BASE_URL . '/index.php/manageposts';?>" class="btn btn-big">Manage Posts</a>
      </div>

      <h2 class="page-title"><?php echo $heading; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
      
      <form action="<?php //echo BASE_URL . '/index.php/addpost';?>" method="post" enctype="multipart/form-data">
        <div>
          <label for="tile">Title</label>
          <input type="text" name="post[title]" id="" class="text-input" value="<?php echo $title  ?? '' ;?>">
        </div>
        <div>
          <label for="tile">Body</label>
          <textarea name="post[body]" id="body"><?php echo $body ?? '' ;?></textarea>
        </div>
        <div>
          <label for="image">Image</label>
          <input type="file" name="image_name" id="" class="text-input">
        </div>
        <div>
        <label for="topic">Topic</label>
          <select name="post[topic_id]" class="text-input">
            <option value="">Select a topic</option>

            <?php foreach($topics as $key => $topic):?>

              <?php if(!empty($topic_id && $topic_id == $topic['id'])):?>
                <option value="<?php echo $topic['id']  ?? '' ;?>" selected><?php echo $topic['name']  ?? '' ;?></option>

              <?php else:?>
                <option value="<?php echo $topic['id']  ?? '' ;?>"><?php echo $topic['name'];?></option>
              <?php endif;?>

            <?php endforeach;?>
          </select>
        </div>
        <div>
        <?php if(empty($published)):?>
          <label for="published">
            Publish immediately  <input type="checkbox" name="post[published]" value="1" id="" class="w3-check"> 
          </label>
        <?php else:?>
          <label for="published">
            Publish immediately  <input type="checkbox" name="post[published]" value="1" id="" class="w3-check" checked> 
          </label>
        <?php endif;?>
        </div>
        <div>
          <button type="submit" name="updatepost" class="btn btn-big">Save edition</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->