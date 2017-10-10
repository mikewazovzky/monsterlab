<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authenticated_user_can_see_other_user_profile()
    {
        $this->signIn();
        $user = create('App\User');

        $this->get(route('profiles.show', $user))
            ->assertStatus(200)
            ->assertSee($user->name);
    }
}
