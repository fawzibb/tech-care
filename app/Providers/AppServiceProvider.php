<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;


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
    Paginator::useBootstrapFive();
    App::useLangPath(base_path('resources/lang'));

    if (Session::has('locale')) {
        App::setLocale(Session::get('locale'));
    } else {
        App::setLocale(config('app.locale'));
    }
}
}
