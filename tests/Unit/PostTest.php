<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_a_slug()
    {
        $post = create('App\Post');

        $this->assertEquals(str_slug($post->title), $post->fresh()->slug);
    }
}
