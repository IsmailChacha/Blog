<?php
namespace Specific\Controllers
{
	//ARTICLES CONTROLLERS
	class Post
	{
		private $postsTable; // ARTICLES TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $usersTable;  // USES TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $topicsTable;  // TOPICS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $authentication;  // ATHENTICATION CLASS INSTANCE 
		private $topics;
		public $posts;
		
		public const TITLE = 'TECH GENIE';
		private const ROOT_PATH = '';

		public function __construct(\Ninja\DatabaseHandler $postsTable, \Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $topicsTable,  \Ninja\Authentication $authentication)
		{
			$this->postsTable = $postsTable;
			$this->usersTable = $usersTable;
			$this->topicsTable = $topicsTable;
			$this->topics = $this->topicsTable->findAll();
			//RETURNS AN ARRAY OF \SPECIFC\ENTITY\JOKE OBJECTS 
			$this->posts = $this->postsTable->findAll();
			$this->authentication = $authentication;

			$this->ROOT_PATH = ROOT_PATH;
		}

		// SELECT POPULAR POSTS => NOT IN USE THOUGH
		private function popularPosts(string $conditions = '')
		{
			$seealso = $this->postsTable->searchPosts($conditions);
			// display($seealso);
			shuffle($seealso);
			$popularPosts = ['posts' => $seealso, 'heading' => 'Popular Articles'];
			return $popularPosts;
		}

		//SELECT ALL POSTS WITH ASSOC AUTHORS
		public function list():array
		{
			//display($this->posts);
			$posts = [];

			//SELECT POSTS BY TOPIC
			foreach($this->topics as $topic)
			{
				$topicPosts = $topic->getPosts();
				$posts[$topic->Name] = $topicPosts;
			}

			$title = self::TITLE;
			$output = '';
			$post2 = $this->postsTable->findAFew();
			shuffle($post2);
			
			$recentPosts = ['posts' => $posts, 'heading' => 'Recent Articles'];

			$variables = ['title' => self::TITLE, 
										'template' => 'home.html.php',
										'variables' => [
												'recentPosts' => $recentPosts,
												'topics' => $this->topics,
										]
									];

			return $variables;
		}

		//READING &times; An article
		public function read()
		{
			if(isset($_GET['subfolder']))
			{
				$string = $_GET['subfolder'];
				$post = $this->postsTable->findOne(['String' => strtolower($string)]);
				$author = $post->getAuthor();
				$authorName = $author->FirstName . ' ' . $author->LastName;
				$description = $post->Description ?? 'A simple post';
				$keywords = $post->Keywords ?? 'Keywords';
				// display($authorName);
				$variables = ['title' => $post->Title,
											'authorName' => $authorName,
											'description' => $description,
											'keywords' => $keywords,
											'template' => 'single.html.php',
											'variables' => [ 
													'post' => $post,
													'popularPosts' => $this->popularPosts($post->Keywords),
													'topics' => $this->topics,
											]
										];
	
			} else
			{
				$posts = $this->postsTable->findAll();
				$variables = ['title' => self::TITLE,
											'secondHeading' => 'Articles',
											'template' => 'articles.html.php',
											'variables' => [ 
													'posts' => $posts,
													'popularPosts' => $this->popularPosts(),
													'topics' => $this->topics,
											]
										];				
			}

			return $variables;
		}

		//SEARCH FUNCTIONALITY
		public function searchPosts () 
		{
			$searchResults = $this->postsTable->searchPosts($_GET['searchterm']);
			$number = count($searchResults);

			if($number > 0)
			{
				$variables = ['title' => 'Search results',
					'template' => 'searchresults.html.php',
					'variables' => [ 

						'topics' => $this->topics,
						'searchResults' => $searchResults,
						'heading' => 'Search results for <em>\'' . $_GET['searchterm'] . '\'</em>',
						'secondHeading' => $number . ' result(s) found',
						'popularPosts' => $this->popularPosts($_GET['searchterm']),

					]
				];
			} else 
			{
				$variables = [
				'title' => 'Search results',
				'template' => 'searchresults.html.php',
				'variables' => [ 
					'topics' => $this->topics,
					'heading' => '<a href="/index.php">No results were found. Would you try a different term?</a>',
					'popularPosts' => $this->popularPosts($_GET['searchterm']),
					]
				];
			}

			return $variables;	
		}

