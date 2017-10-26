<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_can_not_view_user_profiles()
    {
        $user = create('App\User');

        $this->get(route('profiles.show', $user))->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_see_user_profiles()
    {
        $this->signIn();

        $user = create('App\User');

        $this->get(route('profiles.show', $user))
            ->assertStatus(200)
            ->assertSee($user->name);
    }
}
