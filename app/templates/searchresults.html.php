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
						<a href="/index.php/articles/<?php echo $post->String;?>" alt=""><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="" class="post-image"></a>
					</div>
						
					<div class="post-preview">
						<h3><a href="/index.php/articles/<?php echo $post->String;?>"><?php echo $post->Title;?></a></h3>
					</div>
				</div>  
			<?php endforeach;?>
		<?php else: ?>
			<h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
		<?php endif; ?>
	</div>
	<!-- //Main Content -->
	<!-- Sidebar -->
	<aside class="sidebar single">

	<!-- Search section -->
		<div class="section search">
			<form action="/index.php/search" method="get">
				<input type="text" name="searchterm" class="text-input" placeholder="Search entire site">
			</form>
		</div>
	<!-- Search section -->        
		
	<!-- Popular posts -->
	<div class="section popular">
			<h3 class="section-title"><?php echo $popularPosts['heading'] ?? 'Popular Articles' ;?></h3>
			<!-- Single popular post -->
			<?php foreach($popularPosts['posts'] as $p):?>
				<div class="post clearfix">
					<a href="/index.php/articles/<?php echo $p->String;?>"><img src="<?php echo BASE_URL . '/assets/images/' . $p->Image;?>" alt=""></a>
					<a href="/index.php/articles/<?php echo $p->String;?>" class="title"><h4><?php echo $p->Title;?></h4></a>
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
		<!-- Join Our News Letter -->
		<div class="section contactus">
			<h3 class="section-title">Subscribe to our newsletter</h3>
			<br />
				<form action="/index.php/mailinglist" method="post">
					<input type="text" name="newsletter[name]" class="text-input contact-input" placeholder="Name">
					<input type="email" name="newsletter[email]" class="text-input contact-input" placeholder="Email">
					<button type="submit" class="btn btn-big contact-btn"> Subscribe </button>
				</form>
		</div>
		<!-- Join Our News Letter -->        
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