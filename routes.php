<?php 

use Core\App;

$router = App::get('Core\Router');

$router->get('/', 'PageController@index', 'home');

$router->get('phpinfo', function() {
    phpinfo();
});

$router->post('login', 'SessionController@login', 'login');
$router->get('logout', 'SessionController@logout', 'logout');

$router->resource('post', 'PostController', ['only' => ['index', 'show']]);

$router->resource('admin/post', 'Admin\PostController', ['except' =>['show']]);

/**
 * Store the instance of the router
 */
App::setInstance($router);

$router->run();