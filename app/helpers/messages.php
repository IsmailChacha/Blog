<?php if(isset($_SESSION['message'])):?>
  <div class="msg <?php echo $_SESSION['type'];?>" id="msg" >
    <?php echo $_SESSION['message']?>
    <span id="closeNotification">X</span>
    <?php
      unset($_SESSION['message']);
      unset($_SESSION['type']);
    ?>
  </div>
<?php endif;?>
