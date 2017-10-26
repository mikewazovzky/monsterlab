<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UsersDataController extends Controller
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

        return response(['message' => 'User role updated.'], 200);
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
            'email' => [ 'required', 'email', 'unique:users,email,' . $user->id, ],
            'country' => [ 'required', 'in:Russia,USA,undefined'],
        ]);

        $user->update($attributes);

        return response(['message' => 'User data updated.'], 200);
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

        return response(['message' => 'User password updated.'], 200);
    }
}
