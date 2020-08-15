<?php
namespace Specific\Controllers
{
	//SPECIFIES THE CONTROLLERS AND ACTIONS FOR EVERY REQUEST AND REQUEST METHOD AND RETURNS THAT TO ENTRYPOINT CLASS
	class BlogRoutes implements \Ninja\Routes
	{
		private $usersTable; //USERS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $postsTable; //POSTS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $topicsTable; //TOPICS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $postTopics; //POSTS-TOPICS JOIN TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $authentication; //AUTHENTICATION CLASS INSTANCE

		//INSTANTIATE THE VARIOUS CLASS VAIABLES AND SUPPLY THEIR REQUIED CONSTRUCTOR AGS
		public function __construct()
		{
			include ROOT_PATH . '/app/includes/DatabaseConnection.php';

			$this->postsTable = new \Ninja\DatabaseHandler($pdo, 'Articles', 'String', 'AuthorId', '\Specific\Entity\Post', [&$this->usersTable, &$this->postTopics]);
			
			$this->usersTable = new \Ninja\DatabaseHandler($pdo, 'Users', 'Id', 'Email', '\Specific\Entity\Author', [&$this->postsTable]);
			
			$this->topicsTable = new \Ninja\DatabaseHandler($pdo, 'Topics', 'Id', 'Name', '\Specific\Entity\Category', [&$this->postsTable, &$this->postTopics]);
			
			$this->postTopics = new \Ninja\DatabaseHandler($pdo, 'ArticleTopics', 'TopicId', '');
			$this->mailingListTable = new \Ninja\DatabaseHandler($pdo, 'Mailing_List', 'Id', 'Email');
			$this->authentication = new \Ninja\Authentication($this->usersTable, 'Email', 'Password');
		}
		
		public function getRoutes():array
		{
			//INSTANTIATE THE VARIOUS CONTROLLERS
			$postController = new \Specific\Controllers\Post($this->postsTable, $this->usersTable, $this->topicsTable, $this->authentication);

			$topicsController = new \Specific\Controllers\Category($this->topicsTable, $this->authentication); 
			$userController = new \Specific\Controllers\Users($this->usersTable, $this->mailingListTable, $this->authentication);
			$loginController = new \Specific\Controllers\Login($this->authentication);

			//SPECIFIES THE VARIOUS CONTROLLERS AND ACTIONS TO PERFORM FOR EVERY SINGLE REQUEST
			// THESE CORRESPOND TO PAGES
			$routes = [
				//GENERAL 
				'home' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'read'
					]
				],

				'search' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'searchPosts'
					]
				],

				'topics' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'list'
					]
				],

				'articles' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'read'
					],
				],

				//ACCOUNTS 
				'signup' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'registrationForm'
					],
					'POST' => [
						'controller' => $userController,
						'action' => 'registerUser'
					]
				],

				'signin' => [
					'GET' => [
						'controller' => $loginController,
						'action' => 'loginForm'
					],
					'POST' => [
						'controller' => $loginController,
						'action' => 'processLogin'
					]
				],

				'signout' => [
					'GET' => [
						'controller' => $loginController,
						'action' => 'logout'
					],
				],

				'dashboard' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'dashboard'
					],
					'login' => true,
					'superuser' => true,
					'admin' => true
				],

				'profile' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'profile'
					],
					'login' => true,
				],

				'dashboard2' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'dashboard2'
					],
					'login' => true,
				],

				'profile2' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'profile2'
					],
					'login' => true,
				],

				//ARTICLES => CONTENT MANAGEMENT SYSTEM
				'manageposts' => [
					'GET' => [
							'controller' => $postController,
							'action' => 'manageposts'
					],
					'login' => true,
					'superuser' => true,
					'admin' => true
				],

				'addpost' => [
					'POST' => [
						'controller' => $postController,
						'action' => 'save'
						],
					'GET' => [
						'controller' => $postController,
						'action' => 'addpost'
						],
					'login' => true,
					'superuser' => true,
					'admin' => true,
					],

				'editarticle' => [
					'POST' => [
						'controller' => $postController,
						'action' => 'save'
					],
					'GET' => [
						'controller' => $postController,
						'action' => 'editpost'
					],
					'login' => true,
					'superuser' => true,
					'admin' => true,
				],
				
				'delete' => [
					'POST' => [
						'controller' => $postController,
						'action' => 'delete'
					],
					'GET' => [
						'controller' => $postController,
						'action' => 'delete'
					],
					'login' => true,
					'superuser' => true,
				],

				'visibility' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'togglePublish'
					],
					'login' => true,
					'superuser' => true,
					'admin' => true
				],

				'drafts' => [
					'GET' => [
						'controller' => $postController,
						'action' => 'drafts'
					],
					'login' => true,
					'superuser' => true,
					'admin' => true
				],

				//TOPICS
				'edittopic' => [
					'GET' => [
						'controller' => $topicsController,
						'action' => 'displayedittopicform'
					],
					'login' => true,
					'superuser' => true,
				],

				'updatetopic' => [
					'POST' => [
						'controller' => $topicsController,
						'action' => 'updateTopic'
					],
					'login' => true,
					'superuser' => true,
				],

				'deletetopic' => [
					'GET' => [
						'controller' => $topicsController,
						'action' => 'deletetopic'
					],
					'login' => true,
					'superuser' => true,
				],

				'managetopics' => [
					'GET' => [
							'controller' => $topicsController,
							'action' => 'managetopics'
							],
					'login' => true,
					'superuser' => true,
				],

				'addtopic' => [
					'POST' => [
						'controller' => $topicsController,
						'action' => 'addTopic',
					],

					'GET' => [
							'controller' => $topicsController,
							'action' => 'addtopicForm'
							],
					'login' => true,
					'superuser' => true,
				],

				//AUTHORS
				'manageauthors' => [
						'GET' => [
						'controller' => $userController,
						'action' => 'manageauthors'
					],
					'login' => true,
					'superuser' => true,
				],

				'createauthor' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'displayForm'
					],
					'POST' => [
						'controller' => $userController,
						'action' => 'promoteuser'
					],
					'login' => true,
					'superuser' => true,
				],

				'searchuser' => [
					'POST' => [
						'controller' => $userController,
						'action' => 'searchUserToPromote'
					], 
					'login' => true,
					'superuser' => true,
				],

				'promoteuser' => [
					'GET' => [
						'controller' => $userController,
						'action' => 'displayForm'
					], 

					'POST' => [
						'controller' => $userController,
						'action' => 'promoteUser'
					], 
					'login' => true,
					'superuser' => true,
				],

				// OTHERS
				'contactus' => [
					'POST' => [
						'controller' => $userController,
						'action' => 'contactus',
					]
				],

				'mailinglist' => [
					'POST' => [
						'controller' => $userController,
						'action' => 'newsLetter',
					]
				],
			];

			return $routes;
		}

		// RETURN AUTHENTICATION INSTANCE TO ENTRYPOINT CLASS
		public function getAuthentication():\Ninja\Authentication
		{
			return $this->authentication;
		}

		// RETURN TOPICSTABLE INSTANCE TO ENTRYPOINT CLASS
		public function getTopicsTable():\Ninja\DatabaseHandler
		{
			return $this->topicsTable;
		}
	}
}
