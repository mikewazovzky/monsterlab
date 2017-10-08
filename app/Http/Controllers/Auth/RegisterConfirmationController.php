<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function confirm(Request $request)
    {
        $user = User::where('confirmation_token', $request->token)->first();

        if (! $user) {
            flash()->danger('Unknown token.');
            return redirect(route('main'));
        }

        $user->confirm();

        flash()->success('Your account is now confirmed!');
        return redirect(route('posts.index'));
    }
}
