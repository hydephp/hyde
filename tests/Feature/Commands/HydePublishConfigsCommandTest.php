<?php

namespace Tests\Feature\Commands;

use App\Commands\TestWithBackup;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HydePublishConfigsCommandTest extends TestCase
{
    /** Setup */
    public function setUp(): void
    {
        parent::setUp();

        TestWithBackup::backupDirectory(Hyde::path('config'));
        File::deleteDirectory(Hyde::path('config'));
    }


    /** @test */
    public function test_command_has_expected_output()
    {
        $this->artisan('update:configs')
            ->expectsOutput('Published config files to ' . Hyde::path('config'))
            ->assertExitCode(0);
    }


    /** @test */
    public function test_config_files_are_published()
    {
        $this->assertDirectoryDoesNotExist(Hyde::path('config'));

        $this->artisan('update:configs')
            ->assertExitCode(0);

        $this->assertFileEquals(Hyde::vendorPath('config/hyde.php'), Hyde::path('config/hyde.php'));

        $this->assertDirectoryExists(Hyde::path('config'));
    }

    /** @test */
    public function test_command_overwrites_existing_files()
    {
        File::makeDirectory(Hyde::path('config'));
        File::put(Hyde::path('config/hyde.php'), 'foo');

        $this->artisan('update:configs')
            ->assertExitCode(0);

        $this->assertNotEquals('foo', File::get(Hyde::path('config/hyde.php')));
    }

    /** Teardown */
    public function tearDown(): void
    {
        TestWithBackup::restoreDirectory(Hyde::path('config'));

        parent::tearDown();
    }
}
