<?php 

use Core\Route;

Route::get('/', 'PageController@index');

Route::get('phpinfo', function() {
    phpinfo();
});

Route::post('login', 'SessionController@login');
Route::get('logout', 'SessionController@logout');

Route::get('post', 'PostController@index');
Route::get('post/{id}', 'PostController@show');

Route::get('admin/post', 'Admin\PostController@index');
Route::get('admin/post/create', 'Admin\PostController@create');
Route::get('admin/post/update/{id}', 'Admin\PostController@update');
Route::post('admin/post/save', 'Admin\PostController@save');
Route::get('admin/post/delete/{id}', 'Admin\PostController@delete');