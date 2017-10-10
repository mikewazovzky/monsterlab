<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $notifications = (auth()->id() == $user->id) ? $user->unreadNotifications : null;

        return view('profiles.show', [
            'profileUser' => $user,
            'notifications' => $notifications,
        ]);
    }
}
