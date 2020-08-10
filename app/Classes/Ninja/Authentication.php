<?php
namespace Ninja
{
	class Authentication
	{
		private $usersTable;
		private $user;
		private $usernameColumn;
		private $passwordColumn;

		public function __construct(\Ninja\DatabaseHandler $usersTable, $usernameColumn, $passwordColumn)
		{
			session_start();
			$this->usersTable = $usersTable;
			$this->usernameColumn = $usernameColumn;
			$this->passwordColumn = $passwordColumn;
		}

		//LOGIN USERS
		public function login($username, $password) 
		{
			$username = strtolower($username);

			//LOGOUT ANY LOGGED IN USER BEFORE LOGGING IN ANOTHER
			if(!empty($_SESSION) && $_SESSION['username'] !== $username)
			{
				$this->logout();
			}

			$conditions = [$this->usernameColumn => $username];
			$users = $this->usersTable->findAll($conditions);

			if(!empty($users) && password_verify($password, $users[0]->{$this->passwordColumn}))
			{
				$user = $users[0];
				session_regenerate_id();

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
				$users = $this->usersTable->findAll($conditions);
				$this->user = $users[0];
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
				$_SESSION['Time Of Last LogIn'] = time();
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