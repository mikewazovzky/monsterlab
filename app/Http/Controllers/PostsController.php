<?php

namespace App\Http\Controllers;

use App\Post;
use App\Image;
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
        $posts = Post::with('user:id,name,slug')
            ->latest()
            ->filter($filters);

        if (request()->wantsJson()) {
            return $posts->get();
        }

        // provide service info on the page
        $page = $request->page ?: 1;
        $postsOnPage = 10;

        // highligh search query in the posts
        $search = $request->search ?: '';

        return view('posts.index', [
            'posts' => $posts->paginate($postsOnPage),
            'page' => $page,
            'postsOnPage' => $postsOnPage,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);

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
        $this->authorize('create', Post::class);

        $postAttributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $imageAttributes = $request->validate([
            'featured' => 'sometimes|image|max:400',
        ]);

        $post = Post::publish($postAttributes, $request->tagList);

        if ($request->has('featured')) {
            $image = Image::fromFile($request->file('featured'));
            $post->addImage($image);
        }

        flash('Your post has been published!');

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
        $post->updateViewsCount();

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
        $this->authorize('update', $post);

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

        $this->authorize('update', $post);

        $attributes = $request->validate([
            'title' => 'sometimes|required',
            'body' => 'sometimes|required',
        ]);

        $imageAttributes = $request->validate([
            'featured' => 'sometimes|image|max:400',
        ]);

        $post->modify($attributes, $request->tagList);

        if ($request->has('featured')) {
            $image = Image::fromFile($request->file('featured'));
            $post->updateImage($image);
        }

        flash('Your post has been updated!');

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
        $this->authorize('delete', $post);

        $post->delete();

        flash()->danger('Your post has been deleted!');

        return redirect(route('posts.index'));
    }
}
