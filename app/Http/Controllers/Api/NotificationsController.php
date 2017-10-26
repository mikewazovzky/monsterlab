<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
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
     * @return Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('update', $user);

        return response($user->unreadNotifications, 200);
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
