<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Filters\PostFilters;
use Illuminate\Http\Request;

class PostsController extends Controller
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
    public function index(Request $request, PostFilters $filters)
    {
        $posts = Post::latest()->filter($filters);

        return view('posts.index', ['posts' => $posts->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = $this->createPost($attributes, $request->tagList);

        return redirect(route('posts.show', $post));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($attributes);

        $this->syncTags($post, $request->tagList);

        return redirect(route('posts.show', $post));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect(route('posts.index'));
    }

    /**
     * Creates new post. Associate tags with the post.
     *
     * @param array $attributes
     * @param array $tagList
     * @return App\Post
     */
    protected function createPost($attributes, $tagList) : Post
    {
        $post = auth()->user()->posts()->create($attributes);

        $this->syncTags($post, $tagList);

        return $post;
    }

    /**
     * Method description
     *
     * @param App\Post $post
     * @param array $tagList
     * @return void
     */
    protected function syncTags(Post $post, $tagList = [])
    {
        $post->tags()->sync($tagList);
    }
}
