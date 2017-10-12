<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store(User $user)
    {
        $this->authorize('update', $user);

        request()->validate([
            'avatar' => ['required', 'image', 'max:400']
        ]);

        // $user = auth()->user();

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
