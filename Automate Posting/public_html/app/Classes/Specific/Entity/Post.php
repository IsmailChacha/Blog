<?php
namespace Specific\Entity
{
	//POST ENTITY CLASS
	class Post
	{
		//DATABASE FIELDS
		public $Id;
		public $Title;
		public $Image;
		public $String;
		public $Body;
		public $Published;
		public $AuthorId;
		public $Date;
		public $MailedOut;

		private $usersTable;
		private $postTopicsTable;
		private $postsTable;
		private $topicsTable;
		private $mailingListTable;  // TOPICS TABLE INSTANCE OF DATABASEHANDLER CLASS

		public $author;

		public function __construct(\Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $postTopicsTable, \Ninja\DatabaseHandler $postsTable, \Ninja\DatabaseHandler $topicsTable
		, \Ninja\DatabaseHandler $mailingListTable)
		{
			$this->usersTable = $usersTable;
			$this->postTopicsTable = $postTopicsTable;
			$this->postsTable = $postsTable;
			$this->topicsTable = $topicsTable;
			$this->mailingListTable = $mailingListTable;
		}

		public function getAuthor()
		{
			if(empty($this->author))
			{
				$this->author = $this->usersTable->findById($this->AuthorId);
			}
			return $this->author;
		}

		public function addCategory($categoryId)
		{	
			$postCat = ['ArticleId' => $this->Id, 'TopicId' => $categoryId];
			return $this->postTopicsTable->save($postCat); 
		}

		public function belongsToCategory($categoryId)
		{
			$postCategories = $this->postTopicsTable->findAll(['ArticleId' => $this->Id]);
			foreach($postCategories as $postCategory)
			{
				if($postCategory->TopicId == $categoryId)
				{
					return true;
				}
			}
		}
		
		public function getCategories()
		{
			$postCategoriesIds = $this->postTopicsTable->findAll(['ArticleId' => $this->Id]);
// 			display($postCategoriesIds);
			$postCategories = [];
			foreach($postCategoriesIds as $category)
			{
			    $topic = $this->topicsTable->findOne(['Id' => $category->TopicId]);
			    array_push($postCategories, $topic);
			}
		    return $postCategories;
		}

		public function clearCategories()
		{
			return $this->postTopicsTable->deleteWhere(['ArticleId' => $this->Id]);
		}

		public function deletePost()
		{
			$conditions = ['Id' => $this->Id];
			return $this->postsTable->deleteWhere($conditions);
		}

		public function togglePublish($conditions)
		{
			$conditions['Id'] = $this->Id;
			return $this->postsTable->save($conditions);
		}
		
		public function checkValidity()
		{
		    $conditions['Id'] = $this->Id;
		    if($this->Image != '')
		    {
		        return true;
		    } else 
		    {
		        return false;
		    }
		}
		
		public function sendToMailingList()
		{
		    if(!$this->MailedOut)
		    {
		        require ROOT_PATH . '/app/includes/newsletter.php'; //does the actual sending
                if($status)
                {
                    $_SESSION['message'] = 'Messages sent to ' . count($mailingList) . ' people';
                    $_SESSION['type'] = 'success';
                } else 
                {
                    $_SESSION['message'] = 'An error occurred sending messages.Sorry about that.';
                    $_SESSION['type'] = 'error';                
                }
                return true;
		    } else 
		    {
		      //  Article has already been send to mailing list
                return false;		      
		    }
		}
	}
}