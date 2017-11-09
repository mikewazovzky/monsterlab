<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_favorite_a_post()
    {
        $this->post(route('favorites.store', ['model' => 'someType', 'id' => 333]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_may_favorite_post()
    {
        $this->withoutExceptionHandling();

        // Given we have an autenticated user
        $this->signIn();
        // .. and a post
        $post = create('App\Post');

        // When we post to "favorites" endpoint
        $modelType = (new \ReflectionClass($post))->getShortName();
        $this->post(route('favorites.store', ['model' => $modelType, 'id' => $post->id]))->assertStatus(302);

        // Then it should be recorded in data base
        $this->assertDatabaseHas('favorites', [
            'favorited_type' => get_class($post),
            'favorited_id' => $post->id
        ]);
        // .. and it can fetch post favortes
        $this->assertCount(1, $post->favorites);
    }

    /** @test */
    public function authenticated_user_may_favorite_post_only_once()
    {
        // Given we have an autenticated user
        $this->signIn();
        // .. and a post
        $post = create('App\Post');

        // When  we  post to "favorites"  endpoint a few  times
        // unique constrain violation exception must be throwen
        try {
            $modelType = (new \ReflectionClass($post))->getShortName();
            $this->post(route('favorites.store', ['model' => $modelType, 'id' => $post->id]));
            $this->post(route('favorites.store', ['model' => $modelType, 'id' => $post->id]));
        } catch(\Exception $e) {
            $this->fail('Error! Can not insert same record twice.');
        }

        // Then it should be recorded in data base only once
        $this->assertCount(1, $post->favorites);
    }

    /** @test */
    public function guest_may_not_unfavorite_post()
    {
        $post = create('App\Post');
        $this->delete(route('favorites.destroy', ['model' => 'someType', 'id' => 333]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_may_unfavorite_post()
    {
        // Given we have a post favorited by the user
        $this->signIn();
        $post = create('App\Post');
        $post->favorite(auth()->user());
        $this->assertCount(1, $post->fresh()->favorites);

        // When we post to "unfavorite" endpoint
        $modelType = (new \ReflectionClass($post))->getShortName();
        $this->delete(route('favorites.destroy', ['model' => $modelType, 'id' => $post->id]))
            ->assertStatus(302);

        // Then it should be deleted from database
        $this->assertCount(0, $post->favorites);
    }
}
