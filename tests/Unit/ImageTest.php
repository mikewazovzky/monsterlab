<?php

namespace Tests\Unit;

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
    public function image_files_are_uploaded_into_public_folder_when_new_image_is_created()
    {
        // When we create an image
        $image = Image::fromFile($file = UploadedFile::fake()->image('featured.jpg'));

        // Then image files are uploaded into public folder,
        Storage::disk('public')->assertExists('featured/' . $file->hashName());
        Storage::disk('public')->assertExists('thumbnails/' . $file->hashName());
    }

    /** @test */
    public function image_files_are_deleted_when_image_is_deleted()
    {
        // Given we have an image
        $image = Image::fromFile(
            $file = UploadedFile::fake()->image('featured.jpg')
        );

        Storage::disk('public')->assertExists('featured/' . $file->hashName());
        Storage::disk('public')->assertExists('thumbnails/' . $file->hashName());

        // When we delete an image
        $image->delete();

        // Then image files are deleted from public folder,
        Storage::disk('public')->assertMissing('featured/' . $file->hashName());
        Storage::disk('public')->assertMissing('thumbnails/' . $file->hashName());
    }
}
