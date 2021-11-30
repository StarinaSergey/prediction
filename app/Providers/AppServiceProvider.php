<?php

namespace App\Providers;

use App\Http\Contracts\Language\GetLanguageService;
use App\Http\Services\Language\LanguageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GetLanguageService::class, LanguageService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
