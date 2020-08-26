<div class="content clearfix">
	<!-- Main Content -->
	<div class="main-content">
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

		<?php if(isset($searchResults)): ?>
			<h2 class="recent-post-title"><?php echo $heading ?? ''; ?></h2>
			<h4><?php echo $secondHeading ?? '';?></h4>
			<?php foreach($searchResults as $post):?>
				<div class="post clearfix">
					<div class="recent-post-image">
						<a href="/index.php/<?php echo $post->String;?>" alt="<?php echo strip_tags($post->Description); ?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="" class="post-image"></a>
					</div>
						
					<div class="post-preview">
						<h3><a href="/index.php/<?php echo $post->String;?>"><?php echo $post->Title;?></a></h3>
					</div>
				</div>  
			<?php endforeach;?>
		<?php else: ?>
			<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
		<?php endif; ?>
	</div>
	<!-- //Main Content -->
	
	<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>

</div>