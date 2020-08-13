<?php
namespace Ninja
{
	//CONTROLS THE WHOLE APPLICATION. SERVES PAGES & TEMPLATES AND OUTPUT BUFFERS CONTENT INTO THEM
	//ALSO DOES ACCESS CONTROL
	class EntryPoint 
	{
		private $route; // ROUTE OF PAGE THE VISITO WANTS TO VIEW
		private $method; //METHOD USED, POST/GET
		private $routes; //ALL THE APLLICATION ROUTES

		//INITIALIZES THE ROUTE, METHOD OF ACCESS, AND ALL THE AVAILABLE ROUTES
		public function __construct (string $route, string $method,\Ninja\Routes $routes)
		{
			$this->route = $route;
			$this->method = $method;
			$this->routes = $routes;
			$this->checkURL(); 
		}

		//CHECK HOW ACCESS URL IS TYPED (ONLY LOWERCASE ENCOURAGED) //CONVERT ANY UPPERCASE URLS TO LOWERCASE
		private function checkURL()
		{
			if($this->route !== strtolower($this->route))
			{
				http_response_code(301);
				header('location:index.php' . strtolower($this->route));
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
			if(isset($page['variables']))
			{
				$output = $this->loadTemplate($page['template'], $page['variables']);
				return $output;
			} else 
			{
				$output = $this->loadTemplate($page['template']);
				return $output;
			}
		}

		//ENGINE AND STEERING OF THE WHOLE APP
		public function run ()
		{
			
			$routes = $this->routes->getRoutes();
			$authentication = $this->routes->getAuthentication();
			$topicsTable = $this->routes->getTopicsTable();
			$topics = $topicsTable->findAll([], 'Name ASC');

			// CHECK WHETHER REQUESTED PAGE EXISTS IN ROUTES DATA STRUCTURE
			if(array_key_exists($this->route, $routes))
			{
			//IF THE REQUESTED PAGE REQUIRES A LOGGED IN USER => 
				if(isset($routes[$this->route]['login']) && $routes[$this->route]['login'])
				{
					// GET THE USER
					$user = $authentication->getUser();
					//WE NEED TO KNOW WHETHER THEY ARE LOGGED IN OR NOT
					if(isset($routes[$this->route]['login']) && $routes[$this->route]['login'] && $authentication->isLoggedIn())
					{
						if((time() - $_SESSION['Time Of Last LogIn']) > 10)
						{
							$authentication->logout();
							$_SESSION['message'] = 'You\'ve been logged out due to inactivity';
							$_SESSION['type'] = 'error';
							header('location: /index.php/signin');
						}else
						{
							$controller = $routes[$this->route][$this->method]['controller'];
							$action = $routes[$this->route][$this->method]['action'];

							$page = $controller->$action();

							$title = $page['title'];
							$output = $this->outputBuffer($page);
							//SERVE THE PAGE
							echo $this->loadTemplate('layout-two.html.php', 
										[
											'output' => $output,
											'title' => $title,
										]);			
						}
						//IF THEY ARE NOT LOGGED IN, REDIRECT THEM AND DISPLAY AN ERROR
					} else if(isset($routes[$this->route]['login']) && $routes[$this->route]['login'] && !$authentication->isLoggedIn())
					{
						$_SESSION['message'] = 'You need to login to access your account';
						$_SESSION['type'] = 'error';
						header('location:/');
						exit();
					}				
					//REQUESTED PAGE DOESN'T REQUIRE A LOGGED IN USER => GUEST USERS
				} else 
				{
					// BUT THEY COULD STILL BE LOGGED IN:
					if(isset($_SESSION['Time of Last Login']))
					{
						if((time() - $_SESSION['Time Of Last LogIn']) > 10)
						{
							$authentication->logout();
							$_SESSION['message'] = 'You\'ve been logged out due to inactivity';
							$_SESSION['type'] = 'error';
							return;
						}
					}

					$controller = $routes[$this->route][$this->method]['controller'];
					$action = $routes[$this->route][$this->method]['action'];
					$page = $controller->$action();

					$title = $page['title'];
					$page['variables']['topics'] = $topics;
					$title = $page['title'];
					$description = $page['description'] ?? 'Get access to the best learning materials for your programming or coding life';
					$keywords = $page['keywords'] ?? 'Programming, Php, Java';
					$authorName = $page['authorName'] ?? 'Ismail Chacha';

					//LOAD THE TEMPLATE AND OUTPUT BUFFER INTO THE PAGE REQUESTED
					$output = $this->outputBuffer($page);

					//SERVE THE PAGE
					echo $this->loadTemplate('layout.html.php', 
								[
									'output' => $output,
									'title' => $title,
									'topics' => $topics,
									'description' => $description,
									'keywords' => $keywords,
									'authorName' => $authorName,
								]);						
				}
			} else
			{
				display('Requested URI was not found on this server');
				header('location:/');
			}
		}
	}
}
