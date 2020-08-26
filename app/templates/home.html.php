<!-- Page wrapper -->
<div class="page-wrapper">
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

    <div class="content clearfix col-3">
      <!-- Main Content -->
      <section class="main-content">
        <h1 class="post-title"><?php echo $recentPosts['heading']; ?></h1>
        <?php foreach($recentPosts['posts'] as $topic => $postsArray):?>
          <section class="topicPosts clearfix">
            <?php if(empty($postsArray)): ?>
              <?php //PRINT NOTHING IF TOPIC DOESN'T HAVE ANY POSTS ;?>
            <?php else: ?>
              <a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($topic)));?>"><h2  class="topics" ><?=$topic; ?></h2></a>
            <?php endif; ?>
            <?php foreach($postsArray as $post): ?>
                <div class="post clearfix">
                  <a href="/index.php/<?php echo $post->String;?>" alt=""><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->Description);?>" class="post-image"></a>
                    
                  <div class="post-preview clearfix">
                    <a href="/index.php/<?php echo $post->String;?>"><h4><?php echo $post->Title;?></h4></a>
                  </div>
                </div>  
            <?php endforeach; ?>
            <!-- Generate Pagination -->
            <div class="pagination">
              <?php 
                // Calculate number of pages
                $numPages = ceil($totalArticles/15);
                // Display a link for each page
                if($numPages >= 2):
                  for($i=1; $i<=$numPages;$i++):
                    foreach($currentPage as $key => $page):
                      if($topic === $key):
              ?>
                    <a href="<?php echo '/index.php/topics/' . str_replace(' ', '-', trim(strtolower($topic))) . '/more='. $page;?>" class="active"><?='Load More';?></a>
                      <?php endif;?>
                    <?php endforeach;?>
                  <?php endfor;?>
                <?php endif; ?>
            </div>			               
          </section>
        <?php endforeach;?>     
      </section>
      <!-- //Main Content -->

      <?php include ROOT_PATH . '/app/helpers/sidebar.php';?>

    </div>
</div>
  <!-- //Page wrapper