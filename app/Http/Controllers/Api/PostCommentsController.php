<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCommentsController extends Controller
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
        $comments = $post->comments()->latest()->paginate(10);

        return response($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Request $request)
    {
        $this->authorize('create', Comment::class);

        $request->validate(['body' => 'required']);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response($comment, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $attributes = $request->validate(['body' => 'required']);

        $comment->update($attributes);

        return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response('deleted', 204);
    }
}
