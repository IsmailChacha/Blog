<?php 
  include 'path.php';
  require ROOT_PATH . '/app/includes/autoloader.php';
  // DISPLAY STUFF TEMPORARILY
  function display2($data)
  {
    echo '<pre>', print_r($data, true),'</pre>'; die();
  }

  try
    {
			// GENERATE DYNAMIC NAVIGATION MENU
			$requestURI = $_SERVER['REQUEST_URI'] . '/';

			$indexes = substr($requestURI, (stripos($requestURI, '/') + 1));
			$navigationLink = explode('/', $indexes);
			$_GET['navigationLink'] = [];

			$pos = 0;
			$newPos = 0;
			$length = strlen($indexes);
			$i = 0;

			{
				foreach($navigationLink as $key => $value)
				{
					if($i == 0)
					{
						$pos = stripos($indexes, '/');
						$newPos = $pos;
						if($key === '/index.php' || '/index.php/articles')
						{
							$key = '/'. substr($indexes, 0, $pos);
						}
						$value = 'Home';
						$_GET['navigationLink'][$key] = ucfirst($value);
						$currentPage = $key;
					}else 
					{
						$length = $pos - strlen($indexes);
						$newPos = stripos($indexes, '/', $pos + 1);
						if($newPos === false)
						{
							break;
						} else 
						{
							$key = substr($indexes, 0, stripos($indexes, '/', $newPos));
							if(strstr($key, 'index.php/search?searchterm='))
							{
								$key = '/';
								$value = 'Search';
								$_GET['navigationLink'][$key] = ucfirst($value);
							} else
							{
								$key = '/' . $key;
								if(stristr($key, 'Page=') || stristr($key, '/index.php/articles=') || stristr($key, 'More=')) //REMOVE PAGINATION FROM NAVIGATION MENU
								{
									unset($key);
									unset($value);
								} else
								{
									$_GET['navigationLink'][$key] = ucfirst($value);
									$currentPage = $key;
								}
							}
						}
					}
					$i++;
					$pos = $newPos;
				}
				// display2($_GET['navigationLink']);
				$_GET['currentPage'] = $currentPage;
			}

			// START THE CAR
      if(isset($_GET['searchterm']))
      {
        $route = 'search';
			} else 
			{
				$routes = explode('/', $_SERVER['REQUEST_URI']);

				if($routes == strtok($_SERVER['REQUEST_URI'], '/'))
				{
					$route = 'home';
				}else 
				{
					// display2($routes);
					if(count($routes) > 2)
					{
						$route = $routes[2];
 
						if(isset($routes[3]))
						{
						 $_GET['subfolder'] = $routes[3]; 
						}
						
						if(isset($routes[4]))
						{
						 $_GET['specific'] = $routes[4]; 
						}

						if(isset($routes[5]))
						{
						 $_GET['page'] = $routes[5]; 
						}
 
					} else 
					{
						$route = 'home';
					}
				 }
			}

			$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

      $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
      $entryPoint->run();

    } catch(\PDOException $e)
    {
      $title = 'An error has occurred';
      $output = 'Database error: ' . $e->getMessage() . ' in '
                . $e->getFile() . ':' . $e->getLine();
      include ROOT_PATH. '/app/templates/layout.html.php';
    }

