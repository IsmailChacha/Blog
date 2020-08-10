  <!-- Admin content -->
  <div class="admin-content">
    <div class="content2 main-content single">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/index.php/manageposts';?>" class="btn btn-big">Manage Posts</a>
      </div>

      <h2 class="page-title"><?php echo $title; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

			<div class="postinfo">
            <h2 class="post-title"><?php echo $post->Title;?></h2>
            <i class="far fa-user post-info"> &nbsp;<?php echo 'Author: ' . $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName; ?></i>
            <i class="far fa-calendar published"> &nbsp; <?php echo 'Published: ' . date('F j, Y', strtotime($post->Date));?></i>
            <div class="socialmedia">
              <!-- Twitter share button -->
                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              <!--// Twitter share button -->
            </div>
          </div>
          <div class="post-content">
            <?php echo html_entity_decode($post->Body); ?>
					</div>
					
				<form action="<?php echo BASE_URL . '/index.php/addpost';?>" method="post" enctype="multipart/form-data">
					<div>
						<label for="tile">Title</label><br /><br />
						<input type="text" name="post[Title]" id="" class="text-input" value="<?php echo $title  ?? '' ;?>">
					</div>
					<div>
						<label for="tile">Body</label><br /><br />
						<textarea name="post[Body]" id="body"><?php echo $body ?? '' ;?></textarea>
						<!--<script>
							CKEDITOR.replace( 'body' );
						</script>-->
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
						<label for="published">Action </label>
						<?php if(empty($published)):?>
							<input type="checkbox" name="post[Published]" value="1" id="" class="w3-check">
							<label for="published">Publish </label>
						<?php else:?>
							<input type="checkbox" name="post[Published]" value="1" id="" class="w3-check" checked>
							<label for="published">Publish </label>
						<?php endif;?>
					</div>
					<div>
						<button type="submit" name="add" class="btn btn-big" value="add">Add Post</button>
					</div>
				</form>
    </div>
  </div>
  <!-- Admin content -->