<div class="content2">
  <h2 class="page-title"><?php echo $title ;?></h2>
  <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
        
  <!-- DASHBOARD CONTENT -->
  <div class="dashboard-content">
    <table>
      <tbody>
        <tr>
          <td>All Posts<td>
          <td>Live<td>
          <td>Drafts<td>
        </tr>
        <tr>
          <td><?php echo $author->getTotalByAuthor(); ?><td>
          <td><?php echo $author->getPublishedByAuthor(); ?><td>
          <td><?php echo $author->getUnpublishedByAuthor(); ?><td>
        </tr>
      </tbody>
    </table>
  </div>
  

  <!-- //DASHBOARD CONTENT -->
</div>
