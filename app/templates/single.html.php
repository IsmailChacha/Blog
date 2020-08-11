<!-- JavaScript SDK For Facebook Page-->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0"
    nonce="QCPHup8t"></script>

  <!-- Page wrapper -->
  <div class="page-wrapper">
    <!-- Content -->
    <div class="content clearfix">
      <!-- Main content wrapper -->
      <div class="main-content-wrapper">
        <!-- Main content -->
        <section class="main-content single clearfix">
          <article class="">

            <div class="image-and-moreinfo clearfix">
              <img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="" class="post-image" >             
              <div class="more-info">
                <h1 class="post-title"><?php echo $post->Title;?></h1>
                <!-- far fa-user -->
                <!-- far fa-calendar  -->
                <span class="post-info"><?php echo 'By ' . $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName; ?></span>
                <span class="published"><?php echo 'Published on ' . date('F j, Y', strtotime($post->Date));?></span>
                 <!-- <div class="socialmedia">
                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>  -->
              </div>     
                       
            </div> 
            
            <div class="post-content clearfix">
              <?php echo html_entity_decode($post->Body); ?>
            </div>            
          </article>
        </section>
        <!-- Main content -->
      </div>
      <!-- Main content wrapper -->
    
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
              <li><a href="<?php echo '/index.php/topics/'.strtolower($topic->Name);?>"><?php echo $topic->Name; ?></a></li>
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
    <!-- //Content -->
  </div>
  <!-- //Page wrapper -->