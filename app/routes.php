<?php

/**
 * List of routes
 */

$router->any('phpinfo', function() {
    phpinfo();
});

$router->get('/', 'PageController@index');