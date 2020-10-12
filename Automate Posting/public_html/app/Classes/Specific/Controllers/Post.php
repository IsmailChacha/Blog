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
		public $variables;
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
			$this->variables = new \Ninja\Variables($this->authentication);

			$this->ROOT_PATH = ROOT_PATH;
		}

		// SELECT POPULAR POSTS
		private function popularPosts()
		{
			$seealso = $this->postsTable->findAll(['Published' => 1], 'RAND()', 5, null); //SELECT 4 RANDOM ARTICLES FOR THE POPULAR ARTICLES SECTION
			$popularPosts = ['posts' => $seealso, 'heading' => 'You may also like'];
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
				$limit = 12; // NUMBER TO SELECT
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
				$title = \Ninja\Variables::TITLE;
				$output = '';

				$recentPosts = ['posts' => $posts, 'heading' => 'Articles By Topic'];

				if(empty($posts)) // CHECK IF THE POSTS ARRAY IS EMPTY
				{
					$variables = ['title' => \Ninja\Variables::TITLE,
					'template' => 'home.html.php',
					'description' => $topic->Description,
					'activeLink' => $activeLink,
					'variables' => [ 
						'heading' => 'We are working to add posts to this topic. Check back soon.',
						'popularPosts' =>$this->popularPosts(),
						]
					];
				} else //NOT EMPTY
				{
					$variables = ['title' => \Ninja\Variables::TITLE, 
					'template' => 'home.html.php',
					'description' => $topic->Description,
					'activeLink' => $activeLink,
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

						$variables = ['title' => ucwords($topicname) . ' | '  . \Ninja\Variables::TITLE,
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
						$limit = ($page + 1) * 12;
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

						$variables = ['title' => \Ninja\Variables::TITLE,
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
					} 
				} else // ARTICLES IN A PARTICULAR TOPIC
				{
					$page = 1;
					$topicname = $topic->Name;
					$activeLink = $topicname;
					$limit = 12;
					$offset = 0;
					$topicPosts = $topic->getPosts($limit, $offset);
					// display($_GET['page']);
                    $featuredImage = $topic->Image ?? '';
					if(empty($topicPosts))
					{
						$variables = ['title' => ucwords($topicname) . ' | '  . \Ninja\Variables::TITLE,
						'template' => 'topicposts.html.php',
						'description' => $topic->Description,
						'featuredImage' => $featuredImage,
						'activeLink' => $activeLink,
						'variables' => [ 
							'heading' => 'We are working to add posts to this topic. Check back soon.',
							'popularPosts' =>$this->popularPosts(),
						]
					];
					} else 
					{
						$variables = ['title' => ucwords($topicname) . ' | '  . \Ninja\Variables::TITLE,
						'template' => 'topicposts.html.php',
						'activeLink' => $activeLink,
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
				$this->variables->notFound();
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

					$variables = ['title' => '',
								'template' => 'articles.html.php',
								'variables' => [ 
										'heading' => 'Latest programming and linux tips, tricks and tutorials',
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
					$post = $this->postsTable->findOne(['String' => strtolower($string), 'Published' => 1]);
					if(is_object($post))
					{
						$author = $post->getAuthor();
						$authorName = $author->FirstName . ' ' . $author->LastName;
						$description = $post->Description;
						$keywords = $post->Keywords;
                    	$featuredImage = $post->Image ?? '';
						$variables = ['title' => $post->Title . ' | ' .\Ninja\Variables::TITLE,
									'authorName' => $authorName,
									'description' => $description,
									'keywords' => $keywords,
									'featuredImage' => $featuredImage,
									'template' => 'single.html.php',
									'variables' => [ 
											'post' => $post,
											'postCategories' => $post->getCategories(),
											'popularPosts' => $this->popularPosts($post->String),
											'topics' => $this->topics,
									]
						];
						
						return $variables;
					} else 
					{
						$this->variables->notFound();
					}
				}
			} else // IF NOT, DISPLAY HOME PAGE
			{
				$page = 1;
				$order = 'Id DESC';
				$limit = 12;
				$offset = ($page-1) * $limit;

				$posts = $this->postsTable->findAll(['Published' => 1], $order, $limit, $offset);
				$variables = ['title' => \Ninja\Variables::TITLE,
								'template' => 'articles.html.php',
								'variables' => [ 
										'heading' => 'Latest programming and linux tips, tricks and tutorials',
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
			    $suffix = ($number > 1) ? 's ' : ' ';
				$variables = ['title' => 'Search results',
					'template' => 'searchresults.html.php',
					'variables' => [ 
						'topics' => $this->topics,
						'searchResults' => $searchResults,
						'heading' => 'Search results for <strong>\'' . $_GET['searchterm'] . '\'</strong>',
						'secondHeading' => $number . ' result' . $suffix . 'found',
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

		//SUPERUSER
		public function delete() 
		{
			if($this->variables->superUserOnly())
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
							
							return $this->manageposts();
						}
					}
				} else 
				{
					$this->variables->notFound();
				}							
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		//CHANGE POST VISIBILITY
		public function togglePublish()
		{
			if($this->variables->superUserOnly())
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
				
				// Fetch post first to check validity
				$conditions = ['Published' => $state, 'Draft' => $draft];
				$post = $this->postsTable->findOne(['String' => $_GET['specificId']]);
				
				$title = $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE;
				
				if($post)
				{
	                if($post->checkValidity())
                    {
    					$postEntity = $post->togglePublish($conditions);
    					if($postEntity)
    					{	
    					    $postId = $postEntity->Id;
    						return $this->manageposts();
    					} else 
    					{
    						if($_SESSION['Superuser'])
    						{
    							$_SESSION['message'] = 'An error occurred processing your request.Sorry about that.';
    							$_SESSION['type'] = 'error';
    		
    							return $this->manageposts();
    						} else 
    						{
    							$_SESSION['message'] = 'An error occurred processing your request.Sorry about that.';
    							$_SESSION['type'] = 'error';
    		
    							$author = $this->authentication->getUser();
    		
    							return $this->manageposts();
    						}
    					}                        
                    } else 
                    {
                    	$_SESSION['message'] = 'Article not ready to go live! Image was never provided';
						$_SESSION['type'] = 'error';
        				return $this->drafts();
                    }
	
				} else
				{
					$this->variables->notFound();
				}
			} else 
			{
				$this->variables->notAuthorized();
			}
		}
		
        // Send to mailing list
        public function sendToMailingList()
        {
            $post = $this->postsTable->findOne(['String' => $_GET['specificId']]);
            if($post->sendToMailingList())
            {
                // was sent 
                // Update MailedOut status in Db
                $post = json_decode(json_encode($post), true);
                $status = $this->save($post);
            } else 
            {
                $_SESSION['message'] = 'Article has already been sent to mailing list';
                $_SESSION['type'] = 'success';
            }
            return $this->manageposts();
        }

		//METHODS FOR HANDLING POST UPLOADS

		//HANDLES FILES
		private function handleFiles($post, $files, $errors, $valid):array 
		{
			//PROCESS IMAGE 
			if (!empty($files['Image']['name'])) 
			{
				$image_name = $files['Image']['name'] = time();
				$destination = ROOT_PATH.'/assets/images/' . $image_name;

				$result = move_uploaded_file($files['Image']['tmp_name'], $destination);

				if ($result) 
				{
					$post['Image'] = $image_name;
				} else 
				{
					$valid = false;
					http_response_code(500);
					array_push($errors, "An error occurred uploading image");
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
				if(!$post['Id'])
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
// 			$title = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9?\s]/', ' ', $input)));
			// replace any double whitespace with a single whitespace
			$title = preg_replace('/  [^  ]+?/', ' ', $input);
			return $title;
		}
		
		//SAVE ARTICLE => ADD || UPDATE 
		public function save($post = [])
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
                if(isset($_POST['post']))
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
        				
                        // GENERATE TITLE
        				$post['Title'] = $this->generateTitle($post['Title']);
        				$post['Body'] = htmlentities($post['Body']);
        				
        				// Tell difference between adding new and editing old
        				// String will never be edited
        				if(isset($post['Id']) && ($post['Id'] !== ''))
        				{
                            // Will pick the Id of the post from hidden form field 
        				} else {
        				    if(isset($_POST['add']))
        					{
        						$post['Id'] = ''; // Set Id field to empty string
        						$post['Published'] = 0;
        						$post['Draft'] = 1;
        						$post['Date'] = $this->generateDate();
        						$post['MailedOut'] = 0;
        						// GENERATE SEO-FRIENDLY URL
        						$post['String'] = $this->generateSEOLink($post['Title'], '-', true, $words_array); // GENERATE SEO SLUG
        				 	}
        				}
        
        				//SAVE POST
        				save:
        				$postEntity = $authorObject->addPost($post);
        				//INSERT CATEGORY RECORDS
        				if($postEntity)
        				{
        					//CLEAR CATEGORY RECORDS
        					$postEntity->clearCategories();
        				
        					
        					if(isset($_POST['category']))
        					{
        					    //INSERT CATEGORY RECORD FOR POST 
        						foreach($_POST['category'] as $categoryId)
        						{
        							$postEntity->addCategory($categoryId);
        						}
        							
        						if($postEntity)
        						{
        							if($_SESSION['Superuser'])
        							{
        								$_SESSION['message'] = 'Changes applied';
        								
        								$_SESSION['type'] = 'success';
        
        								return $this->manageposts();
        							} else 
        							{
        								$_SESSION['message'] = $_POST['edit'] ? 'Article updated successfully' : 'Article added successfully';
        								$_SESSION['type'] = 'success';
        
        								$author = $this->authentication->getUser();
        								return $this->manageposts();
        							}
        						} else 
        						{
        							http_response_code(500);
        							$_SESSION['message'] = 'An error occurred processing your request';
        							$_SESSION['type'] = 'error';
        
        							return $this->addpost();
        						}								
        					}
        				} else 
        				{
        					http_response_code(500);
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
        					'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
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
                    // Update after sending to mailing list
                	//FETCH THE AUTHOR OBJECT
    				$authorObject = $this->authentication->getUser();
    				//SAVE POST
    				$postEntity = $authorObject->updateAfterSendingToMailingList($post);
    				if($postEntity)
    				{
    				    return true;
    				} else 
    				{
    				    return false;
    				}
                }
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		//MANAGE POSTS
		public function manageposts() 
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
			    $user = $this->authentication->getUser();
				if($_SESSION['Superuser'])
				{
				    $posts = $user->getAllPosts();
		
					return [
						'title' => \Ninja\Variables::SUPERUSERTITLE,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $posts,
										'heading' => 'Manage Posts',
									]
					];
				} else
				{
					$posts = $user->getPosts();
		
					return [
						'title' => \Ninja\Variables::ADMINTITLE,
						'template' => 'manageposts.html.php',
						'variables' => [
										'posts' => $posts,
										'heading' => 'Manage My Posts',
							]
					];
				}
			} else 
			{
				$this->variables->notAuthorized();
			}
		}

		//SERVE ADD POST FORM
		public function addpost() 
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
				return [
					'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
					'template' => 'addpost.html.php',
					'variables' => [
						'heading' => 'Add post',
						'categories' => $this->topics
					]
				];
			} else 
			{
				$this->variables->notAuthorized();		
			}
		}
		
		//SERVE EDIT POST FORM
		public function editpost()
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
				$idOfPostToEdit = $_GET['specificId'];

				$post = $this->postsTable->findOne(['String' => $idOfPostToEdit]);
				if($post->getAuthor()->Id !== $_SESSION['Id'])
				{
				    $_SESSION['message'] = 'You can\'t edit blogs you didn\'t write!';
				    $_SESSION['type'] = 'error';
				    return $this->manageposts();
				} else 
				{
    				if(is_object($post))
    				{
    					return [
    						'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
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
					$this->variables->notFound();
				}
	
				}
			} else 
			{
				$this->variables->notAuthorized();	
			}
		}

		// HANDLE DRAFTS
		public function drafts()
		{
			if($this->variables->checkWhetherAdminOrSuperUser())
			{
			    $user = $this->authentication->getUser();
			    
			    if($_SESSION['Superuser'])
			    {
			        $drafts = $user->getDrafts();
			    } else 
			    {
			        $drafts = $user->getAuthorDrafts();
			    }
	
				return [
					'title' => $_SESSION['Superuser'] ? \Ninja\Variables::SUPERUSERTITLE : \Ninja\Variables::ADMINTITLE,
					'template' => 'drafts.html.php',
					'variables' => [
						'heading' => 'Drafts',
						'posts' => $drafts,
					]
				];
			} else 
			{
				$this->variables->notAuthorized();
			}
		}
		
		public function handleerrors()
		{
        	return [
				'title' => \Ninja\Variables::TITLE,
				'template' => 'errorpage.html.php',
				'variables' => [
					'message' => 'We regret an error occurred! We are working to have it resolved as soon as possible',
				]
			];		    
		}
		public function aboutus()
		{
        	return [
				'title' => 'About us - ' . \Ninja\Variables::TITLE,
				'template' => 'aboutus.html.php',
				'variables' => [
					'message' => '<strong>Thelinuxpost.com</strong> is a Kenyan blog that is focused on publishing content about programming, linux tips, tricks and tutorials. We 
					are passionate about programming and enjoy coming up with solutions to any programming problems. We are also Linux enthusiasts and we often delve into
					linux tips, and tricks discussions. <br/><br/> The blog is developed and run by Ismail Chacha, a full-stack developer and computer enthusiast. <br/>You can always 
					get in touch with me for collaboration - maybe on a project, hiring - you can hire me if you want to have a website built. <br/><br/> I\'m available on Twitter
					so you can always get in touch - handle at <strong>Get social</strong> section. You can also follow me on Github.'
				]
			];		    
		}
	}
}
