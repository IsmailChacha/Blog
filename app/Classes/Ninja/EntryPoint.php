<?php

namespace Ninja {
	//CONTROLS THE WHOLE APPLICATION. SERVES PAGES & TEMPLATES AND OUTPUT BUFFERS CONTENT INTO THEM
	//ALSO DOES ACCESS CONTROL
	class EntryPoint
	{
		private $route; // ROUTE OF PAGE THE VISITO WANTS TO VIEW
		private $method; //METHOD USED, POST/GET
		private $routes; //ALL THE APLLICATION ROUTES
		private $authentication;
		private $variables;

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

		//ENGINE AND STEERING OF THE WHOLE APP
		public function run()
		{
			$routes = $this->routes->getRoutes();
			$topicsTable = $this->routes->getTopicsTable();
			$topics = $topicsTable->findAll([], 'Name ASC');

			// CHECK WHETHER REQUESTED PAGE EXISTS IN ROUTES DATA STRUCTURE
			if (array_key_exists($this->route, $routes)) 
			{
				http_response_code(200);
				http_response_code(202);
				//IF THE REQUESTED PAGE REQUIRES A LOGGED IN USER => 
				if (isset($routes[$this->route]['login']) && $routes[$this->route]['login'])
				{
					// GET THE USER
					$user = $this->authentication->getUser();
					//WE NEED TO KNOW WHETHER THEY ARE LOGGED IN OR NOT
					if (isset($routes[$this->route]['login']) && $routes[$this->route]['login'] && $this->authentication->isLoggedIn()) 
					{
						if ((time() - $_SESSION['Time Of Last LogIn']) > 86400000) 
						{
							$this->variables->sessionManager();
						} else 
						{
							$_SESSION['Time Of Last LogIn'] = time();

							$controller = $routes[$this->route][$this->method]['controller'];
							$action = $routes[$this->route][$this->method]['action'];

							$page = $controller->$action();

							$title = $page['title'];

							http_response_code(202);
							$output = $this->outputBuffer($page);

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
							http_response_code(201);
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
					if (isset($_SESSION['Time of Last Login']) && (time() - $_SESSION['Time Of Last LogIn']) > 86400000) 
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
						$title = $page['title'];
						$description = $page['description'] ?? 'Get access to the best learning materials for your programming or coding path';
						$keywords = $page['keywords'] ?? 'Programming, Php, Java, ';
						$authorName = $page['authorName'] ?? 'Ismail Chacha';

						//LOAD THE TEMPLATE AND OUTPUT BUFFER INTO THE PAGE REQUESTED
						http_response_code(202);
						$output = $this->outputBuffer($page);

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
								'authorName' => $authorName,
							]
						);
						http_response_code(201);
					}
				}
			} else 
			{
				$this->variables->notFound();
			}
		}
	}
}
