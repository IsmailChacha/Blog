<div class="content2">
  <div class="button-group">
    <a href="<?php echo BASE_URL.'/private/index.php/addtopic';?>" class="btn btn-big">Add Topic</a>
  </div>
  
  <h2 class="page-title"><?php echo $heading ?? '';?></h2>
  <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
  <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
  <div>
    <table>
      <thead>
        <th>SN</th>
        <th>Name</th>
        <th>Articles</th>
        <th colspan="2">Action</th>
      </thead>
      <tbody>
        <?php foreach ($topics as $key => $topic):?>
          <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $topic->Name; ?></td>
            <td><?php echo $topic->totalPosts(); ?></td>
            <td>
              <a href="<?php echo BASE_URL . '/private/index.php/edittopic/topic/'.$topic->Id;?>" class="publish" rel="nofollow">Edit</a>
            </td>
            <td>
              <a href="javascript:deleteTopic('<?php echo $topic->Name;?>', '<?php echo $topic->Id;?>')" class="publish">Delete</a></td>
            </td>
          </tr>
        <?php endforeach;?>          
      </tbody>
    </table>
  </div>
</div>
