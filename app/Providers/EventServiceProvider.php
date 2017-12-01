<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            'App\Listeners\SendConfirmEmailRequest',
            'App\Listeners\InformAdminThatUserRegistered',
        ],
        'App\Events\PostCreated' => [
            'App\Listeners\InformAdminThatPostCreated',
            'App\Listeners\PublishTwitterStatus',
            'App\Listeners\PublishFacebookStatus',
        ],
        'App\Events\CommentCreated' => [
            'App\Listeners\InformAdminThatCommentCreated',
            'App\Listeners\InformUserThatCommentCreated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
