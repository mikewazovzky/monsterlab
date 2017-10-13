<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PagesController extends Controller
{
    public function index($locale = null)
    {
        $locale = ($locale == 'ru') ? 'ru' : 'en';

        App::setLocale($locale);

        $locale = ($locale == 'ru') ? 'en' : 'ru';

        return view('pages.main', ['locale' => $locale]);
    }
}
