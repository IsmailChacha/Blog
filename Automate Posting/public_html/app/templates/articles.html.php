<div class="content clearfix">
    <div class="main-content">
        <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
        <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
        <?php if(isset($posts)): ?>
            <div class="articles clearfix">
                <!--<h1 class="post-title"><?php echo $heading ?? ''; ?></h1>-->
                <?php foreach($posts as $post):?>
                <?php require ROOT_PATH . '/app/helpers/articles.php';?>
                <?php endforeach;?>		
            </div>
            <div class="pagination">
                <div class="pg-container">
                    <?php 
                        // Calculate number of pages
                        $numPages = ceil($totalArticles/12);
                        // Display a link for each page
                        if($numPages < 2):
                        // DO NOTHING
                        else:
                    ?>
                            <a href="#">&laquo;</a>
                    <?php
                        for($i=1; $i<=$numPages;$i++):
                            if($i == $currentPage):
                    ?>
                    
                    <a href="<?php echo BASE_URL . '/page='. $i;?>" class="active"><?=$i?></a>
                            <?php else:?>
                    <a href="<?php echo BASE_URL . '/page='. $i;?>"><?=$i?></a>
                            <?php endif;?>
                        <?php endfor;?>
                    <a href="#">&raquo;</a>
                        <?php endif ;?>
                </div>
            </div>						
        <?php else: ?>
            <h3 class="recent-post-title"><?php echo $heading ?? ''; ?></h3>
        <?php endif; ?>
    </div>
    <?php include ROOT_PATH . '/app/helpers/sidebar.php';?>
</div>