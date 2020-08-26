<!-- Form container -->
<div class="auth-content login">
	<form action="" method="post">
		<h2 class="form-title">Login</h2>
		<?php include ROOT_PATH. "/app/helpers/formerrors.php";?>
		<?php include ROOT_PATH. "/app/helpers/messages.php";?>
		
		<div>
			<label for="email">Email</label><br /><br />
			<input type="email" name="email" placeholder="someone@example.com" value="<?php echo $email  ?? '';?>" class="text-input">
		</div>

		<div>
			<label for="password">Password</label><br /><br />
			<input type="password" name="password" class="text-input">
		</div>

		<button type="submit" name="" class="btn btn-big auth">Login</button><br /><br />
		<p>Don't have an accout yet? <a href="<?php echo BASE_URL .'/index.php/signup';?>">Sign Up</a></p>
	</form>
</div>
<!-- Form container -->