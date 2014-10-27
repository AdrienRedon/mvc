<?php 

class PageController extends \Core\Controller
{
	protected $page;
	protected $posts;

	public function __construct()
	{
		parent::__construct();
		$this->page = \Core\Model::load('page');
		$this->posts = \Core\Model::load('post');
	}

	public function index()
	{
		$user = $this->auth->user();
		$content = $this->page->first()->content;
        $posts = $this->posts->all();
        $last_post = $posts->last('name');

		if($this->isAjax())
		{
			$this->view->json(compact('content'));
		}
		else
		{
			$this->view->render('index', compact('content', 'user', 'posts', 'last_post'));
		}
	}
}