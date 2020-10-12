<div class="content2">
    <h2 class="page-title">Profile</h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    <div class="dashboard-content">
        <p class="username"><?php echo 'First Name: ' . $user->FirstName;?></p>
        <p class="username"><?php echo 'Last Name' . ' ' . $user->LastName;?></p>
        <p class="email"><?php echo 'Email: ' . $user->Email;?></p>
        <?php $role = $user->Superuser ? 'Super User' : 'Author';?>
        <p class="role"><?php echo 'ROLE: ' . $role;?></p>
    </div>
</div>
