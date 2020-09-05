<div class="sidebar-container hide-scroll-bar">
  <!-- Left side bar -->
  <div class="left-sidebar">
    <ul>
      <?php if($_SESSION['Superuser']):?>
        <li><a href="<?php echo BASE_URL.'/private/index.php/dashboard';?>">Dashboard</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/profile';?>">Profile</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/manageauthors';?>">Manage Authors</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/manageposts';?>">Manage Posts</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/managetopics';?>">Manage Topics</a></li>
      <?php elseif ($_SESSION['Admin']):?>
        <li><a href="<?php echo BASE_URL.'/private/index.php/dashboard';?>">Dashboard</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/profile';?>">Profile</a></li>
        <li><a href="<?php echo BASE_URL.'/private/index.php/manageposts';?>">Manage Posts</a></li>
      <?php else:?>
        <li><a href="<?php echo BASE_URL.'/user/index.php/dashboard2';?>">Dashboard</a></li>
        <li><a href="<?php echo BASE_URL.'/user/index.php/profile2';?>">Profile</a></li>
      <?php endif;?>
    </ul>
  </div>
  <!-- //Left side bar -->
</div>