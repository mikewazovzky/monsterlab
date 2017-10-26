<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Mail\WebsiteFeedback;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function feedback(Request $request)
    {
        $feedbackData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subj' => '',
            'body' => 'required',
        ]);

        if ($admin = User::admin()) {
            Mail::to($admin)->send(new WebsiteFeedback($feedbackData));
        }

        return redirect(route('contacts'));
    }
}
