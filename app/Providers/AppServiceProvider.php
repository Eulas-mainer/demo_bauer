<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
    public function boot()
    {
        Validator::extend('phone_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $value);
        });
    }
}
