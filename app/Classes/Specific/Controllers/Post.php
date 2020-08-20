<?php
namespace Specific\Controllers
{
	//ARTICLES CONTROLLER
	class Post
	{
		private $postsTable; // ARTICLES TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $usersTable;  // USERS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $topicsTable;  // TOPICS TABLE INSTANCE OF DATABASEHANDLER CLASS
		private $authentication;  // AUTHENTICATION CLASS INSTANCE 
		private $topics;
		public $posts;
		
		public const TITLE = 'TECH GENIE';
		private const ROOT_PATH = '';

		public function __construct(\Ninja\DatabaseHandler $postsTable, \Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $topicsTable,  \Ninja\Authentication $authentication)
		{
			$this->postsTable = $postsTable;
			$this->usersTable = $usersTable;
			$this->topicsTable = $topicsTable;
			$this->topics = $this->topicsTable->findAll([], 'Name ASC');
			//RETURNS AN ARRAY OF \SPECIFC\ENTITY\JOKE OBJECTS 
			$this->posts = $this->postsTable->findAll(['Published' => 1], 'Date ASC');
			$this->authentication = $authentication;

			$this->ROOT_PATH = ROOT_PATH;
		}

		// SELECT POPULAR POSTS
		private function popularPosts()
		{
			$seealso = $this->postsTable->findAll(['Published' => 1], 'RAND()', 4, null); //SELECT 4 RANDOM ARTICLES FOR THE POPULAR ARTICLES SECTION
			$popularPosts = ['posts' => $seealso, 'heading' => 'Popular Articles'];
			return $popularPosts;
		}

		//LISTS ARTICLES PER TOPIC
		public function list():array
		{
			// HANDLE ARTICLES AND PAGINATION IN TOPICS AND INDIVIDUAL TOPICS
			if(isset($_GET['subfolder']))
			{
				return $this->postsPerTopic();
			} else  // HANDLE THE PAGE 1 OF ARTICLES PER TOPIC PAGE {TOPICPOSTS.HTML.PHP}
			{
				$page = 1; // PAGE 1
				$limit = 8; // NUMBER TO SELECT
				$offset = 0; // OFFSET
				$posts = []; //INITIALIZE EMPTY POSTS ARRAY

				//SELECT POSTS BY TOPIC
				// CRITERIA FOR SELECTION
				// INITIALIZIE CURENT PAGE TRACKER
				$currentPage = [];

				foreach($this->topics as $topic)
				{
					$currentPage[$topic->Name] = 1;
					$topicPosts = $topic->getPosts($limit, $offset); // GET ARTICLES ENCAPSULATED IN EACH TOPIC
					$posts[$topic->Name] = $topicPosts; // CREATE AN ENTRY IN POSTS ARRAY WITH KEY BEING TOPIC NAME AND VALUE BEING THE TOPIC ARTICLES
				}	

				// display(count($posts['PYTHON']));
				$title = self::TITLE;
				$output = '';

				$recentPosts = ['posts' => $posts, 'heading' => 'Articles By Topic'];

				if(empty($posts)) // CHECK IF THE POSTS ARRAY IS EMPTY
				{
					$variables = ['title' => self::TITLE,
					'template' => 'home.html.php',
					'description' => $topic->Description,
					'variables' => [ 
						'heading' => 'We are working to add posts to this topic. Check back soon.',
						'popularPosts' =>$this->popularPosts(),
						]
					];
				} else //NOT EMPTY
				{
					$variables = ['title' => self::TITLE, 
					'template' => 'home.html.php',
					'description' => $topic->Description,
					'variables' => [
							'recentPosts' => $recentPosts,
							'topics' => $this->topics,
							'totalArticles' => $topic->totalPosts(),
							'popularPosts' =>$this->popularPosts(),
							'currentPage' => $currentPage,
						]
					];
				}
					return $variables;
			}
		}

