<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ValidationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_requires_a_valid_title()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);

        // Create post: title must be provided, may not be null
        $post = make('App\Post', ['title' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('title');

        // Update post: title may not be null if provided
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->patch(route('posts.update', $post), ['title' => null])
            ->assertStatus(302)
            ->assertSessionHasErrors('title');

        // Update post: title field is optional
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->patch(route('posts.update', $post), ['body' => 'Some body'])
            ->assertStatus(302)
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_requires_a_valid_body()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);

        // Create post: body must be provided, may not be null
        $post = make('App\Post', ['body' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('body');

        // Update post: body may not be null if provided
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->patch(route('posts.update', $post), ['body' => null])
            ->assertStatus(302)
            ->assertSessionHasErrors('body');

        // Update post: body field is optional
        $post = create('App\Post', ['user_id' => $user->id]);
        $this->patch(route('posts.update', $post), ['title' => 'Some title'])
            ->assertStatus(302)
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_adds_valid_tags_to_created_post()
    {
        // Given we have an authenticated user (writer)
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        // .. and tagOne persisted into database
        $tagOne = create('App\Tag');
        // .. and tagTwo NOT persisted into database
        $tagTwo = make('App\Tag');

        // When user creates a new post
        $this->post(route('posts.store'), [
            'user_id' => $user->id,
            'title' => 'Some title',
            'body' => 'Some body',
            'tagList' => [$tagOne->name, $tagTwo->name],
        ])->assertStatus(302);

        // Only existing (persisted into database) tags are added to the post
        $post = \App\Post::first();
        $this->assertTrue($post->tags->contains($tagOne));
        $this->assertFalse($post->tags->contains($tagTwo));
    }

    /** @test */
    public function it_syncs_valid_tags_to_updated_post()
    {
        $this->withoutExceptionHandling();

        // Given we have an authenticated user (writer)
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        // .. and a post with a tag
        $post = create('App\Post', ['user_id' => $user->id]);
        $tagOriginal = create('App\Tag');
        $post->tags()->attach($tagOriginal);
        // .. and tag tagNewOne persisted into database
        $tagNewOne = create('App\Tag');
        // .. and tag tagNewTwo NOT persisted into database
        $tagNewTwo = make('App\Tag');

        // When user updates the post
        $this->patch(route('posts.update', $post), [
            'user_id' => $user->id,
            'title' => 'Some title',
            'body' => 'Some body',
            'tagList' => [$tagNewOne->name, $tagNewTwo->name],
        ])->assertStatus(302);

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
