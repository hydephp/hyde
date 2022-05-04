<?php

namespace Tests;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Hyde\Framework\Services\StarterFileService;
use Illuminate\Support\Facades\File;

trait ResetsApplication
{
    public function resetApplication()
    {
        File::deleteDirectory(Hyde::path('_pages'));
        File::deleteDirectory(Hyde::path('_posts'));
        // File::deleteDirectory(Hyde::path('_media'));
        File::deleteDirectory(Hyde::path('_docs'));
        File::deleteDirectory(Hyde::path('_site'));

        (new CreatesDefaultDirectories)->__invoke();
        StarterFileService::publish();
    }
}
