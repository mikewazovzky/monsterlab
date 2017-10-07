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
    public function guest_may_not_create_or_modify_posts()
    {
        $post = create('App\Post');

        $this->get(route('posts.create'))->assertRedirect(route('login'));
        $this->post(route('posts.store'), [])->assertRedirect(route('login'));
        $this->get(route('posts.edit', $post))->assertRedirect(route('login'));
        $this->patch(route('posts.update', $post), [])->assertRedirect(route('login'));
        $this->delete(route('posts.update', $post))->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_create_post()
    {
        $this->signIn();
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
    public function authenticated_user_can_update_post()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $orignalTitle = 'Original post title';
        $post = create('App\Post', ['title' => $orignalTitle]);

        $newTitle = 'Updated post title';
        $post->title = $newTitle;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $newTitle,
        ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => $orignalTitle,
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_post()
    {
        $this->signIn();
        $post = create('App\Post');

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
        $this->signIn();

        $post = make('App\Post', ['title' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('title');

        $post = create('App\Post');
        $post->title = null;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function post_requires_a_valid_body()
    {
        $this->signIn();

        $post = make('App\Post', ['body' => null]);
        $this->post(route('posts.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('body');

        $post = create('App\Post');
        $post->body = null;
        $this->patch(route('posts.update', $post), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors('body');
    }
}
