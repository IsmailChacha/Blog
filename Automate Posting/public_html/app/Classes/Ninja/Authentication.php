<?php
namespace Ninja
{
	// AUTH CLASS
	class Authentication 
	{
		private $usersTable;
		private $user;
		private $usernameColumn;
		private $passwordColumn;

		public function __construct(\Ninja\DatabaseHandler $usersTable, $usernameColumn, $passwordColumn)
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			
			$this->usersTable = $usersTable;
			$this->usernameColumn = $usernameColumn;
			$this->passwordColumn = $passwordColumn;
		}

		//LOGIN 
		public function login($username, $password) 
		{
			$username = strtolower($username);

			//LOGOUT ANY LOGGED IN USER BEFORE LOGGING IN ANOTHER
			if(!empty($_SESSION['username']) && $_SESSION['username'] !== $username)
			{
				$this->logout();
			}

			$conditions = [$this->usernameColumn => $username];
			$user = $this->usersTable->findOne($conditions);
			if(is_object($user) && password_verify($password, $user->{$this->passwordColumn}))
			{
				session_regenerate_id(); //REGENERATE SESSION ID

				//SET SESSION VARIABLES
				$_SESSION['Time Of Last LogIn'] = time();
				$_SESSION['Id'] = $user->Id;
				$_SESSION['Name'] = $user->FirstName . ' ' . $user->LastName;
				$_SESSION['First Name'] = $user->FirstName;
				$_SESSION['Last Name'] = $user->LastName;
				$_SESSION['Superuser'] = $user->Superuser;
				$_SESSION['Admin'] = $user->Admin;
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $user->{$this->passwordColumn};
				$_SESSION['isLoggedIn'] = $this->isLoggedIn();

				return true;
			} else
			{
				return false;
			}
		}
		
		//FIND OUT WHETHER USER IS STILL LOGGED IN AND CREDENTIALS STILL MATCH
		public function isLoggedIn()
		{
			if(empty($_SESSION['username']))
			{
				return false;
			} else 
			{
				$conditions = [$this->usernameColumn => strtolower($_SESSION['username'])];
				$this->user = $this->usersTable->findOne($conditions);
				if(!empty($this->user) && $this->user->{$this->passwordColumn} === $_SESSION['password'])
				{
					return true;
				} else
				{
					return false;
				}
			}
		}

		//FETCH USE, {AUTHOR OBJ}
		public function getUser()
		{
			if($this->isLoggedIn())
			{
				return $this->user;
			} else 
			{
				return false;
			}
		}

		//LOGOUT USERS
		public function logout()
		{
			unset($_SESSION);
			session_destroy();
			$_SESSION['message'] = 'You\'ve been logged out';
			$_SESSION['type'] = 'success';
			return;
		}
	}
}