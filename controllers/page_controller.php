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
        $this->user = \Core\Model::load('user');
	}

	public function index()
	{
		$user = $this->auth->user();
		$content = $this->page->first()->content;
        $posts = $this->user->find(1)->post;//->all();
        $last_post = $posts->orderBy('name', 'asc')->last('name');

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