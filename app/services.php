<?php 
use App\Core\Database\MySQLDatabase;
use App\Core\Model\ModelResolver;
use App\Libs\Session;
use App\Core\Config;
use App\Libs\Auth;
use App\Libs\Redirection;
use App\Libs\Flash;
use App\Core\View\ViewTwig;
use App\Libs\Asset;

/**
 * List of services
 */
$container->register('ModelResolver', function() use ($container) {
    return new ModelResolver($container);
});
$container->register('ViewInterface', function() use ($container) {
    return new ViewTwig($container);
});
$container->register('Database', function() {
    return new MySQLDatabase(new Config());
});
$container->register('SessionInterface', function() {
    return new Session();
});
$container->register('Auth', function() use ($container) {
    return new Auth($container);
});
$container->register('Redirection', function() use ($container) {
    return new Redirection($container->resolve('SessionInterface'));
});
$container->register('Flash', function() use ($container) {
    return new Flash($container->resolve('SessionInterface'));
});
$container->register('Asset', function() use($container) {
    return new Asset($container);
});
$container->register('Config', function() {
    return new Config();
});
