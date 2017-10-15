<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagOperationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_new_tag()
    {

        $tagName = 'TagName';
        $tag = make('App\Tag', ['name' => $tagName ]);

        $this->post('/tags', $tag->toArray())
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tags', ['name' => $tagName]);
    }

    /** @test */
    public function authenticated_user_can_create_tag()
    {
        $this->signIn();

        $tagName = 'TagName';
        $tag = make('App\Tag', ['name' => $tagName ]);

        $this->post('/tags', $tag->toArray())->assertStatus(200);

        $this->assertDatabaseHas('tags', ['name' => $tagName]);
    }

    /** @test */
    public function user_can_get_list_of_tags()
    {
        $this->withoutExceptionHandling();
        $tag = create('App\Tag');

        $this->signIn();
        $response = $this->getJson(route('tags.index'))
            ->assertStatus(200)
            ->json();

        $this->assertEquals($tag->name, $response[0]['name']);
    }
}
