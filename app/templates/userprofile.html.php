<!-- Admin content -->
<div class="admin-content">
  <div class="content2">
    <h2 class="page-title">Profile</h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
             
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
      <p class="username"><?php echo 'First Name: ' . $user->FirstName ;?></p>
      <p class="username"><?php echo 'Last Name' . ' ' . $user->LastName;?></p>
      <p class="email"><?php echo 'Email: ' . $user->Email;?></p>
    </div>
    <!-- //DASHBOARD CONTENT -->
  </div>
</div>
<!-- Admin content -->
