<?php 

namespace Controllers\Admin;

use \Core\Controller;
use \Libs\Validation;
use \Core\App;

class PostController extends Controller
{
    protected $posts;

    public function __construct()
    {
        parent::__construct();
        $this->post = App::get('\Models\Post');
        $this->user = App::get('\Models\User');

        if(!$this->auth->check())
        {
            $this->notAllowed();
        }
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
            $this->view->render('admin/post/index', compact('posts'));
        }
    }

    public function create()
    {
        $this->view->render('admin/post/create');
    }

    public function store()
    {
        $input = array(
            'name'    => $this->data['name'],
            'content' => $this->data['content']
        );

        $rules = [
            'name'    => 'required',
            'content' => 'required'
        ];

        $this->validation = new Validation($input, $rules);

        if($this->validation->passes())
        {
            $this->post->save($input);
            $this->redirect->to('admin/post');
        }
        else
        {
            $this->redirect->backWithInput($input);
        }
    }

    public function edit($id)
    {
        $post = $this->post->find($id);

        if(!$post)
        {
            $this->notFound();
        }
        
        $this->view->render('admin/post/edit', compact('post'));
    }

    public function update($id)
    {
        $post = $this->post->find($id);

        if(!$post)
        {
            $this->notFound();
        }

        $input = array(
            'name'    => $this->data['name'],
            'content' => $this->data['content']
        );

        $rules = [
            'name'    => 'required',
            'content' => 'required'
        ];

        $this->validation = new Validation($input, $rules);

        if($this->validation->passes())
        {
            $post->save($input);
            $this->redirect->to('admin/post');
        }
        else
        {
            $this->redirect->backWithInput($input);
        }
    }

    public function delete($id)
    {
        $this->post->delete($id);
        $this->redirect->back();
    }
}
