<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Events\PostCreated;
use App\Events\ReplyCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function event_is_fired_when_post_is_created()
    {
        Event::fake();

        $post = create('App\Post');

        Event::assertDispatched(PostCreated::class, function ($e) use ($post) {
            return $e->post->id === $post->id;
        });
    }

    /** @test */
    public function event_is_fired_when_reply_is_created()
    {
        Event::fake();

        $reply = create('App\Reply');

        Event::assertDispatched(ReplyCreated::class, function ($e) use ($reply) {
            return $e->reply->id === $reply->id;
        });
    }
}
