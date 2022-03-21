<?php

namespace App\Providers;

use Hyde\Core\Actions\CreatesDefaultDirectories;
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
