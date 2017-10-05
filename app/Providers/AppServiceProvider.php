<?php

namespace App\Providers;

use App\Tag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.sidebar', function ($view) {
                $tags = Tag::has('posts')->pluck('name');
                return $view->with(compact('tags'));
            }
        );

        View::composer('posts.form', function ($view) {
                $tags = Tag::pluck('id', 'name');
                return $view->with(compact('tags'));
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
