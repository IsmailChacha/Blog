<!-- Admin content -->
<div class="admin-content">
  <div class="content2">
  <div class="button-group">
    <a href="<?php echo BASE_URL.'/private/index.php/createauthor';?>" class="btn btn-big">Create author</a>
    <a href="<?php echo BASE_URL.'/private/index.php/manageauthors';?>" class="btn btn-big"><?=$heading;?></a>
  </div>
  
    <h2 class="page-title"><?=$heading;?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
      
    <table>
      <thead>
        <th>SN</th>
        <th>Name</th>
        <th>Email</th>
        <th>Date created</th>
        <th>Number of posts</th>
      </thead>
      <tbody>
        <?php foreach($authors as $key => $author):?>
          <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $author->FirstName . ' ' . $author->LastName; ?></td>
            <td><?php echo $author->Email; ?></td> 
            <td><?php echo $author->Date; ?></td>
            <td><?php echo $author->getTotalByAuthor(); ?></td> 
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- Admin content -->
</div>
