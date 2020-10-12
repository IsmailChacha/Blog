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
       // START THE CAR
        if(isset($_GET['searchterm']))
        {
            $route = 'search';
    	} else 
    	{
            $pages = ['topics', 'mailinglist', 'contactus', 'signup', 'signin', 'signout', 'aboutus'];
    		$route = 'home'; //SET THE DEFAULT ROUTE INCASE SOMETHING GOES WRONG
    		$routes = explode('/', $_SERVER['REQUEST_URI']);
        		if(count($routes) >= 2)
        		{
        		 //   display2(count($routes));
    			if(count($routes) == 2)
    			{
    			    if($routes[1] == '')
    			    {
    			        $route = 'home';
    			    } else 
    			    {
    			        if(in_array($routes[1], $pages))
    					{
    						$route = $routes[1];
    					} else 
    					{
                            // ROUTE FOR VIEWING ARTICLES
    						$route = 'home';
    						$_GET['subfolder'] = $routes[1];
    					}
    			    }
        			} elseif(count($routes) == 3)
        			{
        			    // display2($routes);
        				if(in_array($routes[1], $pages))
        				{
        					$route = $routes[1];
        					$_GET['subfolder'] = $routes[2];
        				} else 
        				{
        					// ROUTE FOR TOPIC ARTICLES
        					$route = 'home';
        					$_GET['subfolder'] = $routes[2];
        				}
        
        			} elseif(count($routes) == 4)
        			{
        				if($routes[2] == 'topics')
        				{
        					$route = $routes[2];
        					$_GET['subfolder'] = $routes[3];
        
        				} else 
        				{
        					$route = 'home';
        				}
        			} elseif(count($routes) == 5)
        			{
        				$route = $routes[1];
        				$_GET['subfolder'] = $routes[2];
        				$_GET['specific'] = $routes[3];
        			}
    
    			} else 
    			{
    				$route = 'home';
    			}
    		}
    
          $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    
          $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
          $entryPoint->run();

    } catch(\PDOException $e)
    {
        // Log the error and notify via Email
        $error = $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . getLine();
        error_log($error, 1, 'admin@thelinuxpost.com');
        $route = 'handleerrors';
        $method = 'GET';
        
        $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
        $entryPoint->run();
        // $output = 'Database error: ' . $e->getMessage() . ' in '
        //         . $e->getFile() . ':' . $e->getLine();
        include ROOT_PATH. '/app/templates/layout.html.php';
    }

