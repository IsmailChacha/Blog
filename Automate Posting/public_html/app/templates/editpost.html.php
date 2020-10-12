<div class="content">
    <div class="button-group">
    </div>
    
    <h2 class="page-title"><?php echo $heading; ?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <div>
        <form action="<?php echo BASE_URL . '/private/index.php/editarticle';?>" method="post" enctype="multipart/form-data" id="editpost"  class="form">
            <input type="hidden" name="post[Id]" value="<?php echo $id ?? '' ?>">
            <label for="title">
                Title<br /><br />
                <p id="statusMessage"></p>
                <input type="text" name="post[Title]" id="title" class="text-input" value="<?php echo $title  ?? '' ;?>" maxlength="70">
            </label><br /><br />
            
            <label for="body">
                Body<br /><br />
                <textarea name="post[Body]" class="text-input"><?php echo $body ?? '' ;?></textarea>
            </label><br /><br />
            
            <label for="description">
                Description<br /><br />
                <textarea name="post[Description]" class="text-input"><?php echo $description ?? ''; ?></textarea>
            </label><br /><br />
            
            <label for="keywords">
                Keywords<br /><br />
                <textarea name="post[Keywords]" class="text-input"><?php echo $keywords ?? '' ;?></textarea>
            </label><br /><br />
            
            <label for="image">
                Image<br /><br />
                <input type="file" name="Image" id="" class="text-input">
            </label><br /><br />
           
           <label for="topic">
               Select categories for this post:<br /><br />
                <?php foreach ($categories as $category): ?>
                    <?php if(isset($post)): ?>
                        <?php if($post && $post->belongsToCategory($category->Id)): ?>
                            <input type="checkbox" name="category[]" value="<?=$category->Id?>" checked/>
                            <label><?=$category->Name?></label> &nbsp;&nbsp;
                        <?php else: ?>
                            <input type="checkbox" form="editpost" name="category[]" value="<?=$category->Id?>"/>
                            <label><?=$category->Name?></label> &nbsp;&nbsp;
                        <?php endif; ?>
                    <?php else: ?>
                        <input type="checkbox" form="editpost" name="category[]" value="<?=$category->Id?>"/>
                        <label><?=$category->Name?></label> &nbsp;&nbsp;
                    <?php endif; ?>
                <?php endforeach ;?>
            </label><br /><br />
            
            <?php if(empty($published)):?>
                    <input type="checkbox" form="editpost" name="post[Published]" value="1" id="" class="w3-check" disabled>
                    <label for="published">Published </label><br /><br />
            <?php else:?>
                    <input type="checkbox" form="editpost" name="post[Published]" value="1" id="" class="w3-check" checked disabled>
                    <label for="published">Published </label><br /><br />
            <?php endif; ?>
            
            <?php if($_SESSION['Superuser']):?>
                <button form="editpost" type="submit" name="add" class="btn btn-big" value="edit">Next</button>
                <!--<button form="editpost" type="submit" name="draft" class="btn btn-big" value="Save draft">Save draft</button>-->
            <?php elseif($_SESSION['Admin']):?>
                <button form="editpost" type="submit" name="edit" class="btn btn-big" value="Save">Next</button>
            <?php endif;?>
        </form>
    </div>
</div>