<?php

namespace Tests;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Hyde\Framework\Services\StarterFileService;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

/**
 * @todo make the directory resets more granular to speed up testing.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectories([
            Hyde::path('_pages'),
            Hyde::path('_posts'),
            Hyde::path('_media'),
            Hyde::path('_docs'),
            Hyde::path('_site'),
        ]);

        (new CreatesDefaultDirectories)->__invoke();
        StarterFileService::publish();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        File::deleteDirectories([
            Hyde::path('_pages'),
            Hyde::path('_posts'),
            Hyde::path('_media'),
            Hyde::path('_docs'),
            Hyde::path('_site'),
        ]);

        (new CreatesDefaultDirectories)->__invoke();
        StarterFileService::publish();

        parent::tearDown();
    }
}
