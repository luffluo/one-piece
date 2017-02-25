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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\\HomeController@index')->name('admin.index');

    Route::get('options', 'Admin\\OptionController@index')->name('admin.options.index');
    Route::post('options', 'Admin\\OptionController@store')->name('admin.options.store');
});