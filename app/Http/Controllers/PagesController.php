<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PagesController extends Controller
{
    public function index($locale = null)
    {
        if ($locale != 'ru') {
            $locale = 'en';
        }

        App::setLocale($locale);

        return view('pages.main', compact('locale'));
    }
}