		//ON VISITING A TOPIC LINK
		public function postsPerTopic()
		{
			if(isset($_GET['subfolder']))
			{
				$string = $_GET['subfolder'];
				$topic = $this->topicsTable->findOne(['Name' => str_replace('-', ' ', strtoupper($string))]);
				// display(str_replace('-', ' ', strtoupper($string)));
				if(is_object($topic))
				{
					if(isset($_GET['specific']) && $_GET['specific'] !== '')
					{
						$post = $this->postsTable->findOne(['String' => $_GET['specific']]);
	
						$author = $post->getAuthor();
						$authorName = $author->FirstName . ' ' . $author->LastName;
						$description = $post->Description ?? 'A simple post';
						$keywords = $post->Keywords ?? 'Keywords';
	
						$variables = ['title' => $post->Title,
													'authorName' => $authorName,
													'description' => $description,
													'keywords' => $keywords,					
													'template' => 'single.html.php',
													'variables' => [ 
															'post' => $post,
															'popularPosts' => $this->popularPosts($post->Keywords),
															'topics' => $this->topics,
													]
												];
						unset($_GET['specific']);
		
						return $variables;
		
					} else 
					{
						$topicname = $topic->Name;
						$topicPosts = $topic->getPosts();
	
						if(empty($topicPosts))
						{
							$variables = ['title' => $topicname,
							'template' => 'topicposts.html.php',
							'variables' => [ 
								'heading' => 'We are working to add posts to this topic. Check back soon.',
								'popularPosts' =>$this->popularPosts(),
							]
						];
						} else 
						{
							$variables = ['title' => $topicname,
							'template' => 'topicposts.html.php',
							'variables' => [ 
								'popularPosts' =>$this->popularPosts($topic->Name),
								'heading' => $topicname,
								'topicPosts' => $topicPosts,
								]
							];
						}
		
						return $variables;
					}
				} else 
				{
					$_SESSION['message'] = 'An error occurred';
					$_SESSION['type'] = 'error';
					header('location:/');
				}
			} else 
			{
				// display('Not set');
				header('location:/');
				exit();
			}

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
			} else{
				return false;
			}
		}

		//ACCESS CONTROL
		private function superUserOnly()
		{
			$user = $this->authentication->getUser();
			if($user->Superuser)
			{
				return true;
			}else 
			{
				$this->authentication->logout();
				$_SESSION['message'] = 'You are not authorized!';
				$_SESSION['type'] = 'error';
				return false;
			}
		}

