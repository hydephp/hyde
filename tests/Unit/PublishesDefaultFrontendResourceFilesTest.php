<?php

namespace Tests\Unit;

use App\Commands\TestWithBackup;
use Hyde\Framework\Actions\PublishesDefaultFrontendResourceFiles;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use tests\TestCase;

class PublishesDefaultFrontendResourceFilesTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        TestWithBackup::backupDirectory(Hyde::path('resources/frontend'));
        File::deleteDirectory(Hyde::path('resources/frontend'));
    }

    /** @test */
    public function test_default_files_are_published()
    {
        $this->assertDirectoryDoesNotExist(Hyde::path('resources/frontend'));

        (new PublishesDefaultFrontendResourceFiles)->__invoke();

        $this->assertDirectoryExists(Hyde::path('resources/frontend'));

        $this->assertFileExists(Hyde::path('resources/frontend/app.css'));
        $this->assertFileExists(Hyde::path('resources/frontend/hyde.css'));
        $this->assertFileExists(Hyde::path('resources/frontend/hyde.js'));
    }

    /** Teardown */
    public function tearDown(): void
    {
        TestWithBackup::restoreDirectory(Hyde::path('resources/frontend'));

        parent::tearDown();
    }
}
