<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Validate the locale
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en'; // Default to English
        }

        // Store the locale in the session
        Session::put('locale', $locale);

        // Set the application locale
        App::setLocale($locale);

        // Create a cookie that lasts for 1 year
        $cookie = Cookie::make('locale', $locale, 525600); // 525600 minutes = 1 year

        // Get the previous URL to redirect back
        $previousUrl = url()->previous();

        // If previous URL is empty or is the language switch route, redirect to home
        if (empty($previousUrl) || str_contains($previousUrl, '/language/')) {
            return redirect()->route('home')->withCookie($cookie);
        }

        return redirect()->back()->withCookie($cookie);
    }
}
