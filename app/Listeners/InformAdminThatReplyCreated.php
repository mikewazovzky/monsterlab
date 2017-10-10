<?php

namespace App\Listeners;

use App\User;
use App\Events\ReplyCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ReplyCreatedAdminNotification;

class InformAdminThatReplyCreated
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
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        $admin = User::admin();

        if ($admin && $admin->id != $event->reply->user->id) {
            $admin->notify(new ReplyCreatedAdminNotification($event->reply));
        }
    }
}
