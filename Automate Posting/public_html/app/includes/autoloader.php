<?php
	function autoloader($className)
	{
		$fileName =  str_replace('\\', '/', $className);
		if($className != 'PHPMailer')
		{
		    $file = ROOT_PATH .'/app/Classes/' . $fileName . '.php';
		}
		
		require_once($file);
	}
	
	spl_autoload_register('autoloader');