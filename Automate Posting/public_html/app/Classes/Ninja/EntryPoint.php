<?php
namespace Ninja {
	//CONTROLS THE WHOLE APPLICATION. SERVES PAGES & TEMPLATES AND OUTPUT BUFFERS CONTENT INTO THEM
	//ALSO DOES ACCESS CONTROL
	class EntryPoint
	{

		private $route; // ROUTE OF PAGE THE VISITOR WANTS TO VIEW
		private $method; //METHOD USED, POST/GET
		private $routes; //ALL THE APLLICATION ROUTES
		private $authentication;
		private $variables;
		private $description = '<strong>Thelinuxpost</strong> is a blog that publishes about programming and linux tips, tricks and tutorials.';
		private $keywords = 'Programming, Linux Tips, Tricks and Tutorials';
		private $exceptions = ['signin', 'signup', 'about'];

		//INITIALIZES THE ROUTE, METHOD OF ACCESS, AND ALL THE AVAILABLE ROUTES
		public function __construct(string $route, string $method, \Ninja\Routes $routes)
		{
			$this->route = $route;
			$this->method = $method;
			$this->routes = $routes;
			$this->checkURL();
			$this->authentication = $this->routes->getAuthentication();
			$this->variables = new \Ninja\Variables($this->authentication);
		}

		//CHECK HOW ACCESS URL IS TYPED (ONLY LOWERCASE ENCOURAGED) //CONVERT ANY UPPERCASE URLS TO LOWERCASE
		private function checkURL()
		{
			if ($this->route !== strtolower($this->route)) {
				http_response_code(301);
				header('location:' .BASE_URL . '/'. strtolower($this->route));
			}
		}

		//LOAD TEMPLATE FOR WHATEVER THE PAGE USER WANTS TO ACCESS
		private function loadTemplate($templateFileName, $variables = [])
		{
			extract($variables);
			ob_start();
			include ROOT_PATH . '/app/templates/' . $templateFileName;
			return ob_get_clean();
		}

		//PERFORM OB
		private function outputBuffer($page)
		{
			if (isset($page['variables'])) 
			{
				$output = $this->loadTemplate($page['template'], $page['variables']);
				return $output;
			} else 
			{
				$output = $this->loadTemplate($page['template']);
				return $output;
			}
		}
		
        //Log Access 		
		private function logAccess()
		{
		    //'geoplugin_areaCode' => '', 'geoplugin_dmaCode' => '', 'geoplugin_countryCode' => 'KE', 'geoplugin_countryName' => 'Kenya', 'geoplugin_inEU' => 0,
		    //'geoplugin_euVATrate' => false, 'geoplugin_continentCode' => 'AF', 'geoplugin_continentName' => 'Africa', 'geoplugin_latitude' => '1', 'geoplugin_longitude' => '38',
		    //'geoplugin_locationAccuracyRadius' => '50', 'geoplugin_timezone' => 'Africa/Nairobi', 'geoplugin_currencyCode' => 'KES', 'geoplugin_currencySymbol' => 'K Sh', 
		    //'geoplugin_currencySymbol_UTF8' => 'K Sh', 'geoplugin_currencyConverter' => '108.5377', ) 
            // Fetch user geolocation details 
            $ip = $_SERVER['REMOTE_ADDR'];
            $locationDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
        	//Notify webmaster
        	$name = $_SESSION['Name'] ?? 'A guest user';
        	$to = 'admin@thelinuxpost.com';
        	$subject = 'Access Notification';
        	$message = $name . ' just accessed ' . $_SERVER['REQUEST_URI'] . ' from country: ' . $locationDetails['geoplugin_countryName'] . ' and timezone: ' . 
        	            $locationDetails['geoplugin_timezone'];
        	
    	    error_log($message, 1, 'ismail@thelinuxpost.com');
			
			return;
		}

