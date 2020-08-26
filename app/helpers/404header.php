<!-- Header -->
<header>
  <div class="header-container">
    <a href="<?php echo BASE_URL .'/';?>" class="logo"><?php echo '<span class="logo-style">MINDS</span>JOURNAL'; ?></a>
    
    <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>

    <ul class="nav">
      <li><a href="/index.php/aboutus">About Us</a></li>
      <?php if(isset($_SESSION['Id'])):?>
        <li>  <a href="#" class="user-menu">
              <i class="fa fa-user"></i>
              <?php echo $_SESSION['Name']?>
              <i class="fa fa-chevron-down chevron-down"></i>
            </a>
          <ul class="user-dropdown">
            <?php if($_SESSION['Superuser']):?>
              <li><a href="<?php echo BASE_URL . '/private/';?>">Dashboard</a></li>
              <li><a href="<?php echo BASE_URL .'/index.php/signout'?>" class="logout">Logout</a></li>
            <?php elseif($_SESSION['Admin']):?>
              <li><a href="<?php echo BASE_URL . '/private/';?>">Dashboard</a></li>
              <li><a href="<?php echo BASE_URL .'/index.php/signout';?>" class="logout">Logout</a></li>
            <?php else:?>
              <li><a href="<?php echo BASE_URL . '/user/';?>">Account</a></li>
              <li><a href="<?php echo BASE_URL .'/index.php/signout'?>" class="logout">Logout</a></li>
            <?php endif;?>       
          </ul>
        </li>
      <?php else:?>
        <li><a href="<?php echo BASE_URL .'/index.php/signup';?>">Sign Up</a></li>
        <li><a href="<?php echo BASE_URL .'/index.php/signin';?>">Sign In</a></li>
      <?php endif;?>
    </ul>
  </div>
    
    <!-- Side Nav -->
    <div class="sidenav" id="sidenav">
      <div class="sidenav2">
        <form action="" method="get">
          <input type="text" name="searchterm" class="sidesearch text-input" placeholder="Search...">
        </form>
        <h2><?php echo "Topics"; ?></h2>

        <button type="button" name="closebtn" class="closebtn btn" id="closeSideNav">&times;
        </button>
    
        <h2><?php echo "Menu"; ?></h2>

        <?php if(isset($_SESSION['Id'])):?>
            <a href="#" class="user-menu"><i class="fa fa-user"></i><?php echo $_SESSION['Name']?><i class="fa fa-chevron-down chevron-down"></i></a>

            <?php if($_SESSION['Superuser'] || $_SESSION['Admin']):?>
              <a href="<?php echo BASE_URL . '/private/'; ?>">Dashboard</a>
              <a href="<?php echo BASE_URL .'/index.php/signout'?>" class="logout">Logout</a>
            <?php elseif($_SESSION['Admin']): ?>
              <a href="<?php echo BASE_URL . '/private/'; ?>">Dashboard</a>
              <a href="<?php echo BASE_URL .'/index.php/signout'?>" class="logout">Logout</a>         
            <?php else:?>
              <a href="<?php echo BASE_URL .'/index.php/signout'?>" class="logout">Logout</a>
            <?php endif;?>       
        <?php else:?>
          <a href="<?php echo BASE_URL .'/index.php/signup'; ?>">Sign Up</a>
          <a href="<?php echo BASE_URL .'/index.php/signin';?>">Sign In</a>
        <?php endif;?>
      </div>
    </>
      
    <!-- //Side Nav -->
  </header>
  <!-- //Header -->