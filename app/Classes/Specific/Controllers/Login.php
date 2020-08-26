<?php
namespace Specific\Controllers
{
	//HANDLES LOGINS
	class Login
	{
		private $authentication; //AUTHENTICATION CLASS INSTANCE
		private const LOGTITLE = 'Sign In' . ' - ' . \Ninja\Variables::TITLE;

		//INITIALIZE AUTHENTICATION CLASS
		public function __construct(\Ninja\Authentication $authentication)
		{
			$this->authentication = $authentication;
		}

		//GENERATES LOGIN FORM TEMPLATE
		public function loginForm()
		{
			return ['template' => 'login.html.php', 'title' => self::LOGTITLE];
		}

		//HANDLE THE LOGIN PROCESS
		public function processLogin()
		{
			$errors = [];

			if($_POST['email'] == '' || $_POST['password'] == '' )
			{
				array_push($errors, 'Please fill out the form');
				$type = 'error';

				return ['template' => 'login.html.php', 
								'title' => self::LOGTITLE,
								'variables' => [
									'errors' => $errors,
									'type' => $type,
								]
				];
			} else 
			{
				if($this->authentication->login($_POST['email'], $_POST['password']))
				{
					header('location:/');
					exit();
				} else 
				{
					$_SESSION['message'] = 'Invalid username/password combination';
					$_SESSION['type'] = 'error';

					return ['template' => 'login.html.php', 
									'title' => self::LOGTITLE,
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