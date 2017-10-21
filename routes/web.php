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
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@confirm')->name('register.confirm');
Route::get('/register/sendconfirmationrequest', 'Auth\RegisterConfirmationController@send')->name('register.send')->middleware('auth');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show')->middleware('auth');
Route::post('/profiles/{user}/avatar', 'AvatarsController@store')->name('avatars.store')->middleware('auth');
Route::patch('/profiles/{user}/data', 'UsersUpdateController@data')->name('user.update.data')->middleware('auth');
Route::patch('/profiles/{user}/role', 'UsersUpdateController@role')->name('user.update.role')->middleware('auth');
Route::patch('/profiles/{user}/password', 'UsersUpdateController@password')->name('user.update.password')->middleware('auth');

Route::get('/profiles/{user}/notifications', 'NotificationsController@index')->name('notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'NotificationsController@markAsRead')->name('notifications.markAsRead');
Route::delete('/profiles/{user}/notifications', 'NotificationsController@markAllAsRead')->name('notifications.markAllAsRead');

Route::resource('/tags', 'TagsController')->middleware('auth');
Route::resource('/posts', 'PostsController');
Route::get('/posts/{post}/replies', 'PostRepliesController@index')->name('post.replies.index');
Route::post('/posts/{post}/replies', 'PostRepliesController@store')->name('post.replies.store');
Route::patch('/posts/{post}/replies/{reply}', 'PostRepliesController@update')->name('post.replies.update');
Route::delete('/posts/{post}/replies/{reply}', 'PostRepliesController@destroy')->name('post.replies.destroy');

// Route::get('/search', function(Illuminate\Http\Request $request) {
//     $engine = $request['search-type'];
//     $query = $request['search-query'];

//     switch($engine) {
//         case 'mySQL':   return redirect(route('posts.index', ['search' => $query]));
//         case 'algolia': return view('search', ['query' => $query]);
//         default:        return back();
//     }
// });
Route::get('/search', 'SearchController@search');

Route::get('/main/{locale?}', 'PagesController@index')->name('main');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contacts', 'pages.contacts')->name('contacts');

Route::redirect('/', '/main', 301);
Route::redirect('/home', '/main', 301);  // TEMPORARY: find actions that redirect home!



