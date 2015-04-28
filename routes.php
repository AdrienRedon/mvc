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
Route::post('admin/post/store', 'Admin\PostController@store');
Route::get('admin/post/{id}/update', 'Admin\PostController@update');
Route::post('admin/post/{id}/save', 'Admin\PostController@save');
Route::get('admin/post/{id}/delete', 'Admin\PostController@delete');