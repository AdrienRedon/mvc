<?php 

namespace Controllers;

use \Core\Model;

class PageController extends \Core\Controller
{
    protected $page = Model::load('page');
    protected $post = Model::load('post');
    protected $user = Model::load('user');

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
