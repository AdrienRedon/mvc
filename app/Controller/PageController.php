<?php 
namespace App\Controller;

use App\Core\Controller\Controller;

class PageController extends Controller 
{
    public function index() 
    {
        return $this->view->render('Page/index');
    }
}