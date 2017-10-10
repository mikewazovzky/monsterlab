<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Notifications\ReplyCreatedUserNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_be_notified()
    {
        $user = create('App\User');
        $reply = create('App\Reply');

        $user->notify(new ReplyCreatedUserNotification($reply));

        $this->assertCount(1, $user->notifications);
        $this->assertCount(1, $user->unreadNotifications);
    }

    /** @test */
    public function guest_may_not_fetch_notifications()
    {
        $response = $this->getJson("user/1/notifications")->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_fetch_all_notifications()
    {
        $this->signIn($user = create('App\User'));
        $reply = create('App\Reply');

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(0, $response);

        $user->notify(new ReplyCreatedUserNotification($reply));

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(1, $response);
    }

    /** @test */
    public function authenticated_user_can_mark_a_notification_as_read()
    {
        $this->signIn($user = create('App\User'));
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(1, $response);

        $this->deleteJson("user/{$user->id}/notifications/{$notification->id}")->assertStatus(200);

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(0, $response);
    }

    /** @test */
    public function authenticated_user_can_mark_all_notifications_as_read()
    {
        $this->withoutExceptionHandling();

        $this->signIn($user = create('App\User'));
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(1, $response);

        $this->deleteJson("user/{$user->id}/notifications")->assertStatus(200);

        $response = $this->getJson("user/{$user->id}/notifications")->json();
        $this->assertCount(0, $response);
    }
}
