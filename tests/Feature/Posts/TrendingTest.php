<?php

namespace Tests\Feature\Posts;

use App\Post;
use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TrendingTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Post::resetViewsCount();
    }

    /** @test */
    public function it_increases_a_view_count_every_time_a_post_is_read()
    {
        $post = create('App\Post');
        $this->assertEquals(0, $post->viewsCount);

        $this->get(route('posts.show', $post));

        $this->assertEquals(1, $post->viewsCount);
    }

    /** @test */
    public function it_delets_views_count_when_post_is_deleted()
    {
        $post = create('App\Post');
        $this->assertEquals(0, $post->viewsCount);

        $this->get(route('posts.show', $post));
        $this->assertEquals(1, $post->viewsCount);

        $post->delete();
        $this->assertEquals(0, $post->viewsCount);
    }

    /** @test */
    public function it_fetches_trending_post()
    {
        $post = create('App\Post');
        $this->assertCount(0, Post::trending());

        $this->get(route('posts.show', $post));

        tap($trending = Post::trending(), function ($trending) use ($post) {
            $this->assertCount(1, $trending);
            $this->assertEquals($post->title, $trending[0]->title);
        });
    }
}
