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

include('routes.php');

try {
    $router->run();
} catch (NotFoundException $e) {
    die($e->getMessage());
} catch (NotAllowedException $e) {
    die($e->getMessage());
}