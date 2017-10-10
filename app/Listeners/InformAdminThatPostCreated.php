<?php

namespace App\Listeners;

use App\User;
use App\Events\PostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\PostCreatedAdminNotification;

class InformAdminThatPostCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $admin = User::admin();

        if ($admin && $admin->id != $event->post->user->id) {
            $admin->notify(new PostCreatedAdminNotification($event->post));
        }
    }
}
