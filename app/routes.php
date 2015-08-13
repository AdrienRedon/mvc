<?php 

namespace App;

use App\Core\Router;
use App\Core\Route\Exception\NotFoundException;
use App\Core\Route\Exception\NotAllowedException;
use App\Core\Controller\ControllerResolver;
use App\Core\DependencyInjection\Container;

$container = new Container();

$resolver = new ControllerResolver($container);

$router = new Router($resolver);

/**
 * List of routes
 */

$router->get('/', function() {
    echo 'Hello World!';
});

try {
    $router->run();
} catch (NotFoundException $e) {
    die($e->getMessage());
} catch (NotAllowedException $e) {
    die($e->getMessage());
}