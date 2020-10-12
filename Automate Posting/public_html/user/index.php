<?php 
  require_once '../path.php';
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
				 $route = 'dashboard2';
       }else 
       {
         if(count($routes) > 3)
         {
						if($routes[3] == '')
						{
							$route = 'dashboard2';
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
							$_GET['specificId'] = $routes[5];    
						}
				 }else 
				 {
					 $route = 'dashboard2';
         }
         
         $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

          $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
          $entryPoint->run();
      }
    } catch(\PDOException $e)
    {
        // Log the error and notify via Email
        $error = $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . getLine();
        error_log($error, 1, 'admin@thelinuxpost.com');
        $route = 'handleerrors';
        $method = 'GET';
        
        $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
        $entryPoint->run();
    }

