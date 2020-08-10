<!-- Page wrapper -->
<div class="page-wrapper">
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>

    <div class="content clearfix col-3">
      <!-- Main Content -->
      <section class="main-content">
        <h1 class="post-title"><?php echo $recentPosts['heading']; ?></h1>
        <?php foreach($recentPosts['posts'] as $topic => $postsArray):?>
          <div class="topicPosts clearfix">
            <?php if(empty($postsArray)): ?>
              <?php //PRINT NOTHING IF TOPIC DOESN'T HAVE ANY POSTS ;?>
            <?php else: ?>
              <a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($topic)));?>"><h2  class="topics" ><?=$topic; ?></h2></a>
            <?php endif; ?>
            <?php foreach($postsArray as $post): ?>
                <div class="post">
                  <a href="/index.php/topics/<?php echo str_replace(' ', '-', trim(strtolower($topic))) . '/' .  $post->String;?>" alt=""><img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="" class="post-image"></a>
                    
                  <div class="post-preview">
                    <a href="/index.php/topics/<?php echo str_replace(' ', '-', trim(strtolower($topic))) . '/' .  $post->String;?>"><h4><?php echo $post->Title;?></h4></a>
                  </div>
                </div>  
            <?php endforeach; ?>
          </div>
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
        <div class="section search">
          <form action="index.php/search" method="get">
            <input type="text" name="searchterm" class="text-input" placeholder="Search entire site">
          </form>
        </div>
        <!-- Search section -->
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
    </div>
  </div>
  <!-- //Page wrapper