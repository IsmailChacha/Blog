  <!-- Content -->
  <section class="content clearfix">
    <!-- Main content wrapper -->
    <section class="main-content-wrapper">
      <!-- Main content -->
      <section class="main-content single clearfix">
        <article class="">

          <section class="image-and-moreinfo clearfix">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post->Image;?>" alt="<?php echo strip_tags($post->String);?>" class="post-image" >             
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
  
    <!-- Sidebar -->
    <aside class="sidebar single">
      <!-- Search section -->
        <section class="section search">
          <form action="/index.php/search" method="get">
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
              <a href="/index.php/<?php echo $p->String;?>"><img src="<?php echo BASE_URL . '/assets/images/' . $p->Image;?>" alt=""></a>
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
  </section>
  <!-- //Content -->