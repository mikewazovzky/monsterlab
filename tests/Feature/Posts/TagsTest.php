<?php

namespace Tests\Feature;

use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_attach_tags_to_the_post()
    {
        $post = create('App\Post');
        $tag = create('App\Tag');

        $this->assertCount(0, $post->tags);

        $post->tags()->attach($tag);
        $this->assertCount(1, $post->fresh()->tags);
    }

    /** @test */
    public function it_can_detach_tags_from_the_post()
    {
        $post = create('App\Post');
        $tag = create('App\Tag');
        $post->tags()->attach($tag);

        $this->assertCount(1, $post->tags);
        $post->tags()->detach($tag);

        $this->assertCount(0, $post->fresh()->tags);
    }

    /** @test */
    public function it_can_sync_tags()
    {
        $post = create('App\Post');
        $tagOne = create('App\Tag');
        $tagTwo = create('App\Tag');
        $tagThree = create('App\Tag');

        $post->tags()->attach($tagOne);
        $post->tags()->attach($tagTwo);

        $this->assertTrue($post->tags->contains($tagOne));
        $this->assertTrue($post->tags->contains($tagTwo));
        $this->assertFalse($post->tags->contains($tagThree));

        $post->tags()->sync([$tagTwo->id, $tagThree->id]);
        $post = $post->fresh();

        $this->assertFalse($post->tags->contains($tagOne));
        $this->assertTrue($post->tags->contains($tagTwo));
        $this->assertTrue($post->tags->contains($tagThree));
    }

    /** @test */
    public function it_validates_tags()
    {
        $tagOne = create('App\Tag');
        $tagTwo = create('App\Tag');

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name])
        );

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name, 'wrongName'])
        );
    }
}
