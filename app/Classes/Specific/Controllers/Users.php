<?php
namespace Specific\Controllers
{
	//USERS CONTROLLER
	class Users
	{
		private $usersTable; //USERS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $authentication; //AUTHENTICATION CLASS INSTANCE

		public function __construct(\Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $mailingList, \Ninja\Authentication $authentication)
		{
			$this->usersTable = $usersTable;
			$this->mailingList = $mailingList;
			$this->authentication = $authentication;
		}

		//CHECK WHETHER LOGGED IN USER IS ADMIN/SUPER => WORKS PERFECTLY
		private function checkWhetherAdminOrSuperUser():bool //WORKS PERFECTLY
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

		private function superUserOnly()
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

		private function userOnly()
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

		public function dashboard() 
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				$author = $this->authentication->getUser();
				$title = $_SESSION['Superuser'] ? 'SuperUser Panel | Dashboard' : 'Author Panel | Dashboard';
				
				return [
					'title' => $title,
					'template' => 'dashboard.html.php',
					'variables' => [
						'title' => 'Dashboard',
						'author' => $author,
					],
				];
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function dashboard2()
		{
			if($this->userOnly())
			{
				$title = 'My account';
				return [
					'title' => $title,
					'template' => 'userdashboard.html.php',
					'variables' => [
							'title' => 'Dashboard',
					],
				];
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function profile()
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				//FETCH INFORMATION ABOUT USER
				$user = $this->authentication->getUser();
				$title = $_SESSION['Superuser'] ? 'SuperUser Panel | Profile' : 'Author Panel | Profile';

				return [
					'title' => $title,
					'template' => 'profile.html.php',
					'variables' => [
						'title' => 'Profile Information',
						'user' => $user,
					]
				];
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function profile2()
		{
			if($this->userOnly())
			{
				$title = 'My account';
				//FETCH INFORMATION ABOUT USER
				$user = $this->authentication->getUser();
				$title = 'Profile';

				return [
					'title' => $title,
					'template' => 'userprofile.html.php',
					'variables' => [
						'title' => 'Profile Information',
						'user' => $user,
					]
				];
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		//SERVE REGISTRATION FORM
		public function registrationForm():array
		{
			return ['template' => 'register.html.php', 'title' => 'Create a new account'];
		}

		//VALIDATE FIELDS DURING REGISTRATION 
		private function validateFields($user)
		{
			// Assume the data is valid to begin with
			$valid = true;
			$errors = [];	

			if (empty($user['FirstName'])) 
			{
				$valid = false;
				$errors [] = 'First name cannot be empty';
			}

			if (empty($user['LastName'])) 
			{
				$valid = false;
				$errors [] = 'Last name cannot be empty';
			}

			if (empty($user['Email'])) 
			{
				$valid = false;
				$errors [] = 'Email cannot be empty';

			}else if (filter_var($user['Email'], FILTER_VALIDATE_EMAIL) === false)
			{
				$valid = false;
				$errors[] = 'Invalid Email address';
			}else 
			{
				$user['Email'] = strtolower($user['Email']);
				$conditions = ['Email' => $user['Email']];
				$checkForExistingUser = $this->usersTable->findOne($conditions);
				if($checkForExistingUser)
				{
					$valid = false;
					array_push($errors, 'User with this email already exists');
				} else 
				{
					$user['Email'] = strtolower($user['Email']);
				}
			}

			if (empty($user['Password'])) 
			{
				$valid = false;
				$errors [] = 'Password cannot be empty';
			}

			if(count($errors)  >= 4)
			{
				unset($errors);
				$errors[] = 'Please fill out the form';				
			}

			return ['errors' => $errors, 'valid' => $valid];			
		}

		//GENERATE DATE
		private function generateDate() 
		{
			$date = new \DateTime(); 
			$formatedDate = $date->format('Y-m-d H:i:s');
			return $formatedDate;
		}

		//REGISTER USER
		public function registerUser()
		{
			$user = $_POST['user'];
			extract($this->validateFields($user)); //CREATES VARIABLES $errors and $valid IN THIS SCOPE

			if ($valid) 
			{
				$user['Id'] = '';
				$user['Password'] = Password_hash($user['Password'], PASSWORD_DEFAULT); //Hash the Password
				$user['Date'] = $this->generateDate();
				$affected_rows = $this->usersTable->save($user);
				if($affected_rows)
				{
					$_SESSION['message'] = 'Registration successful. Want to check out your account?';
					$_SESSION['type'] = 'success';
					
					header('location:/index.php/signin');
					exit();
				} else 
				{
					$_SESSION['message'] = 'An error occurred on our end. Sorry about that.';
					$_SESSION['type'] = 'error';

					return  [
						'template' => 'register.html.php', 
						'title' => 'Register an account', 
						'variables' => 
							[
							'user' => $user
						]
					];
				}	
			} else 
			{
				// If the data is not valid, show the form again and prefill it
				return  [
					'template' => 'register.html.php', 
					'title' => 'Register an account', 
					'variables' => 
						[
						'errors' => $errors,
						'type' => 'error',
						'user' => $user
					]
				];
			}
		}

		//MANAGE AUTHORS
		public function manageauthors()
		{
			if($this->superUserOnly())
			{
				$conditions = ['Admin' => 1];
				$authors = $this->usersTable->findAll($conditions);
	
				$title = 'SuperUser Panel | Manage Users';
	
				return [
					'title' => $title,
					'template' => 'manageauthors.html.php',
					'variables' => [
						'heading' => 'Manage authors',
						'authors' => $authors,
					]
				];
			} else
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		//PROMOTE USER 
		public function displayForm() 
		{
			if($this->superUserOnly())
			{

				$title = 'SuperUser Panel | Create author';

				return [
					'title' => $title,
					'template' => 'createauthor.html.php',
					'variables' => [
						'heading' => 'Enter user\'s validated email',
					]
				];
			} else
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function searchUserToPromote() 
		{
			if($this->superUserOnly())
			{
				$conditions = ['Email' => filter_var(strtolower($_POST['email']), FILTER_VALIDATE_EMAIL)];
				$users = $this->usersTable->findAll($conditions);
	
				if(count($users) === 0)
				{
					$_SESSION['message'] = 'User with that email is not yet registered.';
					$_SESSION['type'] = 'error';
	
					$title = 'SuperUser Panel | Create author';
	
					return [
						'title' => $title,
						'template' => 'createauthor.html.php',
						'variables' => [
							'heading' => 'Enter user\'s validated email',
						]
					];				
				} else 
				{
					$user = $users[0];
				
					if($user->Admin)
					{
						$_SESSION['message'] = 'User is already an author. Do you want to demote them?';
						$_SESSION['type'] = 'error';
	
						$title = 'SuperUser Panel | Demote user';
	
							return [
								'title' => $title,
								'template' => 'promoteauthor.html.php',
								'variables' => [
									'heading' => 'Demote author',
									'btn' => 'Demote author',
									'user' => $user
								]
							];	
					} else 
					{
						$_SESSION['message'] = 'User found. Proceed.';
						$_SESSION['type'] = 'success';
	
						$title = 'SuperUser Panel | Promote user';
	
						return [
							'title' => $title,
							'template' => 'promoteauthor.html.php',
							'variables' => [
								'heading' => 'Promote user',
								'user' => $user,
								'errors' => ['User found. Proceed.'],
							]
						];	
					}
				}
			} else
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function promoteUser() 
		{
			if($this->superUserOnly())
			{
				if(!isset($_POST['admin']))
				{
					$_POST['admin'] = 0;
					
					$record = ['Admin' => $_POST['admin'], 'Id' => $_POST['id']];
					$affected_rows = $this->usersTable->save($record);
					$title = 'SuperUser Panel | Manage Users';
	
					$conditions = ['Admin' => 1];
					$authors = $this->usersTable->findAll($conditions);
		
					foreach($authors as $author)
					{
						$totalposts = $author->getTotalByAuthor();
					}
		
					if($affected_rows)
					{
						$_SESSION['message'] = 'User striped of author role';
						$_SESSION['type'] = 'success';
	
						return [
							'title' => $title,
							'template' => 'manageauthors.html.php',
							'variables' => [
								'heading' => 'Manage authors',
								'authors' => $authors,
								'total' => $totalposts ?? 0,
							]
						];	
					} else 
					{
						$_SESSION['message'] = 'An error occurred';
						$_SESSION['type'] = 'error';
	
						return [
							'title' => $title,
							'template' => 'createauthor.html.php',
							'variables' => [
								'heading' => 'Manage authors',
							]
						];	
					}			
				} else 
				{
					$record = ['Admin' => 1, 'Id' => $_POST['id']];
					$affected_rows = $this->usersTable->save($record);
					$conditions = ['Admin' => 1];
					$authors = $this->usersTable->findAll($conditions);
					$title = 'SuperUser Panel | Manage Users';
		
					foreach($authors as $author)
					{
						$totalposts = $author->getTotalByAuthor();
					}
		
					if($affected_rows)
					{
						$_SESSION['message'] = 'User promoted to an author';
						$_SESSION['type'] = 'success';
	
						return [
							'title' => $title,
							'template' => 'manageauthors.html.php',
							'variables' => [
								'heading' => 'Manage authors',
								'authors' => $authors,
								'total' => $totalposts ?? 0,
							]
						];
					} else 
					{
						$_SESSION['message'] = 'An error occurred';
						$_SESSION['type'] = 'error';
	
						return [
							'title' => $title,
							'template' => 'createauthor.html.php',
							'variables' => [
								'heading' => 'Manage authors',
							]
						];	
					}		
				}
			} else
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		public function contactus()
		{
			if(isset($_POST['contactus']['email']) && filter_var($_POST['contactus']['email'], FILTER_VALIDATE_EMAIL))
			{
				$email = strtolower(filter_var($_POST['contactus']['email'], FILTER_VALIDATE_EMAIL));
				//DO SOMETHING WITH THIS EMAIL LATER ON
				
				$_SESSION['message'] = 'Thank you for contacting us.';
				$_SESSION['type'] = 'success';
				header('location:/');
				exit();
			} else 
			{
				$_SESSION['message'] = 'Please enter a valid email address.';
				$_SESSION['type'] = 'error';
				header('location:/');
				exit();
			}
		}

		public function newsLetter()
		{
			if(isset($_POST['newsletter']['email']) && filter_var($_POST['newsletter']['email'], FILTER_VALIDATE_EMAIL))
			{
				$email = strtolower(filter_var($_POST['newsletter']['email'], FILTER_VALIDATE_EMAIL));
				//DO SOMETHING WITH THIS EMAIL LATER ON

				$name = trim(ucfirst($_POST['newsletter']['name']));
				$existingSubsciber = $this->mailingList->findOne(['Email' => $email]);
				if($existingSubsciber)
				{
					$_SESSION['message'] = 'You already are subscribed to our mailing list. Thank you.';
					$_SESSION['type'] = 'success';
					header('location:/');
					exit();
				} else
				{
					$user = ['Name' => $name, 'Email' => $email, 'Id' => ''];
					// display($user);
					$this->mailingList->save($user);
					$_SESSION['message'] = 'Thank you for joining our mailing list';
					$_SESSION['type'] = 'success';
					header('location:/');
					exit();
				}

			} else 
			{
				$_SESSION['message'] = 'Please enter a valid email address.';
				$_SESSION['type'] = 'error';
				header('location:/');
				exit();
			}
		}
	}
}