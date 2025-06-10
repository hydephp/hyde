<?php

namespace Hyde\Testing;

use App\Console\Commands\ServeCommand;
use App\Services\ViteService;
use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Mockery;

class ServeCommandTest extends TestCase
{
    private Command $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new ServeCommand();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testServeWithViteOptionChecksForNodeModules()
    {
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(false);

        $this->command = Mockery::mock(ServeCommand::class)->makePartial();
        $this->command->shouldReceive('getOutput')->andReturn($output);
        $this->command->shouldReceive('option')->with('vite')->andReturn(true);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Node modules are not installed');

        $this->command->handle();
    }

    public function testServeWithViteOptionStartsViteServer()
    {
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(true);
        
        // Create a mock Process object for Vite server
        $viteProcess = Mockery::mock(Process::class);
        $viteProcess->shouldReceive('isRunning')->andReturn(true);
        $viteProcess->shouldReceive('stop');

        // Mock ViteService to avoid actual server startup
        $viteService = Mockery::mock('overload:' . ViteService::class);
        $viteService->shouldReceive('ensureViteCanRun')->once();
        $viteService->shouldReceive('startViteServer')->once()->andReturn($viteProcess);

        $this->command = Mockery::mock(ServeCommand::class)->makePartial();
        $this->command->shouldReceive('getOutput')->andReturn($output);
        $this->command->shouldReceive('option')->with('vite')->andReturn(true);
        $this->command->shouldReceive('info')->with('Starting Vite development server...');

        // Parent handle call needs to be mocked to prevent actual server start
        $this->command->shouldReceive('parentHandle')->andReturn(0);

        $this->command->handle();

        // Trigger destructor to verify cleanup
        $this->command->__destruct();
    }

    public function testServeWithoutViteOptionSkipsViteServer()
    {
        $this->command = Mockery::mock(ServeCommand::class)->makePartial();
        $this->command->shouldReceive('option')->with('vite')->andReturn(false);
        
        // Parent handle call needs to be mocked to prevent actual server start
        $this->command->shouldReceive('parentHandle')->andReturn(0);

        // ViteService should not be called
        $viteService = Mockery::mock('overload:' . ViteService::class);
        $viteService->shouldNotReceive('ensureViteCanRun');
        $viteService->shouldNotReceive('startViteServer');

        $this->assertEquals(0, $this->command->handle());
    }

    public function testServeHandlesViteStartupFailure()
    {
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(true);

        // Mock ViteService to simulate startup failure
        $viteService = Mockery::mock('overload:' . ViteService::class);
        $viteService->shouldReceive('ensureViteCanRun')->once();
        $viteService->shouldReceive('startViteServer')->once()
            ->andThrow(new RuntimeException('Vite server failed to start'));

        $this->command = Mockery::mock(ServeCommand::class)->makePartial();
        $this->command->shouldReceive('getOutput')->andReturn($output);
        $this->command->shouldReceive('option')->with('vite')->andReturn(true);
        $this->command->shouldReceive('error')->with('Vite server failed to start');

        $this->assertEquals(1, $this->command->handle());
    }

    public function testServeWithViteCleanupOnDestruct() 
    {
        $output = Mockery::mock(OutputInterface::class);
        $output->shouldReceive('isInteractive')->andReturn(true);
        
        // Create a mock Process object for Vite server
        $viteProcess = Mockery::mock(Process::class);
        $viteProcess->shouldReceive('isRunning')->andReturn(true);
        $viteProcess->shouldReceive('stop')->once(); // Verify stop is called exactly once

        // Setup command mock
        $this->command = Mockery::mock(ServeCommand::class)->makePartial();
        $this->command->shouldReceive('getOutput')->andReturn($output);
        $this->command->shouldReceive('option')->with('vite')->andReturn(true);
        
        // Set the viteProcess property through reflection
        $reflection = new \ReflectionClass($this->command);
        $property = $reflection->getProperty('viteProcess');
        $property->setValue($this->command, $viteProcess);

        // Trigger destructor
        $this->command->__destruct();
    }
}
