  <!-- Header -->
  <header>
    <a href="<?php echo BASE_URL.'/'?>" class="logo">
      <h1 class="logo-text"><span class="logo-color">TECH</span>GENIE</h1>
    </a>

    <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>

    <ul class="nav">
      <?php if(isset($_SESSION['username'])): ?>
        <li> <a href="#" class="user-menu">
            <i class="fa fa-user"></i>
            <?php echo $_SESSION['Name'];?>
            <i class="fa fa-chevron-down chevron-down"></i>
          </a>
          <ul class="user-dropdown">
            <li><a href="<?php echo BASE_URL. '/index.php/signout';?>" class="logout">Logout</a></li>
          </ul>
        </li>
      <?php endif;?>
    </ul>

    <!-- Side Nav -->
    <div class="sidenav" id="sidenav">
      <div class="sidenav2">
      <button type="button" name="closebtn" class="closebtn btn" id="closeSideNav">&times;
        </button>
      <?php if(isset($_SESSION['username'])): ?>
       <a href="#" class="user-menu"><i class="fa fa-user"></i><?php echo $_SESSION['Name'];?><i class="fa fa-chevron-down chevron-down"></i></a>
        <a href="signout" class="logout">Logout</a>
      <?php endif;?>
      </div>
    </div>
    <!-- //Side Nav -->    
  </header>
  <!-- //Header -->
