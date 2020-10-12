<?php 
//send headers: we'll be writing to output and downloading the file
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="post.csv"');

// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');


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
	$total = $number;
	$donePages = 0; //progress tracker
	$numPages = ceil($total / 48);
	if(filter_var($resource, FILTER_VALIDATE_URL))
	{
		while($donePages < $numPages)
		{
			$scraped_page = curl($resource);
			$startTag = '<ul id="w0" class="accounting-list">'; 
			$endTag = '<div id="sidebar" class="js-sidebar faq_sidebar ">';
			$results = scrape_data($scraped_page, $startTag, $endTag); // Scraping out only the middle section of the results page that contains our results
			// echo $results; die(); //1
	
			$separateResultsArray = explode('<p class="accounting-item__info">', $results);   // Expploding the results into separate parts into an array
			// print_r($separateResultsArray); die(); //1 , 51
					 
			// For each separate result, scrape the URL
			foreach ($separateResultsArray as $singleResult) 
			{
				if ($singleResult != "") 
				{
					$results_urls[] = "https://studydaddy.com" . substr(scrape_data($singleResult, 'href="', '">'), 6); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
				}
			}

			// display($results_urls); die();
			unset($results_urls[0]); //remove first elemnt
			array_values($results_urls);//re-index the array
			++$donePages; //update count
			// display($results_urls); die();
		}

		// find the NEXT links
		$startTag = '</span></li>'; 
		$endTag = '</a></li>';
		$results = scrape_data($scraped_page, $startTag, $endTag); // Scraping out only the middle section of the results page that contains our results

		if($results)
		{
			if($donePages < $numPages)
			{
				$page = substr(strstr($results, 'page='), 5, 3); //1 Got it
				$url = "https://studydaddy.com/management-homework-help?page=" . ($page - 1); //Extract nextpage URI
				// display($url); die();
				sleep(rand(3,5));   // Sleep for 3 to 5 seconds. Useful if not using proxies. We don't want to get into trouble.
				verifyURL($url, $number); //repeat the loop
			} 
		} 


		// Handle the array of single posts
		// display($results_urls); //1
		$allPostsHTML = [];
		foreach($results_urls as $link)
		{
			$allPostsHTML[] = curl($link); // download the single post page
			sleep(rand(3,5));   // Sleep for 3 to 5 seconds. Useful if not using proxies. We don't want to get into trouble.
		}

		//build array of posts
		$posts = [];
		foreach($allPostsHTML as $singlePostHTML)
		{
			// display($singlePostHTML);
			$posts[] = fetchPost($singlePostHTML);
			// display($post[1]);//=>1
		}


		$delimiter = ",";
		$separator = '"';
		// write data to output
		if($handle = fopen("php://output", "w"))
		{
			fputcsv($handle, ["post_title","post_content","post_type","post_date","post_status", "post_category"], $delimiter, $separator); //add column headings
			foreach($posts as $post)
			{
				fputcsv($handle, $post, $delimiter, $separator);
			}
		}
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
		CURLOPT_USERAGENT => selectBrowser(),  // pick a random browser from the array to mascarade as
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

// Fetch the exact post content
function fetchPost($singlePostHTML)//=>1
{
	$articleHead = strip_tags(scrape_data($singlePostHTML, '<h1>', '</h1>'));
	$articleBody = strip_tags(scrape_data($singlePostHTML, '<div class="question-description tutor-info__about tutor-info__about_state_hidden js-cut-container">', '</div>'));
	return [$articleHead, $articleBody, "post","","", "psychology"];
}

// select browser
function selectBrowser()
{
	// we'll select one browser to use randomly
	$userAgents = ["Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36", "Mozilla/5.0 (X11; Ubuntu; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2919.83 Safari/537.36", "Mozilla/5.0 (X11; Ubuntu; Linux i686 on x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2820.59 Safari/537.36", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2762.73 Safari/537.36", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2656.18 Safari/537.36", "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/44.0.2403.155 Safari/537.36", "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36", "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2226.0 Safari/537.36", "Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36", "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36", "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36", "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36", "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:77.0) Gecko/20190101 Firefox/77.0", "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:77.0) Gecko/20100101 Firefox/77.0", "Mozilla/5.0 (X11; Linux ppc64le; rv:75.0) Gecko/20100101 Firefox/75.0", "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:39.0) Gecko/20100101 Firefox/75.0", "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.10; rv:75.0) Gecko/20100101 Firefox/75.0", "Mozilla/5.0 (X11; Linux; rv:74.0) Gecko/20100101 Firefox/74.0", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:61.0) Gecko/20100101 Firefox/73.0", "Mozilla/5.0 (X11; OpenBSD i386; rv:72.0) Gecko/20100101 Firefox/72.0", "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:71.0) Gecko/20100101 Firefox/71.0", "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:70.0) Gecko/20191022 Firefox/70.0", "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:70.0) Gecko/20190101 Firefox/70.0", "Mozilla/5.0 (Windows; U; Windows NT 9.1; en-US; rv:12.9.1.11) Gecko/20100821 Firefox/70",];
	// generate a random number between 1 and the numbe of useragents in the array
	$number = rand(0, count($userAgents) - 1);
	return $userAgents[$number];
}
