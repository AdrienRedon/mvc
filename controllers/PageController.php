<?php 

namespace Controllers;

use \Core\Controller;
use \Core\App;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page = App::get('\Models\Page');
        $this->post = App::get('\Models\Post');
        $this->user = App::get('\Models\User');
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
