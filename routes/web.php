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
Route::get('/', 'IndexController@index')->name('home');

Route::get('a/{id}', 'PostController@show')->name('post.show');

Route::get('tags', 'TagController@index')->name('tags');


// Admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@showLogin')->name('admin.login');
    Route::post('login', 'LoginController@handleLogin');

    Route::post('logout', 'LogoutController')->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth.admin']], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('admin.home');

    // Option
    Route::get('options', 'OptionController@index')->name('admin.options.index');
    Route::post('options', 'OptionController@store')->name('admin.options.store');

    // Post
    Route::get('posts', 'PostController@index')->name('admin.posts.index');
    Route::get('posts/create', 'PostController@create')->name('admin.posts.create');
    Route::post('posts', 'PostController@store')->name('admin.posts.store');
    Route::get('posts/{id}', 'PostController@edit')->name('admin.posts.edit');
    Route::patch('posts/{id}', 'PostController@update')->name('admin.posts.update');
    Route::delete('posts/{id}', 'PostController@destroy')->name('admin.posts.destroy');

    // Tag
    Route::get('tags', 'TagController@index')->name('admin.tags.index');
    Route::get('tags/create', 'TagController@create')->name('admin.tags.create');
    Route::post('tags/store', 'TagController@store')->name('admin.tags.store');
    Route::get('tags/{id}', 'TagController@edit')->name('admin.tags.edit');
    Route::patch('tags/{id}', 'TagController@update')->name('admin.tags.update');
    Route::delete('tags/{id}', 'TagController@destroy')->name('admin.tags.destroy');
});