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

/***************************** Front routes start *****************************/
Route::get('/', 'HomeController@index')->name('home');

// Search
Route::get('search', 'HomeController@index')->name('search');

// Post
Route::get('a/{post}', 'PostsController@show')->name('posts.show');

// 文章评论
Route::post('a/{post}/comment', 'PostsController@handleComment')->name('posts.comment');

// Tags
Route::get('tags', 'TagsController@index')->name('tags.index');
Route::get('t/{slug}', 'TagsController@posts')->name('tags.posts');

// Archive
Route::get('/{year}/{month?}/{day?}', 'PostsController@archive')
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{1,2}', 'day' => '[0-9]{1,2}'])
    ->name('archive');

// User
Route::group(['prefix' => 'u'], function () {

    Route::get('{user}', 'UsersController@center')->name('users.center');

    Route::get('{user}/profile', 'UsersController@editProfile')->name('users.edit_profile');
    Route::patch('{user}/profile', 'UsersController@updateProfile')->name('users.update_profile');

    Route::get('{user}/avatar', 'UsersController@editAvatar')->name('users.edit_avatar');
    Route::patch('{user}/avatar', 'UsersController@updateAvatar')->name('users.update_avatar');

    Route::get('{user}/password', 'UsersController@editPassword')->name('users.edit_password');
    Route::patch('{user}/password', 'UsersController@updatePassword')->name('users.update_password');
});



// SiteMap
Route::get('sitemap', 'PagesController@sitemap')->name('sitemap');

// RSS
Route::get('feed', 'PagesController@rss')->name('feed');

// Auth
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::get('login', 'LoginController@showLogin')->name('login');
    Route::post('login', 'LoginController@handleLogin');

    Route::get('register', 'RegisterController@showRegister')->name('register');
    Route::post('register', 'RegisterController@handleRegister');

    Route::post('logout', 'LogoutController')->name('logout');
});
/***************************** Front routes end *****************************/


/***************************** Admin routes start *****************************/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('admin.home');

    // 侧边栏开关
    Route::post('nav_trigger', 'HomeController@navTrigger')->name('admin.nav.trigger');

    // Option
    Route::group(['prefix' => 'options'], function () {
        Route::get('general', 'OptionsController@showGeneral')->name('admin.options.general');
        Route::post('general', 'OptionsController@handleGeneral');

        Route::get('discussion', 'OptionsController@showDiscussion')->name('admin.options.discussion');
        Route::post('discussion', 'OptionsController@handleDiscussion');

        Route::get('reading', 'OptionsController@showReading')->name('admin.options.reading');
        Route::post('reading', 'OptionsController@handleReading');
    });

    // theme
    Route::group(['prefix' => 'themes'], function () {
        Route::get('option', 'ThemesController@showOption')->name('admin.themes.option');
        Route::post('option', 'ThemesController@handleOption');
    });

    // Post
    Route::resource('posts', 'PostsController', [
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
    Route::get('comments', 'CommentsController@index')->name('admin.comments.index');
    Route::post('comments/{comment}', 'CommentsController@reply')->name('admin.comments.reply');
    Route::patch('comments/{comment}', 'CommentsController@update')->name('admin.comments.update');
    Route::delete('comments/{comment}', 'CommentsController@destroy')->name('admin.comments.destroy');

    // Tag
    Route::resource('tags', 'TagsController', [
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
    Route::resource('navs', 'NavsController', [
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
    Route::resource('users', 'UsersController', [
        'except' => ['create', 'store', 'show'],
        'names'  => [
            'index'   => 'admin.users.index',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],
    ]);
});
/***************************** Admin routes end *****************************/
