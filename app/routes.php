<?php 

namespace App;

use App\Core\Router;
use App\Core\Route\NotFoundException;
use App\Core\Route\NotAllowedException;

$router = new Router();

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
    die($é->getMessage());
}