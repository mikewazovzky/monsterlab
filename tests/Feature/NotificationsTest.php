<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Events\PostCreated;
use App\Events\CommentCreated;
use App\Notifications\UserConfirmed;
use App\Notifications\UserRegistered;
use App\Notifications\PostCreatedAdminNotification;
use App\Notifications\CommentCreatedUserNotification;
use App\Notifications\CommentCreatedAdminNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_sends_notification_to_admin_wnen_new_user_is_registered()
    {
        Notification::fake();

        $admin = create('App\User', ['role' => 'admin']);

        event(new Registered($user = create('App\User')));

        Notification::assertSentTo(
            $admin,
            UserRegistered::class,
            function ($notification, $channels) use ($user) {
                return ($notification->user->id === $user->id) && $channels = ['database', 'mail'];
            }
        );
    }

    /** @test */
    public function it_sends_notification_to_admin_wnen_new_user_is_confirmed()
    {
        Notification::fake();

        $admin = create('App\User', ['role' => 'admin']);

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::whereName('John')->first();

        $this->get(route('register.confirm', [ 'token' => $user->confirmation_token]));

        Notification::assertSentTo(
            $admin,
            UserConfirmed::class,
            function ($notification, $channels) use ($user) {
                return ($notification->user->id === $user->id) && $channels = ['database', 'mail'];
            }
        );
    }

    /** @test */
    public function it_sends_notification_to_admin_wnen_new_post_is_created()
    {
        Notification::fake();

        $admin = create('App\User', ['role' => 'admin']);

        event(new PostCreated($post = create('App\Post')));

        Notification::assertSentTo(
            $admin,
            PostCreatedAdminNotification::class,
            function ($notification, $channels) use ($post) {
                return ($notification->post->id === $post->id) && $channels = ['database', 'mail'];
            }
        );
    }

    /** @test */
    public function it_sends_notification_to_admin_wnen_new_comment_is_created()
    {
        Notification::fake();

        $admin = create('App\User', ['role' => 'admin']);

        event(new CommentCreated($comment = create('App\Comment')));

        Notification::assertSentTo(
            $admin,
            CommentCreatedAdminNotification::class,
            function ($notification, $channels) use ($comment) {
                return ($notification->comment->id === $comment->id) && $channels = ['database', 'mail'];
            }
        );
    }

    /** @test */
    public function it_sends_notification_to_user_wnen_new_comment_is_created_to_his_post()
    {
        Notification::fake();

        $post = create('App\Post');

        event(new CommentCreated($comment = create('App\Comment', [
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Post',
        ])));

        Notification::assertSentTo(
            $post->user,
            CommentCreatedUserNotification::class,
            function ($notification, $channels) use ($comment) {
                return ($notification->comment->id === $comment->id) && $channels = ['database', 'mail'];
            }
        );
    }
}
