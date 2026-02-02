<?php

namespace App\Providers;

use App\Models\Customer;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Customer::class => CustomerPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Set application locale based on session or cookie
        $this->setApplicationLocale();
    }

    /**
     * Set the application locale based on session or cookie.
     */
    private function setApplicationLocale(): void
    {
        // Priority: Session > Cookie > Default (en)
        $locale = Session::get('locale');

        if (!$locale) {
            // Try to get from request cookie
            $locale = request()->cookie('locale');
        }

        // Validate and set locale
        if ($locale && in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Default to English
            App::setLocale('en');
            Session::put('locale', 'en');
        }
    }
}
