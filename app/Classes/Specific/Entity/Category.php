<?php
namespace Specific\Entity
{
	//CATEGORY ENTITY CLASS
	class Category
	{
		public $Id;
		public $Name;
		public $postsTable;
		public $postCategoriesTable;

		public function __construct(\Ninja\DatabaseHandler $postsTable, \Ninja\DatabaseHandler $postCategoriesTable)
		{
			$this->postsTable = $postsTable;
			$this->postCategoriesTable = $postCategoriesTable;
		}

		public function getPosts()
		{
			$postCategories = $this->postCategoriesTable->findAll(['TopicId' => $this->Id]);
			// display($postCategories);
			$posts = [];
			foreach($postCategories as $postCategory)
			{
				$post = $this->postsTable->findOne(['Id' => $postCategory->ArticleId, 'Published' => 1]);
				if($post)
				{
					$posts[] = $post;
				}
			}

			return array_reverse($posts);
		}

		public function totalPosts()
		{
			return $this->postCategoriesTable->total(['topicId' => $this->Id]);
		}
	}
}