<?php

namespace Tests\Feature;

use Exception;
use Hyde\Framework\Hyde;
use Hyde\Framework\Services\BuildService;
use Hyde\Framework\StaticPageBuilder;
use Tests\TestCase;

/**
 * Note that we don't actually test if the files were created,
 * since the service is just a proxy for the actual builders,
 * which have their own tests that include this feature.
 */
class BuildServiceTest extends TestCase
{
    /** @throws Exception */
    public function testDetermineModelCanFindMarkdownPost()
    {
        $service = new BuildService('_posts/test.md');
        $result = $service->determineModel();
        $this->assertEquals('Hyde\Framework\Models\MarkdownPost', $result);
    }

    /** @throws Exception */
    public function testDetermineModelCanFindMarkdownPage()
    {
        $service = new BuildService('_pages/test.md');
        $result = $service->determineModel();
        $this->assertEquals('Hyde\Framework\Models\MarkdownPage', $result);
    }

    /** @throws Exception */
    public function testDetermineModelCanFindDocumentationPage()
    {
        $service = new BuildService('_docs/test.md');
        $result = $service->determineModel();
        $this->assertEquals('Hyde\Framework\Models\DocumentationPage', $result);
    }

    /** @throws Exception */
    public function testDetermineModelCanFindBladePage()
    {
        $service = new BuildService('resources/views/pages/test.md');
        $result = $service->determineModel();
        $this->assertEquals('Hyde\Framework\Models\BladePage', $result);
    }

    public function testDetermineModelThrowsExceptionWhenSuppliedWithUnknownPath()
    {
        $service = new BuildService('foo/bar/test.md');
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid source path.');
        $this->expectExceptionCode(400);
        $result = $service->determineModel();
        $this->assertNull($result);
    }

    /** @throws Exception */
    public function testExecute()
    {
        $path = '_posts/test-f01cae99-29ca-481e-b977-6acf9ee364d3.md';
        copy(Hyde::path('vendor/hyde/framework/tests/stubs/_posts/my-new-post.md'),
            Hyde::path($path)
        );
        $service = new BuildService('_posts/test-f01cae99-29ca-481e-b977-6acf9ee364d3.md');
        $service->execute();
        $this->assertNotNull($service->model);
        unlink(Hyde::path($path));
    }

    /** @throws Exception */
    public function testHandle()
    {
        $this->runHandleTest('_posts');
        $this->runHandleTest('_pages');
        $this->runHandleTest('_docs');
        $this->runHandleTest('resources/views/pages', '.blade.php');
    }

    /** @throws Exception */
    private function runHandleTest(string $prefix, string $suffix = '.md')
    {
        $path = $prefix.'/test-f01cae99-29ca-481e-b977-6acf9ee364d3'.$suffix;
        copy(Hyde::path('vendor/hyde/framework/tests/stubs/_posts/my-new-post.md'),
            Hyde::path($path)
        );
        $service = new BuildService($path);
        $service->determineModel();
        $result = $service->handle();
        $this->assertInstanceOf(StaticPageBuilder::class, $result);
        unlink(Hyde::path($path));
    }
}
