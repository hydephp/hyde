<?php

namespace Hyde\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

require_once __DIR__.'/helpers.php';

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../app/bootstrap.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
