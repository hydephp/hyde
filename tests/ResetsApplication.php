<?php

namespace Hyde\Testing;

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;

/**
 * @internal
 */
trait ResetsApplication
{
    public function resetApplication()
    {
        copy(Hyde::path('_media/app.css'), Hyde::path('storage/framework/cache/app.css'));

        $this->resetMedia();
        $this->resetPages();
        $this->resetPosts();
        $this->resetDocs();
        $this->resetSite();
    }

    public function resetMedia()
    {
        File::cleanDirectory(Hyde::path('_media'));
        copy(Hyde::path('storage/framework/cache/app.css'), Hyde::path('_media/app.css'));
    }

    public function resetPages()
    {
        File::cleanDirectory(Hyde::path('_pages'));
        Hyde::copy(Hyde::vendorPath('resources/views/homepages/welcome.blade.php'), Hyde::path('_pages/index.blade.php'));
        Hyde::copy(Hyde::vendorPath('resources/views/pages/404.blade.php'), Hyde::path('_pages/404.blade.php'));
    }

    public function resetPosts()
    {
        File::cleanDirectory(Hyde::path('_posts'));
    }

    public function resetDocs()
    {
        File::cleanDirectory(Hyde::path('_docs'));
    }

    public function resetSite()
    {
        File::cleanDirectory(Hyde::path('_site'));
    }
}
