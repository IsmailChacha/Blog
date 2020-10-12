<div class="sidebar single">
	<section class="section search">
		<form action="/search" method="get">
			<input type="text" name="searchterm" class="text-input" placeholder="Search entire site">
		</form>
	</section>
	<section class="section popular">
		<h3 class="section-title"><?php echo $popularPosts['heading'] ?? 'Popular Articles' ;?></h3>
    		<?php $i = 1; foreach($popularPosts['posts'] as $p):?>
    			<section class="post clearfix">
    				<div class="counter"><?=$i;?></div>
    				<a href="/<?php echo $p->String;?>" class="title"><?php echo $p->Title;?></a>
    			</section>
    		<?php $i++; endforeach;?>
	</section>	
	<section class="section topics">
	    <h3 class="section-title"><?php echo 'Like what I\'m doing?';?>😊</h3>
	    <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="thelinuxpost" data-color="#79D6B5" data-emoji=""  data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000" data-font-color="#fff" data-coffee-color="#fd0" ></script>
	</section>		
	<!--<section class="section contactus">-->
	<!--	<h3 class="section-title">Contact us</h3>-->
	<!--	<br />-->
	<!--	<form action="/contactus" method="post">-->
	<!--		<input type="email" name="contactus[email]" class="text-input contact-input" placeholder="Email">-->
	<!--		<textarea name="contactus[message]" class="text-input contact-input" rows="4" placeholder="Message"></textarea>-->
	<!--		<button type="submit" class="btn btn-big contact-btn"> Send </button>-->
	<!--	</form>-->
	<!--</section>-->
</div>