<section class="content clearfix">
	<!-- Main Content -->
	<section class="main-content">
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
			<?php if(isset($topicPosts)):?>
				<div class="topicPosts clearfix">
					<h1 class="post-title"><?php echo $heading ?? ''; ?></h1>
					<?php foreach($topicPosts as $post):?>
						<div class="post clearfix">
							<div class="recent-post-image">
								<a href="/index.php/<?php echo $post->String;?>" alt=""><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="" class="post-image"></a>
							</div>
								
							<div class="post-preview">
								<h3><a href="/index.php/<?php echo $post->String;?>"><?php echo $post->Title;?></a></h3>
								<a href="/index.php/<?php echo $post->String;?>"><p class="preview-text">
							</div>
						</div>  
					<?php endforeach;?>
				</div>
				<!-- Generate Pagination -->
				<section class="pagination clearfix">
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
				</section>						
						<?php else: ?>
							<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
						<?php endif ;?>

	</section>
	<!-- //Main Content -->
		
	<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
</section>
