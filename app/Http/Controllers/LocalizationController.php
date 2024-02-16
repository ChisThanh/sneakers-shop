<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function greeting($locale)
    {
        if (!in_array($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }
        $cookie = cookie('locale', $locale, 60 * 24 * 30);

        return redirect()->back()->withCookie($cookie);
    }
}
