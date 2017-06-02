<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front routes
Route::get('/', 'IndexController@index');

Route::resource('post', 'PostController', ['only' => ['show']]);

// Admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('admin.index');

    // Options
    Route::get('options', 'OptionController@index')->name('admin.options.index');
    Route::post('options', 'OptionController@store')->name('admin.options.store');

    // Posts
    Route::get('posts', 'PostController@index')->name('admin.posts.index');
    Route::get('posts/create', 'PostController@create')->name('admin.posts.create');
    Route::post('posts', 'PostController@store')->name('admin.posts.store');
    Route::get('posts/{id}', 'PostController@edit')->name('admin.posts.edit');
    Route::patch('posts/{id}', 'PostController@update')->name('admin.posts.update');
    Route::delete('posts/{id}', 'PostController@destroy')->name('admin.posts.destroy');
});
