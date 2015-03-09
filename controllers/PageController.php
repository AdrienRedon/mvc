<?php 

namespace Controllers;

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
