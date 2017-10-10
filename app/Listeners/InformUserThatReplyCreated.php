<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ReplyCreatedUserNotification;

class InformUserThatReplyCreated
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
        $postAuthor = $event->reply->post->user;

        if ($postAuthor->id != $event->reply->user_id) {
            $postAuthor->notify(new ReplyCreatedUserNotification($event->reply));
        }
    }
}
