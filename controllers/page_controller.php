<?php 

class PageController extends \Core\Controller
{
	protected $page;

	public function __construct()
	{
		parent::__construct();
		$this->page = \Core\Model::load('page');
	}

	public function index()
	{
		$user = $this->auth->user();
		$content = $this->page->first(['conditions' => 'id = 1'])->content;

		if($this->isAjax())
		{
			$this->view->json(compact('content'));
		}
		else
		{
			$this->view->render('index', compact('content', 'user'));
		}
	}
}