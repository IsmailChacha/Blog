<?php if(isset($_SESSION['message'])):?>
  <div class="msg <?php echo $_SESSION['type'];?>" id="msg">
    <?php echo $_SESSION['message']?>
    <?php
      unset($_SESSION['message']);
      unset($_SESSION['type']);
    ?>
  </div>
<?php endif;?>
