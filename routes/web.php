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

Auth::routes();

Route::get('/', 'HomeController@index')->middleware('guest');

Route::get('/feed', 'FeedController@index')->name('feed');

//Route::get('/logout', 'UserController@postLogout')->name('user.logout');

Route::post('/comments', 'CommentController@store')->name('comment.new');

Route::get('/comments', 'CommentController@delete')->name('comment.delete');
