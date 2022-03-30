<?php

namespace Commands;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeRebuildStaticSiteCommandTest extends TestCase
{
    public static string $stub = 'vendor/hyde/framework/tests/stubs/_posts/my-new-post.md';
    public static string $path = '_pages/test-07239181-403e-443b-94f3-f912a031f31a.md';

    public function testHandleIsSuccessfulWithValidPath()
    {
        copy(Hyde::path(static::$stub), Hyde::path(static::$path));

        $this->artisan('rebuild '.static::$path)
            ->assertExitCode(0);

        $outputPath = '_site/test-07239181-403e-443b-94f3-f912a031f31a.html';
        $this->assertFileExists(Hyde::path($outputPath));

        unlink(Hyde::path(static::$path));
        unlink(Hyde::path($outputPath));
    }

    public function testValidateCatchesBadSourceDirectory()
    {
        $this->artisan('rebuild foo/bar')
            ->expectsOutput('Path [foo/bar] is not in a valid source directory.')
            ->assertExitCode(400);
    }

    public function testValidateCatchesMissingFile()
    {
        $this->artisan('rebuild _pages/foo.md')
            ->expectsOutput('File [_pages/foo.md] not found.')
            ->assertExitCode(404);
    }
}
