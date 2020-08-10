<?php 
namespace Specific\Entity
{
	//AUTHOR ENTITY CLASS
	class Author
	{
		//DATABASE FIELDS
		public $Id;
		public $FirstName;
		public $LastName;
		public $Email;
		public $Superuser;
		public $Admin;
		public $Password;
		public $Date;

		private $postsTable;

		public function __construct(\Ninja\DatabaseHandler $postsTable)
		{
			$this->postsTable = $postsTable;
		}

		public function getPosts()
		{
			return $this->postsTable->findAll(['AuthorId' => $this->Id]);
		}

		public function addPost($post)
		{
			$post['AuthorId'] = $this->Id;
			return $this->postsTable->save($post);
		}

		public function previewPost($post)
		{
			$post['AuthorId'] = $this->Id;
			$post['Published'] = 0;
			return $this->postsTable->save($post);
		}

		public function getTotalPublished()
		{
			return $this->postsTable->total(['Published' => 1]);
		}

		public function getTotalUnPublished()
		{
			return $this->postsTable->total(['Published' => 0]);
		}

		public function getTotal()
		{
			return $this->postsTable->total();
		}

		public function getTotalByAuthor()
		{
			return $this->postsTable->total(['AuthorId' => $this->Id]);
		}

		public function getPublishedByAuthor()
		{
			return $this->postsTable->total(['Published' => 1, 'authorid' => $this->Id]);
		}

		public function getUnpublishedByAuthor()
		{
			return $this->postsTable->total(['Published' => 0, 'authorid' => $this->Id]);
		}
	}
}