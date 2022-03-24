<?php

namespace Tests\Setup;

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Hyde\Framework\Actions\CreatesDefaultDirectories;

trait ResetsFileEnvironment
{
    public function resetFileEnvironment()
    {
        Artisan::call('stubs:publish --clean --force');
        File::deleteDirectory(Hyde::path('_site'));
        (new CreatesDefaultDirectories)->__invoke();
    }
}
