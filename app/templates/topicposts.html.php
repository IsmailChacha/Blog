<div class="content clearfix">
	<!-- Main Content -->
	<div class="main-content">
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
	<!-- //Main Content -->
		
	<!-- Sidebar -->
	<aside class="sidebar single">

	<!-- Search section -->
		<div class="section search">
			<form action="index.php/search" method="get">
				<input type="text" name="searchterm" class="text-input" placeholder="Search entire site">
			</form>
		</div>
	<!-- Search section -->        
        
	<!-- Facebook page embed -->
	<div class="section fb-page" data-href="https://www.facebook.com/Tech-Genie-101835751592250" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
			<blockquote cite="https://www.facebook.com/Tech-Genie-101835751592250" class="fb-xfbml-parse-ignore"><a
					href="https://www.facebook.com/Tech-Genie-101835751592250">Tech Genie</a></blockquote>
		</div>
	<!-- Facebook page embed -->
	
	<!-- Popular posts -->
		<div class="section popular">
			<h3 class="section-title"><?php echo $popularPosts['heading'] ?? 'Popular Articles' ;?></h3>
			<!-- Single popular post -->
			<?php foreach($popularPosts['posts'] as $p):?>
				<div class="post clearfix">
					<a href="/index.php/<?php echo $p->String;?>"><img src="<?php echo BASE_URL . '/assets/images/' . $p->Image;?>" alt=""></a>
					<a href="/index.php/<?php echo $p->String;?>" class="title"><h4><?php echo $p->Title;?></h4></a>
				</div>
			<?php endforeach;?>
			<!-- //Single popular post -->
		</div>
		<!-- //Popular posts -->   

		<!-- Topics section -->
		<div class="section topics">
			<h3 class="section-title">Topics</h3>
			<ul>
				<?php foreach($topics as $topic): ?>
					<li><a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($topic->Name)));?>"><?php echo $topic->Name; ?></a></li>
				<?php endforeach; ?>            
			</ul>
		</div>
		<!-- Topics section -->
		<!-- Contact us -->
		<div class="section contactus">
			<h3 class="section-title">Contact us</h3>
			<br />
					<form action="/index.php/contactus" method="post">
						<input type="email" name="contactus[email]" class="text-input contact-input" placeholder="Email">
						<textarea name="contactus[message]" class="text-input contact-input" rows="4" placeholder="Message"></textarea>
						<button type="submit" class="btn btn-big contact-btn"> Send </button>
					</form>
		</div>
		<!-- Contact us -->  
	</aside>
	<!-- Sidebar -->