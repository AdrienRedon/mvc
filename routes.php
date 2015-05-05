<?php 

use Core\Route;

Route::get('/', 'PageController@index');

Route::get('phpinfo', function() {
    phpinfo();
});

Route::post('login', 'SessionController@login');
Route::get('logout', 'SessionController@logout');

Route::resource('post', 'PostController', ['only' => ['index', 'show']]);

Route::resource('admin/post', 'Admin\PostController', ['except' =>['show']]);