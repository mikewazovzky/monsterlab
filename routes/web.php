<?php

Auth::routes();
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@confirm')->name('register.confirm');
Route::get('/register/sendconfirmationrequest', 'Auth\RegisterConfirmationController@send')->name('register.send')->middleware('auth');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show')->middleware('auth');
Route::post('/profiles/{user}/avatar', 'Api\UsersAvatarsController@store')->name('avatars.store')->middleware('auth');
Route::patch('/profiles/{user}/data', 'Api\UsersDataController@data')->name('user.update.data')->middleware('auth');
Route::patch('/profiles/{user}/role', 'Api\UsersDataController@role')->name('user.update.role')->middleware('auth');
Route::patch('/profiles/{user}/password', 'Api\UsersDataController@password')->name('user.update.password')->middleware('auth');

Route::get('/profiles/{user}/notifications', 'Api\NotificationsController@index')->name('notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'Api\NotificationsController@markAsRead')->name('notifications.markAsRead');
Route::delete('/profiles/{user}/notifications', 'Api\NotificationsController@markAllAsRead')->name('notifications.markAllAsRead');

Route::resource('/tags', 'Api\TagsController')->middleware('auth');

Route::resource('/posts', 'PostsController');
Route::get('/posts/{post}/adjustments', 'PostsAdjustmentsController@index')->name('adjustments.index');
Route::get('/search', 'PostsSearchController@search')->name('posts.search');

Route::get('/posts/{post}/replies', 'Api\PostRepliesController@index')->name('post.replies.index');
Route::post('/posts/{post}/replies', 'Api\PostRepliesController@store')->name('post.replies.store');
Route::patch('/posts/{post}/replies/{reply}', 'Api\PostRepliesController@update')->name('post.replies.update');
Route::delete('/posts/{post}/replies/{reply}', 'Api\PostRepliesController@destroy')->name('post.replies.destroy');

Route::get('/main/{locale?}', 'PagesController@index')->name('main');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contacts', 'pages.contacts')->name('contacts');
Route::post('/feedback', 'FeedbackController@feedback')->name('feedback');

Route::redirect('/', '/main', 301);
Route::redirect('/home', '/main', 301); // TEMPORARY: find actions that redirects to  'home' and 'logout'!