		//SUPERUSER
		public function delete() 
		{
			if($this->superUserOnly())
			{
				$post = $_POST['post'];
				$condition = ['id' => $post['id']];
				$affected_rows = $this->postsTable->delete($condition);
				$title = 'SuperUser Panel | Manage Posts';
				if($affected_rows)
				{
					$_SESSION['message'] = 'Deleted successfully';
					$_SESSION['type'] = 'success';
	
					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $this->postsTable->findAll(),
										'heading' => 'Manage Posts',
						]
					];
				} else 
				{
					$_SESSION['message'] = 'An error occurred processing your request';
					$_SESSION['type'] = 'error';
	
					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $this->posts,
										'heading' => 'Manage Posts',
						]
					];
				}	
			} else 
			{
				return false;
			}
		}

		//CHANGE POST VISIBILITY
		public function togglePublish()
		{
			if(!$this->checkWhetherAdminOrSuperUser())
			{
				return false;
			}

			if($_GET['subfolder'] === 'publish')
			{
				$state = 1; 
				$draft = 0;
			} elseif($_GET['subfolder'] === 'unpublish')
			{
				$state = 0;
				$draft = 1;
			}
			
			$condition = ['Id' => $_GET['specificId'], 'Published' => $state, 'Draft' => $draft];

			$affected_rows = $this->postsTable->save($condition);
			$title = $_SESSION['Superuser'] ? 'SuperUser Panel | Manage Posts' : 'Admin Panel | Manage Posts';
			
			if($affected_rows)
			{
				$_SESSION['message'] = 'Post visibility changed';
				$_SESSION['type'] = 'success';

				if($_SESSION['Superuser'])
				{
					$title = 'SuperUser Panel | Manage Posts';

					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
							'posts' => $this->postsTable->findAll(),
							'heading' => 'Manage Posts',
						]
					];
				} else 
				{
					$_SESSION['message'] = 'Post visibility changed';
					$_SESSION['type'] = 'success';

					$title = 'Admin Panel | Manage Posts';

					$author = $this->authentication->getUser();

					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
							'posts' => $author->getPosts(),
							'heading' => 'Manage Posts',
						]
					];
				}
			} else 
			{
				if($_SESSION['Superuser'])
				{
					$_SESSION['message'] = 'An error occurred processing your request.Sorry about that.';
					$_SESSION['type'] = 'error';

					$title = 'SuperUser Panel | Manage Posts';

					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
							'posts' => $this->postsTable->findAll(),
							'heading' => 'Manage Posts',
						]
					];
				} else 
				{
					$_SESSION['message'] = 'An error occurred processing your request.Sorry about that.';
					$_SESSION['type'] = 'error';

					$title = 'Admin Panel | Manage Posts';

					$author = $this->authentication->getUser();

					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
							'posts' => $author->getPosts(),
							'heading' => 'Manage Posts',
						]
					];
				}
			}	
		}

		//METHODS FOR HANDLING POST UPLOADS

		//HANDLES FILES
		private function handleFiles($post, $files, $errors, $valid):array 
		{
			if(isset($_POST['add'])) //DONT PERFORM THE CHECK WHEN UPDATING POSTS
				{
				//PROCESS IMAGE 
				if (!empty($files['Image']['name'])) 
				{
					$image_name = time() .'_'. $files['Image']['name'];
					$destination = ROOT_PATH.'/assets/images/' . $image_name;

					$result = move_uploaded_file($files['Image']['tmp_name'], $destination);

					if ($result) {
						$post['Image'] = $image_name;
					} else {
						$valid = false;
						array_push($errors, "An error occurred uploading image");
					}
				} else
				{
					$valid = false;
					array_push($errors, "Post image required!");
				}				
			}

			return ['post' => $post, 'errors' => $errors, 'valid' => $valid];
		}

		//GENERATE DATE
		private function generateDate() 
		{
			$date = new \DateTime(); 
			$formatedDate = $date->format('Y-m-d');
			return $formatedDate;
		}

		//CHECKS FOR ERRORS IN POST
		public function validatePost (array $post):array 
		{
			$valid = true;
			$errors = [];
			if(empty($post['Title']))
			{
				$valid = false;
				array_push($errors, "&times; Title is required"); 
			} else 
			{
				//CHECK FOR EXISTING POST WITH EXACTLY SAME TITLE
				//DONT PERFORM THE CHECK WHEN UPDATING POSTS
				if(isset($_POST['add']))
				{
					$existingPost = $this->postsTable->findAll(['Title' => trim($post['Title'])]);
					if($existingPost)
					{
						$valid = false;
						array_push($errors, "&times; An article with that exact title already exists"); 
					} 	
				}
			}

			if(empty($post['Body']))
				{
					$valid = false;
					array_push($errors, "&times; An article body is required");  
				}

				if(empty($post['Description']))
				{
					$valid = false;
					array_push($errors, "&times; An article description is required");  
				}
				
				if(empty($post['Keywords']))
				{
					$valid = false;
					array_push($errors, "&times; Article keywords are required");  
				}				

			return ['errors' => $errors, 'valid' => $valid];
		}

		//SAVE POST => ADD & UPDATE 
		public function save()
		{
			if(!$this->checkWhetherAdminOrSuperUser())
			{
				return false;
			}
			$post = $_POST['post'];
			if(isset($_POST['add']))
			{
				$post['Id'] = '';
			}

			$files = $_FILES;
			//PROCESS POST
			extract($this->validatePost($post)); //CREATE VARIABLES $errors and $valid in this scope

			//PROCESS IMAGE
			extract($this->handleFiles($post, $files, $errors, $valid));  //CREATE VARIABLES $post, $errors and $valid IN THIS SCOPE
			//CHECK FOR ANY ERRORS
			if($valid)
			{
				//FETCH THE AUTHOR OBJECT
				$authorObject = $this->authentication->getUser();
				// Generate string identifier
				if(isset($_POST['add']) || isset($_POST['edit']))
				{
					$string = trim(str_replace(' ', '-', strtolower($post['Title'])));
					$post['String'] = $string;
					$post['Published'] = 1;
					$post['Draft'] = 0;
				} elseif(isset($_POST['draft']))
				{
					$post['Published'] = 0;
					$post['Draft'] = 1;
				}

				$post['Date'] = $this->generateDate();
				$post['Body'] = htmlentities($post['Body']);

				//SAVE POST
				$postEntity = $authorObject->addPost($post);

				//INSERT CATEGORY RECORDS
				if($postEntity)
				{
					//CLEAR CATEGORY RECORDS
					$postEntity->clearCategories();
					
					if($postEntity)
					{
						//INSERT CATEGORY RECORD FOR POST
						foreach($_POST['category'] as $categoryId)
						{
							$postEntity->addCategory($categoryId);
						}

						if($postEntity)
						{
							// PREVIEW ARTICLE BEFORE PUBLISHING OR WHATEVER
							if(isset($_POST['preview']))
							{
								$postString = strtolower($postEntity->String);
								echo "<script>window.open(\"/index.php/articles/$postString\")</script>";

								return [
									'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
									'template' => 'editpost.html.php',
									'variables' => [
										'heading' => 'Edit post',
										'post' => $postEntity,
										'id' => $postEntity->Id,
										'string' => $postEntity->String,
										'title' => $postEntity->Title,
										'body' => $postEntity->Body,
										'description' => $postEntity->Description,
										'keywords' => $postEntity->Keywords,
										'published' => $postEntity->Published,
										'categories' => $this->topics,
									]
								];
							} else 
							{
								if($_SESSION['Superuser'])
								{
									if(isset($_POST['edit']))
									{
										$_SESSION['message'] = 'Article updated successfully';
									} elseif(isset($_POST['add']))
									{
										$_SESSION['message'] = 'Article added successfully';
									}elseif(isset($_POST['draft']))
									{
										$_SESSION['message'] = 'Draft saved successfully';
									}
									
									$_SESSION['type'] = 'success';
	
									return [
										'title' => 'SuperUser panel | Manage Posts',
										'template' => 'manageposts.html.php',
										'variables' => [
											'heading' => 'Manage Posts',
											'posts' => $this->postsTable->findAll(),
										]
									];
								} else 
								{
									$_SESSION['message'] = $_POST['edit'] ? 'Article updated successfully' : 'Article added successfully';
									$_SESSION['type'] = 'success';
	
									$author = $this->authentication->getUser();
									return [
										'title' =>'Admin panel | Manage Posts',
										'template' => 'manageposts.html.php',
										'variables' => [
											'posts' => $author->getPosts(),
											'heading' => 'Manage Posts',
										]
									];
								}
							}
						} else 
						{
							$_SESSION['message'] = 'An error occurred processing your request';
							$_SESSION['type'] = 'error';

							return [
								'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Manage Posts' : 'Admin panel | Manage Posts',
								'template' => 'addpost.html.php',
								'variables' => [
									'posts' => $this->postsTable->findAll(),
									'heading' => 'Add Post',
								]
							];
						}								
					}
				} else 
				{
					$_SESSION['message'] = 'An error occurred processing your request';
					$_SESSION['type'] = 'error';

					return [
						'title' => $title,
						'template' => 'addpost.html.php',
						'variables' => [
							'posts' => $this->postsTable->findAll(),
							'heading' => 'Add Post',
						]
					];
				}					
			} else 
			{
				//INCASE ANY OF THE REQUIRED FIELDS IS EMPTY OR INVALID, RETURN AND PREFILL THE POST UPLOAD FORM
				$title = $post['Title'];
				$body = $post['Body'];
				$published = isset($post['Published']) ? 1 : 0;
				
				return [
					'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
					'template' => 'editpost.html.php',
					'variables' => [
						'heading' => 'Review post',
						'title' => $title,
						'body' => $body,
						'published' => $published,
						'categories' => $this->topics,
						'errors' => $errors,
						'type' =>'error'
					]
				];
			} 
		}

		//MANAGE
		public function manageposts() 
		{
			if(!$this->checkWhetherAdminOrSuperUser())
			{
				return false;
			} else 
			{
				if($_SESSION['Superuser'])
				{
					$conditions = ['Draft' => 0];
					$all = $this->postsTable->findAll($conditions);

					$title = 'SuperUser Panel | Manage Posts';
		
					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $all,
										'heading' => 'Manage Posts',
									]
					];
				} else
				{
					$author = $this->authentication->getUser();
					$posts = $author->getPosts();
					$title = 'Author panel | Manage Posts';
		
					return [
						'title' => $title,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $posts,
										'heading' => 'Manage My Posts',
							]
					];
				}
			}
		}

		//SERVE ADD POST FORM
		public function addpost() 
		{
			if(!$this->checkWhetherAdminOrSuperUser())
			{
				return false;
			} else 
			{
				if($_SESSION['Superuser'])
				{

					$title = 'SuperUser Panel | Add Post';

					return [
						'title' => $title,
						'template' => 'addpost.html.php',
						'variables' => [
							'heading' => 'Add post',
							'categories' => $this->topics
						]
					];

				} else 
				{
				{
					$title = 'Author Panel | Add Post';

					return [
						'title' => $title,
						'template' => 'addpost.html.php',
						'variables' => [
							'heading' => 'Add post',
							'categories' => $this->topics
							]
						];
					}
				}
			}
		}
		
		//SERVE EDIT POST FORM
		public function editpost()
		{
			if(!$this->checkWhetherAdminOrSuperUser())
			{
				return false;
			}
			
			$idOfPostToEdit = $_POST['post']['id'];
			$post = $this->postsTable->findOne(['id' => $idOfPostToEdit]);

			return [
				'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
				'template' => 'editpost.html.php',
				'variables' => [
					'heading' => 'Edit post',
					'post' => $post,
					'id' => $post->Id,
					'string' => $post->String,
					'title' => $post->Title,
					'body' => $post->Body,
					'description' => $post->Description,
					'keywords' => $post->Keywords,
					'published' => $post->Published,
					'categories' => $this->topics,
				]
			];
		}

		public function drafts()
		{
			$conditions = ['Published' => 0, 'Draft' => 1];
			$drafts = $this->postsTable->findAll($conditions);

			return [
				'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
				'template' => 'drafts.html.php',
				'variables' => [
					'heading' => 'Drafts',
					'posts' => $drafts,
				]
			];			
		}
	}
}
