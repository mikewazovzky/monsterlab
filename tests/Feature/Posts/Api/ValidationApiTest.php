<?php

namespace Feature\Posts\Api;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Mikewazovzky\Taggable\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ValidationApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function api_request_should_provide_a_valid_title()
    {
        Passport::actingAs($user = create('App\User', ['role' => 'writer']));

        // Create post: title must be provided, may not be null
        $post = make('App\Post', ['title' => null]);
        $this->postJson('/api/v1.01/posts', $post->toArray())
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ]
                ]
            ]);

        // Update post: title may not be null if provided
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->postJson("/api/v1.01/posts/{$post->id}/update", ['title' => null])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ]
                ]
            ]);

        // Update post: title field is optional
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->postJson("/api/v1.01/posts/{$post->id}/update", ['body' => 'Some body'])
            ->assertStatus(200)
            ->assertJsonMissing([
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function api_request_should_provide_a_valid_body()
    {
        Passport::actingAs($user = create('App\User', ['role' => 'writer']));

        // Create post: body must be provided, may not be null
        $post = make('App\Post', ['body' => null]);
        $this->postJson('/api/v1.01/posts', $post->toArray())
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'body' => [
                        'The body field is required.'
                    ]
                ]
            ]);

        // Update post: body may not be null if provided
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->postJson("/api/v1.01/posts/{$post->id}/update", ['body' => null])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'body' => [
                        'The body field is required.'
                    ]
                ]
            ]);

        // Update post: body field is optional
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->postJson("/api/v1.01/posts/{$post->id}/update", ['title' => 'Some title'])
            ->assertStatus(200)
            ->assertJsonMissing([
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function api_request_adds_valid_tags_to_created_post()
    {
        // Given we have an authenticated user (writer)
        Passport::actingAs($user = create('App\User', ['role' => 'writer']));
        // .. and tagOne persisted into database
        $tagOne = create(Tag::class);
        // .. and tagTwo NOT persisted into database
        $tagTwo = make(Tag::class);

        // When user creates a new post
        $this->postJson('/api/v1.01/posts', [
            'user_id' => $user->id,
            'title' => 'Some title',
            'body' => 'Some body',
            'tagList' => [$tagOne->name, $tagTwo->name],
        ])->assertStatus(201);

        // Only existing (persisted into database) tags are added to the post
        $post = \App\Post::first();
        $this->assertTrue($post->tags->contains($tagOne));
        $this->assertFalse($post->tags->contains($tagTwo));
    }

    /** @test */
    public function api_request_syncs_valid_tags_to_updated_post()
    {
        $this->withoutExceptionHandling();

        // Given we have an authenticated user (writer)
        Passport::actingAs($user = create('App\User', ['role' => 'writer']));
        // .. and a post with a tag
        $post = create('App\Post', ['user_id' => $user->id]);
        $tagOriginal = create(Tag::class);
        $post->tags()->attach($tagOriginal);
        // .. and tag tagNewOne persisted into database
        $tagNewOne = create(Tag::class);
        // .. and tag tagNewTwo NOT persisted into database
        $tagNewTwo = make(Tag::class);

        // When user updates a new post
        $this->postJson("/api/v1.01/posts/{$post->id}/update", [
            'user_id' => $user->id,
            'title' => 'Some title',
            'body' => 'Some body',
            'tagList' => [$tagNewOne->name, $tagNewTwo->name],
        ])->assertStatus(200);

        // Post tags are synced with provided valid (persisted into database) tags
        $post = $post->fresh();
        // .. original tag is removed
        $this->assertFalse($post->tags->contains($tagOriginal));
        // .. existing new tag is attached
        $this->assertTrue($post->tags->contains($tagNewOne));
        // .. non existing new tag is not attached
        $this->assertFalse($post->tags->contains($tagNewTwo));
    }
}
