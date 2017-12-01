<?php

namespace Tests\Feature;

use App\Events\PostCreated;
use App\Events\CommentCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function event_is_fired_when_user_is_registered()
    {
        $attributes = [
            'name' => 'User Name',
            'email' => 'user@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post(route('register', $attributes))->assertStatus(302);

        Event::assertDispatched(Registered::class, function ($event) use ($attributes) {
            return $event->user->name === $attributes['name'];
        });
    }

    /** @test */
    public function event_is_fired_when_post_is_created()
    {
        $post = create('App\Post');

        Event::assertDispatched(PostCreated::class, function ($event) use ($post) {
            return $event->post->id === $post->id;
        });
    }

    /** @test */
    public function event_is_fired_when_comment_is_created()
    {
        $comment = create('App\Comment');

        Event::assertDispatched(CommentCreated::class, function ($event) use ($comment) {
            return $event->comment->id === $comment->id;
        });
    }
}
