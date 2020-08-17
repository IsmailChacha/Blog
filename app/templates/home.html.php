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

      <!-- Sidebar -->
      <aside class="sidebar col-9">
        <!-- Social media -->
        <!-- <div class="section socialmedia">
          Twitter follow button 
            <a href="https://twitter.com/ismail_mxxiv?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @ismail_mxxiv</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
         Twitter follow button 
        </div> -->
        <!-- //Social media -->
        <!-- Search section -->
        <section class="section search">
          <form action="index.php/search" method="get">
            <input type="text" name="searchterm" class="text-input" placeholder="Search entire site">
          </form>
        </section>
        <!-- Search section -->
        
        <!-- Facebook page embed -->
        <div class="section fb-page" data-href="https://www.facebook.com/Tech-Genie-101835751592250" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/Tech-Genie-101835751592250" class="fb-xfbml-parse-ignore"><a
                href="https://www.facebook.com/Tech-Genie-101835751592250">Tech Genie</a></blockquote>
        </div>
        <!-- Facebook page embed -->

        <!-- Popular posts -->
        <section class="section popular">
          <h3 class="section-title"><?php echo $popularPosts['heading'] ?? 'Popular Articles' ;?></h3>
          <!-- Single popular post -->
          <?php foreach($popularPosts['posts'] as $p):?>
            <div class="post clearfix">
              <a href="/index.php/<?php echo $p->String;?>"><img src="<?php echo BASE_URL . '/assets/images/' . $p->Image;?>" alt="<?php echo strip_tags($p->String);?>"></a>
              <a href="/index.php/<?php echo $p->String;?>" class="title"><h4><?php echo $p->Title;?></h4></a>
            </div>
          <?php endforeach;?>
          <!-- //Single popular post -->
        </section>
        <!-- //Popular posts -->           
        <!-- Topics section -->
        <section class="section topics">
          <h3 class="section-title">Topics</h3>
          <ul>
            <?php foreach($topics as $topic): ?>
              <li><a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($topic->Name)));?>"><?php echo $topic->Name; ?></a></li>
            <?php endforeach; ?>            
          </ul>
        </section>
        <!-- Topics section -->
        <!-- Contact us -->
        <section class="section contactus">
          <h3 class="section-title">Contact us</h3>
          <br />
              <form action="/index.php/contactus" method="post">
                <input type="email" name="contactus[email]" class="text-input contact-input" placeholder="Email">
                <textarea name="contactus[message]" class="text-input contact-input" rows="4" placeholder="Message"></textarea>
                <button type="submit" class="btn btn-big contact-btn"> Send </button>
              </form>
        </section>
        <!-- Contact us -->
      </aside>
      <!-- Sidebar -->
    </div>
</div>
  <!-- //Page wrapper