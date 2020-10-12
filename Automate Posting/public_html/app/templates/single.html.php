<div class="content clearfix">
    <div class="main-content-wrapper">
        <div class="main-content single clearfix">
            <article class="">
                <div class="image-and-moreinfo clearfix">
                    <div class="more-info">
                        <h1 class="title single"><?php echo ucwords(strtolower($post->Title));?></h1>
                        <!--<span class="post-info"><?php echo 'Author: ' . $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName; ?></span>-->
                        <span class="post-info"><?php echo 'By TheLinuxPost'; ?></span>
                        <span class="published"><?php echo 'On ' . date('jS F Y', strtotime($post->Date));?></span>
                        <div id="tags">
                        <?php foreach($postCategories as $topic):?>
                            <a class="tags" href="/<?php echo 'topics/'. str_replace(' ', '-', trim(strtolower($topic->Name)));?>"><?php echo '#' . $topic->Name; ?></a>
                        <?php endforeach;?>
                    </div>
                    </div>
                    <!--<div class="post-image">-->
                    <!--    <img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->String);?>" class="featured-image" >-->
                    <!--</div>                         -->
                </div> 
                
                <div class="post-content clearfix">
                    <?php echo html_entity_decode($post->Body); ?>
                    <div id="disqus_thread" style="margin-top:100px"></div>
                    <?php $permalink = 'https://thelinuxpost.com/' . $post->String ; ?>
                    <script>
                        var disqus_config = function () {
                            this.page.url = '<?php echo $permalink;?>';  
                            this.page.identifier = '<?php echo $post->String;?>'; 
                        };
                        
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');
                            s.src = 'https://https-thelinuxpost-com.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>  
                    
                </div> 
            </article>
        </div>
    </div>
    <?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
</div>