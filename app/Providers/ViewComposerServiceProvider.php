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
        View::composer('posts.sidebar', function ($view) {

            // $tags = Cache::remember('tags', 3600, function() {
            //     return Tag::has('posts')->withCount('posts')->get();
            // });

            // $archives = Cache::remember('archives', 3600, function() {
            //     return Post::archives();
            // });

            // $popular = Cache::remember('popular', 3600, function() {
            //     return Post::orderBy('views', 'desc')->take(5)->get();
            // });

            // $latest = Cache::rememberForever('latest', function() {
            //     return Post::latest()->take(5)->get();
            // });

            $tags = Tag::has('posts')->withCount('posts')->get();
            $archives = Post::archives();
            $popular = Post::orderBy('views', 'desc')->take(5)->get();
            $latest = Post::latest()->take(5)->get();

            return $view->with([
                'tags' => $tags,
                'archives' => $archives,
                'latest' => $latest,
                'popular' => $popular,
            ]);
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
