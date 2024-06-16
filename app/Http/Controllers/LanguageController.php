<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'es'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return Redirect::back();
    }
}
