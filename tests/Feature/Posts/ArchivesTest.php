<?php

namespace Tests\Feature\Posts;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArchivesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_fetchs_archives()
    {
        $post = create('App\Post');

        $archives = Post::archives();

        $this->assertEquals($post->created_at->format('F'), $archives[0]['month']);
        $this->assertEquals($post->created_at->year, $archives[0]['year']);
        $this->assertCount(1, $archives);
    }
}
