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

            $tags = Cache::remember('tags', 60, function() {
                return Tag::has('posts')->withCount('posts')->get();
            });

            // $archives = Cache::remember('archives', 1440, function() {
            //     return Post::archives();
            // });

            // $latest = Cache::rememberForever('latest', function() {
            //     return Post::latest()->take(5)->get();
            // });

            $archives = Post::archives();
            $trending = Post::trending(5);
            $latest   = Post::latest()->take(5)->get();

            return $view->with([
                'tags'     => $tags,
                'archives' => $archives,
                'latest'   => $latest,
                'trending' => $trending,
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
