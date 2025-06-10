<?php

namespace App\Services;

use RuntimeException;
use Illuminate\Console\Command;
use Hyde\Hyde;
use Symfony\Component\Process\Process;

class ViteService
{
    /**
     * Check if Vite dependencies are installed and handle installation if needed.
     *
     * @param Command $command The current command instance for IO
     * @throws RuntimeException If Vite cannot be started
     */
    public static function ensureViteCanRun(Command $command): void
    {
        if (!is_dir(Hyde::path('node_modules'))) {
            if (!$command->getOutput()->isInteractive()) {
                throw new RuntimeException('Cannot start Vite server: Node modules are not installed. Run `npm install` first.');
            }

            $command->warn('Node modules are not installed. Vite requires npm dependencies to run.');
            
            if (!$command->confirm('Would you like to install the dependencies now?', false)) {
                throw new RuntimeException('Cannot start Vite server without installing dependencies. Please run `npm install` manually.');
            }

            $command->info('Installing Node dependencies...');
            
            $process = self::runNpmInstall($command);

            if (!$process->isSuccessful()) {
                throw new RuntimeException('Failed to install Node dependencies. Please run `npm install` manually.');
            }

            $command->info('Dependencies installed successfully.');
        }
    }

    /**
     * Run npm install command.
     *
     * @param Command $command The current command instance for output
     * @return Process The completed process
     */
    protected static function runNpmInstall(Command $command): Process
    {
        $process = new Process(['npm', 'install'], Hyde::path());
        $process->run(function ($type, $buffer) use ($command) {
            $command->getOutput()->write($buffer);
        });
        return $process;
    }

    /**
     * Start the Vite development server.
     * 
     * @throws RuntimeException If Vite fails to start
     * @return Process The Vite server process
     */
    public static function startViteServer(): Process
    {
        $process = new Process(['npm', 'run', 'dev'], Hyde::path(), null, null, null);
        $process->setTimeout(null);
        $process->start();

        // Wait a bit to catch any immediate startup errors
        usleep(1000000); // 1 second

        if (!$process->isRunning()) {
            $output = $process->getOutput() . $process->getErrorOutput();
            throw new RuntimeException("Vite server failed to start:\n" . $output);
        }

        return $process;
    }
}
