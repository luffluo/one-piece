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
Route::get('/', 'PostsController@index')->name('home');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

// Search
Route::get('search', 'PostsController@index')->name('search');

// Post
Route::get('archives/{post}', 'PostsController@show')->name('posts.show');

// Post comment
Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);

// Tags
Route::get('tags', 'TagsController@index')->name('tags.index');
Route::get('tag/{slug}', 'TagsController@posts')->name('tag.posts');

// Archive
Route::get('/{year}/{month?}/{day?}', 'PostsController@archive')
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{1,2}', 'day' => '[0-9]{1,2}'])
    ->name('archive');

// User
Route::prefix('u')->group(function () {

    Route::get('{user}', 'UsersController@center')->name('users.center');

    Route::get('{user}/profile', 'UsersController@editProfile')->name('users.edit_profile');
    Route::post('{user}/profile', 'UsersController@updateProfile')->name('users.update_profile');

    Route::get('{user}/avatar', 'UsersController@editAvatar')->name('users.edit_avatar');
    Route::post('{user}/avatar', 'UsersController@updateAvatar')->name('users.update_avatar');

    Route::get('{user}/password', 'UsersController@editPassword')->name('users.edit_password');
    Route::post('{user}/password', 'UsersController@updatePassword')->name('users.update_password');
});

// SiteMap
Route::get('sitemap', 'PagesController@sitemap')->name('sitemap');

// RSS
Route::get('feed', 'PagesController@rss')->name('feed');

// 上传图片
Route::post('action/upload', 'UploadController@handleUpload')
    ->middleware('auth.admin')
    ->name('upload');

/***************************** Front routes end *****************************/


/***************************** Admin routes start *****************************/
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {

    // Home
    Route::get('/', 'HomeController@index')->name('home');

    // Option
    Route::prefix('options')->group(function () {
        Route::get('general', 'OptionsController@showGeneral')->name('options.general');
        Route::post('general', 'OptionsController@handleGeneral');

        Route::get('discussion', 'OptionsController@showDiscussion')->name('options.discussion');
        Route::post('discussion', 'OptionsController@handleDiscussion');

        Route::get('reading', 'OptionsController@showReading')->name('options.reading');
        Route::post('reading', 'OptionsController@handleReading');
    });

    // theme
    Route::prefix('themes')->group(function () {
        Route::get('option', 'ThemesController@showOption')->name('themes.option');
        Route::post('option', 'ThemesController@handleOption');
    });

    // Post
    Route::resource('posts', 'PostsController', [
        'except' => ['show'],
    ]);

    // Comment
    Route::get('comments', 'CommentsController@index')->name('comments.index');
    Route::post('comments/{comment}', 'CommentsController@store')->name('comments.store');
    Route::patch('comments/{comment}', 'CommentsController@update')->name('comments.update');
    Route::patch('comments/{comment}/{status}', 'CommentsController@changeStatus')->name('comments.change.status');
    Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

    // Tag
    Route::resource('tags', 'TagsController', [
        'except' => ['show'],
    ]);
    Route::patch('tags/{tag}/default', 'TagsController@setDefault')->name('tags.set.default');

    // 导航
    Route::resource('navs', 'NavsController', [
        'except' => ['show'],
    ]);

    // Attachment 附件
    Route::resource('attachments', 'AttachmentsController', [
        'except' => ['create', 'story', 'show']
    ]);
    // 清理未归档文件
    Route::post('attachments/clear', 'AttachmentsController@clear')->name('attachments.clear');

    // User
    Route::resource('users', 'UsersController', [
        'except' => ['create', 'store', 'show'],
    ]);
});
/***************************** Admin routes end *****************************/
