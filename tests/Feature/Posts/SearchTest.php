<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mysql_engine_finds_posts_by_title_content()
    {
        // mySQL
        $post = create('App\Post', ['title' => 'Do not search me']);
        $postFindMe = create('App\Post', ['title' => 'Title find me']);
        $query = 'find me';

        $this->get(route('posts.search', ['search-query' => 'find me', 'search-type' => 'mySQL']))
            ->assertRedirect(route('posts.index', ['search' => $query]));

        $response = $this->getJson(route('posts.index', ['search' => $query]))
            ->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['title'];
        }, $response);

        $this->assertTrue(in_array($postFindMe->title, $data));
        $this->assertFalse(in_array($post->title, $data));
    }

    /** @test */
    public function mysql_engine_finds_posts_by_body_content()
    {
        // mySQL
        $post = create('App\Post', ['body' => 'Do not search me']);
        $postFindMe = create('App\Post', ['body' => 'Title find me']);
        $query = 'find me';

        $this->get(route('posts.search', ['search-query' => 'find me', 'search-type' => 'mySQL']))
            ->assertRedirect(route('posts.index', ['search' => $query]));

        $response = $this->getJson(route('posts.index', ['search' => $query]))
            ->assertStatus(200)->json();

        $data = array_map(function ($item) {
            return $item['body'];
        }, $response);

        $this->assertTrue(in_array($postFindMe->body, $data));
        $this->assertFalse(in_array($post->body, $data));
    }

    // Testing algolia search - need to access data loaded by JavaScript/Vue
}
