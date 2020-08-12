<!-- Admin content -->
  <div class="admin-content">

    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL . '/private/index.php/addpost';?>" class="btn btn-big">Add Article</a>
        <a href="<?php echo BASE_URL . '/private/index.php/manageposts';?>" class="btn btn-big">Manage Articles</a>
        <a href="<?php echo BASE_URL . '/private/index.php/drafts';?>" class="btn btn-big">Drafts</a>
      </div>

      <h2 class="page-title"><?php echo $heading; ?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
         
      <table>
        <thead>
          <th>SN</th>
          <th>Title</th>
          <th>Author</th>
            <th colspan="3">Action</th>
        </thead>
        <?php if(isset($posts)): ?>
          <?php if(count($posts) > 0): ?>
            <tbody>
            <?php foreach ($posts as $key => $post): ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $post->Title; ?></td>
                  <td><?php echo $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName;?></td>
                  <td>
                    <form action="<?php echo BASE_URL . '/private/index.php/editpost';?>" method="post">
                      <input type="hidden" name="post[id]" value="<?php echo $post->Id;?>">
                      <input type="submit" name="submit" value="Edit">
                    </form>
                  </td>
                    <?php if($_SESSION['Superuser']): ?>
                      <td>
                        <!-- <form action="<?php echo BASE_URL . '/private/index.php/deletepost';?>" method="post">
                          <input type="hidden" name="post[id]" value="<?php echo $post->Id;?>">
                          <input type="submit" name="submit" value="Delete">
                        </form> -->

                        <!-- TRYING OUT A NEW APROACH TO DELETING ATICLES -->
                        <a href="javascript:deleteArticle('<?php echo $post->Title;?>', '<?php echo $post->String;?>')" class="publish">Delete</a></td>
                      </td>
                    <?php endif ;?>
                    <?php if($post->Published):?>
                      <td>
                      <a href="<?php echo BASE_URL . '/private/index.php/visibility/unpublish/'.$post->Id;?>" class="publish" rel="nofollow">Unpublish</a></td>
                    <?php else:?>
                      <td><a href="<?php echo BASE_URL . '/private/index.php/visibility/publish/'.$post->Id;?>" class="publish" rel="nofollow">Publish</a></td>
                    <?php endif; ?>
                </tr>
              </tbody>
            <?php endforeach; ?>
          <?php else: ?>
            <h3>Once you publish some posts they'll appear here</h3>
          <?php endif; ?>
        <?php endif; ?>
      </table>
    </div>
  </div>
<!-- Admin content -->
</div>
