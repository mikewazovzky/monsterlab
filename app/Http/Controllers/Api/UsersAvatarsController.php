<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UsersAvatarsController extends Controller
{
    /**
     * Store users avatar.
     *
     * @param App\User $user
     * @return Illuminate\Http\Response
     */
    public function store(User $user)
    {
        $this->authorize('update', $user);

        request()->validate([
            'avatar' => ['required', 'image', 'max:400']
        ]);

        $this->deleteAvatarFile($user);

        $user->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }

    /**
     * Delete user avatar file
     *
     * @return bool
     */
    protected function deleteAvatarFile($user)
    {
        $avatarPath = array_get($user->getAttributes(), 'avatar_path');

        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            return Storage::disk('public')->delete($avatarPath);
        }

        return false;
    }
}
