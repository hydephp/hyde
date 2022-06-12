<?php

namespace Hyde\Rocket\Providers;

use Hyde\Rocket\Models\Project;
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
        $this->app->singleton(\Desilva\Console\Contracts\Console::class, function() {
            return new \Desilva\Console\Console;
        });
    }

/**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Initialize and boot the project singleton.
        Project::get();
    }
}
