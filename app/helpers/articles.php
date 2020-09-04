<article class="post clearfix">
	<div class="recent-post-image">
		<a href="/index.php/<?php echo strip_tags($post->String);?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->String);?>" class="post-image"></a>
	</div>
		
	<div class="post-preview">
		<?php 
				$description = strip_tags($post->Description); 
				$wordCount = strlen($description); 

				if($wordCount <= 120) 
				{
					$elipsis = '';
				} else 
				{
					$elipsis = ',...';
				} 
		?>
		<h3><a href="/index.php/<?php echo $post->String;?>"><?php echo strip_tags($post->Title);?></a></h3>
		<p class="description"><?php echo substr($description, 0, 120) . $elipsis; ?></p>
	</div>
</article>  