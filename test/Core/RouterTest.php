<?php 

namespace Test\Core;

use App\Core\Router;
use \PHPUnit_Framework_TestCase;

define('WEBROOT', '');

class RouterTest extends PHPUnit_Framework_TestCase 
{

    public function testInitRoute()
    {
        $router = new Router();
        $router->get('/test-get', function() {
            return 'get ok';
        });
        $router->post('/test-post', function() {
            return 'post ok';
        });
        $router->any('/test-any', function() {
            return 'any ok';
        });
        return $router;
    }

    /**
     * @depends testInitRoute
     */
    public function testRouteGet(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test-get';
        $result = $router->run();
        $this->assertEquals($result, 'get ok');
    }

    /**
     * @depends testInitRoute
     */
    public function testRouteGetInvalidMethod(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test-get';
        $this->setExpectedException('App\Core\Route\NotFoundException');
        $result = $router->run();
        $this->fail('Exception not thrown');
    }

    /**
     * @depends testInitRoute
     */
    public function testRouteGetNotFound(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';
        $this->setExpectedException('App\Core\Route\NotFoundException');
        $result = $router->run();
        $this->fail('Exception not thrown');
    }

    /**
     * @depends testInitRoute
     */
    public function testRoutePost(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test-post';
        $result = $router->run();
        $this->assertEquals($result, 'post ok');
    }

    /**
     * @depends testInitRoute
     */
    public function testRoutePostInvalidMethod(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test-post';
        $this->setExpectedException('App\Core\Route\NotFoundException');
        $result = $router->run();
        $this->fail('Exception not thrown');
    }

    /**
     * @depends testInitRoute
     */
    public function testRoutePostNotFound(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test';
        $this->setExpectedException('App\Core\Route\NotFoundException');
        $result = $router->run();
        $this->fail('Exception not thrown');
    }

    /**
     * @depends testInitRoute
     */
    public function testRouteAny(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test-any';
        $result = $router->run();
        $this->assertEquals($result, 'any ok');

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/test-any';
        $result = $router->run();
        $this->assertEquals($result, 'any ok');

        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/test-any';
        $result = $router->run();
        $this->assertEquals($result, 'any ok');

        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/test-any';
        $result = $router->run();
        $this->assertEquals($result, 'any ok');
    }
}