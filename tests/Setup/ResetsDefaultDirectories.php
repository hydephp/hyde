<?php

namespace Tests\Setup;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;

trait ResetsDefaultDirectories
{
    /**
     * @deprecated Please delete only the files that actually need to be deleted in the test setup
     */
    public function resetDefaultDirectories()
    {
        foreach (CreatesDefaultDirectories::getRequiredDirectories() as $directory) {
            File::deleteDirectory(Hyde::path($directory));
        }
        (new CreatesDefaultDirectories)->__invoke();
    }
}