		//ENGINE AND STEERING OF THE WHOLE APP
		public function run()
		{
			$routes = $this->routes->getRoutes();
			$topicsTable = $this->routes->getTopicsTable();
			$topics = $topicsTable->findAll([], 'Name ASC');
			// CHECK WHETHER REQUESTED PAGE EXISTS IN ROUTES DATA STRUCTURE
			if (array_key_exists($this->route, $routes)) 
			{
				//IF THE REQUESTED PAGE REQUIRES A LOGGED IN USER => 
				if (isset($routes[$this->route]['login']) && $routes[$this->route]['login'])
				{
					// GET THE USER
					$user = $this->authentication->getUser();
					//WE NEED TO KNOW WHETHER THEY ARE LOGGED IN OR NOT
					if (isset($routes[$this->route]['login']) && $routes[$this->route]['login'] && $this->authentication->isLoggedIn()) 
					{
						if ((time() - $_SESSION['Time Of Last LogIn']) > 21600000) 
						{
							$this->variables->sessionManager();
						} else 
						{
							$_SESSION['Time Of Last LogIn'] = time();

							$controller = $routes[$this->route][$this->method]['controller'];
							$action = $routes[$this->route][$this->method]['action'];
							$page = $controller->$action();

							$title = $page['title'];

							$output = $this->outputBuffer($page);

                            // Monitor actions
                            // $this->logAccess();
                            
							//RENDER THE PAGE
							echo $this->loadTemplate(
								'layout-two.html.php',
								[
									'output' => $output,
									'siteName' => \Ninja\Variables::SITENAME,
									'title' => $title,
									'footer' => \Ninja\Variables::TITLE,
								]
							);
							http_response_code(200);
						}
						//IF THEY ARE NOT LOGGED IN, REDIRECT THEM AND DISPLAY AN ERROR
					} else if (isset($routes[$this->route]['login']) && $routes[$this->route]['login'] && !$this->authentication->isLoggedIn()) 
					{
						http_response_code(401);
						http_response_code(511);
						
						$_SESSION['message'] = 'You need to login to access your account';
						$_SESSION['type'] = 'error';
						header('location:/');
						exit();
					}
					//REQUESTED PAGE DOESN'T REQUIRE A LOGGED IN USER => GUEST USERS
				} else 
				{
					// BUT THEY COULD STILL BE LOGGED IN:
					if (isset($_SESSION['Time Of Last LogIn']) && ((time() - $_SESSION['Time Of Last LogIn']) > 21600000)) 
					{
						$this->variables->sessionManager();
					} else
					{
						$_SESSION['Time Of Last LogIn'] = time();
						$controller = $routes[$this->route][$this->method]['controller'];
						$action = $routes[$this->route][$this->method]['action'];
						$page = $controller->$action();
						$title = $page['title'];
						$page['variables']['topics'] = $topics;
						$description = $page['description'] ?? $this->description;
						$keywords = $page['keywords'] ?? $this->keywords;
						$activeLink = $page['activeLink'] ?? '';
						
						if($page['featuredImage'] == '')
						{
						    $featuredImage = BASE_URL . '/favicon.ico';
						} else 
						{
						    $featuredImage = BASE_URL . '/assets/images/' . $page['featuredImage'];
						}
						
						$url = $page['url'] ?? 'Programming, Php, Java, ';
						$authorName = $page['authorName'] ?? 'Ismail Chacha';
						//LOAD THE TEMPLATE AND OUTPUT BUFFER INTO THE PAGE REQUESTED
						$output = $this->outputBuffer($page);
						
        				//Log the action
        				// $this->logAccess();
						//RENDER THE PAGE
						echo $this->loadTemplate
						(
							'layout.html.php',
							[
								'output' => $output,
								'siteName' => \Ninja\Variables::SITENAME,
								'title' => $title,
								'footer' => \Ninja\Variables::TITLE,
								'topics' => $topics,
								'description' => strip_tags($description),
								'keywords' => strip_tags($keywords),
								'featuredImage' => $featuredImage,
								'authorName' => $authorName,
								'activeLink' => $activeLink,
							]
						);
						http_response_code(200);
					}
				}
			} else 
			{
			    error_log('A guest user just tried to access a page that was not found: ' . $this->route, 1, 'admin@thelinuxpost.com');
				$this->variables->notFound();
			}
		}
	}
}
