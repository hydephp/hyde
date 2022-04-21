<?php

namespace Tests\Unit;

use Hyde\Framework\Actions\PublishesDefaultFrontendResourceFiles;
use Hyde\Framework\Hyde;
use tests\TestCase;

class PublishesDefaultFrontendResourceFilesTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        backupDirectory(Hyde::path('resources/assets'));
        deleteDirectory(Hyde::path('resources/assets'));
    }

    /** @test */
    public function test_default_files_are_published()
    {
        $this->assertDirectoryDoesNotExist(Hyde::path('resources/assets'));

        (new PublishesDefaultFrontendResourceFiles)->__invoke();

        $this->assertDirectoryExists(Hyde::path('resources/assets'));

        $this->assertFileExists(Hyde::path('resources/assets/app.css'));
        $this->assertFileExists(Hyde::path('resources/assets/hyde.css'));
        $this->assertFileExists(Hyde::path('resources/assets/hyde.js'));
    }

    /** Teardown */
    public function tearDown(): void
    {
        restoreDirectory(Hyde::path('resources/assets'));

        parent::tearDown();
    }
}
