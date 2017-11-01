<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_user_can_get_array_of_posts()
    {
        Passport::actingAs(create('App\User'));

        $post = create('App\Post');

        $response = $this->getJson('/api/v1.01/posts')
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $post->title
            ]);
    }

    /** @test */
    public function any_user_can_get_specific_post()
    {
        Passport::actingAs(create('App\User'));

        $post = create('App\Post');

        $this->getJson('/api/v1.01/posts')
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $post->title
            ]);
    }

    /** @test */
    public function guest_may_not_create_post()
    {
        $post = create('App\Post');
        // Guest may not create a post
        $this->postJson('/api/v1.01/posts', $post->toArray())->assertStatus(401);
    }

    /** @test */
    public function reader_may_not_create_post()
    {
        $post = make('App\Post');
        Passport::actingAs(create('App\User', ['role' => 'reader']));
        $this->postJson('/api/v1.01/posts', $post->toArray())->assertStatus(403);
    }

    /** @test */
    public function writer_can_create_post()
    {
        $this->withoutExceptionHandling();

        $post = make('App\Post');
        Passport::actingAs(create('App\User', ['role' => 'writer']));

        $this->postJson('/api/v1.01/posts', $post->toArray())
            ->assertStatus(201)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    /** @test */
    public function admin_can_create_post()
    {
        $post = make('App\Post');
        Passport::actingAs(create('App\User', ['role' => 'admin']));

        $this->postJson('/api/v1.01/posts', $post->toArray())
            ->assertStatus(201)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('posts', [
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    /** @test */
    public function guest_may_not_update_post()
    {
        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/update", [])->assertStatus(401);
    }

    /** @test */
    public function reader_may_not_update_post()
    {
        Passport::actingAs(create('App\User', ['role' => 'reader']));

        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/update", [])->assertStatus(403);
    }

    /** @test */
    public function writer_may_not_update_other_user_post()
    {
        Passport::actingAs(create('App\User', ['role' => 'writer']));

        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/update", [])->assertStatus(403);
    }

    /** @test */
    public function writer_can_update_his_own_post()
    {
        $user = create('App\User', ['role' => 'writer']);
        Passport::actingAs($user);
        $post = create('App\Post', ['user_id' => $user->id]);
        $updatedTitle = 'Updated Title';
        $post->title = $updatedTitle;

        $this->postJson("/api/v1.01/posts/{$post->id}/update", [
            'title' => $updatedTitle,
            'body' => 'Lorem ipsum dolorem sit',
        ])->assertStatus(200)
        ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('posts', [
            'title' => $updatedTitle
        ]);
    }

    /** @test */
    public function admin_can_update_any_post()
    {
        $user = create('App\User', ['role' => 'admin']);
        Passport::actingAs($user);

        $post = create('App\Post');
        $updatedTitle = 'Updated Title';
        $post->title = $updatedTitle;

        $this->postJson("/api/v1.01/posts/{$post->id}/update", [
            'title' => $updatedTitle,
            'body' => 'Lorem ipsum dolorem sit',
        ])->assertStatus(200)
        ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('posts', [
            'title' => $updatedTitle
        ]);
    }

    /** @test */
    public function guest_may_not_delete_post()
    {
        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/destroy")->assertStatus(401);
    }

    /** @test */
    public function reader_may_not_delete_post()
    {
        Passport::actingAs(create('App\User', ['role' => 'reader']));

        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/destroy")->assertStatus(403);
    }

    /** @test */
    public function writer_may_not_delete_other_user_post()
    {
        Passport::actingAs(create('App\User', ['role' => 'writer']));

        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/destroy")->assertStatus(403);
    }

    /** @test */
    public function writer_can_delete_his_own_post()
    {
        $user = create('App\User', ['role' => 'writer']);
        Passport::actingAs($user);
        $post = create('App\Post', ['user_id' => $user->id]);

        $this->postJson("/api/v1.01/posts/{$post->id}/destroy")->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);
    }

    /** @test */
    public function admin_can_delete_any_post()
    {
        Passport::actingAs(create('App\User', ['role' => 'admin']));
        $post = create('App\Post');

        $this->postJson("/api/v1.01/posts/{$post->id}/destroy")->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'title' => $post->title
        ]);
    }
}
