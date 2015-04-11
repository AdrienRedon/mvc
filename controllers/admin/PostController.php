<?php 

namespace Controllers\Admin;

use \Core\Controller;
use \Libs\Validation;

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
        $this->view->render('admin/post/new');
    }

    public function update($id)
    {
        $post = $this->post->find($id);
        $this->view->render('admin/post/update', compact('post'));
    }

    public function save()
    {
        if($this->data)
        {
            if(array_key_exists('id', $this->data)) // update
            {
                $input = array(
                    'id'      => $this->data['id'],
                    'name'    => $this->data['name'],
                    'content' => $this->data['content']
                );

                $rules = [
                    'id'      => 'required',
                    'name'    => 'required',
                    'content' => 'required'
                ];
            }
            else // create
            {
                $input = array(
                    'name'    => $this->data['name'],
                    'content' => $this->data['content']
                );

                $rules = [
                    'name'    => 'required',
                    'content' => 'required'
                ];
            }

            $this->validation = new Validation($input, $rules);

            if($this->validation->passes())
            {
                $this->post->save($input);
                $this->redirect->to('post');
            }
            else
            {
                $this->redirect->backWithInput($input);
            }
        }
    }

    public function delete($id)
    {
        $this->post->delete($id);
    }
}
