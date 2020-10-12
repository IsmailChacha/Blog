<div class="header admin-header">
    <div class="header-container">
        <a href="<?php echo BASE_URL .'/';?>" class="logo"><?php echo $siteName; ?></a>
        <i class="fas fa-bars menu-toggle" id="menu-toggle"></i>
        <ul class="nav">
            <?php if(isset($_SESSION['username'])): ?>
                <li> 
                    <a href="#" class="user-menu">
                        <i class="fas fa-user-circle"></i> <?php echo $_SESSION['Name'];?> <i class="fa fa-chevron-down chevron-down"></i>
                    </a>
                    <ul class="user-dropdown">
                        <li><a href="<?php echo BASE_URL. '/signout';?>" class="logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Sign out</a></li>
                    </ul>
                </li>
            <?php endif;?>
        </ul>
    </div>
    <div class="sidenav" id="sidenav">
        <div class="sidenav2">
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
            <?php endif;?>
        </div>
    </div>
</div>
