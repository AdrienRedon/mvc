<?php 

namespace Core;

use \Core\View;
use \Libs\Auth;
use \Libs\Redirect;
use \Libs\Flash;

class Controller
{
    protected $view;
    protected $auth;
    protected $redirect;
    protected $flash;
    protected $validation;

    /**
     * Data given throw $_REQUEST  POST
     * @var Array
     */
    protected $data;

    public function __construct()
    {
        $this->view = App::get('\Core\View');
        $this->auth = App::get('\Libs\Auth');
        $this->redirect = App::get('\Libs\Redirect');
        $this->flash = App::get('\Libs\Flash');
        

        if(isset($_REQUEST))
        {
            $this->data = $_REQUEST;
        }
    }

    /**
     * Determine si l'appel a été fait en Ajax
     * @return bool
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function notFound()
    {
        if($this->isAjax())
        {
            $this->view->json('Page introuvable', 404);
        }
        else
        {
            $this->view->render('errors/404');
        }
    }

    public function notAllowed()
    {
        if($this->isAjax())
        {
            $this->view->json('Accès refusé', 403);
        }
        else
        {
            $this->view->render('errors/403');
        }
    }
}
