<div class="content clearfix">
	<!-- Main Content -->
	<div class="main-content">
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

		<?php if(isset($searchResults)): ?>
			<h2 class="recent-post-title"><?php echo $heading ?? ''; ?></h2>
			<h4 class="numberofresults"><?php echo $secondHeading ?? '';?></h4>
			<?php foreach($searchResults as $post):?>
				<?php require ROOT_PATH . '/app/helpers/articles.php';?>
			<?php endforeach;?>
		<?php else: ?>
			<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
		<?php endif; ?>
	</div>
	<!-- //Main Content -->
	
	<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>

</div>