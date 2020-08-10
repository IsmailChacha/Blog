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

		public $author;

		public function __construct(\Ninja\DatabaseHandler $usersTable, \Ninja\DatabaseHandler $postTopicsTable)
		{
			$this->usersTable = $usersTable;
			$this->postTopicsTable = $postTopicsTable;
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
	}
}