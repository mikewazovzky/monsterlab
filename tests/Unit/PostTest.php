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

    /** @test */
    public function post_tracks_a_views_count()
    {
        $post = create('App\Post');

        $this->assertEquals(0, $post->fresh()->views);

        $post->increment('views');

        $this->assertEquals(1, $post->fresh()->views);

        $this->get(route('posts.show', $post))->assertStatus(200);

        $this->assertEquals(2, $post->fresh()->views);
    }

    /** @test */
    public function it_strips_title_html_tags()
    {
        $post = create('App\Post', [
            'title' => 'Some <strong>text</strong> with tags.'
        ]);

        $this->assertEquals('Some text with tags.', $post->title);
    }

    /** @test */
    public function it_cleans_body_from_dangerous_html_content()
    {
        $post = create('App\Post', [
            'body' => 'Some <strong>text</strong> with <script>dangerous</script> html content.'
        ]);

        $this->assertEquals('Some <strong>text</strong> with  html content.', $post->body);
    }

    /** @test */
    public function it_can_highlight_title()
    {
        $post = create('App\Post', [
            'title' => 'Some title text that matches search query.'
        ]);

        $query = 'search';

        $this->assertEquals(
            'Some title text that matches <span class="highlight">search</span> query.',
            $post->getTitle($query)
        );
    }

    /** @test */
    public function it_can_highlight_body_excert()
    {
        $post = create('App\Post', [
            'body' => 'Some body text that matches search query.'
        ]);

        $query = 'search';

        $this->assertEquals(
            'Some body text that matches <span class="highlight">search</span> query. ...',
            $post->getExcerpt($query)
        );
    }
}
