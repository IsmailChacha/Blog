<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CSV Generator</title>
	<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
	<!-- <?php #require 'logic/index.php';?> -->
	<main id="csv-gen-main">
		<header id="csv-gen-header">
			<p>What we do? We scrappe websites and generate CSV files. Explore below.</p>
		</header>
		<div id="csv-gen-main-content">
			<div id="info">
				Would you like to enter a URI to scrappe?
				<?php
					if(isset($_GET['error']) && $_GET['error'])
					{
						$error = $_GET['error'];
						echo "<p>$error</p>";
					} else if(isset($_GET['finished']))
					{
						echo "<p> Finished ". $_GET['number'] ." posts</p>";
					}
				?>
			</div>
			<div id="csv-logic">
				<form action="logic/index.php" name="input-form" id="input-form" method="POST">
					<label for="resource"> Parent URI <br>
						<input type="url" name="resource" id="resource" placeholder="Enter the resource url" required>
					</label><br>
					<!-- <label for="resource"> Next page URI <br>
						<input type="text" name="next" id="next" placeholder="Class of the next button" required>
					</label><br> -->
					<label for="resource"> How many posts you want to generate? <br>
						<input type="number" name="number" id="number" required  min="0" step="5">
					</label><br>
					<button type="submit" id="submit-resource">Next</button>
				</form>
			</div>

			<!-- reponses -->
			<div class="responses">
				<p class="status">Status</p>
				<div class="message">

				</div>
				<div class="number">

				</div>
				<button type="button" value="continue" class="action-buttons" id="continue">Continue</button>
				<button type="button" value="cancel" class="action-buttons" id="cancel">Cancel</button>
			</div>
		</div>
	</main>
	<footer id="footer">

	</footer>
	<!-- <script src="logic/index.js"></script> -->
</body>
</html>