<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
<div class="content clearfix col-3">
    <div class="main-content">
        <h1 class="post-title"><?php echo $recentPosts['heading']; ?></h1>
        <?php foreach($recentPosts['posts'] as $topic => $postsArray):?>
            <div class="topicPosts clearfix">
                <?php if(empty($postsArray)): ?>
                    <?php //PRINT NOTHING IF TOPIC DOESN'T HAVE ANY POSTS ;?>
                <?php else: ?>
                    <a href="<?php echo '/index.php/topics/'. str_replace(' ', '-', trim(strtolower($topic)));?>"><h2  class="topics" ><?=$topic; ?></h2></a>
                <?php endif; ?>
                <?php foreach($postsArray as $post): ?>
                    <?php require ROOT_PATH . '/app/helpers/articles.php';?>
                <?php endforeach; ?>
            </div>
        <?php endforeach;?>     
    </div>
<?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
</div>