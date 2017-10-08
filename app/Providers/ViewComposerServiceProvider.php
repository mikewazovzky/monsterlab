<?php

namespace App\Providers;

use App\Tag;
use App\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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

            $tags = Cache::rememberForever('tags', function() {
                return Tag::has('posts')->withCount('posts')->get();
            });

            $archives = Cache::rememberForever('archives', function() {
                return Post::archives();
            });

            $latest = Cache::rememberForever('latest', function() {
                return Post::latest()->take(5)->get();
            });

            $popular = Cache::rememberForever('popular', function() {
                return Post::orderBy('views', 'desc')->take(5)->get();
            });

            return $view->with([
                'tags' => $tags,
                'archives' => $archives,
                'latest' => $latest,
                'popular' => $popular,
            ]);
        });

        View::composer('posts.form', function ($view) {
            $tags = Tag::pluck('id', 'name');

            return $view->with(['tags' => $tags]);
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
