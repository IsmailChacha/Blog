<div class="content2">
    <h2 class="page-title"><?php echo $title;?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    <div class="dashboard-content">
        <p class="username"><?php echo 'First Name: ' . $user->FirstName ;?></p>
        <p class="username"><?php echo 'Last Name' . ' ' . $user->LastName;?></p>
        <p class="email"><?php echo 'Email: ' . $user->Email;?></p>
    </div>
</div>
