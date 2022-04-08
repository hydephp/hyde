<?php

namespace Tests\Setup;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

trait ResetsFileEnvironment
{
    public function resetFileEnvironment()
    {
        Artisan::call('test:publish-stubs --clean --force');
        File::deleteDirectory(Hyde::path('_site'));
        (new CreatesDefaultDirectories)->__invoke();
    }
}
