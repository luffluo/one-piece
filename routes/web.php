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

/* Front routes start */
Route::get('/', 'HomeController@index')->name('home');

// Search
Route::get('search', 'HomeController@index')->name('search');

// Post
Route::get('a/{id}', 'PostController@show')->name('post.show');

// 文章评论
Route::post('a/{post_id}/comment', 'PostController@handleComment')->name('post.comment');

// Tags
Route::get('tags', 'TagController@index')->name('tags');
Route::get('t/{slug}', 'TagController@posts')->name('tag.posts');

// Archive
Route::get('/{year}/{month?}/{day?}', 'PostController@archive')
    ->where(['year' => '[0-9]+', 'month' => '[0-9]+', 'day' => '[0-9]+'])
    ->name('archive');

// SiteMap
Route::get('sitemap', 'SiteMapController')->name('sitemap');

// RSS
Route::get('feed', 'RssController')->name('feed');

// Auth
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::get('login', 'LoginController@showLogin')->name('login');
    Route::post('login', 'LoginController@handleLogin');

    Route::get('register', 'RegisterController@showRegister')->name('register');
    Route::post('register', 'RegisterController@handleRegister');

    Route::get('logout', 'LogoutController')->name('logout');
});
/* Front routes end */

/* Admin routes start */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('admin.home');

    // 侧边栏开关
    Route::post('nav_trigger', 'HomeController@navTrigger')->name('admin.nav.trigger');

    // Option
    Route::group(['prefix' => 'options'], function () {
        Route::get('general', 'OptionController@showGeneral')->name('admin.options.general');
        Route::post('general', 'OptionController@handleGeneral');

        Route::get('discussion', 'OptionController@showDiscussion')->name('admin.options.discussion');
        Route::post('discussion', 'OptionController@handleDiscussion');

        Route::get('reading', 'OptionController@showReading')->name('admin.options.reading');
        Route::post('reading', 'OptionController@handleReading');
    });

    // theme
    Route::group(['prefix' => 'theme'], function () {
        Route::get('options', 'ThemeController@showOptions')->name('admin.theme.options');
        Route::post('options', 'ThemeController@handleOptions');
    });

    // Post
    Route::resource('posts', 'PostController', [
        'except' => ['show'],
        'names'  => [
            'index'   => 'admin.posts.index',
            'create'  => 'admin.posts.create',
            'store'   => 'admin.posts.store',
            'edit'    => 'admin.posts.edit',
            'update'  => 'admin.posts.update',
            'destroy' => 'admin.posts.destroy',
        ],
    ]);

    // Comment
    Route::get('comments', 'CommentController@index')->name('admin.comments.index');
    Route::post('comments/{comment}', 'CommentController@reply')->name('admin.comments.reply');
    Route::patch('comments/{comment}', 'CommentController@update')->name('admin.comments.update');
    Route::delete('comments/{comment}', 'CommentController@destroy')->name('admin.comments.destroy');

    // Tag
    Route::resource('tags', 'TagController', [
        'except' => ['show'],
        'names'  => [
            'index'   => 'admin.tags.index',
            'create'  => 'admin.tags.create',
            'store'   => 'admin.tags.store',
            'edit'    => 'admin.tags.edit',
            'update'  => 'admin.tags.update',
            'destroy' => 'admin.tags.destroy',
        ],
    ]);

    // 导航
    Route::resource('navs', 'NavController', [
        'except' => ['show'],
        'names'  => [
            'index'   => 'admin.navs.index',
            'create'  => 'admin.navs.create',
            'store'   => 'admin.navs.store',
            'edit'    => 'admin.navs.edit',
            'update'  => 'admin.navs.update',
            'destroy' => 'admin.navs.destroy',
        ],
    ]);

    // User
    Route::resource('users', 'UserController', [
        'except' => ['create', 'store', 'show'],
        'names'  => [
            'index'   => 'admin.users.index',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],
    ]);
});
/* Admin routes end */
