<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostOperationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_user_can_see_posts_on_index_page()
    {
        $post = create('App\Post');

        $this->get(route('posts.index'))
            ->assertStatus(200)
            ->assertSee($post->title);
    }

    /** @test */
    public function any_user_can_see_post_on_show_page()
    {
        $post = create('App\Post');

        $this->get(route('posts.show', $post))
            ->assertSee($post->title)
            ->assertSee($post->body);
    }

    /** @test */
    public function unauthorized_user_may_not_create_posts()
    {
        // Guest may not create a post
        $post = create('App\Post');
        $this->get(route('posts.create'))->assertRedirect(route('login'));
        $this->post(route('posts.store'), [])->assertRedirect(route('login'));
        // Reader may not create a post
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);
        $this->get(route('posts.create'))->assertStatus(403);
        $this->post(route('posts.store'), [])->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_create_posts()
    {
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = make('App\Post');

        $response = $this->post(route('posts.store'), $post->toArray())->assertStatus(302);

        $this->get($response->headers->get('Location'))
            ->assertSee($post->title)
            ->assertSee($post->body);

        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_update_posts()
    {
        $post = create('App\Post');
        // Guest may not modify a post
        $this->get(route('posts.edit', $post))->assertRedirect(route('login'));
        $this->patch(route('posts.update', $post), [])->assertRedirect(route('login'));
        // Reader may not modify a post
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);
        $this->get(route('posts.edit', $post))->assertStatus(403);
        $this->patch(route('posts.update', $post), [])->assertStatus(403);
        // Writer may not modify other user's post
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $this->get(route('posts.edit', $post))->assertStatus(403);
        $this->patch(route('posts.update', $post), [])->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_posts()
    {
        // Writer can update own post
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $orignalTitle = 'Original post title';
        $post = create('App\Post', ['title' => $orignalTitle, 'user_id' => $user->id]);

        $updatedTitle = 'Updated post title';
        $post->title = $updatedTitle;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $updatedTitle,
        ]);

        // Admin can update any post
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);

        $updatedAgain = 'Updated again';
        $post->title = $updatedAgain;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $updatedAgain,
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_delete_posts()
    {
        // Guest may not delete a post
        $post = create('App\Post');
        $this->delete(route('posts.update', $post))->assertRedirect(route('login'));
        // Reader may not delete a post
        $user = create('App\User', ['role' => 'reader']);
        $this->signIn($user);
        $this->delete(route('posts.update', $post))->assertStatus(403);
        // Writer may not delete other user's post
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $this->delete(route('posts.update', $post))->assertStatus(403);
    }


    /** @test */
    public function authorized_user_can_delete_posts()
    {
        // Writer can delete own post
        $user = create('App\User', ['role' => 'writer']);
        $this->signIn($user);
        $post = create('App\Post', ['user_id' => $user->id]);

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => $post->title,
        ]);

        // Admin can delete any post
        $post = create('App\Post');
        $user = create('App\User', ['role' => 'admin']);
        $this->signIn($user);

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => $post->title,
        ]);
    }

    /** @test */
    public function post_requires_a_valid_title()
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
    public function post_requires_a_valid_body()
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
