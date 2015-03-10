<?php 

namespace Core;

use \Libs\Session;
use \Libs\Auth;
use \Libs\Redirect;
use \Libs\Flash;

class Controller
{
    protected $session;
    protected $view;
    protected $auth;
    protected $redirect;
    protected $flash;
    protected $validation;

    /**
     * Données passées en POST
     * @var Array
     */
    protected $data;

    public function __construct()
    {
        $this->session = new Session;

        $this->auth = new Auth($this->session);
        $this->redirect = new Redirect($this->session);
        $this->flash = new Flash($this->session);
        
        $this->view = new View;

        if(isset($_POST))
        {
            $this->data = $_POST;
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
