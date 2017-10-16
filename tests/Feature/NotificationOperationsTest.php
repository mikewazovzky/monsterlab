<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Notifications\ReplyCreatedUserNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationOperationsTest extends TestCase
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
        $response = $this->getJson(route('notifications.index', 1))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_may_not_fetch_notifications()
    {
        // User can not fetch other user's notifications
        $this->signIn();
        $user = create('App\User');

        $response = $this->getJson(route('notifications.index', $user))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_fetch_all_notifications()
    {
        $this->signIn($user = create('App\User'));

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(0, $response);

        $reply = create('App\Reply');
        $user->notify(new ReplyCreatedUserNotification($reply));

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(1, $response);
    }

    /** @test */
    public function guest_may_not_mark_a_notification_as_read()
    {
        $user = create('App\User');
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $this->deleteJson(route('notifications.markAsRead', [$user, $notification]))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_may_not_mark_a_notification_as_read()
    {
        // User can not mark other user's notification as read
        $this->signIn();
        $user = create('App\User');
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $this->deleteJson(route('notifications.markAsRead', [$user, $notification]))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_mark_a_notification_as_read()
    {
        $this->signIn($user = create('App\User'));
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(1, $response);

        $this->deleteJson(route('notifications.markAsRead', [$user, $notification]))->assertStatus(200);

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(0, $response);
    }

    /** @test */
    public function guest_may_not_mark_all_notifications_as_read()
    {
        $user = create('App\User');
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $this->deleteJson(route('notifications.markAllAsRead', $user))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_user_may_not_mark_all_notifications_as_read()
    {
        // User can not mark all other user's notifications as read
        $this->signIn();
        $user = create('App\User');
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $this->deleteJson(route('notifications.markAllAsRead', $user))->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_mark_all_notifications_as_read()
    {
        $this->signIn($user = create('App\User'));
        $user->notify(new ReplyCreatedUserNotification(create('App\Reply')));
        $notification = $user->notifications()->first();

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(1, $response);

        $this->deleteJson(route('notifications.markAllAsRead', $user))->assertStatus(200);

        $response = $this->getJson(route('notifications.index', $user))->json();
        $this->assertCount(0, $response);
    }
}
