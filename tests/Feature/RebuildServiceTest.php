<?php

namespace Tests\Feature;

use Hyde\Framework\Hyde;
use Hyde\Framework\Services\RebuildService;
use Hyde\Framework\StaticPageBuilder;
use Tests\TestCase;

/**
 * Note that we don't actually test if the files were created,
 * since the service is just a proxy for the actual builders,
 * which have their own tests that include this feature.
 */
class RebuildServiceTest extends TestCase
{
    public function testService()
    {
        $path = '_posts/test-f01cae99-29ca-481e-b977-6acf9ee364d3.md';
        copy(
            Hyde::path('vendor/hyde/framework/tests/stubs/_posts/my-new-post.md'),
            Hyde::path($path)
        );
        $service = new RebuildService('_posts/test-f01cae99-29ca-481e-b977-6acf9ee364d3.md');
        $service->execute();
        $this->assertNotNull($service->model);
        unlink(Hyde::path($path));
    }

    public function testExecute()
    {
        $this->runExecuteTest('_posts');
        $this->runExecuteTest('_pages');
        $this->runExecuteTest('_docs');
        $this->runExecuteTest('resources/views/pages', '.blade.php');
    }

    private function runExecuteTest(string $prefix, string $suffix = '.md')
    {
        $path = $prefix.'/test-f01cae99-29ca-481e-b977-6acf9ee364d3'.$suffix;
        copy(
            Hyde::path('vendor/hyde/framework/tests/stubs/_posts/my-new-post.md'),
            Hyde::path($path)
        );
        $service = new RebuildService($path);
        $result = $service->execute();
        $this->assertInstanceOf(StaticPageBuilder::class, $result);
        unlink(Hyde::path($path));
    }
}
