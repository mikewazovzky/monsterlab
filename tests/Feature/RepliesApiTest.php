<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RepliesApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_user_can_get_a_list_of_replies_for_the_post()
    {
        $reply = create('App\Reply');

        $response = $this->getJson(route('post.replies.index', $reply->post))->json();

        $this->assertCount(
            1,
            array_filter($response['data'], function ($item) use ($reply) {
                return $item['body'] == $reply->body;
            })
        );
    }

    /** @test */
    public function unauthorized_user_may_not_create_a_reply_to_a_post()
    {
        // Guest may not post a reply
        $post = create('App\Post');

        $this->postJson(route('post.replies.store', $post), [])
            ->assertStatus(401);

        // Reader may not post a reply
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->postJson(route('post.replies.store', $post), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_may_create_a_reply_to_a_post()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = create('App\Post');
        $body = 'Some body';

        $response = $this->postJson(route('post.replies.store', $post), ['body' => $body])
            ->assertStatus(201)
            ->json();

        $this->assertEquals($body, $response['body']);

        $this->assertDatabaseHas('replies', [
            'body' => $body,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_update_a_reply_to_a_post()
    {
        $reply = create('App\Reply');

        // Guest may not update a reply
        $this->patchJson(route('post.replies.update', [$reply->post, $reply]), [])
            ->assertStatus(401);

        // Reader may not update a reply
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->patchJson(route('post.replies.update', [$reply->post, $reply]), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_may_update_a_reply_to_a_post()
    {
        // Writer can update own reply
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $reply = create('App\Reply', ['user_id' => $user->id]);
        $updatedBody = 'Updated';

        $response = $this->patchJson(route('post.replies.update', [$reply->post, $reply]), ['body' => $updatedBody])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($updatedBody, $response['body']);

        $this->assertDatabaseHas('replies', [
            'body' => $updatedBody,
        ]);

        // Admin can update any reply
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);
        $updatedBody = 'Updated again';

        $response = $this->patchJson(route('post.replies.update', [$reply->post, $reply]), ['body' => $updatedBody])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($updatedBody, $response['body']);

        $this->assertDatabaseHas('replies', [
            'body' => $updatedBody,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_delete_reply_to_a_post()
    {
        // Guest may not delete a reply
        $reply = create('App\Reply');

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(401);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);

        // Reader may not delete a reply
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(403);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);

        // Writer may not delete other user's reply
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(403);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);
    }

    /** @test */
    public function authorized_user_may_delete_a_reply_to_a_post()
    {
        // Writer may delete own reply
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('replies', [
            'body' => $reply->body,
        ]);

        // Admin may delete any reply
        $reply = create('App\Reply');
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('replies', [
            'body' => $reply->body,
        ]);
    }

    /** @test */
    public function reply_requires_a_valid_body()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = create('App\Post');

        // Create a reply
        $response = $this->postJson(route('post.replies.store', $post), ['body' => null])
            ->assertStatus(422)
            ->json();

        $this->assertTrue(isset($response['errors']['body']));

        // Update a reply
        $reply = create('App\Reply', ['user_id' => $user->id]);
        $reply->body = null;

        $response = $this->patchJson(route('post.replies.update', [$reply->post, $reply]), $reply->toArray())
            ->assertStatus(422)
            ->json();

        $this->assertTrue(isset($response['errors']['body']));
    }
}
