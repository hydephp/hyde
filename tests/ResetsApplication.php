<?php

namespace Tests;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
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
        Hyde::copy(Hyde::vendorPath('resources/views/homepages/welcome.blade.php'), Hyde::path('_pages/index.blade.php'));
        Hyde::copy(Hyde::vendorPath('resources/views/pages/404.blade.php'), Hyde::path('_pages/404.blade.php'));
    }
}
