<div class="content">
    <div class="button-group">
    <a href="<?php echo BASE_URL . '/private/index.php/addpost';?>" class="btn btn-big"><i class="fas fa-plus-square" title="Add new"></i>&nbsp;New</a>
    <a href="<?php echo BASE_URL . '/private/index.php/drafts';?>" class="btn btn-big"><i class="fas fa-archive" title="Still editing"></i>&nbsp;Drafts</a>
    </div>
    
    <h2 class="page-title"><?php echo $heading; ?></h2>
    <?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
    <?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
    
    <table>
        <thead>
            <th>SN</th>
            <th>Title</th>
            <th>Author</th>
            <th colspan="3">Action</th>
        </thead>
        <?php if(isset($posts)): ?>
            <?php if(count($posts) > 0): ?>
                <tbody>
                    <?php foreach ($posts as $key => $post): ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $post->Title; ?></td>
                            <td><?php echo $post->getAuthor()->FirstName . ' ' . $post->getAuthor()->LastName;?></td>
                            <td>
                                <?php if($post->getAuthor()->Id === $_SESSION['Id']):?>
                                    <a href="<?php echo BASE_URL . '/private/index.php/editarticle/article/'.$post->String;?>" class="publish" rel="nofollow"><i class="fas fa-pencil-alt" title="Edit"></i></a>
                                <?php endif;?>
                            </td>
                            <?php if($_SESSION['Superuser']): ?>
                                <td>
                                    <a href="javascript:deleteArticle('<?php echo $post->Title;?>', '<?php echo $post->String;?>')" class="publish" rel="nofollow"><i class="fas fa-trash-alt" title="Trash"></i></a></td>
                                </td>
                                 <?php if($post->Published):?>
                                    <td>
                                        <a href="<?php echo BASE_URL . '/private/index.php/visibility/unpublish/'.$post->String;?>" class="publish" rel="nofollow" title="Unpublish"><i class="fas fa-download"></i></a>
                                    </td>
                                <?php else:?>
                                    <td>
                                        <a href="<?php echo BASE_URL . '/private/index.php/visibility/publish/'.$post->String;?>" class="publish" rel="nofollow" title="Publish"><i class="fas fa-upload"></i></a>
                                    </td>
                                <?php endif; ?>
                                  <?php if(!$post->MailedOut):?>
                                    <td>
                                        <a href="<?php echo BASE_URL . '/private/index.php/sendtomailinglist/send/'.$post->String;?>" class="publish" rel="nofollow" title="Send To Mailing List"><i class="fas fa-envelope"></i></a>
                                    </td>
                                  <?php endif; ?>
                            <?php endif ;?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php else: ?>
                <h3>Once you publish some posts they'll appear here</h3>
            <?php endif; ?>
        <?php endif; ?>
    </table>
</div>