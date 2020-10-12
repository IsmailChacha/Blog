<div class="auth-content login">
    <form action="" method="post" name="login" class="form">
        <h2 class="form-title">Login</h2>
        <?php include ROOT_PATH. "/app/helpers/formerrors.php";?>
        <?php include ROOT_PATH. "/app/helpers/messages.php";?>
        
        <label for="email">
            Email<br /><br />
            <input type="email" name="email" placeholder="someone@example.com" value="<?php echo $email  ?? '';?>" class="text-input">
        </label><br />
        
        <label for="password">
            Password<br /><br />
            <input type="password" name="password" class="text-input">
        </label><br />
        <div class="g-recaptcha" data-sitekey="6Lderc8ZAAAAABnfzSmfUJuMl6LwUSViShsvel34"></div>
        <button type="submit" name="" class="btn btn-big auth">Next</button><br /><br />
        <p><a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back home</a></p>
    </form>
</div>