<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeRebuildStaticSiteCommandTest extends TestCase
{
    public function test_handle_is_successful_with_valid_path()
    {
        file_put_contents(Hyde::path('_pages/test-page.md'), 'foo');

        $this->artisan('rebuild '.'_pages/test-page.md')
            ->assertExitCode(0);

        $outputPath = '_site/test-page.html';
        $this->assertFileExists(Hyde::path($outputPath));

        unlink(Hyde::path('_pages/test-page.md'));
        unlink(Hyde::path($outputPath));
    }

    public function test_media_files_can_be_transferred()
    {
        backupDirectory(Hyde::path('_site/media'));
        deleteDirectory(Hyde::path('_site/media'));
        mkdir(Hyde::path('_site/media'));

        touch(Hyde::path('_media/test.jpg'));

        $this->artisan('rebuild _media')
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/media/test.jpg'));
        unlink(Hyde::path('_media/test.jpg'));
        unlink(Hyde::path('_site/media/test.jpg'));

        restoreDirectory(Hyde::path('_site/media'));
    }

    public function test_validate_catches_bad_source_directory()
    {
        $this->artisan('rebuild foo/bar')
            ->expectsOutput('Path [foo/bar] is not in a valid source directory.')
            ->assertExitCode(400);
    }

    public function test_validate_catches_missing_file()
    {
        $this->artisan('rebuild _pages/foo.md')
            ->expectsOutput('File [_pages/foo.md] not found.')
            ->assertExitCode(404);
    }
}
