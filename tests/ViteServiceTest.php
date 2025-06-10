<?php

namespace Hyde\Testing;

use App\Services\ViteService;
use Hyde\Hyde;
use RuntimeException;
use Illuminate\Console\Command;
use Mockery;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ViteServiceTest extends TestCase
{
    private $originalNodeModules;
    private $nodeModulesPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->nodeModulesPath = Hyde::path('node_modules');
        $this->originalNodeModules = is_dir($this->nodeModulesPath);
        
        // Backup node_modules if it exists
        if ($this->originalNodeModules) {
            rename($this->nodeModulesPath, $this->nodeModulesPath . '_backup');
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Restore original node_modules if it existed
        if ($this->originalNodeModules) {
            if (is_dir($this->nodeModulesPath)) {
                rmdir($this->nodeModulesPath);
            }
            rename($this->nodeModulesPath . '_backup', $this->nodeModulesPath);
        }
    }

    public function testThrowsExceptionWhenNodeModulesMissingNonInteractive()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot start Vite server: Node modules are not installed');

        $command = Mockery::mock(Command::class);
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(false);
        $command->shouldReceive('getOutput')->andReturn($output);

        ViteService::ensureViteCanRun($command);
    }

    public function testPromptsToInstallModulesWhenMissingInteractive()
    {
        $command = Mockery::mock(Command::class);
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(true);
        $command->shouldReceive('getOutput')->andReturn($output);
        $command->shouldReceive('warn')->with('Node modules are not installed. Vite requires npm dependencies to run.');
        $command->shouldReceive('confirm')->andReturn(false);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot start Vite server without installing dependencies');

        ViteService::ensureViteCanRun($command);
    }

    public function testStartViteServerHandlesFailure()
    {
        // Create empty node_modules to pass initial check
        mkdir($this->nodeModulesPath);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Vite server failed to start');

        ViteService::startViteServer();
    }
}
