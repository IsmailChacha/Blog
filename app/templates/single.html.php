  <!-- Content -->
  <section class="content clearfix">
    <!-- Main content wrapper -->
    <section class="main-content-wrapper">
      <!-- Main content -->
      <section class="main-content single clearfix">
        <article class="">

          <section class="image-and-moreinfo clearfix">
            <div class="post-image">
              <img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->String);?>" class="featured-image" >
            </div>             
            <div class="more-info">
              <h1 class="post-title single"><?php echo $post->Title;?></h1>
              <!-- far fa-user -->
              <!-- far fa-calendar  -->
              <span class="post-info"><?php echo 'By ' . $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName; ?></span>
              <span class="published"><?php echo 'Published on ' . date('l jS F Y', strtotime($post->Date));?></span>
                <!-- <div class="socialmedia">
                  <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </div>  -->
            </div>     
                      
          </section> 
          
          <section class="post-content clearfix">
            <?php echo html_entity_decode($post->Body); ?>
          </section>            
        </article>
      </section>
      <!-- Main content -->
    </section>
    <!-- Main content wrapper -->
  
    <?php include ROOT_PATH . '/app/helpers/sidebar.php';?>

  </section>
  <!-- //Content -->