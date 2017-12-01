<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CommentCreatedUserNotification;

class InformUserThatCommentCreated
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
    public function handle(CommentCreated $event)
    {
        $postAuthor = $event->comment->post->user;

        if ($postAuthor->id != $event->comment->user_id) {
            $postAuthor->notify(new CommentCreatedUserNotification($event->comment));
        }
    }
}
