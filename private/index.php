<?php 
  include '../path.php';
  require ROOT_PATH . '/app/includes/autoloader.php';
  // DISPLAY STUFF TEMPORARILY
  function display2($data)
  {
    echo '<pre>', print_r($data, true),'</pre>'; die();
  }

  try
    {
      // display2($_SERVER['REQUEST_URI']);
       $routes = explode('/', $_SERVER['REQUEST_URI']);
      //  display2($routes);
      if($routes == strtok($_SERVER['REQUEST_URI'], '/'))
       {
				 $route = 'dashboard';
       }else 
       {
        //  display2($routes);
         if(count($routes) > 3)
         {
						if($routes[3] == '')
						{
							$route = 'dashboard';
						} else 
						{
							$route = $routes[3];
							// display2($route);
						}
						if(isset($routes[4]))
						{
							// display2($routes[4]);
							$_GET['subfolder'] = $routes[4];    
            }
            if(isset($routes[5]))
						{
							// display2($routes[5]);
							$_GET['specificId'] = $routes[5];    
						}
				 }else 
				 {
					 $route = 'dashboard';
				 }
        }
      // echo '<pre>', print_r($routes, true),'</pre>'; die();
      // echo strtok(ltrim($param, '/'), '/'); die();
      $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
      //$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

      $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
      $entryPoint->run();

    } catch(\PDOException $e)
    {
      $title = 'An error has occurred';
      $output = 'Database error: ' . $e->getMessage() . ' in '
                . $e->getFile() . ':' . $e->getLine();
      include ROOT_PATH. '/app/templates/layout.html.php';
    }

