<?php
$text = 'PHp rules';
if(preg_match('/PHP/i', $text))
{
	echo 'Text PHP found in $text';
} else
{
	echo 'Not found';
}

$time = time();

$string = $_GET['subfolder'];

// display(str_replace('-', ' ', strtoupper($string)));
if($present = (strstr($string, 'page=')))
{
	// display($_GET['specific']);
	$position = stripos($present, '=');
	// Pick the page number from it
	$page = substr($present, ($position +1));
	// Turn page numbers into offsets
	$limit = '4';
	$offset = ($page-1) * 4;
	$topicPosts = $topic->getPosts([], null, $limit, $offset);

	if(empty($topicPosts))
	{
		$variables = ['title' => $topicname,
		'template' => 'topicposts.html.php',
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

} else
{
	$topic = $this->topicsTable->findOne(['Name' => str_replace('-', ' ', strtoupper($string))]);
	$topicname = $topic->Name;

	if(is_object($topic))
	{
		$page = 1;
		$limit = '4';
		$offset = $page * 0;
		$topicPosts = $topic->getPosts([], null, $limit, $offset);

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

		if(empty($topicPosts))
		{
			$variables = ['title' => $topicname,
			'template' => 'topicposts.html.php',
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
				// display($variables['variables']['totalTopicPosts']);
				return $variables;
	} else
	{
		// display('An error occurred');
		$_SESSION['message'] = 'An error occurred';
		$_SESSION['type'] = 'error';
		header('location:/');
	}				
}
