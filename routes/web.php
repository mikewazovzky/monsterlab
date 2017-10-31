<?php

use App\Post;
use App\Twitter;
use App\Facebook;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
Route::view('/developers', 'pages.developers')->name('developers');
Route::view('/oauth', 'pages.oauth')->name('oauth');

Route::redirect('/', '/main', 301);
Route::redirect('/home', '/main', 301); // TEMPORARY: find actions that redirects to  'home' and 'logout'!

// TEMPORATY ROUTES: TESTING Social API

// Redirect to APP OAuth Route
Route::get('/facebook/login', function () {
    $fb = new Facebook;
    return $fb->login();
});

Route::get('/facebook/callback', function (Request $request) {
    // Get authentication code passed by Facebook Login
    $code = $request->code;
    // Confirm Identity: Exchanging Code for an User Access Token
    $fb = new Facebook;
    $app_access_token = $fb->getAppAccessToken();
    $user_access_token = $fb->getUserAccessToken($code);
    $page_access_token = $fb->getPageAccessToken($user_access_token);
    // Inspect access token
    if (!$page_access_token || !$fb->isValidAccessToken($page_access_token)) {
        return 'Error: Something went wrong....';
    }
    // Post status to a page timeline on behalf of the Page
    $result = $fb->postToPage(
        $message = 'How cool is that!',
        $link = 'https://laracasts.com/series/whats-new-in-laravel-5-5',
        $page_access_token
    );
    return $result;
});

Route::get('/twitter/{id}', function ($id) {
    $post = Post::findOrFail($id);
    $result = (new Twitter())->publish($post);
    dd(json_decode((string) $result->getBody(), true));
});

Route::get('/facebook/{id}', function ($id) {
    $post = Post::findOrFail($id);
    $result = (new Facebook())->publish($post);
    dd(json_decode((string) $result->getBody(), true));
});

// Server: API authorized method
// Route::get('/user', function () {
//     return auth()->user();
// })->middleware('auth:api');
