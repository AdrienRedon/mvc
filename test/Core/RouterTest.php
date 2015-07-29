<?php 

namespace Test\Core;

use App\Core\Router;
use \PHPUnit_Framework_TestCase;

define('WEBROOT', '');

class RouterTest extends PHPUnit_Framework_TestCase 
{

    public function setUp()
    {
        $this->router = new Router();
        $this->router->get('/test-get', function() {
            return 'get ok';
        });
        $this->router->post('/test-post', function() {
            return 'post ok';
        });
        $this->router->any('/test-any', function() {
            return 'any ok';
        });
    }

    public function requestedValidRoutes()
    {
        return [
            ['GET', '/test-get', 'get ok'],
            ['POST', '/test-post', 'post ok'],
            ['GET', '/test-any', 'any ok'],
            ['POST', '/test-any', 'any ok'],
            ['PUT', '/test-any', 'any ok'],
            ['PATCH', '/test-any', 'any ok'],
            ['DELETE', '/test-any', 'any ok']
        ];
    }

    public function requestedNotFoundRoutes()
    {
        return [
            ['GET', 'test'],
            ['POST', 'test'],
            ['POST', 'test-get'],
            ['GET', 'test-post']
        ];
    }

    /**
     * @dataProvider requestedValidRoutes
     */
    public function testRun($method, $url, $result)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $url;
        $this->assertEquals($this->router->run(), $result);
    }

    /**
     * @dataProvider requestedNotFoundRoutes
     * @expectedException App\Core\Route\NotFoundException
     */
    public function testThrowsExceptionIfRouteNotFound($method, $url)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $url;
        $this->router->run();
    }

}