<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostFiltersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_filters_posts_by_tag()
    {
        // $this->withExceptionHandling();

        $tagOne = create('App\Tag', ['name' => 'One']);
        $tagTwo = create('App\Tag', ['name' => 'Two']);
        $postOne = create('App\Post');
        $postTwo = create('App\Post');
        $postOne->tags()->attach($tagOne);
        $postTwo->tags()->attach($tagTwo);

        $this->get('/posts?tag=' . $tagOne->name)
            ->assertStatus(200)
            ->assertSee($postOne->title)
            ->assertDontSee($postTwo->title);
    }
}
