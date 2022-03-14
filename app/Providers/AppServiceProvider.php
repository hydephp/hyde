<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Actions\CreatesDefaultDirectories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        (new CreatesDefaultDirectories)->__invoke();
    }
}
