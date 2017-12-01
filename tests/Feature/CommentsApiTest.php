<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentsApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_user_can_get_a_list_of_replies_for_the_post()
    {
        $this->withoutExceptionHandling();

        $comment = create('App\Comment');

        $response = $this->getJson(route('post.comments.index', $comment->post))->json();

        $this->assertCount(
            1,
            array_filter($response['data'], function ($item) use ($comment) {
                return $item['body'] == $comment->body;
            })
        );
    }

    /** @test */
    public function unauthorized_user_may_not_create_a_reply_to_a_post()
    {
        // Guest may not post a comment
        $post = create('App\Post');

        $this->postJson(route('post.comments.store', $post), [])
            ->assertStatus(401);

        // Reader may not post a comment
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->postJson(route('post.comments.store', $post), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_may_create_a_reply_to_a_post()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = create('App\Post');
        $body = 'Some body';

        $response = $this->postJson(route('post.comments.store', $post), ['body' => $body])
            ->assertStatus(201)
            ->json();

        $this->assertEquals($body, $response['body']);

        $this->assertDatabaseHas('comments', [
            'body' => $body,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_update_a_reply_to_a_post()
    {
        $comment = create('App\Comment');

        // Guest may not update a comment
        $this->patchJson(route('post.comments.update', [$comment->post, $comment]), [])
            ->assertStatus(401);

        // Reader may not update a comment
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->patchJson(route('post.comments.update', [$comment->post, $comment]), [])
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_may_update_a_reply_to_a_post()
    {
        // Writer can update own comment
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $comment = create('App\Comment', ['user_id' => $user->id]);
        $updatedBody = 'Updated';

        $response = $this->patchJson(route('post.comments.update', [$comment->post, $comment]), ['body' => $updatedBody])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($updatedBody, $response['body']);

        $this->assertDatabaseHas('comments', [
            'body' => $updatedBody,
        ]);

        // Admin can update any comment
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);
        $updatedBody = 'Updated again';

        $response = $this->patchJson(route('post.comments.update', [$comment->post, $comment]), ['body' => $updatedBody])
            ->assertStatus(200)
            ->json();

        $this->assertEquals($updatedBody, $response['body']);

        $this->assertDatabaseHas('comments', [
            'body' => $updatedBody,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_delete_reply_to_a_post()
    {
        // Guest may not delete a comment
        $comment = create('App\Comment');

        $this->deleteJson(route('post.comments.destroy', [$comment->post, $comment]))
            ->assertStatus(401);

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
        ]);

        // Reader may not delete a comment
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);

        $this->deleteJson(route('post.comments.destroy', [$comment->post, $comment]))
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
        ]);

        // Writer may not delete other user's comment
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);

        $this->deleteJson(route('post.comments.destroy', [$comment->post, $comment]))
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
        ]);
    }

    /** @test */
    public function authorized_user_may_delete_a_reply_to_a_post()
    {
        // Writer may delete own comment
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $comment = create('App\Comment', ['user_id' => $user->id]);

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
        ]);

        $this->deleteJson(route('post.comments.destroy', [$comment->post, $comment]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('comments', [
            'body' => $comment->body,
        ]);

        // Admin may delete any comment
        $comment = create('App\Comment');
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);

        $this->deleteJson(route('post.comments.destroy', [$comment->post, $comment]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('comments', [
            'body' => $comment->body,
        ]);
    }

    /** @test */
    public function reply_requires_a_valid_body()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = create('App\Post');

        // Create a comment
        $response = $this->postJson(route('post.comments.store', $post), ['body' => null])
            ->assertStatus(422)
            ->json();

        $this->assertTrue(isset($response['errors']['body']));

        // Update a comment
        $comment = create('App\Comment', ['user_id' => $user->id]);
        $comment->body = null;

        $response = $this->patchJson(route('post.comments.update', [$comment->post, $comment]), $comment->toArray())
            ->assertStatus(422)
            ->json();

        $this->assertTrue(isset($response['errors']['body']));
    }
}
