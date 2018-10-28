<?php

/***************************** Admin routes start *****************************/

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
/***************************** Admin routes end *****************************/
