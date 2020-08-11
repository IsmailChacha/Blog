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

		public function getPosts($limit = null, $offset = null)
		{
			$conditions = ['TopicId' => $this->Id];
			$postCategories = $this->postCategoriesTable->findAll($conditions, null, $limit, $offset);
			$posts = [];
			foreach($postCategories as $postCategory)
			{
				$post = $this->postsTable->findOne(['Id' => $postCategory->ArticleId, 'Published' => 1]);
				if($post)
				{
					$posts[] = $post;
				}
			}

			usort($posts, [$this, 'sortPosts']);
			return $posts;
		}

		public function totalPosts()
		{
			return $this->postCategoriesTable->total(['TopicId' => $this->Id]);
		}

		private function sortPosts($a, $b)
		{
			$aDate = new \DateTime($a->Date);
			$bDate = new \DateTime($b->Date);
			$atimestamp =  $aDate->getTimestamp();
			$btimestamp =  $bDate->getTimestamp(); 
			if($atimestamp == $btimestamp)
			{
				return 0;
			}

			return $atimestamp > $btimestamp ? -1 : 1;
		}
	}
}