<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Mikewazovzky\Taggable\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HelpersTest extends TestCase
{
    use DatabaseMigrations;

    protected $tags;

    /**
     * DISABLED, tag->posts() relationship is NOT available
     */
    public function it_count_posts_per_tag()
    {
        $this->tags = $this->createTags();

        $this->createPosts(100);

        // Tag::macro('posts', function() {
        //     return $this->morphedByMany(Post::class, 'taggable');
        // });

        $phpCount = Tag::withCount('posts')->pluck('posts_count', 'name')['PHP'];

        $this->assertEquals($phpCount, tagCounts('PHP'));
    }

    protected function createPosts($number = 100)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->createPostWithTags();
        }
    }

    protected function createTags()
    {
        $names = ['PHP', 'Laravel', 'HTML', 'CSS', 'JavaScript', 'Vue'];
        $tags = [];

        foreach ($names as $name) {
            $tags[] = create(Tag::class, ['name' => $name]);
        }

        return $tags;
    }

    protected function createPostWithTags($attributes = [])
    {
        $post = create('App\Post', $attributes);

        $max = 3;
        $number = rand(1, $max);

        for ($i=0; $i<$number; $i++) {
            try {
                $post->tags()->attach($this->getRandomTag());
            } catch (\Exception $e) {}
        }

        return $post;
    }

    protected function getRandomTag()
    {
        $index = rand(0, 5);
        return $this->tags[$index];
    }
}
