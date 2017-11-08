<?php

namespace App\Http\Controllers;

use App\Post;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favorite in the database.
     *
     * @param  Post $reply
     */
    public function store(Post $post)
    {
        $post->favorite(auth()->user());

        if (request()->expectsJson()) {
            return response(['status' => 'Post favorited']);
        }

        return back();
    }

    /**
     * Delete the favorite.
     *
     * @param Post $post
     */
    public function destroy(Post $post)
    {
        $post->unfavorite(auth()->user());

        if(request()->expectsJson()) {
            return response(['status' => 'Post unfavorited']);
        }

        return back();
    }
}
