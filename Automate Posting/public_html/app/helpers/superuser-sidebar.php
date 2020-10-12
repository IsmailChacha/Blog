<div class="sidebar-container hide-scroll-bar">
    <div class="left-sidebar">
        <ul>
          <?php if($_SESSION['Superuser']):?>
            <li><a href="<?php echo BASE_URL.'/private/index.php/dashboard';?>"><i class="fas fa-home"></i>&nbsp;Dashboard</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/profile';?>"><i class="fas fa-user-circle"></i> &nbsp; Profile</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/manageauthors';?>"><i class="fas fa-user-friends"></i>&nbsp; Manage Authors</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/manageposts';?>"><i class="fas fa-edit"></i> &nbsp;Manage Posts</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/managetopics';?>"><i class="fas fa-folder-open"></i> &nbsp;Manage Topics</a></li>
          <?php elseif ($_SESSION['Admin']):?>
            <li><a href="<?php echo BASE_URL.'/private/index.php/dashboard';?>"><i class="fas fa-home"></i>&nbsp;Dashboard</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/profile';?>"><i class="fas fa-user-circle"></i> &nbsp; Profile</a></li>
            <li><a href="<?php echo BASE_URL.'/private/index.php/manageposts';?>"><i class="fas fa-edit"></i> &nbsp;Manage Posts</a></li>
          <?php else:?>
            <li><a href="<?php echo BASE_URL.'/user/index.php/dashboard2';?>"><i class="fas fa-home"></i>&nbsp;Dashboard</a></li>
            <li><a href="<?php echo BASE_URL.'/user/index.php/profile2';?>"><i class="fas fa-user-circle"></i> &nbsp; Profile</a></li>
          <?php endif;?>
        </ul>
    </div>
</div>