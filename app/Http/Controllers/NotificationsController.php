<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    /**
     * Create a new NotificationsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return a listing of the notifications for the user.
     *
     * @param App\User $user
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index(User $user)
    {
        $this->authorize('update', $user);

        return $user->unreadNotifications;
    }

    /**
     * Mark user's notification as read.
     *
     * @param App\User $user
     * @param Illuminate\Notifications\DatabaseNotification $notification
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function markAsRead(User $user, DatabaseNotification $notification, Request $request)
    {
        $this->authorize('update', $user);

        $notification->markAsRead();

        return response(['deleted'], 200);
    }

    /**
     * Mark all user's notifications as read.
     *
     * @param App\User $user
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function markAllAsRead(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $user->notifications->markAsRead();

        return response(['deleted'], 200);
    }
}
