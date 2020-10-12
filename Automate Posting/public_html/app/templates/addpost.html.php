<div class="content">
    <div class="button-group">
    </div>
    
    <h2 class="page-title"><?php echo $heading; ?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <form action="<?php echo BASE_URL . '/private/index.php/addpost';?>" method="post" enctype="multipart/form-data" id="addpost" class="form">
        <label for="title">
            Title
            <p id="statusMessage"></p>
            <input type="text" name="post[Title]" id="title" class="text-input" value="<?php echo $title  ?? '';?>" maxlength="70">
        </label><br /><br />

        <label for="body">
            Body
            <br /><br />
            <textarea name="post[Body]" id="body" class="text-input"><?php echo $body ?? '' ;?></textarea>
        </label><br /><br />
        
        <label for="description">
            Description
            <br /><br />
            <textarea name="post[Description]" class="text-input"><?php echo $description ?? ''; ?></textarea>
        </label><br /><br />
        
        <label for="keywords">
            Keywords
            <br /><br />
            <textarea name="post[Keywords]" class="text-input"><?php echo $keywords ?? '' ;?></textarea>
        </label><br /><br />
        
        <label for="image">
            Image
            <br /><br />
            <input type="file" name="Image" id="" class="text-input">
        </label><br /><br />
        
        <label for="topic">
            Select categories for this post:
            <br /><br />
            <?php foreach ($categories as $category): ?>
                <input type="checkbox" name="category[]" value="<?=$category->Id?>" form="addpost"/>
                <label><?=$category->Name?></label> &nbsp;&nbsp;
            <?php endforeach; ?>
        </label><br /><br />
        
        <?php if(empty($published)):?>
            <label for="published">
                Published
                <input type="checkbox" name="post[Published]" value="1" id="" form="addpost" class="w3-check" disabled>    
            </label><br /><br />
        <?php else:?>
            <label for="published">
                Published 
                <input type="checkbox" name="post[Published]" value="1" id="" form="addpost" class="w3-check" checked disabled>    
            </label><br /><br />
        <?php endif;?>

        <?php if($_SESSION['Superuser']):?>
            <button form="addpost" type="submit" name="add" class="btn btn-big" value="add">Next</button>
            <!--<button form="addpost" type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>-->
        <?php elseif($_SESSION['Admin']):?>
            <button form="addpost" type="submit" name="add" class="btn btn-big" value="Save">Next</button>
        <?php endif;?>
    </form>
 
</div>
