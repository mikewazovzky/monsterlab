<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_see_user_profile()
    {
        $this->withoutExceptionHandling();

        $user = create('App\User');

        $this->get('/profiles/' . $user->id)->assertStatus(200)->assertSee($user->name);
    }
}
