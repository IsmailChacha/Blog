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
       $routes = explode('/', $_SERVER['REQUEST_URI']);
      if($routes == strtok($_SERVER['REQUEST_URI'], '/'))
       {
				 $route = 'dashboard';
       }else 
       {
         if(count($routes) > 3)
         {
						if($routes[3] == '')
						{
							$route = 'dashboard';
						} else 
						{
							$route = $routes[3];
						}
						if(isset($routes[4]))
						{
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
        
      $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
      $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
      $entryPoint->run();

    } catch(\PDOException $e)
    {
        // Log the error and notify via Email
        $error = $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();
        error_log($error);
        $route = 'handleerrors';
        $method = 'GET';
        
        $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
        $entryPoint->run();
    }

