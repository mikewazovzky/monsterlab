<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function post_has_a_slug()
    {
        $post = create('App\Post');

        $this->assertEquals(str_slug($post->title), $post->fresh()->slug);
    }

    /** @test */
    public function post_slug_is_unique()
    {
        $title = "Some title";
        $postOne = create('App\Post', ['title' => $title]);
        $postTwo = create('App\Post', ['title' => $title]);

        $this->assertNotEquals($postOne->slug, $postTwo->slug);
    }
}
