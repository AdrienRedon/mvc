<?php 

use \Core\Model;

class PageController extends \Core\Controller
{
	protected $page;
	protected $posts;

	public function __construct()
	{
		parent::__construct();
		$this->page = Model::load('page');
		$this->post = Model::load('post');
        $this->user = Model::load('user');
	}

	public function index()
	{
		$user = $this->auth->user();
		$content = $this->page->first()->content;
        $posts = $this->user->first()->post;

        $last_post = $posts->orderBy('name', 'asc')->last('name');

        $new_post = new $this->post;
        $new_post->name = 'test';
        $new_post->content = 'blablabla';
        $new_post->user_id = $user->id;
        $new_post->save();

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
