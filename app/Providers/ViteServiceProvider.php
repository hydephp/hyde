<?php

namespace App\Providers;

use App\Services\ViteService;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ViteService::class);
    }
}