		//DISPLAYING ARTICLES INSIDE TOPICS, ALSO ARTICLES INSIDE INDIVIDUAL TOPICS. HANDLES PAGINATION ALSO
		private function postsPerTopic()
		{
			$string = $_GET['subfolder'];
			$topic = $this->topicsTable->findOne(['Name' => str_replace('-', ' ', strtoupper($string))]);
			if(is_object($topic))
			{
				$topicname = $topic->Name;

				//THEY WANT TO VIEW ARTICLES INSIDE THAT PARTICULAR TOPIC
				//WE NEED TO FIGURE OUT WHETHER THEY ARE VISITING THE FIRST PAGE OR THEY ARE MOVING PAGES - PAGINATION
				if(isset($_GET['specific']) && ($_GET['specific'] !== '' || empty($_GET['specific'])))
				{

					//THEY ARE NAVIGATING INSIDE TOPICS FOLDER, PAGINATION
					// PAGINATION INSIDE OF A TOPIC E.G TOPICS/CLOUD
					if($present = (strstr($_GET['specific'], 'page=')))
					{
						$position = stripos($present, '=');
						// FORM THE PAGE FROM THE URI VARIABLE
						$page = substr($present, ($position +1));
						// TURN PAGE NUMBERS INTO OFFSETS
						$limit = 12;
						$offset = ($page-1) * $limit;
						$topicPosts = $topic->getPosts($limit, $offset);

						$variables = ['title' => $topicname,
						'template' => 'topicposts.html.php',
						'description' => $topic->Description,						
						'variables' => [ 
							'popularPosts' =>$this->popularPosts($topic->Name),
							'heading' => $topicname,
							'topicPosts' => $topicPosts,
							'totalTopicPosts' => $topic->totalPosts(),
							'currentPage' => $page,
							]
						];

						return $variables;
						
					// LOAD MORE
					} elseif($present = (strstr($_GET['specific'], 'more=')))
					{
						// display($topic->Name);
						$position = stripos($present, '=');
						// FORM THE PAGE FROM THE URI VARIABLE
						$page = substr($present, ($position +1));
						// TURN PAGE NUMBERS INTO OFFSETS
						$limit = ($page + 1) * 8;
						$topicPosts = $topic->getPosts($limit);
						// GENERATE CURRENT PAGES TRACKERS
						$currentPage = [];
						$keywords [] = $topic->Name;
						// OTHER TOPICS' ARTICLES
						foreach($this->topics as $topic2)
						{
							$currentPage [$topic2->Name]  = 1; //RESET THE REST IF THE TOPICS' ARTICLES
							$otherTopicsPosts[$topic2->Name] = $topic2->getPosts(8, 0); // GET ARTICLES ENCAPSULATED IN EACH TOPIC
							// KEYWORDS
							$keywords [] = $topic2->Name;
						}	

						// GENERATE KEYWORDS FOR meta tags
						$keywordsString = '';
						$i = 0;
						foreach($keywords as $value)
						{
							if($i == 0)
							{
								$keywordsString .= $value;
							}else 
							{
								$keywordsString .= ', ' . $value;
							}
							$i++;
						}

						$otherTopicsPosts[$topic->Name] = $topicPosts; // CREATE AN ENTRY IN POSTS ARRAY WITH KEY BEING TOPIC NAME AND VALUE BEING THE TOPIC ARTICLES

						// UPDATE THE PAGE OF THE TOPIC FOR WHICH WE'VE LOADED MORE. TO KEEP TRACK
						$currentPage [$topic->Name]  = $page + 1;

						// UPDATE $otherTopicsPosts WITH UPDATED ARTICLES FOR LOADED 
						$otherTopicsPosts[$topic->Name] = $topicPosts;
						$topicPosts = $otherTopicsPosts;
						$recentPosts = ['posts' => $topicPosts, 'heading' => 'Articles By Topic'];

						$variables = ['title' => self::TITLE,
						'template' => 'home.html.php',
						'description' => 'Explore our collection of useful learning materials on your path to proficiency in whatever language you are interested in.',
							'keywords' => $keywordsString,
						'variables' => [ 
							'popularPosts' =>$this->popularPosts($topic->Name),
							'recentPosts' => $recentPosts,
							'totalArticles' => $topic->totalPosts(),
							'currentPage' => $currentPage,
							]
						];

						// IF NOT VIEWING ARTICLES INSIDE  TOPICS FOLDER, THEY WANT TO VIEW A SPECIFIC ARTICLE THAT LIVES IN A PARTICULAR TOPIC
					} else //FETCH A SINGLE POST INSIDE OF THE TOPIC E.G TOPICS/CLOUD/HOW-THE-CLOUD-WORKS
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
						unset($_GET['subfolder']);
		
						return $variables;
					}
				} else // ARTICLES IN A PARTICULAR TOPIC
				{
					$page = 1;
					$topicname = $topic->Name;
					$limit = 12;
					$offset = 0;
					$topicPosts = $topic->getPosts($limit, $offset);
					// display($_GET['page']);

					if(empty($topicPosts))
					{
						$variables = ['title' => $topicname,
						'template' => 'topicposts.html.php',
						'description' => $topic->Description,
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
							'totalTopicPosts' => $topic->totalPosts(),
							'currentPage' => $page,
							]
						];
					}
						return $variables;
				}					
			} else //THEY WANTED TO SO SMTH IN TOPICS FOLDER BUT SMTH WENT WRONG FROM THEIR ENT, EITHER MANUAL TYPING INTO ADDRESS BAR
			{
				http_response_code(404);
				header('location:/404.php');
				exit();				
			}

