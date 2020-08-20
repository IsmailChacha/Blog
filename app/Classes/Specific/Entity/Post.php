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

		private $usersTable;
		private $postTopicsTable;
		private $postsTable;

		public $author;

		public function __construct(\Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $postTopicsTable, \Ninja\DatabaseHandler $postsTable)
		{
			$this->usersTable = $usersTable;
			$this->postTopicsTable = $postTopicsTable;
			$this->postsTable = $postsTable;
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
	}
}