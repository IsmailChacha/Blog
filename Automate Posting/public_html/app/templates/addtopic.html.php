<div class="content">
    <div class="button-group">
    </div>
    
    <h2 class="page-title"><?php echo $heading ?? ''; ?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <form action="<?php echo BASE_URL.'/private/index.php/addtopic';?>" method="post"  class="form">
        <label for="name">
            Name<br /><br />
            <input type="text" name="topic[name]" id="" class="text-input" value="<?php echo $Name ?? ''; ?>">
        </label><br /><br />
        <label for="description">
            Description<br /><br />
            <textarea name="topic[description]" class="text-input" id="body"><?php echo $Description ?? ''; ?></textarea>
        </label><br /><br />
        <button type="submit" name="add" class="btn btn-big">Add Topic</button>
    </form>
</div>
