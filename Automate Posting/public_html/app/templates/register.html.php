<div class="auth-content">
    <form action="" method="post" name="register" class="form">
        <h2 class="form-title">Register</h2>
        <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
        <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
        
            <label for="fname">
                First Name<br /><br />
                <input type="text" name="user[FirstName]" class="text-input" placeholder="John" value="<?php echo $user['FirstName'] ?? ''; ?>">
            </label><br />
        
            <label for="lname">
                Last Name<br /><br />
                <input type="text" name="user[LastName]" class="text-input"  placeholder="Doe" value="<?php echo $user['LastName'] ?? ''; ?>">
            </label><br />
        
            <label for="email">
                Email<br /><br />
                <input type="email" name="user[Email]" class="text-input" placeholder="someone@example.com" value="<?php echo $user['Email'] ?? ''; ?>">
            </label><br />
        
            <label for="password">
                Password<br /><br />
                <input type="password" name="user[Password]" class="text-input" value="<?php echo $password  ?? ''; ?>">                
            </label><br />
            <div class="g-recaptcha" data-sitekey="6Lderc8ZAAAAABnfzSmfUJuMl6LwUSViShsvel34"></div>
            <button type="submit" name="register-btn" class="btn btn-big auth">Next</button><br /><br />
            <p>Already have an account? <a href="<?php echo BASE_URL .'/signin';?>">Sign In</a></p>
            <p><a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back home</a></p>
    </form>
</div>