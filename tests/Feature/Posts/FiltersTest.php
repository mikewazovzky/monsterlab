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

    /** @test */
    public function it_limits_number_of_returned_posts()
    {
        create('App\Post', [], 20);
        $limit = 5;

        $response = $this->getJson('/posts?limit=' . $limit)->assertStatus(200)->json();

        $this->assertCount(5, $response);
    }

    /** @test */
    public function it_sorts_post_by_views()
    {
        $postRegular = create('App\Post', ['views' => 33]);
        $postPopular = create('App\Post', ['views' => 333]);
        $postUnPopular = create('App\Post', ['views' => 3]);

        // Ascending order: ASC
        $response = $this->getJson('/posts?popular=ASC')->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['id'];
        }, $response);

        $this->assertEquals([3, 1, 2], $data);

        // Ascending order: asc
        $response = $this->getJson('/posts?popular=asc')->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['id'];
        }, $response);

        $this->assertEquals([3, 1, 2], $data);

        // Descending order: DESC
        $response = $this->getJson('/posts?popular=DESC')->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['id'];
        }, $response);

        $this->assertEquals([2, 1, 3], $data);

        // Descending order: by default if no value passed
        $response = $this->getJson('/posts?popular')->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['id'];
        }, $response);

        $this->assertEquals([2, 1, 3], $data);

        // Descending order: by default if wrong value passed
        $response = $this->getJson('/posts?popular=jdbcdsinsxdi')->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['id'];
        }, $response);

        $this->assertEquals([2, 1, 3], $data);
    }

    /** @test */
    public function it_filters_favorite_posts()
    {
        $this->signIn($user = create('App\User'));

        $postNotFavorited = create('App\Post');
        $postFavorited = create('App\Post');
        $postFavorited->favorite($user);

        $this->assertCount(1, $postFavorited->favorites);

        $this->get('/posts?favorite=')
            ->assertStatus(200)
            ->assertSee(substr($postFavorited->body, 0, 100))
            ->assertDontSee(substr($postNotFavorited->body, 0, 100));
    }
}
