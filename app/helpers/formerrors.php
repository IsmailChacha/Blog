<!-- Display errors -->
<?php if(isset($errors) && count($errors) > 0):?>
	<div class="msg <?php echo $type;?>">
			<?php foreach($errors as $error):?>
					<li><?php echo $error; ?></li>
			<?php endforeach; ?>
	</div>
	<?php
	foreach($errors as $error)
		{
			unset($error);
		}
	?>
<?php endif;?>

  <!-- //Display errors -->