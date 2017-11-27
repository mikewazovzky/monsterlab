<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mikewazovzky\Taggable\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_new_tag()
    {

        $tagName = 'TagName';
        $tag = make(Tag::class, ['name' => $tagName ]);

        $this->postJson('/tags', $tag->toArray())
            ->assertStatus(401);

        $this->assertDatabaseMissing('tags', ['name' => $tagName]);
    }

    /** @test */
    public function authenticated_user_can_create_tag()
    {
        $this->signIn();

        $tagName = 'TagName';
        $tag = make(Tag::class, ['name' => $tagName ]);

        $this->postJson('/tags', $tag->toArray())->assertStatus(201);

        $this->assertDatabaseHas('tags', ['name' => $tagName]);
    }

    /** @test */
    public function user_can_get_list_of_tags()
    {
        $this->withoutExceptionHandling();
        $tag = create(Tag::class);

        $this->signIn();
        $response = $this->getJson(route('tags.index'))
            ->assertStatus(200)
            ->json();

        $this->assertEquals($tag->name, $response[0]['name']);
    }
}
