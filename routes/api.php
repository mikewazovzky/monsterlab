<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function () {
    return auth()->user();
});

Route::middleware('auth:api')->get('/posts', 'Api\PostsController@index');
Route::middleware('auth:api')->get('/posts/{id}', 'Api\PostsController@show');
Route::middleware('auth:api')->post('/posts', 'Api\PostsController@store');
Route::middleware('auth:api')->post('/posts/{id}/update', 'Api\PostsController@update');
Route::middleware('auth:api')->post('/posts/{id}/destroy', 'Api\PostsController@destroy');
