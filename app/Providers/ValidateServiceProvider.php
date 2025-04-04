<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('min_words', function ($attribute, $value, $parameters, $validator) {
            $words = str_word_count($value);
            return $words >= $parameters[0];
        });
    }
}
