<!-- Form container -->
<div class="auth-content">
  <form action="" method="post">
    <h2 class="form-title">Register</h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

    <div>
      <label for="fname">First Name</label><br /><br />
      <input type="text" name="user[FirstName]" class="text-input" placeholder="John" value="<?php echo $user['FirstName'] ?? ''; ?>">
    </div>

    <div>
      <label for="lname">Last Name</label><br /><br />
      <input type="text" name="user[LastName]" class="text-input"  placeholder="Doe" value="<?php echo $user['LastName'] ?? ''; ?>">
    </div>

    <div>
      <label for="email">Email</label><br /><br />
      <input type="email" name="user[Email]" class="text-input" placeholder="someone@example.com" value="<?php echo $user['Email'] ?? ''; ?>">
    </div>

    <div>
      <label for="password">Password</label><br /><br />
      <input type="password" name="user[Password]" class="text-input" value="<?php echo $password  ?? ''; ?>">
    </div>

    <button type="submit" name="register-btn" class="btn btn-big">Register</button><br /><br />
    <p>Already have an account? <a href="<?php echo BASE_URL .'/index.php/signin';?>">Sign In</a></p>
  </form>
</div>
<!-- Form container -->
