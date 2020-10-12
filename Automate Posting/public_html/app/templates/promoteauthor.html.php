<div class="content2">
    <div class="button-group">
    </div>
    <h2 class="page-title"><?=$heading;?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <form action="<?php echo BASE_URL.'/private/index.php/promoteuser';?>" method="post">
        <input type="hidden" name="id" class="text-input" value="<?php echo $user->Id;?>">
        <label for="fullname">
            Full Name<br /><br />
            <input type="text" name="" class="text-input" value="<?php echo $user->FirstName . ' ' . $user->LastName;?>" disabled>
        </label><br /><br />
        
        <label for="email">
            Email<br /><br />
            <input type="email" name="email" class="text-input" value="<?php echo $user->Email;?>" readonly>
        </label><br /><br />
        
        <?php if($user->Admin) :?>
            <label for="admin">
                Author 
                <input type="checkbox" name="admin" checked>
            </label><br /><br />
        <?php else:?>
                <label for="admin">
                    Author 
                    <input type="checkbox" name="admin" value='1'>
                </label><br /><br />
        <?php endif;?>
        <button type="submit" name="" class="btn btn-big">Next</button>
    </form>
</div>
