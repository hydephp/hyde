<?php

namespace Hyde\Testing;

use Hyde\Framework\Hyde;

/**
 * @internal
 */
trait ResetsApplication
{
    public function resetApplication()
    {
        $this->resetMedia();
        $this->resetPages();
        $this->resetPosts();
        $this->resetDocs();
        $this->resetSite();
    }

    public function resetMedia()
    {
        //
    }

    public function resetPages()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_pages/*.md')));
        array_map('unlinkUnlessDefault', glob(Hyde::path('_pages/*.blade.php')));
    }

    public function resetPosts()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_posts/*.md')));
    }

    public function resetDocs()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_docs/*.md')));
    }

    public function resetSite()
    {
        array_map('unlinkUnlessDefault', glob(Hyde::path('_site/*.html')));
    }
}
