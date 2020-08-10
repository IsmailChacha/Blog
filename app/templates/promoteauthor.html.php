  <!-- Admin content wrapper-->
  <div class="admin-content">
    <div class="content2">
      <div class="button-group">
        <a href="<?php echo BASE_URL.'/private/index.php/createauthor';?>" class="btn btn-big">Create User</a>
        <a href="<?php echo BASE_URL.'/private/index.php/manageauthors';?>" class="btn btn-big">Manage Users</a>
      </div>
      <h2 class="page-title"><?=$heading;?></h2>
      <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
      <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
            
      <form action="<?php echo BASE_URL.'/private/index.php/promoteuser';?>" method="post">
        
        <div>
          <label for="fullname">Full Name</label><br /><br />
          <input type="text" name="" class="text-input" value="<?php echo $user->FirstName . ' ' . $user->LastName;?>" disabled>
        </div>
        
        <div>
          <label for="email">Email</label><br /><br />
          <input type="email" name="email" class="text-input" value="<?php echo $user->Email;?>" readonly>
        </div>

        <div>
          <input type="hidden" name="id" class="text-input" value="<?php echo $user->Id;?>">
        </div>

        <div>
          <?php if($user->Admin) :?>
            <label for="admin">
            Author <input type="checkbox" name="admin" checked>
            </label>
          <?php else:?>
            <label for="admin">
            Author <input type="checkbox" name="admin" value='1'>
            </label>
          <?php endif;?>
        </div>
          
        <div>
          <button type="submit" name="" class="btn btn-big">Next</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Admin content -->
