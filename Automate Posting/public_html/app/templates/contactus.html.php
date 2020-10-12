<div class="auth-content login contactus" id="contactus">
    <form action="" method="post" name="contact" class="form">
        <h2 class="form-title">Contact us</h2>
        <?php include ROOT_PATH. "/app/helpers/formerrors.php";?>
        <?php include ROOT_PATH. "/app/helpers/messages.php";?>

        <label for="fname">
            First Name<br /><br />
            <input type="text" name="FirstName" class="text-input" placeholder="John" value="<?php echo $firstname ?? ''; ?>" required>
        </label><br />
    
        <label for="lname">
            Last Name<br /><br />
            <input type="text" name="LastName" class="text-input"  placeholder="Doe" value="<?php echo $lastname ?? ''; ?>" required>
        </label><br />
        
        <label for="email">
            Email<br /><br />
            <input type="email" name="Email" placeholder="someone@example.com" value="<?php echo $email  ?? '';?>" class="text-input" required>
        </label><br />
        
        <label for="subject">
            Subject<br /><br />
            <input type="text" name="Subject" class="text-input" placeholder="Subject" value="<?php echo $subject ?? ''; ?>" required>
        </label><br />
        
        <label for="subject">
            Message<br /><br />
            <textarea id="subject" name="Message" class="text-input" placeholder="Your message" style="height:200px" required><?php echo $message ?? '';?></textarea>
        </label><br />
        
        <div class="g-recaptcha" data-sitekey="6Lderc8ZAAAAABnfzSmfUJuMl6LwUSViShsvel34"></div>
        <button type="submit" name="" class="btn btn-big auth">Send Message</button><br /><br />
    </form>
</div>