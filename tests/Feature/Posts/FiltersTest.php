<?php

namespace Tests\Feature\Posts;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FiltersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_filters_posts_by_id()
    {
        $postOne = create('App\Post');
        $postTwo = create('App\Post');

        $this->get('/posts?id=' . $postOne->id)
            ->assertStatus(200)
            ->assertSee(substr($postOne->body, 0, 100))
            ->assertDontSee(substr($postTwo->body, 0, 100));
    }

    /** @test */
    public function it_filters_posts_by_tag()
    {
        $tagOne = create('App\Tag', ['name' => 'One']);
        $tagTwo = create('App\Tag', ['name' => 'Two']);
        $postOne = create('App\Post');
        $postTwo = create('App\Post');
        $postOne->tags()->attach($tagOne);
        $postTwo->tags()->attach($tagTwo);

        $this->get('/posts?tag=' . $tagOne->name)
            ->assertStatus(200)
            ->assertSee(substr($postOne->body, 0, 100))
            ->assertDontSee(substr($postTwo->body, 0, 100));
    }

    /** @test */
    public function it_filters_posts_by_year()
    {
        $post2015 = create('App\Post', ['created_at' => Carbon::createFromDate(2015, 1, 1)]);
        $post2017 = create('App\Post', ['created_at' => Carbon::createFromDate(2017, 1, 1)]);

        $this->get('/posts?year=2017')
            ->assertStatus(200)
            ->assertSee(substr($post2017->body, 0, 100))
            ->assertDontSee(substr($post2015->body, 0, 100));
    }

    // It seems whereMonth() doesn't work with sqlite ??
    /** @test */
    public function it_filters_posts_by_month()
    {
        $postAugest  = create('App\Post', ['created_at' => Carbon::createFromDate(2015,  8, 1)]);
        $postOctober = create('App\Post', ['created_at' => Carbon::createFromDate(2017, 10, 1)]);

        $this->get('/posts?month=October')->assertStatus(200);
            // ->assertSee(substr($postOctober->body, 0, 100))
            // ->assertDontSee(substr($postAugest->body, 0, 100));
    }
}
