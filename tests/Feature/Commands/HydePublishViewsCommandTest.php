<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydePublishViewsCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        backupDirectory(Hyde::path('resources/views/vendor/hyde'));
        deleteDirectory(Hyde::path('resources/views/vendor/hyde'));
    }

    protected function tearDown(): void
    {
        restoreDirectory(Hyde::path('resources/views/vendor/hyde'));

        parent::tearDown();
    }

    public function test_command_publishes_views()
    {
        $this->artisan('publish:views --all')
            ->expectsOutput('Publishing complete.')
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('resources/views/vendor/hyde/layouts/app.blade.php'));
    }

    public function test_command_prompts_for_input()
    {
        $this->artisan('publish:views')
            ->expectsQuestion('Which view categories (tags) would you like to publish?', 'Tag: hyde-components')
            ->assertExitCode(0);
    }
}
