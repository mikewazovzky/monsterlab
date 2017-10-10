<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        return $user->unreadNotifications;
    }

    public function markAsRead(User $user, DatabaseNotification $notification, Request $request)
    {
        $notification->markAsRead();

        if ($request->wantsJson()) {
            return response(['deleted'], 200);
        }

        return back();
    }

    public function markAllAsRead(User $user, Request $request)
    {
        $user->notifications->markAsRead();

        if ($request->wantsJson()) {
            return response(['deleted'], 200);
        }

        return back();
    }
}
