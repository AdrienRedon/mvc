<?php 

namespace Test\Controller;

use App\Core\Controller\Controller;

class TestController extends Controller 
{
    public function index()
    {
        return 'hello';
    }
}