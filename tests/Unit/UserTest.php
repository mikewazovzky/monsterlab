<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_a_slug()
    {
        $this->withoutExceptionHandling();

        $user = create('App\User');

        $this->assertEquals(str_slug($user->name), $user->fresh()->slug);
    }
}
