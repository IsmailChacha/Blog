<!-- Admin content -->
<div class="admin-content">
  <div class="content2">
    <div class="button-group">
      <a href="<?php echo BASE_URL.'/private/index.php/addtopic';?>" class="btn btn-big">Add Topic</a>
      <a href="<?php echo BASE_URL.'/private/index.php/managetopics';?>" class="btn btn-big">Manage Topics</a>
    </div>
    
    <h2 class="page-title"><?php echo $heading ?? '';?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
             
    <table>
      <thead>
        <th>SN</th>
        <th>Name</th>
        <th colspan="2">Action</th>
      <tbody>
        <?php foreach ($topics as $key => $topic):?>
          <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $topic->Name; ?></td>
            <td>
              <form action="<?php echo BASE_URL . '/private/index.php/edittopic';?>" method="post">
                <input type="hidden" name="post[id]" value="<?php echo $topic->Id;?>">
                <input type="submit" name="submit" value="Edit">
              </form>
            </td>
            <td>
              <form action="<?php echo BASE_URL . '/private/index.php/deletetopic';?>" method="post">
                <input type="hidden" name="post[id]" value="<?php echo $topic->Id;?>">
                <input type="submit" name="submit" value="Delete">
              </form>
            </td>
          </tr>
        <?php endforeach;?>          
      </tbody>
      </thead>
    </table>
  </div>
</div>
<!-- Admin content -->
