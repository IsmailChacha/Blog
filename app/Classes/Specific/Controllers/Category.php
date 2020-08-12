<?php
namespace Specific\Controllers
{
	//TOPICS CONTROLLER
	class Category
	{
		private $topicsTable; //TOPICS INSTANCE OF DATABASEHANDLER CLASS
		private $authentication; //AUTHENTICATION CLASS INSTANCE

		public function __construct(\Ninja\DatabaseHandler $topicsTable, \Ninja\Authentication $authentication)
		{
			$this->topicsTable = $topicsTable;
			$this->authentication = $authentication;
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
		
		public function managetopics() 
		{
			if($this->superUserOnly())
			{
				$title = 'SuperUser Panel | Manage Topics';
				
				return [
					'title' => $title,
					'template' => 'managetopics.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'heading' => 'Manage Topics']
				];
			} else
			{
				header('location:/index.php/signin');
			}			
		}
		
		//SERVE ADDTOPIC FORM
		public function addtopicForm() 
		{
			if($this->superUserOnly())
			{
				$title = 'SuperUser Panel | Add Topic';
				return [
					'title' => $title,
					'template' => 'addtopic.html.php',
					'variables' => [
						'heading' => 'Add Topic',
						'btn' => 'Add topic'
					]
				];
			} else
			{
				header('location:/index.php/signin');
			}
		}

		public function addtopic() 
		{
				if($this->superUserOnly())
				{
				//CHECK FOR ALREADY EXISTING TOPICS
				$conditions = ['name' => strtoupper($_POST['topic']['name'])];
				$existingTopic = $this->topicsTable->findAll($conditions);

				if(!empty($existingTopic))
				{
					$_SESSION['message'] = 'Topic already exists';
					$_SESSION['type'] = 'error';
					$title = 'SuperUser Panel | Manage Topics';
					return [
						'title' => $title,
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
					$title = 'SuperUser Panel | Manage Topics';

					if($topic)
					{
						return [
							'title' => $title,
							'template' => 'managetopics.html.php',
							'variables' => [
								'heading' => 'Manage Topics',
								'topics' => $this->topicsTable->findAll([], 'Name ASC'),
							]
						];
					} else 
					{
						$_SESSION['message'] = 'An error occurred on our end. Sorry about that.';
						$_SESSION['type'] = 'error';

						return [
							'title' => $title,
							'template' => 'addtopic.html.php',
							'variables' => [
								'heading' => 'Manage Topics',
								'name' => $_POST['name'],
								'description' => $_POST['description'],
							]
						];
					}
				}
			} else
			{
				header('location:/index.php/signin');
			}
		}

		//SERVE EDIT TOPIC FORM
		public function displayEditTopicForm() 
		{
			if($this->superUserOnly())
			{
				$topic = $_POST['post']['id'];
				$condition = ['Id' => $topic];
				$topic = $this->topicsTable->findOne($condition);
	
				$title = 'SuperUser Panel | Edit Topic';
				return [
					'title' => $title,
					'template' => 'edittopic.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'name' => $topic->Name,
						'description' => $topic->Description,
						'id' => $topic->Id,
						'heading' => 'Edit Topic']
				];
			} else
			{
				header('location:/index.php/signin');
			}
		}

		//UPDATE TOPIC
		public function updateTopic()
		{
			if($this->superUserOnly())
			{
				$idOfTopicToEdit = $_POST['topic']['id'];
				$name = strtoupper($_POST['topic']['name']);
				$description = $_POST['topic']['description'];
				$topic = ['name' => $name, 'description' => $description, 'id' => $idOfTopicToEdit];
				$this->topicsTable->save($topic);
	
				$_SESSION['message'] = 'Topic updated successfully';
				$_SESSION['type'] = 'success';
	
				$title = 'SuperUser Panel | Manage topics';
	
				return [
					'title' => $title,
					'template' => 'managetopics.html.php',
					'variables' => [
						'heading' => 'Manage topics',
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
					]
				];
			} else
			{
				header('location:/index.php/signin');
			}
		}

		//DELETE TOPIC
		public function deletetopic() 
		{
			if($this->superUserOnly())
			{
				$topic = $_POST['post']['id'];
				$condition = ['id' => $topic];
				$post = $this->topicsTable->delete($condition);
	
				$_SESSION['message'] = 'Topic deleted successfully';
				$_SESSION['type'] = 'success';
	
				$title = 'SuperUser Panel | Manage Topics';
				
				return [
					'title' => $title,
					'template' => 'managetopics.html.php',
					'variables' => [
						'topics' => $this->topicsTable->findAll([], 'Name ASC'),
						'heading' => 'Manage Topics'],
				];
			} else
			{
				header('location:/index.php/signin');
			}
		}		
	}
}