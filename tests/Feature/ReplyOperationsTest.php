<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyOperationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_user_can_get_a_list_of_replies_for_the_post()
    {
        $reply = create('App\Reply');

        $response = $this->getJson(route('post.replies.index', $reply->post))->json();

        $this->assertCount(1,
            array_filter($response['data'], function($item) use ($reply) {
                return $item['body'] == $reply->body;
            })
        );
    }

    /** @test */
    public function guest_may_not_publish_reply_to_a_post()
    {
        $post = create('App\Post');

        $this->postJson(route('post.replies.store', $post), [])
            ->assertStatus(401);
    }

    /** @test */
    public function guest_may_not_delete_reply_to_a_post()
    {
        $reply = create('App\Reply');

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(401);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);
    }

    // /** @test */
    // public function unconfimed_user_may_not_post_comments_to_a_client()
    // {
    //     $user = factory('App\User')->states('unconfirmed')->create();
    //     $this->signIn($user);

    //     $client = create('App\Client');

    //     $this->postJson(route('clients.comments.store', $client), [])
    //         ->assertStatus(401);

    //     $this->assertDatabaseMissing('comments', [
    //         'user_id' => $user->id
    //     ]);
    // }

    /** @test */
    public function authenticated_user_may_publish_a_reply_to_a_post()
    {
        $this->signIn();
        $post = create('App\Post');
        $body = 'Some body';

        $response = $this->postJson(route('post.replies.store', $post), ['body' => $body])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($body, $response['body']);

        $this->assertDatabaseHas('replies', [
            'body' => $body,
        ]);
    }

    /** @test */
    public function authenticated_user_may_update_a_reply_to_a_post()
    {
        $this->signIn();
        $post = create('App\Post');
        $reply = create('App\Reply', ['post_id' => $post->id]);
        $updatedBody = 'New body';

        $response = $this->patchJson(route('post.replies.update', [$post, $reply]), ['body' => $updatedBody])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($updatedBody, $response['body']);

        $this->assertDatabaseHas('replies', [
            'body' => $updatedBody,
        ]);
    }

    /** @test */
    public function authenticated_user_may_delete_a_reply_to_a_post()
    {
        $this->signIn();
        $reply = create('App\Reply');

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body,
        ]);

        $this->deleteJson(route('post.replies.destroy', [$reply->post, $reply]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('replies', [
            'body' => $reply->body,
        ]);
    }

    /** @test */
    public function reply_requires_a_valid_body()
    {
        $this->signIn();
        $post = create('App\Post');

        $response = $this->postJson(route('post.replies.store', $post), ['body' => null])
            ->assertStatus(422)
            ->json();

        $this->assertTrue(isset($response['errors']['body']));
    }
}
