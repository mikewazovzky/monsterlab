<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use App\Post;
use App\Filters\PostFilters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostFilters $filters)
    {
        $posts =  Post::with('user:id,name,slug')->latest()->filter($filters)->get();

        return response(['data' => $posts], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $attributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::publish($attributes, $request->tagList);

        return response(['status' => 'success'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $attributes = $request->validate([
            'title' => 'sometimes|required',
            'body' => 'sometimes|required',
        ]);

        $post->update($attributes);

        $post->syncTags($request->tagList);

        return response(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        return response(['status' => 'success'], 200);
    }
}
