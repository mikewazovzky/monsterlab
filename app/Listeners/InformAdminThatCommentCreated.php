<?php

namespace App\Listeners;

use App\User;
use App\Events\CommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CommentCreatedAdminNotification;

class InformAdminThatCommentCreated
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
        $admin = User::admin();

        if ($admin && $admin->id != $event->comment->user->id) {
            $admin->notify(new CommentCreatedAdminNotification($event->comment));
        }
    }
}
