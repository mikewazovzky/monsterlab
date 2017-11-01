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

        // Create a post
        $post = make('App\Post', ['title' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('title');

        // Update a post
        $post = create('App\Post', ['user_id' => $user->id]);
        $post->title = null;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_requires_a_valid_body()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);

        // Create a post
        $post = make('App\Post', ['body' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('body');

        // Update a post
        $post = create('App\Post', ['user_id' => $user->id]);
        $post->body = null;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('body');
    }
}
