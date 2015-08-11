<?php 

namespace Test\Core\Controller;

use \PHPUnit_Framework_TestCase;
use App\Core\Controller\ControllerResolver;
use App\Core\DependencyInjection\Container;

class ControllerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $container = new Container();
        $container->register('App\Controller\TestController', function() {
            return new \Test\Controller\TestController;
        });
        $this->controllerResolver = new ControllerResolver($container);
    }

    public function testCreateController()
    {
        $this->assertEquals(call_user_func_array($this->controllerResolver->create('TestController@index'), array()), 'hello');
    }
}