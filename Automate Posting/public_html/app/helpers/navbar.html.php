<div class="lp-sidebar-container hide-scroll-bar">
    <nav class="lp-left-sidebar">
		<ul>
		    <li>
                <?php if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == BASE_URL): ?>
                    <a id="home" class="active-link nav-link" href="/" title="Home"><i class="fas fa-home"></i></a>
                <?php else: ?>		        
    		        <a id="home" class="nav-link" href="/" title="Home"><i class="fas fa-home"></i></a>
    		    <?php endif; ?>
		    </li>
			<?php foreach($topics as $topic): ?>
				<?php if($topic->totalPosts() !== 0): ?>
					<li>
					    <?php if($activeLink == $topic->Name):?>
    					    <a class="active-link nav-link" href="/<?php echo 'topics/'. str_replace(' ', '-', trim(strtolower($topic->Name)));?>" title="<?php echo ucfirst($topic->Name);?>"><?php echo $topic->Name; ?></a>
    					<?php else: ?>
        					<a class="nav-link" href="/<?php echo 'topics/'. str_replace(' ', '-', trim(strtolower($topic->Name)));?>" title="<?php echo ucfirst($topic->Name);?>"><?php echo $topic->Name; ?></a>
        				<?php endif; ?>
					 </li>
				<?php endif ; ?>
			<?php endforeach; ?>            
		</ul>
    </nav>
</div>