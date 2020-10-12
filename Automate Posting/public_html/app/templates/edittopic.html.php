<div class="content2">
    <div class="button-group">
    </div>
    <h2 class="page-title"><?php echo $heading ?? ''; ?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <form action="<?php echo BASE_URL.'/private/index.php/updatetopic';?>" method="post"  class="form">
        <input type="hidden" name="topic[id]" value="<?php echo $id ;?>">
        <label for="name">
            Name<br /><br />
            <input type="text" name="topic[name]" id="" class="text-input" value="<?php echo $name ?? ''; ?>">
        </label><br /><br />

        <label for="description">
            Description<br /><br />
            <textarea name="topic[description]" class="text-input" id="body"><?php echo $description ?? ''; ?></textarea>
        </label><br /><br />

        <button type="submit" name="edit" class="btn btn-big">Save edition</button>
    </form>
</div>