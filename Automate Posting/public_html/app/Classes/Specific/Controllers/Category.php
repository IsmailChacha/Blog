<?php
namespace Specific\Controllers
{
	//TOPICS CONTROLLER
	class Category
	{
		private $topicsTable; //TOPICS INSTANCE OF DATABASEHANDLER CLASS
		private $authentication; //AUTHENTICATION CLASS INSTANCE
		private $variables;

		public function __construct(\Ninja\DatabaseHandler $topicsTable, \Ninja\Authentication $authentication)
		{
			$this->topicsTable = $topicsTable;
			$this->authentication = $authentication;
			$this->variables = new \Ninja\Variables($this->authentication);
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
		
		// MANAGE TOPICS
		public function managetopics() 
		{
			if($this->variables->superUserOnly())
			{
				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'managetopics.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'heading' => 'Manage Topics']
				];
			} else
			{
				$this->variables->notAuthorized();
			}			
		}
		
		//SERVE ADDTOPIC FORM
		public function addtopicForm() 
		{
			if($this->variables->superUserOnly())
			{
				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'addtopic.html.php',
					'variables' => [
						'heading' => 'Add Topic',
						'btn' => 'Add topic'
					]
				];
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		//ADD TOPIC
		public function addtopic() 
		{
			if($this->variables->superUserOnly())
			{
				$errors = [];
				$valid = true;

				//CHECK FOR VALIDITY OF FORM DATA THEN CHECK FOR ALREADY EXISTING TOPIC
				if(empty($_POST['topic']['name']))
				{
					array_push($errors, 'Topic name required');
					$valid = false;
				} elseif(empty($_POST['topic']['description']))
				{
					array_push($errors, 'Topic description required');
					$valid = false;
				} else
				{
					$name = strtoupper($_POST['topic']['name']);
					$description = ucfirst($_POST['topic']['description']);
				}

				if($valid)
				{
					$conditions = ['name' => $name];
					$existingTopic = $this->topicsTable->findAll($conditions);

					if(!empty($existingTopic))
					{
						$_SESSION['message'] = 'Topic already exists';
						$_SESSION['type'] = 'error';
						return [
							'title' => \Ninja\Variables::SUPERUSERTITLE,
							'template' => 'managetopics.html.php',
							'variables' => [
								'heading' => 'Manage Topics',
								'topics' => $this->topicsTable->findAll([], 'Name ASC'),
							]
						];				
					} else 
					{
						$name = strtoupper($_POST['topic']['name']);
						$description = $_POST['topic']['description'];
						$topic = $this->topicsTable->save(['Name' => $name, 'Description' => $description, 'Id' => '']);
						$_SESSION['message'] = 'Topic added successfully';
						$_SESSION['type'] = 'success';
	
						if($topic)
						{
							return [
								'title' => \Ninja\Variables::SUPERUSERTITLE,
								'template' => 'managetopics.html.php',
								'variables' => [
									'heading' => 'Manage Topics',
									'topics' => $this->topicsTable->findAll([], 'Name ASC'),
								]
							];
						} else 
						{
							http_response_code(500);
							$_SESSION['message'] = 'An error occurred on our end. Sorry about that.';
							$_SESSION['type'] = 'error';
	
							return [
								'title' => \Ninja\Variables::SUPERUSERTITLE,
								'template' => 'addtopic.html.php',
								'variables' => [
									'heading' => 'Manage Topics',
									'name' => $_POST['topic']['name'],
									'description' => $_POST['topic']['description'],
								]
							];
						}
					}
				} else 
				{
					return [
						'title' => \Ninja\Variables::SUPERUSERTITLE,
						'template' => 'edittopic.html.php',
						'variables' => [
							'heading' => 'Edit Topic',
							'name' => $_POST['topic']['name'],
							'description' => $_POST['topic']['description'],
							'errors' => $errors
						]
					];
				}
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		//SERVE EDIT TOPIC FORM
		public function displayEditTopicForm() 
		{
			if($this->variables->superUserOnly())
			{
				$topic = $_GET['specificId'];
				$condition = ['Id' => $topic];
				$topic = $this->topicsTable->findOne($condition);
	
				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'edittopic.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'name' => $topic->Name,
						'description' => $topic->Description,
						'id' => $topic->Id,
						'heading' => 'Edit Topic'
						]
				];
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		//UPDATE TOPIC
		public function updateTopic()
		{
			if($this->variables->superUserOnly())
			{
				$errors = [];
				$valid = true;

				if(empty($_POST['topic']['name']))
				{
					array_push($errors, 'Topic name required');
					$valid = false;
				} else 
				{
					$idOfTopicToEdit = $_POST['topic']['id'];
					$name = strtoupper($_POST['topic']['name']);	
					$description = $_POST['topic']['description'];
				}

				if($valid)
				{
					$topic = ['Name' => $name, 'Description' => $description, 'Id' => $idOfTopicToEdit];
					$this->topicsTable->save($topic);
		
					$_SESSION['message'] = 'Topic updated successfully';
					$_SESSION['type'] = 'success';
		
					return [
						'title' => \Ninja\Variables::SUPERUSERTITLE,
						'template' => 'managetopics.html.php',
						'variables' => [
							'heading' => 'Manage topics',
							'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						]
					];					
				} else 
				{
					return [
						'title' => \Ninja\Variables::SUPERUSERTITLE,
						'template' => 'addtopic.html.php',
						'variables' => [
							'topics' => $this->topicsTable->findAll([], 'Name ASC'),
							'name' => $_POST['topic']['name'],
							'description' => $_POST['topic']['description'],
							'id' => $_POST['topic']['id'],
							'heading' => 'Add Topic'
							]
					];
				}
			} else
			{
				$this->variables->notAuthorized();
			}
		}

		//DELETE TOPIC
		public function deletetopic() 
		{
			if($this->variables->superUserOnly())
			{
				$condition = ['Id' => $_GET['specificId']];

				$post = $this->topicsTable->delete($condition);
	
				$_SESSION['message'] = 'Topic deleted successfully';
				$_SESSION['type'] = 'success';
	
				return [
					'title' => \Ninja\Variables::SUPERUSERTITLE,
					'template' => 'managetopics.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'heading' => 'Manage Topics'],
				];
			} else
			{
				$this->variables->notAuthorized();
			}
		}		
	}
}