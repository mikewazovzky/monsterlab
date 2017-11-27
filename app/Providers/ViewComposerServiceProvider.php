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

            // Cache values

            // $tags = Cache::remember('tags', 60, function() {
            //     return Tag::has('posts')->withCount('posts')->get();
            // });

            // $archives = Cache::remember('archives', 1440, function() {
            //     return Post::archives();
            // });

            // $latest = Cache::rememberForever('latest', function() {
            //     return Post::latest()->take(5)->get();
            // });

            // Option 1: uses tag->posts relationship, returns collection of tags
            // $tags = Tag::has('posts')->withCount('posts')->get();
            // Option 2: uses tag->posts relationship, returns array ['name' => count]
            // $tags = Tag::has('posts')->withCount('posts')->pluck('posts_count', 'name');
            // Option 3: doesn't use tag->posts relationship, returns array ['name' => count]
            $tags = tagCounts();
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
