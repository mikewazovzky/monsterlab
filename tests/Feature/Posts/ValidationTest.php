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
}
