<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AvatarUpdateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function only_members_can_update_avatars()
    {
        $this->json('POST', route('avatars.store', 1), [])
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->signIn();
        $this->json('POST', route('avatars.store', auth()->user()), ['avatar' => 'not-an-image'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_may_update_an_avatar()
    {
        $this->signIn();

        // fake Storage and UploadedFile
        Storage::fake('public');

        $this->json('POST', route('avatars.store', auth()->user()), [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ])->assertStatus(204);

        $this->assertEquals(asset('storage/avatars/' . $file->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

    /** @test */
    public function a_user_has_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('images/avatars/default.png'), $user->avatar_path);

        $user->update(['avatar_path' => 'avatars/me.jpeg']);

        $this->assertEquals(asset('storage/avatars/me.jpeg'), $user->avatar_path);
    }

    /** @test */
    public function an_old_avatar_file_is_deleted_when_avatar_is_updated()
    {
        $this->withoutExceptionHandling();
        Storage::fake('public');

        // Given we have a user with an avatar
        $this->signIn($user = create('App\User'));

        $this->json('POST', route('avatars.store', auth()->user()), [
            'avatar' => $file = UploadedFile::fake()->image('avatarOriginal.jpg')
        ]);

        Storage::disk('public')->assertExists($oldName = 'avatars/' . $file->hashName());

        // When user updates an avtar
        $this->json('POST', route('avatars.store', auth()->user()), [
            'avatar' => $file = UploadedFile::fake()->image('avatarUpdated.jpg')
        ]);

        // Then old avatar file must be deleted
        Storage::disk('public')->assertMissing($oldName);
    }
}
