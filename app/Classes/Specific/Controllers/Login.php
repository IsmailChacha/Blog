<?php
namespace Specific\Controllers
{
	//HADNLE LOGINS
	class Login
	{
		private $authentication; //AUTHENTICATION CLASS INSTANCE

		//INITIALIZE AUTHENTICATION CLASS
		public function __construct(\Ninja\Authentication $authentication)
		{
			$this->authentication = $authentication;
		}

		//GENERATES LOGIN FORM TEMPLATE
		public function loginForm()
		{
			return ['template' => 'login.html.php', 'title' => 'Log in'];
		}

		//HANDLE THE LOGIN PROCESS
		public function processLogin()
		{
			if($_POST['email'] == '' || $_POST['password'] == '' )
			{
				$_SESSION['message'] = 'Please fill out all fields';
				$_SESSION['type'] = 'error';

				return ['template' => 'login.html.php', 
								'title' => 'Login',
							];
			} else 
			{
				if($this->authentication->login($_POST['email'], $_POST['password']))
				{
					header('location:/');
				} else 
				{
					$_SESSION['message'] = 'Invalid username/password combination';
					$_SESSION['type'] = 'error';

				return ['template' => 'login.html.php', 
						'title' => 'Login',
					];
				}
			}
		}				

		//LOGOUT USERS
		public function logout()
		{
			unset($_SESSION);
			session_destroy();
			$_SESSION['message'] = 'We had to logout previous user first. Proceed now';
			$_SESSION['type'] = 'success';
			header('location:/');
			exit();
		}
	}
}