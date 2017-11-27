<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Mikewazovzky\Taggable\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_attach_tags_to_the_post()
    {
        $post = create('App\Post');
        $tag = create(Tag::class);

        $this->assertCount(0, $post->tags);

        $post->tags()->attach($tag);
        $this->assertCount(1, $post->fresh()->tags);
    }

    /** @test */
    public function it_can_detach_tags_from_the_post()
    {
        $post = create('App\Post');
        $tag = create(Tag::class);
        $post->tags()->attach($tag);

        $this->assertCount(1, $post->tags);
        $post->tags()->detach($tag);

        $this->assertCount(0, $post->fresh()->tags);
    }

    /** @test */
    public function it_can_sync_tags()
    {
        $post = create('App\Post');
        $tagOne = create(Tag::class);
        $tagTwo = create(Tag::class);
        $tagThree = create(Tag::class);

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
        $tagOne = create(Tag::class);
        $tagTwo = create(Tag::class);

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name])
        );

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name, 'wrongName'])
        );
    }

    /** @test */
    public function it_detachs_tags_when_model_is_deleted()
    {
        $post = create('App\Post');
        $tag = create(Tag::class);
        $post->tags()->attach($tag);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $post->id,
        ]);

        $post->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $post->id,
        ]);

    }
}
