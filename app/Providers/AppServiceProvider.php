<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator; // ✅ ini perlu ditambahkan
use Anhskohbo\NoCaptcha\Rules\Captcha;

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
    public function boot(): void
    {
        // ✅ Tambahkan extend captcha di sini, bukan di method boot kedua
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            return app('captcha')->verifyResponse($value);
        });
    }
}
