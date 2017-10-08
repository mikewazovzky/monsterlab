<?php

namespace App\Providers;

use App\Tag;
use App\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.sidebar', function ($view) {
            $tags = Tag::has('posts')->withCount('posts')->get();
            $archives = Post::archives();
            $latest = Post::latest()->take(5)->get();
            $popular = Post::orderBy('views', 'desc')->take(5)->get();

            return $view->with(compact('tags', 'archives', 'latest', 'popular'));
        });

        View::composer('posts.form', function ($view) {
            $tags = Tag::pluck('id', 'name');
            return $view->with(compact('tags'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
