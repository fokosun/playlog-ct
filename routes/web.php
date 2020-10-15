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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->middleware('guest');

Route::get('/feed', 'FeedController@index')->name('feed');

Route::post('/comments', 'CommentController@store')->name('comment.new');

Route::delete('/comments/{comment}/{user}', 'CommentController@delete')->name('comment.delete');

Route::post('/reactions/{author_id}/{comment_id}', 'CommentReactionController@store')->name('reaction.new');