<?php
namespace Specific\Controllers
{
	//USERS CONTROLLER
	class Users
	{
		private $usersTable; //USERS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $authentication; //AUTHENTICATION CLASS INSTANCE
		private $variables = '';
		
		

		private const REGTITLE = 'Sign Up'  . ' | ' . \Ninja\Variables::TITLE;

		public function __construct(\Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $mailingList, \Ninja\Authentication $authentication)
		{
			$this->usersTable = $usersTable;
			$this->mailingList = $mailingList;
			$this->authentication = $authentication;
			$this->variables = new \Ninja\Variables($this->authentication);
		}

		public function dashboard() 
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
				$author = $this->authentication->getUser();
				
				return [
					'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
					'template' => 'dashboard.html.php',
					'variables' => [
						'title' => 'Dashboard',
						'author' => $author,
					],
				];
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		public function dashboard2()
		{
			if($this->variables->UserOnly())
			{
				return [
					'title' => \Ninja\Variables::USERTITLE,
					'template' => 'userdashboard.html.php',
					'variables' => [
							'title' => 'Dashboard',
					],
				];
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		public function profile()
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
				//FETCH INFORMATION ABOUT USER
				$user = $this->authentication->getUser();

				return [
					'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
					'template' => 'profile.html.php',
					'variables' => [
						'title' => 'Profile Information',
						'user' => $user,
					]
				];
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		public function profile2()
		{
			if($this->variables->UserOnly())
			{
				$title = 'My account';
				//FETCH INFORMATION ABOUT USER
				$user = $this->authentication->getUser();

				return [
					'title' => \Ninja\Variables::USERTITLE,
					'template' => 'userprofile.html.php',
					'variables' => [
						'title' => 'Profile Information',
						'user' => $user,
					]
				];
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		//SERVE REGISTRATION FORM
		public function registrationForm():array
		{
			return ['template' => 'register.html.php', 'title' => self::REGTITLE];
		}

		//VALIDATE FIELDS DURING REGISTRATION 
		private function validateFields($user)
		{
			// Assume the data is valid to begin with
			$valid = true;
			$errors = [];	
			
            //verify reCaptcha
            $secretKey = "6Lderc8ZAAAAAFVHv0yVOpmmqDjP2_XlbCQIH0hJ"; //captcha secret key
            $captcha = $_POST['g-recaptcha-response'];
            
            if(!$captcha)
            {
                $valid = false;
                array_push($errors, 'Please check the verification box at the bottom');
            } else 
            {
			    // send captcha data to google
			    $ip = $_SERVER['REMOTE_ADDR'];
			    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			    $responseKeys = json_decode($response, true); //decode the response
			    
			    if(intval($responseKeys["success"]) !== 1)
			    {
			        $valid = false;
			        array_push($errors, 'Please check the verification box again');
			    } else 
			    {
        			if (empty($user['FirstName'])) 
        			{
        				$valid = false;
        				$errors [] = 'First name cannot be blank';
        			}
        
        			if (empty($user['LastName'])) 
        			{
        				$valid = false;
        				$errors [] = 'Last name cannot be blank';
        			}
        
        			if (empty($user['Email'])) 
        			{
        				$valid = false;
        				$errors [] = 'Email cannot be blank';
        
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
        				$errors [] = 'Password cannot be blank';
        			}
        
        			if(count($errors)  >= 4)
        			{
        				unset($errors);
        				$errors[] = 'Please fill out the form';				
        			}
			    }
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
					
					header('location:/signin');
					exit();
				} else 
				{
					$_SESSION['message'] = 'An error occurred on our end. Sorry about that.';
					$_SESSION['type'] = 'error';

					return  [
						'template' => 'register.html.php', 
						'title' => self::REGTITLE, 
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
					'title' => self::REGTITLE, 
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
			if($this->variables->superUserOnly())
			{
				$conditions = ['Admin' => 1];
				$authors = $this->usersTable->findAll($conditions);
	
				$title = 'SuperUser Panel | Manage Users';
	
				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'manageauthors.html.php',
					'variables' => [
						'heading' => 'Manage authors',
						'authors' => $authors,
					]
				];
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		//PROMOTE USER 
		public function displayForm() 
		{
			if($this->variables->superUserOnly())
			{

				$title = 'SuperUser Panel | Create author';

				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'createauthor.html.php',
					'variables' => [
						'heading' => 'Enter user\'s validated email',
					]
				];
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		public function searchUserToPromote() 
		{
			if($this->variables->superUserOnly())
			{
				$conditions = ['Email' => filter_var(strtolower($_POST['email']), FILTER_VALIDATE_EMAIL)];
				$users = $this->usersTable->findAll($conditions);
	
				if(count($users) === 0)
				{
					$_SESSION['message'] = 'User with that email is not yet registered.';
					$_SESSION['type'] = 'error';
	
					$title = 'SuperUser Panel | Create author';
	
					return [
						'title' => \Ninja\Variables::SUPERUSERTITLE,
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
								'title' => \Ninja\Variables::SUPERUSERTITLE,
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
							'title' => \Ninja\Variables::SUPERUSERTITLE,
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
				$this->variables->notAuthorized();
			}
		}

		public function promoteUser() 
		{
			if($this->variables->superUserOnly())
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
							'title' => \Ninja\Variables::SUPERUSERTITLE,
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
							'title' => \Ninja\Variables::SUPERUSERTITLE,
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
							'title' => \Ninja\Variables::SUPERUSERTITLE,
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
							'title' => \Ninja\Variables::SUPERUSERTITLE,
							'template' => 'createauthor.html.php',
							'variables' => [
								'heading' => 'Manage authors',
							]
						];	
					}		
				}
			} else
			{
				$this->variables->notAuthorized();
			}
		}
		
		public function displayContactUsForm()
		{
	    	return [
				'template' => 'contactus.html.php',
				'variables' => [
				// 	'heading' => 'Manage authors',
				]
			];	
		}

        // validate inputs from contact us form
        public function validateDetails($inputs)
        {
            $valid = true; //assume all fields were filled properly then set it to false if a field is invalid
            $errors = []; //store errors
            $title = "Contact Us";
            $type = 'error';

            //verify reCaptcha
            $secretKey = "6Lderc8ZAAAAAFVHv0yVOpmmqDjP2_XlbCQIH0hJ"; //captcha secret key
            $captcha = $_POST['g-recaptcha-response'];
            
            if(!$captcha)
            {
                $valid = false;
                array_push($errors, 'Please check the verification box at the bottom');
            }else 
			{
			    // send captcha data to google
			    $ip = $_SERVER['REMOTE_ADDR'];
			    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			    $responseKeys = json_decode($response, true); //decode the response
			    if(intval($responseKeys["success"]) !== 1)
			    {
			        $valid = false;
			        array_push($errors, 'Please check the verification box again');
			    } else 
			    {
                    // process the data
                    //First Name
                    if(!isset($inputs['FirstName']) || $inputs['FirstName'] == "")
                    {
                        $valid = false;
                        array_push($errors, "First Name is required"); 
                    } 
                    
                    // Last Name
                    if(!isset($inputs['LastName']) || $inputs['LastName'] == "")
                    {
                        $valid = false;
                        array_push($errors, "Last Name is required");
                    }
                    
                    
                    // Email
                    if(!isset($inputs['Email']) || !filter_var($inputs['Email'], FILTER_VALIDATE_EMAIL))
                    {
                        $valid = false;
                        array_push($errors, "Provide a valid email addredd");
                    }
                    
                    
                    // Subject
                    if(!isset($inputs['Subject']) || $inputs['Subject'] == "")
                    {
                        $valid = false;
                        array_push($errors, "Subject is required");
                    }            
                    
                    // Message
                    if(!isset($inputs['Message']) || $inputs['Message'] == "")
                    {
                        $valid = false;
                        array_push($errors, "Message is required");
                    } 	
                    
			    }
			}
			
			// return the results
            return ["errors" => $errors, "valid" => $valid, "type" => "error"];
        }
        
		public function contactus()
		{
		    $details = $_POST;
		    foreach($details as $field)
		    {
		        trim($field);
		    }
		    
		    $title = "Contact us | " . \Ninja\Variables::TITLE;
		    
		    $firstname = $details["FirstName"];
		    $lastname = $details["LastName"];
		    $name = $firstname . ' ' . $lastname;
		    $email = $details["Email"];
		    $subject = $details["Subject"];
		    $message = $details["Message"];
		    
		    $host = "sbg104.truehost.cloud";
		    $to = "ismail@thelinuxpost.com";
		    $toName = "Ismail Chacha";
		  //  display($details);//1
            extract($this->validateDetails($details));
            if($valid)
            {
                require ROOT_PATH . '/app/includes/contactus.php'; //does the actual sending
                
                if($status)
                {
                	return ['template' => 'contactus.html.php', 
            		'title' => $title,
            		'variables' => [
            		    $firstname => $firstname,
            		    $lastname => $lastname,
            		    $email => $email,
            		    $subject => $subject,
            		    $message => $message,
            			'errors' => ["We received your message. We'll get back to you ASAP."],
            			'type' => "success",
                		]
                    ];
                } else 
                {
                	return ['template' => 'contactus.html.php', 
            		'title' => $title,
            		'variables' => [
            		    $firstname => $firstname,
            		    $lastname => $lastname,
            		    $email => $email,
            		    $subject => $subject,
            		    $message => $message,
            			'errors' => ["We regret an error occurred sending the message.Try again."],
            			'type' => $type,
                		]
                    ];                    
                }
            } else 
            {
                // return and prefill the form
            	return ['template' => 'contactus.html.php', 
						'title' => $title,
						'variables' => [
						    "firstname" => $firstname,
						    "lastname" => $lastname,
						    "email" => $email,
						    "subject" => $subject,
						    "message" => $message,
							'errors' => $errors,
							'type' => $type,
						]
				];
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