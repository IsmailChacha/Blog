<div class="content clearfix">
	<div class="main-content">
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
			<?php if(isset($topicPosts)):?>
				<div class="topicPosts clearfix">
					<h1 class="post-title"><?php echo $heading ?? ''; ?></h1>
					<?php foreach($topicPosts as $post):?>
						<?php require ROOT_PATH . '/app/helpers/articles.php';?>
					<?php endforeach;?>
				</div>
				<!-- Generate Pagination -->
				<div class="pagination clearfix">
					<?php 
						// Calculate number of pages
						$numPages = ceil($totalTopicPosts/15);
						// Display a link for each page
							if($numPages < 2):
								// DO NOTHING
							else:
								for($i=1; $i<=$numPages;$i++):
									if($i == $currentPage):
					?>
											<a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($heading))) . '/page='. $i;?>" class="active"><?='Page ' .$i?></a>
									<?php else:?>
											<a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($heading))) . '/page='. $i;?>"><?='Page ' .$i?></a>
									<?php endif;?>
								<?php endfor;?>
							<?php endif ;?>
				</div>						
						<?php else: ?>
							<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
						<?php endif ;?>

	</div>
	<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
</div>
