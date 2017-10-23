<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdjustmentsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authorized_user_can_see_adjustments()
    {
        $this->withoutExceptionHandling();

        $user = create('App\User');
        $this->signIn($user);
        $originalTitle = 'Original Title';
        $post = create('App\Post', ['user_id' => $user->id, 'title' => $originalTitle]);

        $updatedTitle = 'Updated Title';
        $post->update(['user_id' => $user->id, 'title' => $updatedTitle]);

        $this->get(route('adjustments.index', $post))
            ->assertStatus(200)
            ->assertSee($originalTitle)
            ->assertSee($updatedTitle);
    }
}
