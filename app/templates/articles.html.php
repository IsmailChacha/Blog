<section class="content clearfix">
	<!-- Main Content -->
	<section class="main-content">
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

		<?php if(isset($posts)): ?>
			<section class="articles clearfix">
				<h1 class="post-title"><?php echo $heading ?? ''; ?></h1>
					<?php foreach($posts as $post):?>
						<article class="post clearfix">
							<div class="recent-post-image">
								<a href="/index.php/<?php echo strip_tags($post->String);?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->String);?>" class="post-image"></a>
							</div>
								
							<div class="post-preview">
								<h3><a href="/index.php/<?php echo $post->String;?>"><?php echo $post->Title;?></a></h3>
							</div>
						</article>  
					<?php endforeach;?>			
			</section>
			<!-- Generate Pagination -->
			<div class="pagination">
				<?php 
					// Calculate number of pages
					$numPages = ceil($totalArticles/15);
					// Display a link for each page
					if($numPages < 2):
						// DO NOTHING
					else:
						for($i=1; $i<=$numPages;$i++):
							if($i == $currentPage):
				?>
								<a href="<?php echo '/index.php/page='. $i;?>" class="active"><?='Page ' .$i?></a>
							<?php else:?>
								<a href="<?php echo '/index.php/page='. $i;?>"><?='Page ' .$i?></a>
							<?php endif;?>
						<?php endfor;?>
					<?php endif ;?>
				</div>						
			<?php else: ?>
				<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
		<?php endif; ?>
	</section>

	<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
	<!-- //Main Content -->
</section>