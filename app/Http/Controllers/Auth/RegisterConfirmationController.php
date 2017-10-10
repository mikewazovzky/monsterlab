<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Mail\ConfirmEmailRequest;
use App\Http\Controllers\Controller;
use App\Notifications\UserConfirmed;
use Illuminate\Support\Facades\Mail;

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

        if ($admin = User::admin()) {
            $admin->notify(new UserConfirmed($user));
        }

        flash()->success('Your account is now confirmed!');

        return redirect(route('login'));
    }

    public function send()
    {
        $user = auth()->user();

        if ($user->isReader()) {
            Mail::to($user)->send(new ConfirmEmailRequest($user));
            flash('User email confirmation request has neen send!');
        }

        return back();
    }
}
