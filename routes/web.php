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
Route::get('/', 'HomeController@index')->name('home');

// Search
Route::get('search', 'HomeController@index')->name('search');

// Post
Route::get('a/{id}', 'PostController@show')->name('post.show');

// Tags
Route::get('tags', 'TagController@index')->name('tags');

// Archive
Route::get('/{year}/{month?}/{day?}', 'PostController@archive')
    ->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'day' => '[0-9]+'])
    ->name('archive');

// SiteMap
Route::get('sitemap', 'SiteMapController')->name('sitemap');
Route::get('sitemap.xml', 'SiteMapController')->name('sitemap.xml');

// RSS
Route::get('feed', 'RssController')->name('feed');


// Admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@showLogin')->name('admin.login');
    Route::post('login', 'LoginController@handleLogin');

    Route::get('logout', 'LogoutController')->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth.admin']], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('admin.home');

    // 侧边栏开关
    Route::post('nav_trigger', 'HomeController@navTrigger')->name('admin.nav.trigger');

    // Option
    Route::group(['prefix' => 'options'], function () {
        Route::get('general', 'OptionController@showGeneral')->name('admin.options.general');
        Route::post('general', 'OptionController@handleGeneral');

        Route::get('reading', 'OptionController@showReading')->name('admin.options.reading');
        Route::post('reading', 'OptionController@handleReading');
    });

    // theme
    Route::group(['prefix' => 'theme'], function () {
        Route::get('options', 'ThemeController@showOptions')->name('admin.theme.options');
        Route::post('options', 'ThemeController@handleOptions');
    });

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

    // User
    Route::get('users/{id}', 'UserController@edit')->name('admin.users.edit');
    Route::patch('users/{id}', 'UserController@update')->name('admin.users.update');
});