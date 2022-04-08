<?php

namespace Tests\Feature\Commands;

use App\Commands\TestWithBackup;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HydePublishFrontendResourcesCommandTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        TestWithBackup::backupDirectory(Hyde::path('resources/frontend'));
        File::deleteDirectory(Hyde::path('resources/frontend'));
    }

    /** @test */
    public function test_command_returns_zero_exit_code()
    {
        $this->artisan('update:resources --force')
            ->doesntExpectOutput('Please note that the following files will be overwritten:')
            ->assertExitCode(0);
    }

    /** @test */
    public function test_command_has_expected_output()
    {
        $this->artisan('update:resources ')
            ->expectsOutput('Publishing frontend resources!')
            ->expectsConfirmation('Would you like to continue?', false)
            ->expectsOutput('Okay. Aborting.')
            ->assertExitCode(1);
    }

    /** @test */
    public function test_command_has_can_publish_resources()
    {
        $this->artisan('update:resources')
            ->expectsConfirmation('Would you like to continue?', 'yes')
            ->expectsOutput('Okay. Proceeding.')
            ->assertExitCode(0);

        $this->assertDirectoryExists(Hyde::path('resources/frontend'));
    }

    /** Teardown */
    public function tearDown(): void
    {
        TestWithBackup::restoreDirectory(Hyde::path('resources/frontend'));

        parent::tearDown();
    }
}
