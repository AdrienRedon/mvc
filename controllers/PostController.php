<?php 

namespace Controllers;

use \Core\Controller;
use \Core\App;

class PostController extends \Core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->post = App::get('\Models\Post');
        $this->user = App::get('\Models\User');
    }

    public function index()
    {
        $posts = $this->post->all();

        if($this->isAjax())
        {
            $this->view->json(compact('posts'));
        }
        else
        {
            $this->view->render('post/index', compact('posts'));
        }
    }

    public function show($id)
    {
        $post = $this->post->find($id);

        if($this->isAjax())
        {
            $this->view->json(compact('post'));
        }
        else
        {
            $this->view->render('post/show', compact('post'));
        }
    }

}
