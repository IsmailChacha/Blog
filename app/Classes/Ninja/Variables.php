<?php 
namespace Ninja
{
	class Variables
	{
		public const SITENAME = '<span class="logo-style">LINUX</span><span class="logo-style-two">POST</span>';
		public const TITLE = 'LINUXPOST';
		public const SUPERUSERTITLE = 'ADMIN' . ' - ' . self::TITLE;
		public const ADMINTITLE = 'AUTHOR' . ' - ' . self::TITLE;
		public const USERTITLE = 'ACCOUNT' . ' - ' . self::TITLE;

		public $authentication;

		public function __construct($authentication)
		{
			$this->authentication = $authentication;
		}

		public function superUserOnly()
		{
			$user = $this->authentication->getUser();
			if($user->Superuser)
			{
				return true;
			}else
			{
				$this->authentication->logout();
				return false;				
			}
		}

		//CHECK WHETHER LOGGED IN USER IS ADMIN/SUPER => WORKS PERFECTLY
		public function checkWhetherAdminOrSuperUser():bool //WORKS PERFECTLY
		{
			$user = $this->authentication->getUser();
			if($user->Superuser) //SUPERUSER
			{
				return true;
			} else if($user->Admin)//ADMIN
			{
				return true;
			} else
			{
				$this->authentication->logout();
				return false;
			}
		}
		
		public function userOnly()
		{
			$user = $this->authentication->getUser();
			if(!$user->Superuser && !$user->Admin)
			{
				return true;
			}else
			{
				$this->authentication->logout();
				return false;				
			}
		}	

		public function notAuthorized()
		{
			http_response_code(401);
			header('location:/');
			exit();
		}

		public function notFound()
		{
			http_response_code(404);
			header('location:/404.php');
			exit();
		}

		public function serverError()
		{
			http_response_code(500);
			header('location:/');
			exit();
		}

		public function sessionManager()
		{
			$this->authentication->logout();
			$_SESSION['message'] = 'You\'ve been logged out due to inactivity';
			$_SESSION['type'] = 'error';
			header('location: /index.php/signin');
			exit();
		}
	}
}