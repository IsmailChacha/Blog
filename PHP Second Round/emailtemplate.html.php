<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Email Template</title>
	<style>
		* {
			margin:0;
			box-sizing: border-box;
			text-decoration:none;
		}

		body {
			height: max-content;
			width: 100%;
			font-size:18px;
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
			color:#4c4c4c;
		}

		.email {
			padding: 10px;
		}

		.intro {
			text-align:left;
		}

		.img-container {
			width:100%;
			height:max-content;
		}

		.img-container > img {
			max-width:100%;
			max-height:100%;
		}

		p {
			padding: 8px 0;
			margin-bottom: 4px;
		}

		#readmore {
			color:blue;
			text-decoration: none;
		}

		.footer {
    width: 100%;
    /*border-top: 1px solid #ccc;*/
    /*background:#1d2d42;*/
    background:#1f385c;
		color:#cce1ff;
  }

		.footer-info {
        width: 100%;
        padding: 10px;
        height: 100px;
        /* color: #cce1ff !important; */
        opacity: .5;
   }
   
   .socials, .about, .copyright {
       padding:4px;
   }

	 .about > a {
		display:block;
		color: #cce1ff !important;
		padding:4px;
		width: 100%;
		text-align:center
	 }

	 .about > a:hover {
		color: #009bff !important;
	 }

	 .add2any {
		 width: max-content;
		 margin: 0 auto;
	 }

	 #copyright {
		text-align:center
	 }

	</style>
</head>
<body>
	<div class="email">
		<header>
			<p class="intro">Hi <?php echo $name;?></p>
		</header>
		<div class="content">
			<div class="img-container">
				<img src="<?php echo $imageSrc;?>" title="<?php echo $imageTitle;?>"/>
			</div>
		<!-- Email content -->
			<?php echo $email; ?>

			<a id="readmore" href="<?php echo $readMoreLink;?>" title="Read more"><?php echo $readMoreText;?></a>

			<p>You are receiving this because you opted in at <a href="<?php echo BASE_URL;?>" title="TheLinuxPost">TheLinuxPost</a></p>
			</div>
	</div>
	<footer class="footer email">
		<div class="footer-info">
        <div class="socials">
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style a2a_follow add2any">
                <a class="a2a_button_twitter" data-a2a-follow="thelinuxpost"></a>
                <a class="a2a_button_facebook" data-a2a-follow="thelinuxpost"></a>
                <a class="a2a_button_github" data-a2a-follow="IsmailChacha"></a>
                <a class="a2a_button_linkedin" data-a2a-follow="IsmailChacha"></a>
                <a class="a2a_button_instagram" data-a2a-follow="thelinuxpost"></a>
                <a class="a2a_button_pinterest" data-a2a-follow="thelinuxpost"></a>
            </div>
        </div>
        <div class="about">
            <a href="/contactus">Contact us</a>
            <a href="/aboutus">About</a>
				</div>
				<div class="copyright">
					<p id="copyright">Copyright &copy; <?php echo date_format(new \DateTime(), 'Y') ; echo ' Thelinuxpost';?></p>
				</div>  			
		</div> 	          
	</footer>
	<script async src="https://static.addtoany.com/menu/page.js"></script>
</body>
</html>