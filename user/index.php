<?php 
  require_once '../path.php';
  require ROOT_PATH . '/app/includes/autoloader.php';

  try
    {
      $route = $_GET['route'] ?? 'dashboard';
      //echo $route;
      $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
      //$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

      $entryPoint = new \Ninja\EntryPoint($route, $method, new \Specific\Controllers\BlogRoutes());
      $entryPoint->run();

    } catch(\PDOException $e)
    {
      $title = 'An error has occurred';
      $output = 'Database error: ' . $e->getMessage() . ' in '
                . $e->getFile() . ':' . $e->getLine();
      include ROOT_PATH. '/app/templates/layout-two.html.php';
    }

