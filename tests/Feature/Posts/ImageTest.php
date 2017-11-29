<?php

namespace Tests\Feature;

use App\Post;
use App\Image;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ImageTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function post_can_have_featured_image()
    {
        // Given we have a post
        $post = create('App\Post');
        $this->assertCount(0, $post->images);

        // When we create a featured image
        $post->addImage(
            Image::fromFile($file = UploadedFile::fake()->image('featured.jpg'))
        );

        // Then new Image is created
        $this->assertDatabaseHas('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $file->hashName(),
            'thumbnail' => 'thumbnails/' . $file->hashName(),
        ]);

        // .. and post images count is updated
        $this->assertCount(1, $post->fresh()->images);
    }

    /** @test */
    public function post_image_can_be_updated()
    {
        // Given we have a post with an image
        $post = create('App\Post');
        $post->addImage(
            Image::fromFile($fileOriginal = UploadedFile::fake()->image('featured_original.jpg'))
        );

        $this->assertDatabaseHas('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $fileOriginal->hashName(),
            'thumbnail' => 'thumbnails/' . $fileOriginal->hashName(),
        ]);

        // When post image is updated
        $post->updateImage(
            Image::fromFile($fileUpdated = UploadedFile::fake()->image('featured_updated.jpg'))
        );

        // Then new image is stored into database
        $this->assertDatabaseHas('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $fileUpdated->hashName(),
            'thumbnail' => 'thumbnails/' . $fileUpdated->hashName(),
        ]);
    }

    /** @test */
    public function user_can_create_post_with_an_image()
    {
        // Given we have an authorized user
        $this->signIn($user = create('App\User', ['role' => 'writer']));

        // When we create a post with an image
        $this->post(route('posts.store'), [
            'title' => $title = 'Some Title',
            'body' => $body = 'Some Body',
            'featured' => $file = UploadedFile::fake()->image('featured.jpg')
        ])->assertStatus(302);

        $post = Post::where('title', $title)->first();

        // Then new Image is created
        $this->assertDatabaseHas('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $file->hashName(),
            'thumbnail' => 'thumbnails/' . $file->hashName(),
        ]);
    }

    /** @test */
    public function user_can_updated_post_image()
    {
        // Given we have an authorized user
        $this->signIn($user = create('App\User', ['role' => 'writer']));

        // .. and a post with an image
        $post = create('App\Post', ['user_id' => $user->id]);
        $post->addImage(
            Image::fromFile($fileOriginal = UploadedFile::fake()->image('featured_original.jpg'))
        );

        // When user updates image
        $this->patch(route('posts.update', $post), [
            'featured' =>  $fileUpdated = UploadedFile::fake()->image('featured_updated.jpg'),
        ])->assertStatus(302);

        // Then old image is deleted from database
        $this->assertDatabaseMissing('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $fileOriginal->hashName(),
            'thumbnail' => 'thumbnails/' . $fileOriginal->hashName(),
        ]);

        // .. and new image is stored into database
        $this->assertDatabaseHas('images', [
            'post_id' => $post->id,
            'featured' => 'featured/' . $fileUpdated->hashName(),
            'thumbnail' => 'thumbnails/' . $fileUpdated->hashName(),
        ]);
    }
}
