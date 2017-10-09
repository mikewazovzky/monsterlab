<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reply;
use Illuminate\Http\Request;

class PostRepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return $post->replies()->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Request $request)
    {
        $this->authorize('create', Reply::class);

        $request->validate(['body' => 'required']);

        $reply = $post->replies()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return $reply;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $attributes = $request->validate(['body' => 'required']);

        $reply->update($attributes);

        return $reply;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();
    }
}
