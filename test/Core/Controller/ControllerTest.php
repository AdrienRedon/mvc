<?php 

namespace Test\Core\Controller;

use \PHPUnit_Framework_TestCase;
use App\Core\Controller\ControllerResolver;
use App\Core\DependencyInjection\Container;

define('ROOT', '');

class ControllerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $container = new Container();
        $this->controllerResolver = new ControllerResolver($container);
    }

    public function testCreateController()
    {
        $this->assertEquals(
            call_user_func_array(
                $this->controllerResolver->getAction('PageController@index'),
                array()
            ),
            'Hello World!'
        );
    }

    /**
     * @expectedException App\Core\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testTrowsExceptionServiceNotFound()
    {
        $this->controllerResolver->getAction('NotFoundController@index');
    }

    /**
     * @expectedException App\Core\Controller\Exception\MethodNotFoundException
     */
    public function testThrowsExceptionMethodNotFound()
    {
        $this->controllerResolver->getAction('PageController@notFoundMethod');
    }
}
