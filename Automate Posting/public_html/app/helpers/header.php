<header class="header">
    <div class="header-container">
        <div class="lp-logo-container">
            <a href="<?php echo BASE_URL .'/';?>" class="logo" title="Home"><?php echo $siteName;?></a>
        </div>
        <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>
        <ul class="nav">
            <li>
                <a href="#" class="theme-toggler"><i class="fas fa-moon"></i></i></a>
            </li>
            <?php if(isset($_SESSION['Id'])):?>
            <li> 
                <a href="" class="user-menu">
                    <i class="fas fa-user-circle"></i>
                <?php echo $_SESSION['Name']?>
                    <i class="fa fa-chevron-down chevron-down"></i>
                </a>
                <ul class="user-dropdown">
                    <?php if($_SESSION['Superuser']):?>
                    <li><a href="<?php echo BASE_URL . '/private/';?>">Dashboard</a></li>
                    <li><a href="<?php echo BASE_URL .'/signout'?>" class="logout"><i class="fas fa-sign-out-alt"></i>Sign out</a></li>
                    <?php elseif($_SESSION['Admin']):?>
                    <li><a href="<?php echo BASE_URL . '/private/';?>">Dashboard</a></li>
                    <li><a href="<?php echo BASE_URL .'/signout';?>" class="logout">Sign out</a></li>
                    <?php else:?>
                    <li><a href="<?php echo BASE_URL . '/user/';?>">Account</a></li>
                    <li><a href="<?php echo BASE_URL .'/signout'?>" class="logout"><i class="fas fa-sign-out-alt"></i>Sign out</a></li>
                    <?php endif;?>       
                </ul>
            </li>
            <?php else:?>
                <!--<li><a href="<?php echo BASE_URL .'/signup';?>">Sign up</a></li>-->
                <li><a href="<?php echo BASE_URL .'/signin';?>">Sign In</a></li>
            <?php endif;?>
        </ul>
    </div>
    
    <div class="sidenav" id="sidenav">
        <div class="sidenav2">
            <form action="/search" method="get">
                <input type="text" name="searchterm" class="sidesearch text-input" placeholder="Search...">
            </form>
            <span class="closebtn btn close" id="closeSideNav">X</span>
            
            <h2><?php echo "Menu"; ?></h2>
            
            <?php if(isset($_SESSION['Id'])):?>
                <a href="#" class="user-menu">
                    <i class="fas fa-user-circle"></i><?php echo $_SESSION['Name']?><i class="fa fa-chevron-down chevron-down"></i>
                </a>
            
                <?php if($_SESSION['Superuser'] || $_SESSION['Admin']):?>
                    <a href="<?php echo BASE_URL . '/private/'; ?>">Dashboard</a>
                    <a href="<?php echo BASE_URL .'/signout'?>" class="logout links"><i class="fas fa-sign-out-alt"></i>Sign out</a>
                    <?php elseif($_SESSION['Admin']): ?>
                    <a href="<?php echo BASE_URL . '/private/'; ?>">Dashboard</a>
                    <a href="<?php echo BASE_URL .'/signout'?>" class="logout links"><i class="fas fa-sign-out-alt"></i>Sign out</a>         
                <?php else:?>
                    <a href="<?php echo BASE_URL . '/user/'; ?>">Account</a>
                    <a href="<?php echo BASE_URL .'/signout'?>" class="logout links"><i class="fas fa-sign-out-alt"></i>Sign out</a>
                <?php endif;?>       
            <?php else:?>
                <!--<a href="<?php echo BASE_URL .'/signup'; ?>" class="links">Sign up</a>-->
                <a href="<?php echo BASE_URL .'/signin';?>" class="links">Sign In</a>
            <?php endif;?>
                <a href="#" class="theme-toggler">Light</i></a>
        </div>
    </div>
</header>