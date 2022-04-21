<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Hyde;
use Tests\TestCase;

/**
 * @covers \Hyde\Framework\Commands\HydeServeCommand
 */
class HydeServeCommandTest extends TestCase
{
    public function test_hyde_serve_command()
    {
        $this->artisan('serve')
            ->expectsOutput('Starting the server... Press Ctrl+C to stop')
            ->expectsOutput('This feature is experimental. Please report any issues on GitHub.')
            ->assertExitCode(0);
    }

    public function test_hyde_serve_command_exits_when_compiler_is_not_installed()
    {
        backup(Hyde::path('vendor/hyde/realtime-compiler/server.php'));
        unlink(Hyde::path('vendor/hyde/realtime-compiler/server.php'));

        $this->artisan('serve')
            ->expectsOutput('Could not start the server.')
            ->assertExitCode(1);

        restore(Hyde::path('vendor/hyde/realtime-compiler/server.php'));
    }
}
