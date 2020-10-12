<?php 
// header('Content-type: text/csv');
// header('Content-Disposition: attachment; filename="demo.csv"');

// // do not cache the file
// header('Pragma: no-cache');
// header('Expires: 0');


function display($input)
{
	echo '<pre>' . print_r($input, true) . '</pre>';die();
}

function redirectWithError($error)
{
	header('Location : /Automate%20Posting/index.php?error='.$error);
	exit();
}

function verifyURL($resource, $number)
{
	if(filter_var($resource, FILTER_VALIDATE_URL))
	{
		$continue = TRUE;
		// while($continue)
		// {
			$scraped_page = curl($resource);
			$startTag = '<ul id="w0" class="accounting-list"><li class="accounting-item"><p class="accounting-item__info">'; 
			$endTag = '<div id="sidebar" class="js-sidebar faq_sidebar ">';
			$results = scrape_data($scraped_page, $startTag, $endTag); // Scraping out only the middle section of the results page that contains our results
			echo $scraped_page; die(); //1
	
			$separateResultsArray = explode('<p class="accounting-item__info">', $results);   // Expploding the results into separate parts into an array
			// print_r(count($separateResultsArray)); die(); //1 , 51
					 
			// For each separate result, scrape the URL
			// foreach ($separateResultsArray as $singleResult) {
			// 		if ($singleResult != "") {
			// 				$results_urls[] = "https://studydaddy.com" . substr(scrape_data($singleResult, 'href="', '">'), 6); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
			// 		}
			// }
			// <a class="accounting-item__link" href="/question/week-7-24">week-7</a>    </p>   
			
			// display($results_urls); die();
			// unset($results_urls[0]);
			// array_values($results_urls);
			// display($results_urls); die();
		// }

			// find the NEXT links
			// $startTag = '<i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i></a></li>'; 
			// $endTag = '<i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i>';
			// $results = scrape_data($scraped_page, $startTag, $endTag); // Scraping out only the middle section of the results page that contains our results
			// // echo $results; die(); //1
	
			// $separateResultsArray = explode('<li class="pager__item"><a class="pager__link"', $results);   // Expploding the results into separate parts into an array
			// display($separateResultsArray);
				sleep(rand(3,5));   // Sleep for 3 to 5 seconds. Useful if not using proxies. We don't want to get into trouble.
		} else
		{
			// return response to javascript
			display('Need a correct URL');
		}
	}

	if(isset($_POST['resource']) && !empty($_POST['resource']))
	{
		$resource = $_POST['resource'];
		$number = intval($_POST['number']);
		verifyURL($resource, $number);
	}

	function curl($url)
	{
		
		if (!function_exists('curl_init'))
		{
				die('cURL is not installed. Install and try again.');
		}

	// Assigning cURL options to an array
	$options = Array(
		CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
		CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
		CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
		CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
		CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
		CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
		CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
		CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
	);
	
		$ch = curl_init();  // Initialising cURL 
		curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
		$data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
		curl_close($ch);    // Closing cURL 
		return $data;   // Returning the data from the function 
	}

	// extract what we want
	function scrape_data($scraped_page, $startTag, $endTag)
	{
		$start = strpos($scraped_page, $startTag);
		$end = strpos($scraped_page, $endTag, $start);
		$length = $end-$start;
		$result = substr($scraped_page, $start, $length);
		return $result;
	}