<?php 

namespace Test;

use App\Core\Router;
use \PHPUnit_Framework_TestCase;

define('WEBROOT', ''); // empty WEBROOT in order to simplify the URL

class RouterTest extends PHPUnit_Framework_TestCase {

    public function testRoute()
    {
        $router = new Router();
        $router->get('/toto', function() {
            return '200';
        });
        return $router;
    }

    /**
     * @depends testRoute
     */
    public function testRoute200(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/toto';
        $result = $router->run();
        $this->assertEquals($result, '200');
    }

    /**
     * @depends testRoute
     */
    public function testRoute404(Router $router)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/azerty';
        $this->setExpectedException('App\Core\Route\NotFoundException');
        $result = $router->run();
        $this->fail('Exception not thrown');
    }
}