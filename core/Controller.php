<?php 

namespace Core;

use \Core\View;
use \Libs\Auth;
use \Libs\Redirect;
use \Libs\Flash;

class Controller
{
    /**
     * View
     * @var \Core\View
     */
    protected $view;

    /**
     * Auth
     * @var \Libs\Auth
     */
    protected $auth;

    /**
     * Redirect
     * @var \Libs\Redirect
     */
    protected $redirect;

    /**
     * Flash
     * @var \Libs\Flash
     */
    protected $flash;

    /**
     * Validation
     * @var \Libs\Validation
     */
    protected $validation;

    /**
     * Data given throw $_REQUEST  POST
     * @var Array
     */
    protected $data;

    /**
     * Constructor
     */
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
     * Check if this is an AJAX call
     * @return bool
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * When the action is not found
     * @return View JSON or HTML view
     */
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

    /**
     * When the acion is not allowed
     * @return View JSON or HTML view
     */
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
