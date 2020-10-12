<?php
namespace Specific\Controllers
{
	//HANDLES LOGINS
	class Login
	{
		private $authentication; //AUTHENTICATION CLASS INSTANCE
		private const LOGTITLE = 'Sign In' . ' | ' . \Ninja\Variables::TITLE;

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
			
            //verify reCaptcha
            $secretKey = "6Lderc8ZAAAAAFVHv0yVOpmmqDjP2_XlbCQIH0hJ"; //captcha secret key
            $captcha = $_POST['g-recaptcha-response'];
            
            if(!$captcha)
            {
                array_push($errors, 'Please check the verification box at the bottom');
                $type = 'error';
            	return ['template' => 'login.html.php', 
							'title' => self::LOGTITLE,
							'variables' => [
								'errors' => $errors,
								'type' => $type,
							]
				];
            } elseif($_POST['email'] == '' || $_POST['password'] == '' )
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
			    // send captcha data to google
			    $ip = $_SERVER['REMOTE_ADDR'];
			    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			    $responseKeys = json_decode($response, true); //decode the response
			    
			    if(intval($responseKeys["success"]) !== 1)
			    {
			        array_push($errors, 'Please check the verification box again');
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