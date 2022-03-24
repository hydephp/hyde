<?php

namespace Hyde\Framework\Commands;

use Tests\TestCase;
use Hyde\Framework\Hyde;

class HydePublishConfigsCommandTest extends TestCase
{
    public function test_command_returns_zero_exit_code()
    {
        $this->artisan('publish:configs')->assertExitCode(0);
    }

    public function test_command_returns_expected_output()
    {
        $this->artisan('publish:configs')
            ->expectsOutputToContain('Copied Directory')
            ->expectsOutput('Publishing complete.')
            ->assertExitCode(0);
    }

    public function test_config_files_are_published()
    {
        // Delete an non-critical file
        unlink(Hyde::path('config/view.php'));

        $this->assertFileDoesNotExist(Hyde::path('config/view.php'));

        $this->artisan('publish:configs')->assertExitCode(0);
        
        $this->assertFileExists(Hyde::path('config/view.php'));
    }

    public function test_that_files_are_not_overwritten_by_default()
    {
        file_put_contents(Hyde::path('config/view.php'), '<?php return [ /** This should not be overwritten */ ];');
        $this->artisan('publish:configs')->assertExitCode(0);
        
        $this->assertStringContainsString(
            'This should not be overwritten',
            file_get_contents(Hyde::path('config/view.php'))
        );

        $this->assertStringNotContainsString(
            'VIEW_COMPILED_PATH',
            file_get_contents(Hyde::path('config/view.php'))
        );
    }
    
    public function test_that_files_are_overwritten_when_force_flag_is_set()
    {
        file_put_contents(Hyde::path('config/view.php'), '<?php return [ /** This should be overwritten */ ];');
        $this->artisan('publish:configs --force')->assertExitCode(0);
        
        $this->assertStringNotContainsString(
            'This should be overwritten',
            file_get_contents(Hyde::path('config/view.php'))
        );

        $this->assertStringContainsString(
            'VIEW_COMPILED_PATH',
            file_get_contents(Hyde::path('config/view.php'))
        );
    }
}
