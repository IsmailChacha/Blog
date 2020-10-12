<article class="post clearfix">
    <div class="post-container">
    	<div class="recent-post-image">
    		<a href="/<?php echo strip_tags($post->String);?>" title="<?php echo ucfirst($post->Title);?>"><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo ucfirst($post->Title);?>" class="post-image"></a>
    	</div>
    		
    	<div class="post-preview">
    		<?php 
    			$description = strip_tags($post->Description); 
    			$wordCount = strlen($description); 
    
    			if($wordCount <= 110) 
    			{
    				$elipsis = '';
    			} else 
    			{
    				$elipsis = ' ...';
    			} 
    		?>
    		<h3><a href="/<?php echo $post->String;?>"><?php echo ucwords(strtolower($post->Title));?></a></h3>
    		<p class="description"><?php echo substr($description, 0, 110) . $elipsis; ?></p>
    	</div>            
    </div>
</article>  