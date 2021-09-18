<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('users', 'UserController');
Route::resource('reviews', 'ReviewController');
Route::get('review/{review}/comments', 'ReviewCommentController@index');
Route::post('review/{review}/comments', 'ReviewCommentController@store');
Route::get('comment/{comment}/replies', 'CommentReplyController@index');
Route::post('comment/{comment}/replies', 'CommentReplyController@store');
Route::resource('comments', 'CommentController')->only(['update', 'destroy']);
