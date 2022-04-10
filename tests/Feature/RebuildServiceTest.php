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
    public function test_service_method()
    {
        createTestPost();
        $service = new RebuildService('_posts/test-post.md');
        $service->execute();
        $this->assertNotNull($service->model);
        unlink(Hyde::path('_posts/test-post.md'));
        unlink(Hyde::path('_site/posts/test-post.html'));
    }

    public function test_execute_methods()
    {
        $this->runExecuteTest('_posts');
        $this->runExecuteTest('_pages');
        $this->runExecuteTest('_docs');
        $this->runExecuteTest('_pages', '.blade.php');

        unlink(Hyde::path('_site/test-file.html'));
        unlink(Hyde::path('_site/docs/test-file.html'));
        unlink(Hyde::path('_site/posts/test-file.html'));
    }

    private function runExecuteTest(string $prefix, string $suffix = '.md')
    {
        $path = $prefix.'/test-file'.$suffix;
        createTestPost($path);
        $service = new RebuildService($path);
        $result = $service->execute();
        $this->assertInstanceOf(StaticPageBuilder::class, $result);
        unlink(Hyde::path($path));
    }
}