				unset($_GET['specific']); //REMOVE VARIABLE FORM MEMORY

				return $variables;
		}

		//DISPLAY A SINGLE ARTICLE FOR READING OR HANDLE DISPLAYING ARTICLES IN ARTICLES FOLDER. ALSO DOES PAGINATION INSIDE OF ARTICLES FOLDER
		public function read()
		{
			// IF A SUBFOLDER PARAMETER EXISTS IN THE URL
			if(isset($_GET['subfolder']))
			{
				// CHECK IF PAGE VARIABLE IS SET IN THE URL => PAGINATION INSIDE ARTICLES FOLDER
				if($present = (strstr($_GET['subfolder'], 'page=')))
				{
					$position = stripos($present, '=');
					// FORM A PAGE NUMBER FROM IT
					$page = substr($present, ($position +1));
					$limit = 12; //LIMIT
					$offset = ($page-1) * $limit; // TURN PAGE NUMBER INTO AN OFFSET
					$order = 'Id DESC'; //ORDER

					$posts = $this->postsTable->findAll(['Published' => 1], $order, $limit, $offset); //SELECT

					$variables = ['title' => self::TITLE,
												'template' => 'articles.html.php',
												'variables' => [ 
														'heading' => 'Recent Articles',
														'posts' => $posts,
														'totalArticles' => $this->postsTable->total(['Published' => 1]),
														'popularPosts' => $this->popularPosts(),
														'topics' => $this->topics,
														'currentPage' => $page,
												]
											];		

					return $variables;

				} else // DISPLAY A SINGLE ARTICLE FOR READING
				{
					$string = $_GET['subfolder'];
					// display($string);
					$post = $this->postsTable->findOne(['String' => strtolower($string)]);

					if(is_object($post))
					{
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
															'popularPosts' => $this->popularPosts($post->String),
															'topics' => $this->topics,
													]
												];
							return $variables;
					} else 
					{
						http_response_code(404);
						header('location:/404.php');
						exit();
					}
				}
			} else // IF NOT, DISPLAY HOME PAGE
			{
				$page = 1;
				$order = 'Id DESC';
				$limit = 15;
				$offset = ($page-1) * $limit;

				$posts = $this->postsTable->findAll(['Published' => 1], $order, $limit, $offset);
				$variables = ['title' => self::TITLE,
											'template' => 'articles.html.php',
											'variables' => [ 
													'heading' => 'Recent Articles',
													'posts' => $posts,
													'totalArticles' => $this->postsTable->total(['Published' => 1]),
													'popularPosts' => $this->popularPosts(),
													'topics' => $this->topics,
													'currentPage' => $page,
											]
										];		

				return $variables;				
			}
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
				return false;				
			}
		}

		//SUPERUSER
		public function delete() 
		{
			if($this->superUserOnly())
			{
				$condition = ['String' => $_GET['specificId']];
				// FETCH IT FIRST
				$postToDelete = $this->postsTable->findOne(['String' => $_GET['specificId']]);

				if(is_object($postToDelete))
				{
					// DELETE CORRESPONDING RECORDING RECORD IN ARTICLE TOPICS TABLE
					$affected_rows = $postToDelete->clearCategories();
					// THEN DELETE IT
					if(is_object($affected_rows))
					{
						$affected_rows = $postToDelete->deletePost($condition);

						if(is_object($affected_rows))
						{
							$_SESSION['message'] = 'Deleted successfully';
							$_SESSION['type'] = 'success';
							$title = 'SuperUser Panel | Manage Posts';
							
							return [
								'title' => $title,
								'template' => 'manageposts.html.php',
								'variables' => [
												'posts' => $this->postsTable->findAll([], 'Date DESC'),
												'heading' => 'Manage Posts',
								]
							];
						}
					}
				} else 
				{
					$title = 'SuperUser Panel | Manage Posts';
					$_SESSION['message'] = 'Article not found. Try again';
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
				header('location:/index.php/signin');
				exit();
			}
		}

		//CHANGE POST VISIBILITY
		public function togglePublish()
		{
			if($this->superUserOnly())
			{
				if($_GET['subfolder'] === 'publish')
				{
					$state = 1; 
					$draft = 0;

					$_SESSION['message'] = 'Article is now live';
					$_SESSION['type'] = 'success';
				} elseif($_GET['subfolder'] === 'unpublish')
				{
					$state = 0;
					$draft = 1;

					$_SESSION['message'] = 'Article moved to drafts';
					$_SESSION['type'] = 'success';
				}
				
				$conditions = ['Published' => $state, 'Draft' => $draft];
				$post = $this->postsTable->findOne(['String' => $_GET['specificId']]);
				$title = $_SESSION['Superuser'] ? 'SuperUser Panel | Manage Posts' : 'Admin Panel | Manage Posts';
				if($post)
				{
					$affected_rows = $post->togglePublish($conditions);
					if($affected_rows)
					{	
						if($_SESSION['Superuser'])
						{
							return [
								'title' => $title,
								'template' => 'manageposts.html.php',
								'variables' => [
									'posts' => $this->postsTable->findAll([], 'Date DESC'),
									'heading' => 'Manage Posts',
								]
							];
						} else 
						{
							$author = $this->authentication->getUser();
		
							return [
								'title' => $title,
								'template' => 'manageposts.html.php',
								'variables' => [
									'posts' => $author->getPosts(15),
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
									'posts' => $this->postsTable->findAll([], 'Date DESC'),
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
									'posts' => $author->getPosts(15),
									'heading' => 'Manage Posts',
								]
							];
						}
					}	
				} else
				{
					header('location:/404.php');
					exit();
				}
			} else 
			{
				header('location:/index.php/signin');
				exit();
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

					if ($result) 
					{
						$post['Image'] = $image_name;
					} else 
					{
						$valid = false;
						array_push($errors, "An error occurred uploading image");
					}
				} else
				{
					$valid = false;
					array_push($errors, "Image is required!");
				}				
			} else 
			{
				if(!empty($files['image_name']['name']))
				{
					$image_name = time() .'_'. $files['image_name']['name'];
					$destination = ROOT_PATH.'/assets/images/' . $image_name;
	
					$result = move_uploaded_file($files['image_name']['tmp_name'], $destination);
	
					if ($result) 
					{
						$post['Image'] = $image_name;
					} else {
						$valid = false;
						array_push($errors, "An error occurred uploading image");
					}				
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
				array_push($errors, "Title is required"); 
			} else 
			{
				//CHECK FOR EXISTING POST WITH EXACTLY SAME TITLE
				//DONT PERFORM THE CHECK WHEN UPDATING POSTS
				if(isset($_POST['add']))
				{
					$existingPost = $this->postsTable->findOne(['Title' => trim($post['Title'])]);

					if(is_object($existingPost))
					{
						$valid = false;
						array_push($errors, "An article with that exact title already exists"); 
					} 	
				}
			}

			if(empty($post['Body']))
				{
					$valid = false;
					array_push($errors, "An article body is required");  
				}

				if(empty($post['Description']))
				{
					$valid = false;
					array_push($errors, "An article description is required");  
				}
				
				if(empty($post['Keywords']))
				{
					$valid = false;
					array_push($errors, "Article keywords are required");  
				}				

			return ['errors' => $errors, 'valid' => $valid];
		}

		// GENERATE SEO-FRIENDLY URL'S
		// TAKES INPUT, SCRUBS UNWANTED WORDS AND CHARACTERS 
		private function generateSEOLink($input, $replace = '-', $remove_words = true, $words_array = array()) 
		{
			//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
			$return = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));

			//remove words, if not helpful to seo
			//i like my defaults list in remove_words(), so I wont pass that array

			if($remove_words)
			{ 
				$return = $this->remove_words($return, $replace, $words_array); 
			}

			//convert the spaces to whatever the user wants
			//usually a dash or underscore..
			//...then return the value.
			return str_replace(' ', $replace, $return);
		}

		// WORDS TO REMOVE FROM SEO LINK 
		private function remove_words($input, $replace, $words_array = array(), $unique_words = true)
		{
			//separate all words based on spaces
			$input_array = explode(' ',$input);

			//create the return array
			$return = array();

			//loops through words, remove bad words, keep good ones
			foreach($input_array as $word)
			{
				//if it's a word we should add...
				if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
				{
					$return[] = $word;
				}
			}

			//return good words separated by dashes
			return implode($replace,$return);
		}

		// GENERATE A GOOD TITLE
		// TAKES INPUT, SCRUBS UNWANTED WORDS AND CHARACTERS
		private function generateTitle($input, $replace = ' ') 
		{
			//remove punctuation, remove multiple/leading/ending spaces
			$title = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9?\s]/', ' ', $input)));
			// replace any double whitespace with a single whitespace
			$title = preg_replace('/  [^  ]+?/', ' ', $title);
			return $title;
		}
		
		//SAVE ARTICLE => ADD || UPDATE 
		public function save()
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				$post = $_POST['post'];
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
					// WORDS TO REMOVE FROM LINK IF PRESENT
					$words_array = array();

					if(isset($_POST['add']))
					{
						$post['Id'] = '';
						$post['Published'] = 1;
						$post['Draft'] = 0;
						$post['Date'] = $this->generateDate();
						// GENERATE SEO-FRIENDLY URL
						$post['String'] = $this->generateSEOLink($post['Title'], '-', true, $words_array); // GENERATE SEO SLUG

					}elseif(isset($_POST['edit']))
					{
						// $post['Id'] = $post['Id'];
					} elseif(isset($_POST['draft']))
					{
						$post['Published'] = 0;
						$post['Draft'] = 1;
						$post['Id'] = '';
						$post['Date'] = $this->generateDate();
					}

					// GENERATE TITLE
					$post['Title'] = $this->generateTitle($post['Title']);
					
					$post['Body'] = htmlentities($post['Body']);

					//SAVE POST
					// display($post);

					$postEntity = $authorObject->addPost($post);
					//INSERT CATEGORY RECORDS
					if($postEntity)
					{
						//CLEAR CATEGORY RECORDS
						$postEntity->clearCategories();
						
						if($postEntity)
						{
							//INSERT CATEGORY RECORD FOR POST IF NOT DRAFT => SAVES ME ALOT OF TROUBLE SOMEWHERE
							if(!isset($_POST['draft']))
							{
								foreach($_POST['category'] as $categoryId)
								{
									$postEntity->addCategory($categoryId);
								}
							}
	
							if($postEntity)
							{
								// PREVIEW ARTICLE BEFORE PUBLISHING OR WHATEVER
								if(isset($_POST['preview']))
								{
									$postString = strtolower($postEntity->String);
									echo "<script>window.open(\"/index.php/$postString\")</script>";
	
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
												'posts' => $this->postsTable->findAll(['Published' => 1], 'Date DESC'),
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
												'posts' => $author->getPosts(15),
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
					$description = $post['Description'];
					$keywords = $post['Keywords'];
					$published = isset($post['Published']) ? 1 : 0;
					
					return [
						'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
						'template' => 'editpost.html.php',
						'variables' => [
							'heading' => 'Review post',
							'title' => $title,
							'body' => $body,
							'description' => $description,
							'keywords' => $keywords,
							'published' => $published,
							'categories' => $this->topics,
							'errors' => $errors,
							'type' =>'error'
						]
					];
				} 
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		//MANAGE POSTS
		public function manageposts() 
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				if($_SESSION['Superuser'])
				{
					$conditions = ['Draft' => 0];
					$all = $this->postsTable->findAll($conditions, 'Date DESC');

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
					$posts = $author->getPosts(15);
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
			} else 
			{
				header('location:/index.php/signin');
				exit();
			}
		}

		//SERVE ADD POST FORM
		public function addpost() 
		{
			if($this->checkWhetherAdminOrSuperUser())
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
			} else 
			{
				header('location:/index.php/signin');
				exit();				
			}
		}
		
		//SERVE EDIT POST FORM
		public function editpost()
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				$idOfPostToEdit = $_GET['specificId'];

				$post = $this->postsTable->findOne(['String' => $idOfPostToEdit]);
				if(is_object($post))
				{
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
				} else
				{
					$_SESSION['message'] = 'Article not found for editing';
					$_SESSION['type'] = 'error';
					header('location:/private/index.php/manageposts');
					exit();		
				}
	
			} else 
			{
				header('location:/index.php/signin');
				exit();				
			}
		}

		// HANDLE DRAFTS
		public function drafts()
		{
			if($this->checkWhetherAdminOrSuperUser())
			{
				$conditions = ['Draft' => 1];
				$drafts = $this->postsTable->findAll($conditions, 'Date DESC');
	
				return [
					'title' => $_SESSION['Superuser'] ? 'SuperUser panel | Add post' : 'Admin panel | Add post',
					'template' => 'drafts.html.php',
					'variables' => [
						'heading' => 'Drafts',
						'posts' => $drafts,
					]
				];
			} else 
			{
				header('location:/index.php/signin');
				exit();				
			}
		}
	}
}
