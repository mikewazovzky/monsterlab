<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersUpdateController extends Controller
{
    /**
     * Updates user role.
     *
     * @param App\User $user
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response response
     */
    public function role(User $user, Request $request)
    {
        $this->authorize('admin', $user);

        $attributes = $request->validate(['role' => ['required', 'in:admin,reader,writer'],]);

        $user->update($attributes);

        flash('User role has been updated.');

        return back();
    }

    /**
     * Updates user name and email.
     *
     * @param App\User $user
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response response
     */
    public function data(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $attributes = $request->validate([
            'name' => [ 'required', 'unique:users,name,' . $user->id, ],
            'email' => [ 'required', 'email', 'unique:users,email,' . $user->id, ]
        ]);

        $user->update($attributes);

        flash('User data has been updated.');

        return back();
    }

    /**
     * Updates user password.
     *
     * @param App\User $user
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response response
     */
    public function password(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $attributes = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        flash('User password has been updated.');

        return back();
    }
}